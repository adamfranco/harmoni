<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the StringValidatorRule checks a given value to make sure it's string
 *
 * @version $Id: StringValidatorRule.class.php,v 1.1 2003/06/26 02:03:27 dobomode Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
 **/
 
class StringValidatorRule
	extends ValidatorRuleInterface 
{
	/**
	 * Checks a given value to make sure it's an string.
	 * Checks a given value to make sure it's an string.
	 * @param mixed $val The value to check.
	 * @access public
	 * @return boolean TRUE, if the value is an string; FALSE if it is not.
	 **/
	function check( & $val ) {
		return is_string($val);
	}
}

?>