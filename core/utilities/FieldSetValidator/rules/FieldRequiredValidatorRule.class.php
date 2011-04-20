<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/RegexValidatorRule.class.php");

/**
 * a FieldRequiredValidatorRule checks a given value to make sure it is set (not blank)
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FieldRequiredValidatorRule.class.php,v 1.8 2007/10/22 18:11:23 adamfranco Exp $
 */
class FieldRequiredValidatorRule
	extends RegexValidatorRule
{
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function FieldRequiredValidatorRule( ) {
		$this->_regex = "/[^[:blank:]]+/"; // matches any string with at least one non-blank character
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
	static function getRule ($regex = null) {
		if ($regex)
			throw new HarmoniException("Passing of a custom string to this rule is not allowed.");
			
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