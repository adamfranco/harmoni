<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the NumericValidatorRule checks a given value to make sure it's numeric
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: NumericValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
 */ 
class NumericValidatorRule
	extends ValidatorRuleInterface 
{
	/**
	 * checks a given value to make sure it's numeric
	 * @param mixed $val the value to check
	 * @access public
	 * @return boolean true if the value is numeric, false if it is not
	 **/
	function check( & $val ) {
		return is_numeric($val);
	}
}

?>