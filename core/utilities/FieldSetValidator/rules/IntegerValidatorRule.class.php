<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the IntegerValidatorRule checks a given value to make sure it's integer
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: IntegerValidatorRule.class.php,v 1.3 2005/01/19 21:10:16 adamfranco Exp $
 */ 
class IntegerValidatorRule
	extends ValidatorRuleInterface 
{
	/**
	 * Checks a given value to make sure it's an integer.
	 * Checks a given value to make sure it's an integer.
	 * @param mixed $val The value to check.
	 * @access public
	 * @return boolean TRUE, if the value is an integer; FALSE if it is not.
	 **/
	function check( & $val ) {
		return (is_integer($val) || $val === 0 || ereg("^[1-9][0-9]*$",$val));
	}
}

?>