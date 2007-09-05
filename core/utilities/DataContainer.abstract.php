<?php

require_once(HARMONI."utilities/DataContainer.interface.php");
require_once(HARMONI."utilities/FieldSetValidator/FieldSet.class.php");
require_once(HARMONI."utilities/FieldSetValidator/RuleSet.class.php");

/**
 * The DataContainer class encapsulates a FieldSet, and a RuleSet and sets up field-setting restrictions.
 * 
 * The class is abstract and allows children to set up a list of fields (keys) that can be set/accessed, and rules to be associated with them.
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DataContainer.abstract.php,v 1.8 2007/09/05 19:55:22 adamfranco Exp $
 *
 * @abstract
 */
class DataContainer 
	extends DataContainerInterface 
{
	/**
	 * The FieldSet where we will store our data.
	 * @access private
	 * @var object FieldSet $_fieldSet
	 **/
	var $_fieldSet;
	
	/**
	 * The RuleSet that will define both rules and what keys are allowed.
	 * @access private
	 * @var object RuleSet $_ruleSet
	 **/
	var $_ruleSet;
	
	/**
	 * The init function -- sets up the private variables.
	 * @access protected
	 * @return void 
	 **/
	function init() {
		$this->_fieldSet =  new FieldSet;
		$this->_ruleSet =  new RuleSet;
	}
	
	/**
	 * The add method adds a new field with associated rule and optional error if validation fails.
	 * @param string $field The key of the field to add.
	 * @param ref object ValidatorRule $rule The validator rule to apply to the value set to this key.
	 * @param optional object Error $error The error to throw if validation of this key fails.
	 * @access protected
	 * @see FieldSetValidator
	 * @return void 
	 **/
	function add( $field, $rule, $message = null, $type = '' ) {
		// add the $field to the ruleset with the rule & error
		if ($message == null) {
			// add the default error for a DataContainer
			$message = "";
			$message .= "The field '$field' in the DataContainer '".get_class($this);
			$message .= "' could not be validated using the rule: ";
			$message .= get_class($rule);
			$message .= ".";
			$type = "System";
		}
		$this->_ruleSet->addRule( $field, $rule, $message, $type );
		// done;
	}
	
	/**
	 * The get method returns the value stored in the FieldSet for $field.
	 * @param string $field The field to get.
	 * @access public
	 * @return mixed The value of $field. 
	 **/
	function get( $field ) {
		// check if this is a valid key
		if (!in_array($field,$this->_ruleSet->getKeys())) {
			throwError(new Error(get_class($this)." - can not get the value for key '$field' because it is not a valid key!","DataContainer",true));
			return false;
		}
		return $this->_fieldSet->get( $field );
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
			printDebugBacktrace();
			throwError( new Error(get_class($this)." - can not set key '$field' because it is not a valid key!","DataContainer",true));
			return false;
		}
		if ($this->_ruleSet->validate($field, $val)) {
			$this->_fieldSet->set($field, $val);
			return true;
		}
		return false;
	}
	
	/**
	 * Goes through all the keys and makes sure they comply to the rules specified for them.
	 * @access public
	 * @return boolean TRUE if all are OK, FALSE otherwise.
	 **/
	function checkAll() {
		$toCheck = $this->_ruleSet->getKeys();
		foreach ($toCheck as $key) {
			if (!$this->_ruleSet->validate($key,$this->_fieldSet->get($key)))
				return false;
		}
		return true;
	}
}

?>