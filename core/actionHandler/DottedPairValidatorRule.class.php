<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/RegexValidatorRule.class.php");

/**
 * The DottedPairValidatorRule checks to see if a string is of a "module.action" 
 * dotted-pair format.
 *
 * @version $Id: DottedPairValidatorRule.class.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.actions
 **/

class DottedPairValidatorRule
	extends RegexValidatorRule
{
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function DottedPairValidatorRule() {
		$this->_regex = "^[[:alnum:]_-]+\.[[:alnum:]_-]+$"; // matches a dotted-pair for modules.actions
	}
}

?>