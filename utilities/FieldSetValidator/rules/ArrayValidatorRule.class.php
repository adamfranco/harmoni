<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ArrayValidatorRuleWithRule.class.php");

/**
 * an ArrayValidatorRule will check if a given value is an array
 *
 * @version $Id: ArrayValidatorRule.class.php,v 1.3 2003/07/06 22:07:40 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator.rules
 **/

class ArrayValidatorRule
	extends ArrayValidatorRuleWithRule
{
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function ArrayValidatorRule() {
		$this->_rule = & new AlwaysTrueValidatorRule;
	}
	
}

?>