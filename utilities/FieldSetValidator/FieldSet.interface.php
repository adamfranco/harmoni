<?php

/**
 * the FieldSetInterface defines the methods required by any FieldSet class or derivatives
 *
 * @version $Id: FieldSet.interface.php,v 1.5 2003/06/23 20:42:35 adamfranco Exp $
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
	function & get( $key ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * returns an array of keys
	 * 
	 * @access public
	 * @return array an array of keys that are set
	 **/
	function getKeys() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * returns the number of fields set
	 * 
	 * @access public
	 * @return int the number of fields
	 **/
	function count() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * sets the value associated with $key to $val
	 * 
	 * @param string $key the key
	 * @param mixed $val the value to set $key to
	 * @access public
	 * @return void 
	 **/
	function set( $key, $val ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * clears the fieldset
	 * 
	 * @access public
	 * @return void
	 **/
	function clear() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * unsets the specified key
	 * 
	 * @param string $key the key to unset
	 * @access public
	 * @return int the number of fields
	 **/
	function unsetKey( $key ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}

?>