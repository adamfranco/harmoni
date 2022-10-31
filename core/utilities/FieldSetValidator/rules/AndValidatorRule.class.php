<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the AndValidatorRule takes 2 other rules and validates if both validate.
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AndValidatorRule.class.php,v 1.6 2007/10/09 21:11:59 adamfranco Exp $
 */ 
class AndValidatorRule extends ValidatorRuleInterface {


	/**
	 * the constructur
	 * 
	 * @param object ValidatorRule $rule1 the first rule
	 * @param object ValidatorRule $rule2 the second rule
	 * @access public
	 * @return void 
	 **/
	function __construct( $rule1, $rule2 ) {
		$this->_rule1 =$rule1;
		$this->_rule2 =$rule2;
	}



	/**
	 * the AndValidatorRule takes 2 other rules and validates if at least one of the 2 validates.
	 * @param mixed $rule1 The first rule.
	 * @access public
	 * @return boolean TRUE, if validated; FALSE if not.
	 **/
	function check( $val ) {
		return ($this->_rule1->check($val) && $this->_rule2->check($val));
	}
	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This method follows a modified Singleton pattern.
	 * 
	 * @param object ValidatorRule $rule1 the first rule
	 * @param object ValidatorRule $rule2 the second rule
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	static function getRule ($rule1, $rule2) {		
		// Because there is no way in PHP to get the class name of the descendent
		// class on which this method is called, this method must be implemented
		// in each descendent class.

		if (!isset($GLOBALS['validator_rules']) || !is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		$ruleKey = $class."(".$rule1->getRuleKey().", ".$rule2->getRuleKey().")";
		
		if (!isset($GLOBALS['validator_rules'][$ruleKey]))
			$GLOBALS['validator_rules'][$ruleKey] = new $class($rule1, $rule2);
		
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
		return get_class($this)."(".$this->_rule1->getRuleKey().", ".$this->_rule2->getRuleKey().")";
	}
}

?>