<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/RegexValidatorRule.class.php");

/**
 * a EmailValidatorRule checks a given value to make sure it is an email address
 *
 * @version $Id: EmailValidatorRule.class.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/

class EmailValidatorRule
	extends RegexValidatorRule
{
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function EmailValidatorRule( ) {
		$this->_regex = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$"; // matches any string that is an email address
	}
}

?>