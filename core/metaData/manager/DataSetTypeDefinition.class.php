<?php

require_once(HARMONI."metaData/manager/FieldDefinition.class.php");

class DataSetTypeDefinition {
	
	var $_manager;
	var $_idmanager;
	var $_dbID;
	var $_type;
	var $_id;
	
	var $_loaded;
	
	var $_fields;
	
	function DataSetTypeDefinition(&$manager, &$idmanager, $dbID, &$type, $id=null) {
		$this->_manager =& $manager;
		$this->_idmanager =& $idmanager;
		$this->_dbID = $dbID;
		$this->_type =& $type;
		
		$this->_loaded = false;
		$this->_fields = array();
		
		// if all we're passed is a type, try to get the ID from the DataSetTypeManager
		if (!$id) {
			$id = $manager->getIDForType($type);
		}
		
		$this->_id = $id;
	}
	
	function addNewField(&$fieldDefinition) {
		$this->_addField($fieldDefinition);
	}
	
	function &getType() {
		return $this->_type;
	}
	
	function getID() { return $this->_id; }
	
	function _addField(&$fieldDefinition, $id=null) {
		ArgumentValidator::validate($fieldDefinition, new ExtendsValidatorRule("FieldDefinition"));
		
		$label = $fieldDefinition->getLabel();
		
		// if we already have a field labeled $label we die
		if (isset($this->_fields[$label]))
			throwError( new Error("Already have a field with label '$label' defined in DataSetTypeDefinition '".OKITypeToString($this->_type)."'. If you feel this is in error, remember that previously deleted FieldDefinitions retain their label so as to avoid data fragmentation.","DataSetTypeDefinition",true));
		
		// associate this field definition with our DataSetTypeDefinition
		$fieldDefinition->associate($this, $this->_idmanager, $this->_dbID, $id);
		
		// add it to our list of fields
		$this->_fields[$label] =& $fieldDefinition;
	}
	
	function load() {
		// load our fields from the database
		if ($this->loaded()) {
//			throwError( new Error("Already loaded from the database for type ".OKITypeToString($this->_type).".","DataSetTypeDefinition",true));
			return true;
		}
		
		// if we were not initialized with an ID, that means that we're not meant to interface with the DB
		if (!$this->_id) {
			throwError( new Error("The DataSetTypeDefinition object of type '".OKITypeToString($this->_type)."'
			was not meant to interface with the database.","DataSetTypeDefinition",true));
			return false;
		}
		
		$query =& new SelectQuery;
		$query->addTable("datasettypedef");
		$query->addColumn("datasettypedef_id");
		$query->addColumn("datasettypedef_label");
		$query->addColumn("datasettypedef_mult");
		$query->addColumn("datasettypedef_active");
		$query->addColumn("datasettypedef_fieldtype");
		$query->setWhere("fk_datasettype=".$this->_id);
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query,$this->_dbID);
		if (!$result) {
			throwError( new UnknownDBError("DataSetTypeDefinition") );
		}
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$newField =& new FieldDefinition($a['datasettypedef_label'],$a['datasettypedef_fieldtype'],
					(($a['datasettypedef_mult'])?true:false),
					(($a['datasettypedef_active'])?true:false)
					);
			$this->_addField($newField, $a['datasettypedef_id']);
			unset($newField);
		}
	}
	
	function loaded() { return $this->_loaded; }
	
	function fieldCount() {
		return count($this->_fields);
	}
	
	function deleteField($label) {
		unset($this->_fields[$label]);
	}
	
	function getAllLabels( $includeInactive = false ) {
		$array = array();
		foreach (array_keys($this->_fields) as $label) {
			if ($includeInactive || $this->_fields[$label]->isActive()) $array[] = $label;
		}
		return $array;
	}
	
	function &getFieldDefinition($label) {
		if (!isset($this->_fields[$label])) {
			throwError(new Error("DataSetTypeDefinition::getFieldDefinition($label) - I don't have a field labeled '$label'. I'm of type '".OKITypeToString($this->_type)."'.","DataSetTypeDefinition",true));
			return false;
		}
		
		return $this->_fields[$label];
	}
	
	function commitAllFields() {
		// go through all our fields and call commit();
		foreach ($this->getAllLabels() as $label) {
			$this->_fields[$label]->commit();
		}
	}
	
	function fieldExists($label) {
		return (isset($this->_fields[$label]))?true:false;
	}
	
	function getFieldType($label) {
		if (!$this->fieldExists($label)) return false;
		
		return $this->_fields[$label]->getType();
	}
}


?>