<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/RegexValidatorRule.class.php");

/**
 * a FieldRequiredValidatorRule checks a given value to make sure it is set (not blank)
 *
 * @version $Id: FieldRequiredValidatorRule.class.php,v 1.3 2003/07/06 22:07:40 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator.rules
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