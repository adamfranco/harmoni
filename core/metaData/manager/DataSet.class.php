<?php

class DataSet {

	var $_idManager;
	var $_dbID;
	var $_dataSetTypeDef;
	
	function DataSet(&$idManager, $dbID, &$dataSetTypeDef) {
		$this->_idManager = $idManager;
		$this->_dbID = $dbID;
		$this->_dataSetTypeDef = $dataSetTypeDef;
	}
	
	function getFieldType($label) {
		return $this->_dataSetTypeDef->getFieldType($label);
	}
	
	function setValue($label, $valueStr, $index=0) {
		
	}
	
	function addValue($label, $valueStr) {
		
	}
	
	function setValueObject($label, &$obj, $index=0) {
		
	}
	
	function addValueObject($label, &$obj) {
		
	}
	
	function commit() {
		
	}
	
	function populate() {
		
	}
	
	function numValues($label) {
		
	}
	
}

class DataFieldArray {
	
	var $_numValues;
	var $_values;
	
	var $_parent;
	var $_myLabel;
	
	var $_mult;
	var $_verControl;
	
	function DataField( $label, &$parent, &$values, $mult=false, $verControl=false ) {
		ArgumentValidator::validate($values, new ArrayValidatorRule());
		$this->_values =& $values;
		$this->_numValues = count($values);
		
		$this->_mult = $mult;
		$this->_verControl = $verControl;
		
		$this->_parent =& $parent;
		$this->_label = $label;
	}
	
	function &getValue($index) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
	}
	
	function setValue($index, &$value) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		if ($this->_verControl) {
			// ...
		}
	}
	
	function addValue(&$value) {
		if (!$this->_mult) {
			// we don't do multiple values... die.
			throwError( new Error("This field, '".$this->_myLabel."', does not support multiple values. Can not addValue().","DataSet",true));
			return false;
		}
		
		$this->_values[] =& $value;
		$this->_numValues++;
		return true;
	}
	
	function numValues() { return $this->_numValues; }
	
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