<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the IntegerRangeValidatorRule checks a given value to make sure it's integer that
 * falls within a certain range.
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: IntegerRangeValidatorRule.class.php,v 1.9 2007/10/09 21:12:00 adamfranco Exp $
 */ 
class IntegerRangeValidatorRule
	extends ValidatorRuleInterface 
{

	/**
	 * The range min.
	 * @var integer _mix 
	 * @access private
	 */
	var $_mix;
	
	/**
	 * The range max.
	 * @var integer _max 
	 * @access private
	 */
	var $_max;
	

	/**
	 * Initializes the rule
	 * @access public
	 */
	function IntegerRangeValidatorRule($min, $max) {
		$this->_min = $min;
		$this->_max = $max;
	}
	
	/**
	 * Checks a given value to make sure it's an integer.
	 * Checks a given value to make sure it's an integer.
	 * @param mixed $val The value to check.
	 * @access public
	 * @return boolean TRUE, if the value is an integer; FALSE if it is not.
	 **/
	function check( $val ) {
//		if (!(is_integer($val) || $val === 0))
//			return false;
//		print "checking $val against $this->_min to $this->_max<br>";
		return ($val >= $this->_min && $val <= $this->_max);
	}
	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This method follows a modified Singleton pattern
	 * 
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	static function getRule ($min, $max) {
		// Because there is no way in PHP to get the class name of the descendent
		// class on which this method is called, this method must be implemented
		// in each descendent class.

		if (!isset($GLOBALS['validator_rules']) || !is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		$ruleKey = $class."(".$min.", ".$max.")";
		if (!isset($GLOBALS['validator_rules'][$ruleKey]))
			$GLOBALS['validator_rules'][$ruleKey] = new $class($min, $max);
		
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
		return get_class($this)."(".$this->_min.", ".$this->_max.")";
	}
}

?>