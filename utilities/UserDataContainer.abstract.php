<?php

/**
 * A UserDataContainer is like a DataContainer, but is targeted towards data
 * used from http forms instead of configuration options in a script.
 * 
 * @package harmoni.utilities
 * @version $Id: UserDataContainer.abstract.php,v 1.1 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 **/
class UserDataContainer extends DataContainer {
	/**
	 * @access private
	 * @var array $_setFields An array of fields that have been set.
	 **/
	var $_setFields;

	/**
	 * The init function -- sets up the private variables.
	 * @access protected
	 * @return void 
	 **/
	function init() {
		parent::init();
		Services::requireService("UserError");
		$handler =& Services::getService("UserError");
		$this->_ruleSet->setErrorHandler($handler);
	}
	
	/**
	 * The set method sets the value for a field while checking constrictions.
	 * @param string $field The field to set.
	 * @param mixed $val The value to set $field to.
	 * @access public
	 * @return boolean True if setting $field succeeds. 
	 **/
	function set( $field, $val ) {
		// first check if this is a valid field.
		if (!in_array($field,$this->_ruleSet->getKeys())) {
			// no good
			throwError( new Error(get_class($this)." - can not set key '$field' because it is not a valid key!","UserDataContainer",true));
			return false;
		}
		if ($this->_ruleSet->validate($field, $val)) {
			$this->_fieldSet->set($field, $val);
			$this->_setFields[$field] = true;
			return true;
		}
		return false;
	}
	
	/**
	 * Checks to see if this field has been set.
	 * @access public
	 * @return boolean
	 **/
	function hasValue( $field ) {
		return isset($this->_setFields[$field]);
	}
	
	/**
	 * Returns the number of fields for which new values have been specified.
	 * @access public
	 * @return integer
	 **/
	function countChanged() {
		return count($this->_setFields);
	}
	
	/**
	 * Populates the attached FieldSet without processing rules or keeping track
	 * of what has been set.
	 * @param array $data An array of key=>value pairs.
	 * @access public
	 * @return void
	 **/
	function populate($data) {
		foreach($data as $key=>$val) {
			$this->_fieldSet->set($key,$val);
		}
	}
	
}

?>