<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * a RegexValidatorRule checks a given value against a regular expression
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RegexValidatorRule.class.php,v 1.3 2005/03/29 18:04:57 adamfranco Exp $
 */
class RegexValidatorRule
	extends ValidatorRuleInterface
{
	/**
	 * the regular expression that should be used to check the value
	 * 
	 * @access private
	 * @var mixed $_regex 
	 */ 
	var $_regex;

	/**
	 * the constructor
	 * 
	 * @param string $regex the regular expression to be used
	 * @access public
	 * @return void 
	 **/
	function RegexValidatorRule( $regex ) {
		$this->_regex = $regex;
	}
	
	/**
	 * checks a given value against the regular expression defined
	 * @param mixed $val the value to check against the regex
	 * @access public
	 * @return boolean true if the check succeeds, false if it (guess...) fails.
	 **/
	function check( & $val ) {
		return (ereg($this->_regex, $val)) ? true : false;
	}
	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This method follows a modified Singleton pattern.
	 * 
	 * @param string $regex
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	function &getRule ($regex) {
		if (!is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		$ruleKey = $class."(".strtolower($regex).")";
		
		if (!$GLOBALS['validator_rules'][$ruleKey])
			$GLOBALS['validator_rules'][$ruleKey] =& new $class($regex);
		
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
		return get_class($this)."(".strtolower($this->_regex).")";
	}
}

?>