<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the StringValidatorRule checks a given value to make sure it's string
 *
 * @version $Id: StringValidatorRule.class.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
class StringValidatorRule
	extends ValidatorRuleInterface 
{
	/**
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