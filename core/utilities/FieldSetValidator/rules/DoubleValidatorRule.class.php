<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the DoubleValidatorRule checks a given value to make sure it's Double
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DoubleValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
 */ 
class DoubleValidatorRule
	extends ValidatorRuleInterface 
{
	/**
	 * Checks a given value to make sure it's an Double.
	 * Checks a given value to make sure it's an Double.
	 * @param mixed $val The value to check.
	 * @access public
	 * @return boolean TRUE, if the value is an Double; FALSE if it is not.
	 **/
	function check( & $val ) {
		return (is_double($val) || $val === 0.0);
	}
}

?>