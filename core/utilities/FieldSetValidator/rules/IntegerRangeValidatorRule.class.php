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
 * @version $Id: IntegerRangeValidatorRule.class.php,v 1.4 2005/01/19 23:23:32 adamfranco Exp $
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
	function check( & $val ) {
//		if (!(is_integer($val) || $val === 0))
//			return false;
		return ($val >= $this->_min && $val <= $this->_max);
	}
}

?>