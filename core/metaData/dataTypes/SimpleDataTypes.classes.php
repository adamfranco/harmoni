<?php

class IntegerDataType
	extends DataType {
	
	var $_value;
	
	function setStringValue( $string ) {
		ArgumentValidator::validate($string, new NumericValidatorRule());
		$this->_value = intval($string);
		return true;
	}
	
	function toString() {
		return $this->_value;
	}
	
	function isEqual(&$dataType) {
		if ($this->_value == $dataType->toString()) return true;
		return false;
	}
}



?>