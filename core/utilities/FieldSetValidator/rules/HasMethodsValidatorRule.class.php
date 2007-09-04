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
 * @version $Id: HasMethodsValidatorRule.class.php,v 1.6 2007/09/04 20:25:55 adamfranco Exp $
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
	function check( $val ) {
		$hasMethods = TRUE;
		foreach ($this->_methods as $method) {
			if (!method_exists($val, $method))
				$hasMethods = FALSE;
		}
		
		return $hasMethods;
	}
	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This method follows a modified Singleton pattern.
	 * 
	 * @param string $methodName
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	function getRule ($methodName) {
		if (!isset($GLOBALS['validator_rules']) || !is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		$ruleKey = $class."(".strtolower($methodName).")";
		
		if (!isset($GLOBALS['validator_rules'][$ruleKey]))
			$GLOBALS['validator_rules'][$ruleKey] = new $class($methodName);
		
		return $GLOBALS['validator_rules'][$ruleKey];
	}
	
	/**
	 * Return a key that can be used to identify this Rule for caching purposes.
	 * If this rule takes no arguments, the class name should be sufficient.
	 * otherwise, append the arguments. 
	 *
	 * This method should only be called by ValidatorRules.
	 * 
	 * @return string
	 * @access protected
	 * @since 3/29/05
	 */
	function getRuleKey () {
		return get_class($this)."(".strtolower(implode(', ', $this->_methods)).")";
	}
}

?>