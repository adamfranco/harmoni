<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the DoubleValidatorRule checks a given value to make sure it's Double
 *
 * @version $Id: DoubleValidatorRule.class.php,v 1.1 2004/02/09 15:54:11 dobomode Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
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