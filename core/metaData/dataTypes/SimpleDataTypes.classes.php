<?php

require_once HARMONI."metaData/manager/DataType.abstract.php";

class IntegerDataType
	extends DataType {
	
	var $_value;
	
	function IntegerDataType($value=0) {
		$this->_value = $value;
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
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("IntegerDataType") );
			return false;
		}
	}
	
	function commit() {
		// decides whether to insert() or update()
		if ($this->getID()) $this->update();
		else $this->insert();
	}
	
	function alterQuery( &$query ) {
		$query->addTable("data_integer",LEFT_JOIN,"data_integer_id = fk_data");
//		$query->addColumn("data_integer_id");
		$query->addColumn("data_integer_data");
	}
	
	function populate( &$dbRow ) {
		$this->_value = intval($dbRow['data_integer_data']);
	}
	
	function takeValue(&$fromObject) {
		$this->_value = $fromObject->_value;
	}
	
	function &clone() {
		return new IntegerDataType($this->_value);
	}
}

class StringDataType
	extends DataType {
	
	var $_value;
	
	function IntegerDataType($value='') {
		$this->_value = $value;
	}
	
	function toString() {
		return $this->_value;
	}
	
	function isEqual(&$dataType) {
		if ($this->_value == $dataType->toString()) return true;
		return false;
	}
	
	function insert() {
		$stringType = new HarmoniType("Harmoni","HarmoniDataManager","StringDataType",
			"Allows for the storage of string values (up to 255 characters) in DataSets.");
		
		$newID = $this->_idManager->newID($stringType);
		
		$query =& new InsertQuery();
		$query->setTable("data_string");
		$query->setColumns(array("data_string_id","data_string_data"));
		
		$query->addRowOfValues(array($newID,"'".addslashes($this->_value)."'"));
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("StringDataType") );
			return false;
		}
		
		$this->_setMyID($newID);
		return true;
	}
	
	function update() {
		if (!$this->getID()) return false;
		
		$query =& new UpdateQuery();
		$query->setTable("data_string");
		$query->setColumns(array("data_string_data"));
		$query->setWhere("data_string_id=".$this->getID());
		
		$query->setValues(array("'".addslashes($this->_value)."'"));
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("StringDataType") );
			return false;
		}
	}
	
	function commit() {
		// decides whether to insert() or update()
		if ($this->getID()) $this->update();
		else $this->insert();
	}
	
	function alterQuery( &$query ) {
		$query->addTable("data_string",LEFT_JOIN,"data_string_id = fk_data");
//		$query->addColumn("data_string_id");
		$query->addColumn("data_string_data");
	}
	
	function populate( &$dbRow ) {
		$this->_value = intval($dbRow['data_string_data']);
	}
	
	function takeValue(&$fromObject) {
		$this->_value = $fromObject->_value;
	}
	
	function &clone() {
		return new StringDataType($this->_value);
	}
}

?>