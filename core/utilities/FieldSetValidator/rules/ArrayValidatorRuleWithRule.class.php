<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * an ArrayValidatorRuleWithRule will make sure that a value is both an array and passes a given rule for each value
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ArrayValidatorRuleWithRule.class.php,v 1.3 2005/03/29 18:04:57 adamfranco Exp $
 */ 
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
	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This method follows a modified Singleton pattern.
	 * 
	 * @param object ValidatorRule $rule
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	function &getRule (&$rule) {		
		// Because there is no way in PHP to get the class name of the descendent
		// class on which this method is called, this method must be implemented
		// in each descendent class.

		if (!is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		$ruleKey = $class."(".$rule->getRuleKey().")";
		
		if (!$GLOBALS['validator_rules'][$ruleKey])
			$GLOBALS['validator_rules'][$ruleKey] =& new $class($rule);
		
		return $GLOBALS['validator_rules'][$ruleKey];
	}
	
	/**
	 * Return a key that can be used to identify this Rule for caching purposes.
	 * If this rule takes no arguments, the class name should be sufficient.
	 * otherwise, append the arguments. 
	 *
	 * This method should only be called by ValidatorRules.
	 * 
	 * @return string
	 * @access protected
	 * @since 3/29/05
	 */
	function getRuleKey () {
		return get_class($this)."(".$this->_rule->getRuleKey().")";
	}
}

?>