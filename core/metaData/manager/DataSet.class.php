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
	
	function _checkLabel($label, $function) {
		
	}
	
	function setValue($label, &$obj, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		// check if $obj is of the required type for $label
		// ...
		
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
		return $this->_values[$index]->numVersions();
	}
	
	function getVersionList( $index=0 ) {
		
	}
	
	function &getVersion( $verID, $index=0 ) {
		
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
		
	}
	
	function setValue(&$value) {
		
	}
	
	function getVersionList() {
		
	}
	
	function &getVersion( $verID ) {
		
	}
	
}

class ValueVersion {
	
	var $_myID;
	
	var $_date;
	var $_valueObj;
	var $_active;
	
	function ValueVersion() {
		$this->_date = null;
		$this->_valueObj = null;
		$this->_active = false;
	}
	
	function setActiveFlag($active) {
		ArgumentValidator::validate($active, new BooleanValidatorRule());
		
		$this->_active = $active;
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