<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the IntegerValidatorRule checks a given value to make sure it's integer
 *
 * @version $Id: IntegerValidatorRule.class.php,v 1.1 2003/06/26 02:03:27 dobomode Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
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
		return is_integer($val);
	}
}

?>