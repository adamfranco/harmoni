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
	
	function setValue($label, &$obj, $index=0) {
		
	}
	
	function &getValue($label, $index=0) {
		
	}
	
	function getAllValues($label) {
		
	}
	
	function commit() {
		
	}
	
	function populate( $arrayOfRows = null, $full = false ) {
		
	}
	
	function numValues($label) {
		
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
	
	function setValue($index, &$value) {
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
	
	function numVersions() {
		
	}
	
	function setValue(&$value) {
		
	}
	
	function getVersionList() {
		
	}
	
	function &getVersion( $verID ) {
		
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