<?php

require_once HARMONI."metaData/manager/DataType.interface.php";


/**
 * The DataType abstract class sets up some default functionality for other DataType classes.
 * @package harmoni.datamanager
 * @version $Id: DataType.abstract.php,v 1.7 2004/01/14 03:21:25 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 * @abstract
 **/
class DataType extends DataTypeInterface {
	
	var $_myID;
	var $_dbID;
	
	var $_idManager;
	
	function setup(&$idManager, $dbID) {
		$this->_dbID = $dbID;
		$this->_idManager =& $idManager;
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
	
	function makeSearchString(&$val) {
		return null;
	}
	
}

?>