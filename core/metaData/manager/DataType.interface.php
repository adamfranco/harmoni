<?php

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