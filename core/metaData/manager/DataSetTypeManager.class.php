<?php

include HARMONI."oki/shared/HarmoniType.class.php";
include HARMONI."oki/shared/HarmoniTypeIterator.class.php";
include HARMONI."metaData/manager/DataSetTypeDefinition.class.php";

class DataSetTypeManager {
	
	var $_idmanager;
	var $_dbID;
	var $_db;
	
	var $_types;
	var $_typeDefinitions;
	var $_typeIDs;
	
	var $_hashSeparator;
	
	function DataSetTypeManager( &$idmanager, $dbID ) {
		$this->_idmanager =& $idmanager;
		$this->_dbID = $dbID;
		$this->_db =& Services::requireService("DBHandler");
		
		// talk to the DB
		$this->populate();
		
		debug::output("Initialized new DataSetTypeManager with ".$this->numberOfTypes()." types.",DEBUG_SYS4,"DataSetTypeManager");
	}
	
	function populate() {
		// let's get all our known types
		$query =& new SelectQuery;
		
		$query->addTable("datasettype");
		$query->addColumn("datasettype_id");
		$query->addColumn("datasettype_domain");
		$query->addColumn("datasettype_authority");
		$query->addColumn("datasettype_keyword");
		$query->addColumn("datasettype_description");
		
		$result =& $this->_db->query($query,$this->_dbID);
		if (!$result) throwError(new UnknownDBError("DataSetTypeManager"));
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$type =& new HarmoniType($a['datasettype_domain'],
					$a['datasettype_authority'],
					$a['datasettype_keyword'],
					$a['datasettype_description']);
			
			$this->_typeDefinitions[$a['datasettype_id']] =& new DataSetTypeDefinition($this, $this->_idmanager, $this->_dbID, $type, $a['datasettype_id']);
			$this->_types[$a['datasettype_id']] =& $type;
			
			$this->_typeIDs[$this->_mkHash($type)] = $a['datasettype_id'];
			unset($type);
		}
	}
	
	function numberOfTypes() {
		return count($this->_types);
	}
	
	function _mkHash($type, $auth=null, $key=null) {
		if (!$this->_hashSeparator)
			$this->_hashSeparator = time();
		
		$parts = array();	
		
		if (is_object($type)) {
			$parts[] = $type->getDomain();
			$parts[] = $type->getAuthority();
			$parts[] = $type->getKeyword();
		} else if ($type && $auth && $key) {
			$parts[] = $type;
			$parts[] = $auth;
			$parts[] = $key;
		} else return "";
		
		return implode($this->_hashSeparator, $parts);
	}
	
	function getIDForType(&$type) {
		$hash = $this->_mkHash($type);
		return ($this->_typeIDs[$hash])?$this->_typeIDs[$hash]:null;
	}
	
	function & newDataSetType(&$type) {
		if ($id = $this->getIDForType($type)) {
			throwError( new Error(
				"DataSetTypeManager::newDataSetType(".OKITypeToString($type).") - a DataSetType for this Type already exists, so the existing one has been returned.",
				"DataSetTypeManager",false));
			debug::output("Returning existing DataSetType for '".OKITypeToString($type)."'",DEBUG_SYS5, "DataSetTypeManager");
			return $this->_types[$id];
		}
		
		// add somethin' to the database
		$newID = $this->_idmanager->newID(new HarmoniDataSetType);
		
		$query =& new InsertQuery;
		$query->setTable("datasettype");
		$query->setColumns(array("datasettype_id","datasettype_domain","datasettype_authority","datasettype_keyword","datasettype_description"));
		$query->addRowOfValues( array(
			$newID,
			"'".addslashes($type->getDomain())."'",
			"'".addslashes($type->getAuthority())."'",
			"'".addslashes($type->getKeyword())."'",
			"'".addslashes($type->getDescription())."'"
		));
		$result =& $this->_db->query($query,$this->_dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("DataSetTypeManager") );
		}
		
		$newDataSetType =& new DataSetTypeDefinition($this, $this->_idmanager, $this->_dbID, $type);

		// add it to our local arrays
		$this->_typeDefinitions[$newID] =& $newDataSetType;
		$this->_types[$newID] =& $type;
		$this->_typeIDs[$this->_mkHash($type)] = $newID;
		debug::output("Created new DataSetType object for '".OKITypeToString($type)."'",DEBUG_SYS5,"DataSetTypeManager");
		return $newDataSetType;
		return true;
	}
	
	function dataSetTypeExists(&$type) {
		return ($this->_typeIDs[$this->_mkHash($type)])?true:false;
	}
	
	function & getDataSetTypeDefinition(&$type) {
		if (!($id = $this->getIDForType($type))) {
			throwError( new Error(
				"DataSetTypeManager::getDataSetTypeDefinition(".OKITypeToString($type).") - no DataSetTypeDefinition exists.",
				"DataSetTypeManager",true));
			return false;
		}
		return $this->_types[$id];
	}
	
	function & getAllDataSetTypes() {
		return new HarmoniTypeIterator($this->_types);
	}
}

class HarmoniDataSetType extends HarmoniType {
	function HarmoniDataSetType() {
		parent::HarmoniType("Harmoni","DataSetTypeManager","DataSetType",
				"Defines a DataSet definition within Harmoni's MetaData Manager system.");
	}
}
?>