<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the BooleanValidatorRule checks a given value to make sure it's a boolean value
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: BooleanValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
 */ 
class BooleanValidatorRule
	extends ValidatorRuleInterface 
{
	/**
	 * checks a given value to make sure it's boolean
	 * @param mixed $val the value to check
	 * @access public
	 * @return boolean true if the value is boolean, false if it is not
	 **/
	function check( & $val ) {
		if (is_bool($val)) return true;
		return false;
	}
}

?>