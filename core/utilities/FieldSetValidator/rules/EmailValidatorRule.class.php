<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/RegexValidatorRule.class.php");

/**
 * a EmailValidatorRule checks a given value to make sure it is an email address
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: EmailValidatorRule.class.php,v 1.6 2007/10/09 21:12:00 adamfranco Exp $
 */
class EmailValidatorRule
	extends RegexValidatorRule
{
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function EmailValidatorRule( ) {
		$this->_regex = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$"; // matches any string that is an email address
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