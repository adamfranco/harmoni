<?php

define("NEW_VALUE",-1);

class DataSet {
	
	var $_idManager;
	var $_dbID;
	var $_dataSetTypeDef;
	var $_versionControlled;
	var $_fields;
	var $_full;
	
	function DataSet(&$idManager, $dbID, &$dataSetTypeDef, $verControl ) {
		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		$this->_idManager = $idManager;
		$this->_dbID = $dbID;
		$this->_dataSetTypeDef = $dataSetTypeDef;
		$this->_fields = array();
		
		$this->_full = false;
		
		// set up the individual fields
		foreach ($dataSetTypeDef->getAllLabels() as $label) {
			$def =& $dataSetTypeDef->getFieldDefinition($label);
			$this->_fields[$label] =& new FieldValues($def, $this, $label );
			unset($def);
		}
	}
	
	function readOnly() {
		return !$this->_full;
	}
	
	function _checkLabel($label, $function) {
		
	}
	
	function setValue($label, &$obj, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		if ($index == NEW_VALUE) {
			return $this->_fields[$label]->addValue($obj);
		}
		return $this->_fields[$label]->setValue($index, $obj);
	}
	
	function &getValue($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->getValue($index);
	}
	
	function &getAllValues($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->getAllValues();
	}
	
	function commit() {
		
	}
	
	function populate( $arrayOfRows = null, $full = false ) {
		
	}
	
	function numValues($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->numValues();
	}
	
	function isVersionControlled() {
		return $this->_versionControlled;
	}
	
	function clone() {
		
	}
	
	function deleteAllValues($label) {
		
	}
	
	function deleteValue($label, $index=0) {
		
	}
	
}

class FieldValues {
	
	var $_numValues;
	var $_values;
	
	var $_parent;
	var $_fieldDefinition;
	var $_myLabel;
	
	function DataField( &$fieldDefinition, &$parent, $label ) {
		ArgumentValidator::validate($values, new ArrayValidatorRule());
		$this->_numValues = 0;
		
		$this->_myLabel = $label;
		
		$this->_parent =& $parent;
		$this->_fieldDefinition =& $fieldDefinition;
	}
	
	function populate( $arrayOfRows ) {
		
	}
	
	function &getValue($index) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index];
	}
	
	function &getAllValues() {
		$values = array();
		for ($i=0; $i< $this->_numValues; $i++) {
			$values[] =& $this->_values[$i]->getValue();
		}
		return $values;
	}
	
	function _checkObjectType(&$object) {
		$dataTypeManager =& Services::requireService("DataTypeManager");
		$type = $this->_fieldDefinition->getType();
		
		if ($dataTypeManager->isObjectOfDataType($object,$type)) return true;
		
		// otherwise... throw an error.
		throwError( new Error(
		"While trying to add/set a value in DataSet ID ".$this->_parent->getID().", we recieved an unexpected
		data type. Expecting: $type, but got an object of class ".get_class($object).".", "FieldValues",true));
		return false;
	}
	
	function addValue(&$value) {
		if ($this->_parent->readOnly()) {
			throwError( new Error("Can not add value to DataSet because it was fetched
			from the database readonly. You must re-fetch it fully to make changes.","FieldValues",true));
		}
		
		if (!$this->_fieldDefinition->getMultFlag()) {
			$label = $this->_myLabel;
			throwError ( new Error(
			"Field label '$label' can not add a new value because it does not allow multiple
				values. In DataSetType ".OKITypeToString($this->_dataSetTypeDef->getType()).".",
			"DataSet",true));
			return false;
		}
		$this->_checkObjectType($value);
		
		$this->_values[$this->_numValues] =& new ValueVersions($this);
		$this->_values[$this->_numValues]->setValue($value);
		$this->_numValues++;
		return true;
	}
	
	function setValue($index, &$value) {
		if ($this->_parent->readOnly()) {
			throwError( new Error("Can not set value in DataSet because it was fetched
			from the database readonly. You must re-fetch it fully to make changes.","FieldValues",true));
		}
		
		// any field can have at least one value.. if index 0 is not yet set up, set it up
		if ($index == 0 && !isset($this->_values[0])) {
			$this->_values[0] =& new ValueVersions($this);
		}
		
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		$this->_values[$index]->setValue($value);
	}
	
	function numValues() { return $this->_numValues; }
	
	function numVersions( $index=0 ) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index]->numVersions();
	}
	
	function getVersionList( $index=0 ) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index]->getVersionList();
	}
	
	function &getVersion( $verID, $index=0 ) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
	}
	
}

