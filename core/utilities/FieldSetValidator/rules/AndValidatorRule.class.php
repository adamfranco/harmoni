<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the AndValidatorRule takes 2 other rules and validates if both validate.
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AndValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
 */ 
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