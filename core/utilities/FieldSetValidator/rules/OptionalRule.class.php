<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * The OptionalRule allows you to have a field where a rule is applied *only* when
 * the value actually exists.
 *
 * @version $Id: OptionalRule.class.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
class OptionalRule
	extends ValidatorRuleInterface
{
	/**
	 * the rule to be used for the values set
	 * 
	 * @access private
	 * @var object ValidatorRule $_rule the rule
	 */ 
	var $_rule;
	
	/**
	 * the constructur
	 * 
	 * @param object ValidatorRule $rule the rule to use for the value when set
	 * @access public
	 * @return void 
	 **/
	function OptionalRule( & $rule ) {
		$this->_rule = & $rule;
	}
	
	
	/**
	 * checks a given value to see if it's set (returns true if not), and then
	 * runs the rule on it.
	 * @param mixed $val the value to check
	 * @access public
	 * @return boolean true if the check succeeds, false if it (guess...) fails.
	 **/
	function check( & $val ) {
		if (is_null($val)) return true;
		if (isset($val) && ereg("[^[:blank:]]+",$val))
			if (!$this->_rule->check($val)) return false;
		return true;
	}
}

?>