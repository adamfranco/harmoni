<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the BooleanValidatorRule checks a given value to make sure it's a boolean value
 *
 * @version $Id: BooleanValidatorRule.class.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
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