<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/StringValidatorRule.class.php");

/**
 * the NonzeroLengthStringValidatorRule checks a given value to make sure it's string and
 * has a non-zero length
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: NonzeroLengthStringValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
 */ 
class NonzeroLengthStringValidatorRule
	extends StringValidatorRule 
{
	/**
	 * Checks a given value to make sure it's an string and has a non-zero length
	 * @param mixed $val The value to check.
	 * @access public
	 * @return boolean TRUE, if the value is an string; FALSE if it is not.
	 **/
	function check( & $val ) {
		return parent::check($val) && (count($val) > 0);
	}
}

?>