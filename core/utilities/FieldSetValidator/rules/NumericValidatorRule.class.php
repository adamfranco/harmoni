<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the NumericValidatorRule checks a given value to make sure it's numeric
 *
 * @version $Id: NumericValidatorRule.class.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
class NumericValidatorRule
	extends ValidatorRuleInterface 
{
	/**
	 * checks a given value to make sure it's numeric
	 * @param mixed $val the value to check
	 * @access public
	 * @return boolean true if the value is numeric, false if it is not
	 **/
	function check( & $val ) {
		return is_numeric($val);
	}
}

?>