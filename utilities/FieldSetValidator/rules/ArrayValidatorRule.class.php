<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ArrayValidatorRuleWithRule.class.php");

/**
 * an ArrayValidatorRule will check if a given value is an array
 *
 * @version $Id: ArrayValidatorRule.class.php,v 1.2 2003/06/23 20:59:13 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
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