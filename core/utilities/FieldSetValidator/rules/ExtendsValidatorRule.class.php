<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * The ExtendsValidatorRule checks if a given object is extends a given class.
 *
 * @version $Id: ExtendsValidatorRule.class.php,v 1.1 2003/08/14 19:26:31 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.fieldsetvalidator.rules
 **/
 
class ExtendsValidatorRule
	extends ValidatorRuleInterface 
{

	/**
	 * The name of the parent class.
	 * The name of the parent class. Will check whether the given object extends
	 * this parent class.
	 * @access private
	 * @var mixed $_regex 
	 */ 
	var $_parentClassName;

	/**
	 * The constructor.
	 * @access public
	 * @param string $parentClassName The name of the parent class. Will check 
	 * whether the given object extends this parent class.
	 * @return void 
	 **/
	function ExtendsValidatorRule($parentClassName) {
		$this->_parentClassName = strtolower($parentClassName);		
	}
	

	/**
	 * Checks that the given object extends a specified class.
	 * Checks that the given object extends a specified class.
	 * @param mixed $val The value to check.
	 * @access public
	 * @return boolean TRUE, if the object extends the class; FALSE if it is not.
	 **/
	function check( & $val ) {
		return is_a($val, $this->_parentClassName);
	}
}

?>