<?php

/**
 * The DataTypeInterface defines the required functions for any DataType for use within the
 * {@link HarmoniDataManager}.
 * @package harmoni.datamanager.interfaces
 * @version $Id: DataType.interface.php,v 1.5 2004/01/01 19:03:42 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class DataTypeInterface {
	
	function toString() { }
	
	function isEqual( &$dataType ) { }
	
	function getID() { }
	
	function setStringValue( $string ) { }
	
	function insert() { }
	
	function update() { }
	
	function commit() { }
	
	function alterQuery( &$query ) { }
	
	function populate( &$dbRow ) { }
	
	function takeValue(&$fromObject) { }
	
	function &clone() { }
	
	function setup(&$idManager, $dbID) { }
	
	function setID() { }
	
}

?>