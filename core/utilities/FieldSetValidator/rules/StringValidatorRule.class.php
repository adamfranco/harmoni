<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the StringValidatorRule checks a given value to make sure it's string
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StringValidatorRule.class.php,v 1.3 2005/03/29 18:04:57 adamfranco Exp $
 */ 
class StringValidatorRule
	extends ValidatorRuleInterface 
{
	/**
	 * Checks a given value to make sure it's an string.
	 * @param mixed $val The value to check.
	 * @access public
	 * @return boolean TRUE, if the value is an string; FALSE if it is not.
	 **/
	function check( & $val ) {
		return is_string($val);
	}
	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This method follows a modified Singleton pattern
	 * 
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	function &getRule () {
		// Because there is no way in PHP to get the class name of the descendent
		// class on which this method is called, this method must be implemented
		// in each descendent class.

		if (!is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		if (!$GLOBALS['validator_rules'][$class])
			$GLOBALS['validator_rules'][$class] =& new $class;
		
		return $GLOBALS['validator_rules'][$class];
	}
}

?>