<?php

/**
 * the ReferencedFieldSet holds a set of key=value pairs of data, where the value is passed by reference
 *
 * @version $Id: ReferencedFieldSet.class.php,v 1.1 2004/06/21 19:26:19 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator
 **/

class ReferencedFieldSet extends FieldSet {
	/**
	 * @param optional array $fields an associative array of key/value pairs to initialize with
	 * @access public
	 * @return void 
	 **/
	function ReferencedFieldSet( $fields = null ) {
		$this->FieldSet($fields);
	}
	
	/**
	 * sets the value associated with $key to $val
	 * 
	 * @param string $key the key
	 * @param ref mixed $val the value to set $key to
	 * @access public
	 * @return void 
	 **/
	function set( $key, & $val ) {
		$this->_fields[$key] = & $val;
	}
	
}

?>
