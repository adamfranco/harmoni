<?php

require_once HARMONI."metaData/manager/DataType.interface.php";


/**
 * The DataType abstract class sets up some default functionality for other DataType classes.
 * @package harmoni.datamanager
 * @version $Id: DataType.abstract.php,v 1.8 2004/03/31 19:13:26 adamfranco Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 * @abstract
 **/
class DataType extends DataTypeInterface {
	
	var $_myID;
	var $_dbID;
	
	function setup($dbID) {
		$this->_dbID = $dbID;
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