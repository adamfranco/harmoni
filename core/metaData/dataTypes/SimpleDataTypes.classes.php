<?php

require_once HARMONI."metaData/manager/DataType.abstract.php";

class IntegerDataType
	extends DataType {
	
	var $_value;
	
	function IntegerDataType($value=0) {
		$this->_value = $value;
	}
	
	function setValueFromString( $string ) {
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
	
	function insert() {
		$integerType = new HarmoniType("Harmoni","HarmoniDataManager","IntegerDataType",
			"Allows for the storage of integer values (big ones too) in DataSets.");
		
		$newID = $this->_idManager->newID($integerType);
		
		$query =& new InsertQuery();
		$query->setTable("data_integer");
		$query->setColumns(array("data_integer_id","data_integer_data"));
		
		$query->addRowOfValues(array($newID,$this->_value));
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("IntegerDataType") );
			return false;
		}
		
		$this->_setMyID($newID);
		return true;
	}
	
	function update() {
		if (!$this->getID()) return false;
		
		$query =& new UpdateQuery();
		$query->setTable("data_integer");
		$query->setColumns(array("data_integer_data"));
		$query->setWhere("data_integer_id=".$this->getID());
		
		$query->setValues(array($this->_value));
	}
	
	function alterQuery( &$query ) {
		$query->addTable("data_integer",LEFT_JOIN,"data_integer_id = fk_data");
		$query->addColumn("data_integer_id");
		$query->addColumn("data_integer_value");
	}
	
	function populate( &$dbRow ) {
		$this->_value = intval($dbRow['data_integer_value']);
	}
}

?>