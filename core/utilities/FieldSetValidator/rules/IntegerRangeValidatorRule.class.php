<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the IntegerRangeValidatorRule checks a given value to make sure it's integer that
 * falls within a certain range.
 *
 * @version $Id: IntegerRangeValidatorRule.class.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
class IntegerRangeValidatorRule
	extends ValidatorRuleInterface 
{

	/**
	 * The range min.
	 * @attribute private integer _mix
	 */
	var $_mix;
	
	/**
	 * The range max.
	 * @attribute private integer _max
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
	function check( & $val ) {
		if (!(is_integer($val) || $val === 0))
			return false;
		return ($val >= $this->_min && $val <= $this->_max);
	}
}

?>