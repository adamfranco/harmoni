<?php

/**
 * the RuleSetInterface defines the methods that are required for any ruleset.
 * 
 * any RuleSet should let the user define a number of keys with associated rules (one or more) and then let the user check any value against the rules defined for a key
 *
 * @version $Id: RuleSet.interface.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.interfaces.utilities.fieldsetvalidator
 **/

class RuleSetInterface {
	/**
	 * Sets the {@link ErrorHandler} to use if validation fails on a certain field.
	 * @param ref object $handler The {@link ErrorHandler}.
	 * @access public
	 * @return void 
	 **/
	function setErrorHandler(&$handler) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }	
	
	/**
	 * adds a new $rule to $key, which if fails when validated throws $error
	 * @param string $key the key to associate the rule with
	 * @param ref object ValidatorRule $rule the ValidatorRule object to be added
	 * @param optional object Error $error the error to throw if the validation fails
	 * @access public
	 * @return void 
	 **/
	function addRule( $key, & $rule, $error=null ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * validates $val against the rules defined for $key. if validation fails the associated error is thrown
	 * @param string $key the key to look at for rules
	 * @param mixed $val the value to check against the rules
	 * @param optional boolean $throwErrors Should we throw the specified errors if validation
	 * fails or just return true/false. Default = TRUE.
	 * @access public
	 * @return boolean if the validation succeeded or failed
	 **/
	function validate( $key, $val, $throwErrors=true ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * returns an array of keys
	 * 
	 * @access public
	 * @return array an array of keys that are set
	 **/
	function getKeys() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * returns the number of keys with rules
	 * 
	 * @access public
	 * @return int the number of keys
	 **/
	function count() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}

?>