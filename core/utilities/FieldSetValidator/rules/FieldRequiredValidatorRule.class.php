<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/RegexValidatorRule.class.php");

/**
 * a FieldRequiredValidatorRule checks a given value to make sure it is set (not blank)
 *
 * @version $Id: FieldRequiredValidatorRule.class.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/

class FieldRequiredValidatorRule
	extends RegexValidatorRule
{
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function FieldRequiredValidatorRule( ) {
		$this->_regex = "[^[:blank:]]+"; // matches any string with at least one non-blank character
	}
}

?>