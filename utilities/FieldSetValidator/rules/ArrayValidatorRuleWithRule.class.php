<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * an ArrayValidatorRuleWithRule will make sure that a value is both an array and passes a given rule for each value
 *
 * @version $Id: ArrayValidatorRuleWithRule.class.php,v 1.2 2003/06/23 20:59:14 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
 **/
 
class ArrayValidatorRuleWithRule
	extends ValidatorRuleInterface
{
	/**
	 * the rule to be used for each array element
	 * 
	 * @access private
	 * @var object ValidatorRule $_rule the rule
	 */ 
	var $_rule;
	
	/**
	 * the constructur
	 * 
	 * @param object ValidatorRule $rule the rule to use for each array element
	 * @access public
	 * @return void 
	 **/
	function ArrayValidatorRuleWithRule( & $rule ) {
		$this->_rule = & $rule;
	}
	
	
	/**
	 * checks a given value to make sure it's an array and then runs $this->_rule on each value
	 * @param mixed $val the value to check
	 * @access public
	 * @return boolean true if the check succeeds, false if it (guess...) fails.
	 **/
	function check( & $val ) {
		if (!is_array($val)) return false;
		
		// now apply the _rule to each value
		foreach (array_keys($val) as $key) {
			if (!$this->_rule->check($val[$key])) return false;
		}
		return true;
	}
}

?>