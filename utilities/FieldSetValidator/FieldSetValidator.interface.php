<?php

/**
 * the FieldSetValidatorInterface defines the required methods for any FieldSetValidator class
 *
 * @package harmoni.utilities.fieldsetvalidator
 * @version $Id: FieldSetValidator.interface.php,v 1.4 2003/07/10 02:34:21 gabeschine Exp $
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
	function validate( $key ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * validates all defined keys in the FieldSet against those in the RuleSet
	 * 
	 * @access public
	 * @return boolean if the validation was successful or not
	 **/
	function validateAll() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
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