// holds multiple values for a given label + index
class ValueVersions {
	
	var $_numVersions;
	var $_parent;
	
	var $_versions;
	
	function ValueVersions (&$parent) {
		$this->_parent =& $parent;
		$this->_numVersions = 0;
	}
	
	function populate( $arrayOfRows ) {
		
	}
	
	function numVersions() {
		return $this->_numVersions;
	}
	
	function setValue(&$value) {
		// if we're version controlled, we're adding a new version
		// otherwise, we're just setting the existing (or only active) one.
		if ($this->_parent->_parent->isVersionControlled()) {
			// we're going to add a new version
			// which means, we add a new VersionValue with a *clone*
			// of the value, so that it gets added to the DB.
			$newVer =& new ValueVersion($this);
			$newVer->setValue($value->clone());
			$this->_versions[] =& $newVer;
			$this->_numVersions++;
			
			// tell the new version to update to the DB on commit();
			$newVer->update();
			
			// now, we h have to activate the new version
			$oldVer =& $this->getActiveVersion();
			$oldVer->setActiveFlag(false);
			$oldVer->update();
			$newVer->setActiveFlag(true);
			
			// all done (we hope)
			return true;
		}
		
		// let's just set the value of the existing one.
		$actVer =& $this->getActiveVersion();
		$oldVal =& $actVer->getValue();
		if ($oldVal) $oldVal->takeValue($value);
		else $actVer->setValue($value);
		
		// now tell actVer to update the DB on commit()
		$actVer->update();
		return true;
	}
	
	function &getActiveVersion() {
		if ($this->_numVersions == 0) return new ValueVersion($this);
	}
	
	function getVersionList() {
		return array_keys($this->_versions);
	}
	
	function &getVersion( $verID ) {
		if (!isset($this->_versions[$verID])) {
			throwError( new Error("Could not find version ID $verID.","ValueVersions",true));
		}
		return $this->_versions[$verID];
	}
	
}

class ValueVersion {
	
	var $_myID;
	
	var $_date;
	var $_valueObj;
	var $_active;
	
	var $_parent;
	
	var $_update;
	
	function ValueVersion(&$parent) {
		$this->_date = null;
		$this->_valueObj = null;
		$this->_active = false;
		
		$this->_parent =& $parent;
		
		$this->_update = false;
	}
	
	function update() { $this->_update=true; }
	
	function setActiveFlag($active) {
		ArgumentValidator::validate($active, new BooleanValidatorRule());
		
		$this->_active = $active;
	}
	
	function populate( $arrayOfRows ) {
		
	}
	
	function setValue(&$object) {
		$this->_valueObj =& $object;
	}
	
	function &getValue() {
		return $this->_valueObj;
	}
	
	function &getDate() {
		return $this->_date;
	}
	
	function setDate(&$date) {
		ArgumentValidator::validate($date, new ExtendsValidatorRule("DateTime"));
		$this->_date =& $date;
	}
	
	function getID() {
		return $this->_myID;
	}
}

class FieldNotFoundError extends Error {
	function FieldNotFoundError($label,$id) {
		parent::Error("The field labeled '$label' was not found in DataSet id $id.","DataSet",true);
	}
}

class ValueIndexNotFoundError extends Error {
	function ValueIndexNotFoundError($label,$id,$index) {
		parent::Error("The value index $index was not found for field '$label' in DataSet ID $id.","DataSet",true);
	}
}

?>