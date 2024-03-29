<?php

//require_once(HARMONI."utilities/FieldSetValidator/RuleSet.interface.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/inc.php");

/**
 * a RuleSet allows a user to define a number of keys each with associated rules and errors
 *
 * @package harmoni.utilities.fieldsetvalidator
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RuleSet.class.php,v 1.8 2007/09/05 19:55:22 adamfranco Exp $
 */
class RuleSet {
	
	/**
	 * an associative array of keys and associated rules
	 * 
	 * the format of the array is this:
	 * [key1]=>array( $rule1, $error1),
	 *         array( $rule2, $error2),
	 *         ...
	 * [key2]=>...
	 * 
	 * @var array $_rules the associative array of rules 
	 * @access private
	 */ 
	var $_rules;
	
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function __construct() {
		$this->_rules = array();
	}
		
	/**
	 * adds a new $rule to $key, which if fails when validated throws $error
	 * @param string $key the key to associate the rule with
	 * @param ref object ValidatorRule $rule the ValidatorRule object to be added
	 * @param optional string $message the error to throw if the validation fails
	 * @access public
	 * @return void 
	 **/
	function addRule( $key, $rule, $message = null, $type = '') {
		ArgumentValidator::validate($rule, ExtendsValidatorRule::getRule("ValidatorRuleInterface"));
		ArgumentValidator::validate($key, StringValidatorRule::getRule());

		if ($message !== null)
			ArgumentValidator::validate($message, StringValidatorRule::getRule(),true);

		if (!isset($this->_rules[$key])) $this->_rules[$key] = array();
		$this->_rules[$key][] = array( $rule, $message, $type );
	}
	
	/**
	 * validates $val against the rules defined for $key. if validation fails the associated error is thrown
	 * @param string $key the key to look at for rules
	 * @param mixed $val the value to check against the rules
	 * @param optional boolean $throwErrors Should we throw the specified errors if validation
	 * fails or just return true/false. Default = TRUE.
	 * @access public
	 * @return boolean if the validation succeeded or failed
	 **/
	function validate( $key, $val, $throwErrors=true ) {
		$error = false; // default to no error
		
		// if we have no rules defined for $key, assume that it's valid
		if (!is_array($this->_rules[$key])) return true;
		
		// now go through each rule and check if it's valid with $val
		$rules =  $this->_rules[$key];
		for ($i = 0; $i < count($rules); $i++) {
			$rule =  $rules[$i];
			if (!$rule[0]->check( $val )) {
				// throw an error
				if ($throwErrors && $rule[1] !== null) {
					throw new HarmoniError($rule[1], $rule[2]);
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