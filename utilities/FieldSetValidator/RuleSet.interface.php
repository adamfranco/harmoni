<?php

/**
 * the RuleSetInterface defines the methods that are required for any ruleset
 * 
 * any RuleSet should let the user define a number of keys with associated rules (one or more) and then let the user check any value against the rules defined for a key
 *
 * @version $Id: RuleSet.interface.php,v 1.2 2003/06/23 00:58:44 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FIeldSetValidator
 **/

class RuleSetInterface {
	/**
	 * adds a new $rule to $key, which if fails when validated throws $error
	 * @param string $key the key to associate the rule with
	 * @param object ValidatorRule $rule the ValidatorRule object to be added
	 * @param object Error $error the error to throw if the validation fails
	 * @access public
	 * @return void 
	 **/
	function addRule( $key, & $rule, & $error ) {}
	
	/**
	 * validates $val against the rules defined for $key. if validation fails the associated error is thrown
	 * @param string $key the key to look at for rules
	 * @param mixed $val the value to check against the rules
	 * @access public
	 * @return boolean if the validation succeeded or failed
	 **/
	function validate( $key, $val ) {}
	
	/**
	 * returns an array of keys
	 * 
	 * @access public
	 * @return array an array of keys that are set
	 **/
	function getKeys() {}

	/**
	 * returns the number of keys with rules
	 * 
	 * @access public
	 * @return int the number of keys
	 **/
	function size() {}
}

?>