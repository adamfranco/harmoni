<?php

//require_once(HARMONI."utilities/FieldSetValidator/FieldSet.interface.php");

/**
 * the FieldSet holds a set of key=value pairs of data
 *
 * @package harmoni.utilities.fieldsetvalidator
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FieldSet.class.php,v 1.7 2007/09/04 20:25:55 adamfranco Exp $
 */
class FieldSet {
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
	 * @param optional array $fields an associative array of key/value pairs to initialize with
	 * @access public
	 * @return void 
	 **/
	function __construct( $fields = null ) {
		if ($fields && is_array($fields)) $this->_fields =  $fields;
		else $this->clear();
	}
	
	/**
	 * returns the value of $key
	 * 
	 * @param string $key the key to return
	 * @access public
	 * @return mixed the value associated with $key
	 **/
	function get( $key ) {
		if (isset($this->_fields[$key]))
			return $this->_fields[$key];
		else
			return null;
	}
	
	/**
	 * returns an array of keys
	 * 
	 * @access public
	 * @return array an array of keys that are set
	 **/
	function getKeys() {
		if ($this->count()) return array_keys($this->_fields);
		return array();
	}
	
	/**
	 * returns the number of fields set
	 * 
	 * @access public
	 * @return int the number of fields
	 **/
	function count() {
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
		$this->_fields[$key] =  $val;
	}
	
	/**
	 * clears the fieldset
	 * 
	 * @access public
	 * @return void
	 **/
	function clear() {
		$this->_fields = array();
	}
	
	/**
	 * unsets the specified key
	 * 
	 * @param string $key the key to unset
	 * @access public
	 * @return int the number of fields
	 **/
	function unsetKey( $key ) {
		unset($this->_fields[$key]);
	}
}