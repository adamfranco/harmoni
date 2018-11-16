<?php

/**
 * the ValidatorRuleInterface defines the methods required by any ValidatorRule
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ValidatorRule.interface.php,v 1.7 2007/10/09 21:12:02 adamfranco Exp $
 */ 
class ValidatorRuleInterface{
	/**
	 * checks a given value against the rule contained within the class
	 * @param mixed $val the value to check against the rule
	 * @access public
	 * @return boolean true if the check succeeds, false if it (guess...) fails.
	 **/
	function check( $val ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
	// static function getRule () {
	// 	// Because there is no way in PHP to get the class name of the descendent
	// 	// class on which this method is called, this method must be implemented
	// 	// in each descendent class.
	// 	die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	// 
	// 	if (!isset($GLOBALS['validator_rules']) || !is_array($GLOBALS['validator_rules']))
	// 		$GLOBALS['validator_rules'] = array();
	// 
	// 	$class = __CLASS__;
	// 	if (!isset($GLOBALS['validator_rules'][$class]))
	// 		$GLOBALS['validator_rules'][$class] = new $class;
	// 
	// 	return $GLOBALS['validator_rules'][$class];
	// }
	
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
		return get_class($this);
	}
}

?>