<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/RegexValidatorRule.class.php");

/**
 * The DottedPairValidatorRule checks to see if a string is of a "module.action" 
 * dotted-pair format.
 *
 * @package harmoni.actions
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DottedPairValidatorRule.class.php,v 1.7 2005/07/07 18:31:38 adamfranco Exp $
 */

class DottedPairValidatorRule
	extends RegexValidatorRule
{
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function DottedPairValidatorRule() {
		$this->_regex = "^[[:alnum:]_-]+\.([[:alnum:]_-]+)|\*$"; // matches a dotted-pair for modules.actions
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
		if (!isset($GLOBALS['validator_rules'][$class]))
			$GLOBALS['validator_rules'][$class] =& new $class;
		
		return $GLOBALS['validator_rules'][$class];
	}
}

?>