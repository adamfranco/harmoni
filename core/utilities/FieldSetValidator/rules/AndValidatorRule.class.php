<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the AndValidatorRule takes 2 other rules and validates if both validate.
 *
 * @version $Id: AndValidatorRule.class.php,v 1.1 2004/07/14 20:56:52 dobomode Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
class AndValidatorRule extends ValidatorRuleInterface {


	/**
	 * the constructur
	 * 
	 * @param object ValidatorRule $rule1 the first rule
	 * @param object ValidatorRule $rule2 the second rule
	 * @access public
	 * @return void 
	 **/
	function AndValidatorRule( & $rule1, & $rule2 ) {
		$this->_rule1 =& $rule1;
		$this->_rule2 =& $rule2;
	}



	/**
	 * the AndValidatorRule takes 2 other rules and validates if at least one of the 2 validates.
	 * @param mixed $rule1 The first rule.
	 * @access public
	 * @return boolean TRUE, if validated; FALSE if not.
	 **/
	function check( & $val ) {
		return ($this->_rule1->check($val) && $this->_rule2->check($val));
	}
}

?>