<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ArrayValidatorRuleWithRule.class.php");

/**
 * an ArrayValidatorRule will check if a given value is an array
 *
 * @version $Id: ArrayValidatorRule.class.php,v 1.4 2003/07/10 02:34:21 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
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