<?php

require_once("ValidatorRule.interface.php");

/**
 * an AlwaysTrueValidatorRule will always return valid for a given value
 *
 * @version $Id: AlwaysTrueValidatorRule.class.php,v 1.1 2003/06/22 23:06:56 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
 **/

class AlwaysTrueValidatorRule
	extends ValidatorRuleInterface
{
	/**
	 * returns true no matter what
	 * @param mixed $val the value to check against the regex
	 * @access public
	 * @return boolean true if the check succeeds, false if it (guess...) fails.
	 **/
	function check( & $val ) {
		return true;
	}
}

?>