<?php

/**
 * The DataContainer Interface defines the required methods for any DataContainer class or child.
 *
 * @version $Id: DataContainer.interface.php,v 1.1 2003/06/24 20:22:40 gabeschine Exp $
 * @copyright 2003
 * @package harmoni.utilities 
 **/

class DataContainerInterface {
	
	/**
	 * The init function -- sets up the private variables.
	 * @access protected
	 * @return void 
	 **/
	function init() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * The add method adds a new field with associated rule and optional error if validation fails.
	 * @param string $field The key of the field to add.
	 * @param object ValidatorRule $rule The validator rule to apply to the value set to this key.
	 * @param object Error [$error] (optional) The error to throw if validation of this key fails.
	 * @access protected
	 * @return void 
	 **/
	function add( $field, & $rule, $error=null ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * The get method returns the value stored in the FieldSet for $field.
	 * @param string $field The field to get.
	 * @access public
	 * @return mixed The value of $field. 
	 **/
	function & get( $field ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * The set method sets the value for a field while checking constrictions.
	 * @param string $field The field to set.
	 * @param mixed $val The value to set $field to.
	 * @access public
	 * @return boolean True if setting $field succeeds. 
	 **/
	function set( $field, $val ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
}

?>