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
	
	/**
	* @return DataSetTypeManager
	* @param object $idmanager The {@link IDManager} to use for ID generation.
	* @param int $dbID The {@link DBHandler} connection ID to use for data type storage.
	* @desc Constructor.
	*/
	function DataSetTypeManager( &$idmanager, $dbID ) {
		$this->_idmanager =& $idmanager;
		$this->_dbID = $dbID;
		$this->_db =& Services::requireService("DBHandler");
		
		// talk to the DB
		$this->populate();
		
		debug::output("Initialized new DataSetTypeManager with ".$this->numberOfTypes()." types.",DEBUG_SYS4,"DataSetTypeManager");
	}
	
	/**
	* @return void
	* @desc Fetches from the DB a list of registered DataSetTypes.
	*/
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
	
	/**
	* @return string The hash as a string.
	* @param mixed $type Either an OKI Type object or the Domain string.
	* @param opt string $auth The Authority.
	* @param opt string $key The Keyword.
	* @desc Creates a hash of the OKI type for keying a type to an ID in a hash array. The hashes should be unique.
	*/
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
		
		$newDataSetType =& new DataSetTypeDefinition($this, $this->_idmanager, $this->_dbID, $type, $newID);

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
	
	function synchronize(&$newDef) {
		$type =& $newDef->getType();
		
		// check if we already have a definition for this type. if we don't, add a new one.
		if (!$this->dataSetTypeExists($type)) {
			$oldDef =& $this->newDataSetType($type);
		} else {
			$oldDef =& $this->getDataSetTypeDefinition($type);
		}
		
		// make sure $oldDef has all its data loaded
		$oldDef->load();
		
		/*
		The synchronization process is not simple. 
		
		get all labels, from both old def (from DB) and new def, store in $label[]
		
		For each $label {
			if the field doesn't exist, add it to the DB
			if the field does exist {
				...in database, but not in new, delete it, including all values in datasets
					that reference the field
				...in both new def and db {
					if mult value has changed ...
						... from yes to no, make the change, go through all values in datasets
							that reference this field -- make sure there is only one active value
						... from no to yes, make the change.
					if versionControl has changed ...
						... shouldn't be a problem -- just make the change
					if field type has changed ...
						... --> should we just not allow this?
						... if values already exist (even inactive ones), throw a huge ugly error.
						... otherwise, make the change but throw a warning too.
				}
			}
		}
		*/
		
		$allLabels = array_merge( $newDef->getAllLabels(), $oldDef->getAllLabels() );
		
		foreach ($allLabels as $label) {
			// now we're going to go through the logic above in the comment
			
			// if the field exists in new and not in old, add it to old, and flag it to add to DB
			if (!$oldDef->fieldExists($label) && $newDef->fieldExists($label)) {
				$field =& $newDef->getFieldDefinition($label);
				$newField =& $field->clone();
				$newField->addToDB();
				$oldDef->addNewField($newField);
				unset($newField, $field);
				continue;
			}
			
			// if the field exists in the old but not in the new, flag it for deletion.
			if ($oldDef->fieldExists($label) && !$newDef->fieldExists($label)) {
				$field =& $oldDef->getFieldDefinition($label);
				$field->delete();
				unset($field);
				continue;
			}
			
			// ok, if we're at this point it means the label is defined in both definitions.
			$oldField =& $oldDef->getFieldDefinition($label);
			$newField =& $newDef->getFieldDefinition($label);
			
			// first let's check if the types match. if they don't, we're going to go psycho
			$oldType = $oldField->getType();
			$newType = $newField->getType();
			if ($newType != $oldType) {
				// go PSYCHO!!!!
				throwError( new Error(
					"While synchronizing DataSetType '".OKITypeToString($this->_type)."', it appears that the
					field type for label '$label' is different from what we have stored. It is not possible
					to synchronize without possible data loss. Aborting.","DataSetTypeManager",true));
				return false;
			}
			unset($newType,$oldType);
			
			// now, check if the versionControl has changed.
			$oldVctl = $oldField->getVersionControlFlag();
			$newVctl = $newField->getVersionControlFlag();
			if ($oldVctl !== $newVctl) { // boolean-safe compare
				$oldField->setVersionControlFlag($newVctl);
				$oldField->update();
			}
			unset($oldVctl, $newVctl);
			
			// now let's check the mult
			$oldMult = $oldField->getMultFlag();
			$newMult = $newField->getMultFlag();
			if ($oldMult !== $newMult) { // boolean-safe compare
				// ok, now, if we're changing from true to false, just go ahead, make the change
				if (!$oldMult && $newMult) {
					$oldField->setMultFlat(true);
					$oldField->update();
				}
				// otherwise, we'll have to do some smart updating
				if ($oldMult && !$newMult) {
					// for this field, we'll have to make sure that there aren't multiple values
					// already set for this. we'll try to keep the most recent active value as the
					// only value.
					
					// @todo - how to do this:
					// select all rows from datasetfield where fk_datasettypedef=$oldField->getID()
					// and datasetfield_active=1, ordering by datasetfield_created ASC
					// then, go through from count to count-1 and set active to 0. that should do it
					
					// now, make the change
					$oldField->setMultFlag(false);
					$oldField->update();
				}
			}
		}
		
		// now that we're done syncrhonizing $newDef with $oldDef, let's commit everything to the DB
		$oldDef->commitAllFields();
	}
}

class HarmoniDataSetType extends HarmoniType {
	function HarmoniDataSetType() {
		parent::HarmoniType("Harmoni","DataSetTypeManager","DataSetType",
				"Defines a DataSet definition within Harmoni's MetaData Manager system.");
	}
}
?>