<?php

/**
 * the FieldSetInterface defines the methods required by any FieldSet class or derivatives
 *
 * @version $Id: FieldSet.interface.php,v 1.3 2003/06/23 13:22:52 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
 **/

class FieldSetInterface {
	/**
	 * returns the value of $key
	 * 
	 * @param string $key the key to return
	 * @access public
	 * @return mixed the value associated with $key
	 **/
	function & get( $key ) {}
	
	/**
	 * returns an array of keys
	 * 
	 * @access public
	 * @return array an array of keys that are set
	 **/
	function getKeys() {}
	
	/**
	 * returns the number of fields set
	 * 
	 * @access public
	 * @return int the number of fields
	 **/
	function count() {}
	
	/**
	 * sets the value associated with $key to $val
	 * 
	 * @param string $key the key
	 * @param mixed $val the value to set $key to
	 * @access public
	 * @return void 
	 **/
	function set( $key, $val ) {}
	
	/**
	 * clears the fieldset
	 * 
	 * @access public
	 * @return void
	 **/
	function clear() {}
	
	/**
	 * unsets the specified key
	 * 
	 * @param string $key the key to unset
	 * @access public
	 * @return int the number of fields
	 **/
	function unset( $key ) {}
}

?>