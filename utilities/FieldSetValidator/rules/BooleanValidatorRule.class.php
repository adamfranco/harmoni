<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the BooleanValidatorRule checks a given value to make sure it's a boolean value
 *
 * @version $Id: BooleanValidatorRule.class.php,v 1.2 2003/06/23 20:59:14 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
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
		if (!($val === true || $val === false || $val == 1 || $val == 0)) return false;
		return true;
	}
}

?>