<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the ResourceValidatorRule checks a given value to make sure it's resource
 *
 * @version $Id: ResourceValidatorRule.class.php,v 1.1 2003/06/26 15:38:48 dobomode Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
 **/
 
class ResourceValidatorRule
	extends ValidatorRuleInterface 
{
	/**
	 * Checks a given value to make sure it's an resource.
	 * Checks a given value to make sure it's an resource.
	 * @param mixed $val The value to check.
	 * @access public
	 * @return boolean TRUE, if the value is a resource; FALSE if it is not.
	 **/
	function check( & $val ) {
		return is_resource($val);
	}
}

?>