<?php

/**
 * the FieldSetValidatorInterface defines the required methods for any FieldSetValidator class
 *
 * @package harmoni.interfaces.utilities.fieldsetvalidator
 * @version $Id: FieldSetValidator.interface.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 **/

class FieldSetValidatorInterface {
	/**
	 * validates the value of $key against the rules defined for it
	 * 
	 * @param string $key the key to validate
	 * @param optional boolean $throwErrors Should we throw the specified errors if validation
	 * fails or just return true/false. Default = TRUE.
	 * @access public
	 * @return boolean if the validation was successful or not
	 **/
	function validate( $key, $throwErrors=true ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * validates all defined keys in the FieldSet against those in the RuleSet
	 * 
	 * @param optional boolean $throwErrors Should we throw the specified errors if validation
	 * fails or just return true/false. Default = TRUE.
	 * @access public
	 * @return boolean if the validation was successful or not
	 **/
	function validateAll( $throwErrors=true ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * sets the fieldset object to use to $fieldset
	 * 
	 * @param object FieldSet $fieldset the object to use
	 * @access public
	 * @return void 
	 **/
	function setFieldSet( & $fieldset ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * sets the ruleset object to use to $ruleset
	 * 
	 * @param object RuleSet $ruleset the object to use
	 * @access public
	 * @return void 
	 **/
	function setRuleSet( & $ruleset ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
}

?>