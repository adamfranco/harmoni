<?php

require_once("FieldSetValidator.interface.php");

/**
 * the FieldSetValidator takes a FieldSet and a RuleSet and validates values between the two
 *
 * @package harmoni.untilities.FieldSetValidator
 * @version $Id: FieldSetValidator.class.php,v 1.1 2003/06/22 23:06:56 gabeschine Exp $
 * @copyright 2003 
 **/

class FieldSetValidator
	extends FieldSetValidatorInterface
{
	/**
	 * the FieldSet object
	 * 
	 * @access private
	 * @var object FieldSet $_fieldset 
	 */ 
	var $_fieldset;
	
	/**
	 * the RuleSet object
	 * 
	 * @access private
	 * @var object RuleSet $_ruleset 
	 */ 
	var $_ruleset;
	
	/**
	 * the constructor
	 * 
	 * @param object FieldSet $fieldset the FieldSet object to use for values
	 * @param object RuleSet $ruleset the RuleSet object to use for rules/validation
	 * @access public
	 * @return void 
	 **/
	function FieldSetValidator( & $fieldset, & $ruleset ) {
		$this->_fieldset = & $fieldset;
		$this->_ruleset = & $ruleset;
	}
	
	/**
	 * sets the fieldset object to use to $fieldset
	 * 
	 * @param object FieldSet $fieldset the object to use
	 * @access public
	 * @return void 
	 **/
	function setFieldSet( & $fieldset ) {
		$this->_fieldset = & $fieldset;
	}
	
	/**
	 * sets the ruleset object to use to $ruleset
	 * 
	 * @param object RuleSet $ruleset the object to use
	 * @access public
	 * @return void 
	 **/
	function setRuleSet( & $ruleset ) {
		$this->_ruleset = & $ruleset;
	}
	
	/**
	 * validates the value of $key against the rules defined for it
	 * 
	 * @param string $key the key to validate
	 * @access public
	 * @return boolean if the validation was successful or not
	 **/
	function validate( $key ) {
		// get the value from the FieldSet
		$val = & $this->_fieldset->get($key);
		
		// run the rules and return
		return $this->_ruleset->validate( $key, & $val );
	}
	
	/**
	 * validates all defined keys in the FieldSet against those in the RuleSet
	 * 
	 * @access public
	 * @return boolean if the validation was successful or not
	 **/
	function validateAll() {
		// get all the defined keys
		$keys = $this->_fieldset->getKeys();
		
		$error = false; // assume no error
		// go through them and validate
		foreach ($keys as $key) {
			if (!$this->validate( $key )) $error = true;
		}
		if ($error) return false;
		return true;
	}
	
}

?>