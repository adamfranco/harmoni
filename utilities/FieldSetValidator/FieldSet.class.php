<?php

require_once("FieldSet.interface.php");

/**
 * the FieldSet holds a set of key=value pairs of data
 *
 * @version $Id: FieldSet.class.php,v 1.2 2003/06/23 00:58:44 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
 **/

class FieldSet
	extends FieldSetInterface
{
	/**
	 * an associative array of keys and values
	 * 
	 * @access private
	 * @var mixed $_fields the associative array
	 */ 
	var $_fields;
	
	/**
	 * the constructor
	 * 
	 * @param array $fields (optional) an associative array of key/value pairs to initialize with
	 * @access public
	 * @return void 
	 **/
	function FieldSet( $fields = null ) {
		if ($fields && is_array($fields)) $this->_fields = & $fields;
	}
	
	/**
	 * returns the value of $key
	 * 
	 * @param string $key the key to return
	 * @access public
	 * @return mixed the value associated with $key
	 **/
	function & get( $key ) {
		return $this->_fields[$key];
	}
	
	/**
	 * returns an array of keys
	 * 
	 * @access public
	 * @return array an array of keys that are set
	 **/
	function getKeys() {
		if ($this->size())return array_keys($this->_fields);
		return array();
	}
	
	/**
	 * returns the number of fields set
	 * 
	 * @access public
	 * @return int the number of fields
	 **/
	function size() {
		return count($this->_fields);
	}
	
	/**
	 * sets the value associated with $key to $val
	 * 
	 * @param string $key the key
	 * @param mixed $val the value to set $key to
	 * @access public
	 * @return void 
	 **/
	function set( $key, $val ) {
		$this->_fields[$key] = & $val;
	}
}

?>