<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/RegexValidatorRule.class.php");

/**
 * a EmailValidatorRule checks a given value to make sure it is an email address
 *
 * @version $Id: EmailValidatorRule.class.php,v 1.3 2003/06/26 03:58:09 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
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