<?php

class DataTypeInterface {
	
	function toString() { }
	
	function isEqual( &$dataType ) { }
	
	function getID() { }
	
	function setStringValue( $string ) { }
	
	function insert() { }
	
	function update() { }
	
}

?>