<?php

require_once HARMONI."metaData/manager/DataType.interface.php";

class DataType extends DataTypeInterface {
	
	var $_myID;
	var $_dbID;
	
	var $_idManager;
	
/*	function DataType( ) {
		$this->_myID=null;
		$this->_dbID=null;
	}*/
	
	function setup(&$idManager, $dbID/*, $myID*/) {
		$this->_dbID = $dbID;
		$this->_idManager =& $idManager;
//		$this->_setMyID($myID);
	}
	
	function toString() {
		return false;
	}
	
	function getID() {
		return $this->_myID;
	}
	
	function setID($id) {
		$this->_setMyID($id);
	}
	
	function _setMyID($id) {
		$this->_myID = $id;
	}
	
	function setValueFromString($string) {
		return false;
	}
}

?>