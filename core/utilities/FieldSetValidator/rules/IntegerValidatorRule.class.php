<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the IntegerValidatorRule checks a given value to make sure it's integer
 *
 * @version $Id: IntegerValidatorRule.class.php,v 1.2 2004/03/05 21:40:06 adamfranco Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
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