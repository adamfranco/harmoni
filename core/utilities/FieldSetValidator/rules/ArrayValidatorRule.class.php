<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ArrayValidatorRuleWithRule.class.php");

/**
 * an ArrayValidatorRule will check if a given value is an array
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ArrayValidatorRule.class.php,v 1.7 2007/10/09 21:11:59 adamfranco Exp $
 */
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
		$this->_rule =  AlwaysTrueValidatorRule::getRule();
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
	static function getRule () {
		// Because there is no way in PHP to get the class name of the descendent
		// class on which this method is called, this method must be implemented
		// in each descendent class.

		if (!isset($GLOBALS['validator_rules']) || !is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		if (!isset($GLOBALS['validator_rules'][$class]))
			$GLOBALS['validator_rules'][$class] = new $class;
		
		return $GLOBALS['validator_rules'][$class];
	}
}

?>