<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * The ExtendsValidatorRule checks if a given object is extends a given class.
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HasMethodsValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
 */ 
class HasMethodsValidatorRule
	extends ValidatorRuleInterface 
{

	/**
	 * The methods to check the existance of.
	 * @access private
	 * @var array $_methods 
	 */ 
	var $_methods;

	/**
	 * The constructor.
	 * @access public
	 * @param string $methodName The name of the first method.
	 * @param optional string $methodName2 specify as man additional strings as needed.
	 * @return void 
	 **/
	function HasMethodsValidatorRule($methodName) {
		$this->_methods = func_get_args();		
	}
	

	/**
	 * Checks that the given object extends a specified class.
	 * Checks that the given object extends a specified class.
	 * @param mixed $val The value to check.
	 * @access public
	 * @return boolean TRUE, if the object extends the class; FALSE if it is not.
	 **/
	function check( & $val ) {
		$hasMethods = TRUE;
		foreach ($this->_methods as $method) {
			if (!method_exists($val, $method))
				$hasMethods = FALSE;
		}
		
		return $hasMethods;
	}
}

?>