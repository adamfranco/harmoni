<?php

/**
 * the FieldSetValidatorInterface defines the required methods for any FieldSetValidator class
 *
 * @package harmoni.untilities.FieldSetValidator
 * @version $Id: FieldSetValidator.interface.php,v 1.1 2003/06/22 23:06:56 gabeschine Exp $
 * @copyright 2003 
 **/

class FieldSetValidatorInterface {
	/**
	 * validates the value of $key against the rules defined for it
	 * 
	 * @param string $key the key to validate
	 * @access public
	 * @return boolean if the validation was successful or not
	 **/
	function validate( $key ) {}
	
	/**
	 * validates all defined keys in the FieldSet against those in the RuleSet
	 * 
	 * @access public
	 * @return boolean if the validation was successful or not
	 **/
	function validateAll() {}
	
	/**
	 * sets the fieldset object to use to $fieldset
	 * 
	 * @param object FieldSet $fieldset the object to use
	 * @access public
	 * @return void 
	 **/
	function setFieldSet( & $fieldset ) {}
	
	/**
	 * sets the ruleset object to use to $ruleset
	 * 
	 * @param object RuleSet $ruleset the object to use
	 * @access public
	 * @return void 
	 **/
	function setRuleSet( & $ruleset ) {}
	
}

?>