<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/StringValidatorRule.class.php");

/**
 * the NonzeroLengthStringValidatorRule checks a given value to make sure it's string and
 * has a non-zero length
 *
 * @version $Id: NonzeroLengthStringValidatorRule.class.php,v 1.1 2003/08/06 22:32:41 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
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