<?php

require_once(HARMONI."utilities/FieldSetValidator/RuleSet.interface.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/inc.php");

/**
 * a RuleSet allows a user to define a number of keys each with associated rules and errors
 * @version $Id: RuleSet.class.php,v 1.11 2003/07/01 21:50:21 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
 **/

class RuleSet
	extends RuleSetInterface
{
	/**
	 * an associative array of keys and associated rules
	 * 
	 * the format of the array is this:
	 * [key1]=>array( &$rule1, &$error1),
	 *         array( &$rule2, &$error2),
	 *         ...
	 * [key2]=>...
	 * 
	 * @attribute private hash $_rules the associative array of rules
	 */ 
	var $_rules;
	
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function RuleSet() {
		$this->_rules = array();
	}
	
	/**
	 * adds a new $rule to $key, which if fails when validated throws $error
	 * @param string $key the key to associate the rule with
	 * @param ref object ValidatorRule $rule the ValidatorRule object to be added
	 * @param optional object Error $error the error to throw if the validation fails
	 * @access public
	 * @return void 
	 **/
	function addRule( $key, & $rule, $error = null) {
		ArgumentValidator::validate($rule, new ExtendsValidatorRule("ValidatorRuleInterface"));
		ArgumentValidator::validate($key, new StringValidatorRule);

		if ($error !== null)
			ArgumentValidator::validate($error,new ExtendsValidatorRule("ErrorInterface"),true);

		if (!isset($this->_rules[$key])) $this->_rules[$key] = array();
		$this->_rules[$key][] = array( &$rule, $error );
	}
	
	/**
	 * validates $val against the rules defined for $key. if validation fails the associated error is thrown
	 * @param string $key the key to look at for rules
	 * @param mixed $val the value to check against the rules
	 * @access public
	 * @return boolean if the validation succeeded or failed
	 **/
	function validate( $key, $val ) {
		$error = false; // default to no error
		
		// if we have no rules defined for $key, assume that it's valid
		if (!is_array($this->_rules[$key])) return true;
		
		// now go through each rule and check if it's valid with $val
		$rules = & $this->_rules[$key];
		for ($i = 0; $i < count($rules); $i++) {
			$rule = & $rules[$i];
			if (!$rule[0]->check( & $val )) {
				// throw an error
				if ($rule[1] !== null) {
    				throw($rule[1]);
				}
				
				// set $error to true;
				$error = true;
			}
		}
		if ($error) return false;
		return true;
	}
	
	/**
	 * returns an array of keys
	 * 
	 * @access public
	 * @return array an array of keys that are set
	 **/
	function getKeys() {
		if ($this->count()) return array_keys($this->_rules);
		return array();
	}
	
	/**
	 * returns the number of keys with rules
	 * 
	 * @access public
	 * @return int the number of keys
	 **/
	function count() {
		return count($this->_rules);
	}
}

?>