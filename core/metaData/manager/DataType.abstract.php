<?php

require_once HARMONI."metaData/manager/DataType.interface.php";

class DataType extends DataTypeInterface {
	
	var $_myID;
	var $_dbID;
	
	var $_idManager;
	
	function DataType( ) {
		$this->_myID=null;
		$this->_dbID=null;
	}
	
	function setup(&$idManager, $dbID, $myID=null) {
		$this->_dbID = $dbID;
		$this->_myID = $myID;
		$this->_idManager =& $idManager;
	}
	
	function toString() {
		return false;
	}
	
	function getID() {
		return $this->_myID;
	}
	
	function setStringValue($string) {
		return false;
	}
}

?>