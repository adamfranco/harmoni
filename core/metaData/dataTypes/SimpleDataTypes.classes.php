<?php

require_once HARMONI."metaData/manager/DataType.abstract.php";

/**
 * A simple integer data type.
 * @package harmoni.datamanager.datatypes
 * @version $Id: SimpleDataTypes.classes.php,v 1.14 2004/01/14 03:21:21 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class IntegerDataType
	extends DataType {
	
	var $_value;
	
	function IntegerDataType($value=0) {
		$this->_value = $value;
	}
	
	function makeSearchString(& $val ) {
		return "data_integer.data_integer_data=".$val->toString();
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
	
	function prune() {
		if (!$this->getID()) return false;
		// delete ourselves from our data table
		$table = "data_integer";
		
		$query =& new DeleteQuery;
		$query->setTable($table);
		$query->setWhere($table."_id=".$this->getID());
		
		$dbHandler =& Services::getService("DBHandler");
		$res =& $dbHandler->query($query, $this->_dbID);
		
		if (!$res) throwError( new UnknownDBError("DataType"));
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

/**
 * A simple float data type.
 * @package harmoni.datamanager.datatypes
 * @version $Id: SimpleDataTypes.classes.php,v 1.14 2004/01/14 03:21:21 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class FloatDataType
	extends DataType {
	
	var $_value;
	
	function FloatDataType($value=0) {
		$this->_value = floatval($value);
	}
	
	function makeSearchString(& $val ) {
		return "data_float.data_float_data=".$val->toString();
	}
	
	function toString() {
		return $this->_value;
	}
	
	function isEqual(&$dataType) {
		if ($this->_value == $dataType->_value) return true;
		return false;
	}
	
	function insert() {
		$floatType = new HarmoniType("Harmoni","HarmoniDataManager","FloatDataType",
			"Allows for the storage of integer values (big ones too) in DataSets.");
		
		$newID = $this->_idManager->newID($floatType);
		
		$query =& new InsertQuery();
		$query->setTable("data_float");
		$query->setColumns(array("data_float_id","data_float_data"));
		
		$query->addRowOfValues(array($newID,$this->_value));
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("FloatDataType") );
			return false;
		}
		
		$this->_setMyID($newID);
		return true;
	}
	
	function update() {
		if (!$this->getID()) return false;
		
		$query =& new UpdateQuery();
		$query->setTable("data_float");
		$query->setColumns(array("data_float_data"));
		$query->setWhere("data_float_id=".$this->getID());
		
		$query->setValues(array($this->_value));
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("FloatDataType") );
			return false;
		}
	}
	
	function commit() {
		// decides whether to insert() or update()
		if ($this->getID()) $this->update();
		else $this->insert();
	}
	
	function prune() {
		if (!$this->getID()) return false;
		// delete ourselves from our data table
		$table = "data_float";
		
		$query =& new DeleteQuery;
		$query->setTable($table);
		$query->setWhere($table."_id=".$this->getID());
		
		$dbHandler =& Services::getService("DBHandler");
		$res =& $dbHandler->query($query, $this->_dbID);
		
		if (!$res) throwError( new UnknownDBError("DataType"));
	}
	
	function alterQuery( &$query ) {
		$query->addTable("data_float",LEFT_JOIN,"data_float_id = fk_data");
		$query->addColumn("data_float_data");
	}
	
	function populate( &$dbRow ) {
		$this->_value = floatval($dbRow['data_float_data']);
	}
	
	function takeValue(&$fromObject) {
		$this->_value = $fromObject->_value;
	}
	
	function &clone() {
		return new FloatDataType($this->_value);
	}
}

/**
 * A simple (large) string data type.
 * @package harmoni.datamanager.datatypes
 * @version $Id: SimpleDataTypes.classes.php,v 1.14 2004/01/14 03:21:21 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class StringDataType
	extends DataType {
	
	var $_value;
	
	function StringDataType($value='') {
		$this->_value = $value;
	}
	
	function makeSearchString(& $val ) {
		return "data_string.data_string_data='".addslashes($val->toString())."'";
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
			"Allows for the storage of string values (large) in DataSets.");
		
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
	
	function prune() {
		if (!$this->getID()) return false;
		// delete ourselves from our data table
		$table = "data_string";
		
		$query =& new DeleteQuery;
		$query->setTable($table);
		$query->setWhere($table."_id=".$this->getID());
		
		$dbHandler =& Services::getService("DBHandler");
		$res =& $dbHandler->query($query, $this->_dbID);
		
		if (!$res) throwError( new UnknownDBError("DataType"));
	}
	
	function alterQuery( &$query ) {
		$query->addTable("data_string",LEFT_JOIN,"data_string_id = fk_data");
//		$query->addColumn("data_string_id");
		$query->addColumn("data_string_data");
	}
	
	function populate( &$dbRow ) {
		$this->_value = $dbRow['data_string_data'];
	}
	
	function takeValue(&$fromObject) {
		$this->_value = $fromObject->_value;
	}
	
	function &clone() {
		return new StringDataType($this->_value);
	}
}
/**
 * A simple short string (up to 255 chars) data type.
 * @package harmoni.datamanager.datatypes
 * @version $Id: SimpleDataTypes.classes.php,v 1.14 2004/01/14 03:21:21 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class ShortStringDataType
	extends DataType {
	
	var $_value;
	
	function ShortStringDataType($value='') {
		$this->_value = $value;
	}
		
	function makeSearchString(& $val ) {
		return "data_shortstring.data_shortstring_data='".addslashes($val->toString())."'";
	}

	function toString() {
		return $this->_value;
	}
	
	function isEqual(&$dataType) {
		if ($this->_value == $dataType->toString()) return true;
		return false;
	}
	
	function insert() {
		$stringType = new HarmoniType("Harmoni","HarmoniDataManager","ShortStringDataType",
			"Allows for the storage of short string values (up to 255 characters) in DataSets.");
		
		$newID = $this->_idManager->newID($stringType);
		
		$query =& new InsertQuery();
		$query->setTable("data_shortstring");
		$query->setColumns(array("data_shortstring_id","data_shortstring_data"));
		
		$query->addRowOfValues(array($newID,"'".addslashes($this->_value)."'"));
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("ShortStringDataType") );
			return false;
		}
		
		$this->_setMyID($newID);
		return true;
	}
	
	function update() {
		if (!$this->getID()) return false;
		
		$query =& new UpdateQuery();
		$query->setTable("data_shortstring");
		$query->setColumns(array("data_shortstring_data"));
		$query->setWhere("data_shortstring_id=".$this->getID());
		
		$query->setValues(array("'".addslashes($this->_value)."'"));
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("ShortStringDataType") );
			return false;
		}
	}
	
	function commit() {
		// decides whether to insert() or update()
		if ($this->getID()) $this->update();
		else $this->insert();
	}
	
	function prune() {
		if (!$this->getID()) return false;
		// delete ourselves from our data table
		$table = "data_shortstring";
		
		$query =& new DeleteQuery;
		$query->setTable($table);
		$query->setWhere($table."_id=".$this->getID());
		
		$dbHandler =& Services::getService("DBHandler");
		$res =& $dbHandler->query($query, $this->_dbID);
		
		if (!$res) throwError( new UnknownDBError("DataType"));
	}
	
	function alterQuery( &$query ) {
		$query->addTable("data_shortstring",LEFT_JOIN,"data_shortstring_id = fk_data");
		$query->addColumn("data_shortstring_data");
	}
	
	function populate( &$dbRow ) {
		$this->_value = $dbRow['data_shortstring_data'];
	}
	
	function takeValue(&$fromObject) {
		$this->_value = $fromObject->_value;
	}
	
	function &clone() {
		return new ShortStringDataType($this->_value);
	}
}
/**
 * A simple boolean data type.
 * @package harmoni.datamanager.datatypes
 * @version $Id: SimpleDataTypes.classes.php,v 1.14 2004/01/14 03:21:21 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class BooleanDataType
	extends DataType {
	
	var $_value;
	
	function BooleanDataType($value=false) {
		$this->_value = $value;
	}
		
	function makeSearchString(& $val ) {
		return "data_boolean.data_boolean_data=".(($val->getBooleanValue())?"1":"0");
	}

	function toString() {
		return $this->_value?"true":"false";
	}
	
	function getBooleanValue() {
		return $this->_value;
	}
	
	function isEqual(&$dataType) {
		if ($this->_value === $dataType->getBooleanValue()) return true;
		return false;
	}
	
	function insert() {
		$boolType = new HarmoniType("Harmoni","HarmoniDataManager","BooleanDataType",
			"Allows for the storage of boolean data types (true/false) in DataSets.");
		
		$newID = $this->_idManager->newID($boolType);
		
		$query =& new InsertQuery();
		$query->setTable("data_boolean");
		$query->setColumns(array("data_boolean_id","data_boolean_data"));
		
		$query->addRowOfValues(array($newID,$this->_value?1:0));
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		if (!$result || $result->getNumberOfRows() != 1) {
			throwError( new UnknownDBError("BooleanDataType") );
			return false;
		}
		
		$this->_setMyID($newID);
		return true;
	}
	
	function update() {
		if (!$this->getID()) return false;
		
		$query =& new UpdateQuery();
		$query->setTable("data_boolean");
		$query->setColumns(array("data_boolean_data"));
		$query->setWhere("data_boolean_id=".$this->getID());
		
		$query->setValues(array($this->_value?1:0));
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("BooleanDataType") );
			return false;
		}
	}
	
	function commit() {
		// decides whether to insert() or update()
		if ($this->getID()) $this->update();
		else $this->insert();
	}
	
	function prune() {
		if (!$this->getID()) return false;
		// delete ourselves from our data table
		$table = "data_boolean";
		
		$query =& new DeleteQuery;
		$query->setTable($table);
		$query->setWhere($table."_id=".$this->getID());
		
		$dbHandler =& Services::getService("DBHandler");
		$res =& $dbHandler->query($query, $this->_dbID);
		
		if (!$res) throwError( new UnknownDBError("DataType"));
	}
	
	function alterQuery( &$query ) {
		$query->addTable("data_boolean",LEFT_JOIN,"data_boolean_id = fk_data");
		$query->addColumn("data_boolean_data");
	}
	
	function populate( &$dbRow ) {
		$this->_value = $dbRow['data_boolean_data']?true:false;
	}
	
	function takeValue(&$fromObject) {
		$this->_value = $fromObject->_value;
	}
	
	function &clone() {
		return new BooleanDataType($this->_value);
	}
}

?>