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
 * @version $Id: ExtendsValidatorRule.class.php,v 1.3 2005/03/29 18:04:57 adamfranco Exp $
 */ 
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
	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This method follows a modified Singleton pattern.
	 * 
	 * @param string $parentClassName The name of the parent class. Will check 
	 * whether the given object extends this parent class.
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	function &getRule ($parentClassName) {
		if (!is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		$ruleKey = $class."(".strtolower($parentClassName).")";
		
		if (!$GLOBALS['validator_rules'][$ruleKey])
			$GLOBALS['validator_rules'][$ruleKey] =& new $class($parentClassName);
		
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
		return get_class($this)."(".$this->_parentClassName.")";
	}
}

?>