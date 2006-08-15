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
 * @version $Id: RegexValidatorRule.class.php,v 1.5 2006/08/15 20:45:00 sporktim Exp $
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
	 * gets the regular expression
	 * 
	 * @access public
	 * @return string the regular expression
	 **/
	 function getRegularExpression() {
		return $this->_regex;
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
		if (!isset($GLOBALS['validator_rules']) || !is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		

		$class = __CLASS__;
		$ruleKey = $class."(".strtolower($regex).")";
		
		if (!isset($GLOBALS['validator_rules'][$ruleKey])){
			eval('$newRule =& new '.$class.'($regex);');
			$GLOBALS['validator_rules'][$ruleKey] =& $newRule;
		}
		return 	$GLOBALS['validator_rules'][$ruleKey];
	}
	
	/**
	 * Returns a block of javascript code defining a function like so:
	 * 
	 * function(element) {
	 * 		return el.value.match(/\w+/);
	 * }
	 * @access public
	 * @return string
	 */
	function generateJavaScript () {
		$re = addslashes($this->_regex);
		return "function(el) {\n" .
				"var re = new RegExp(\"$re\");\n" .
				"return el.value.match(re);\n" .
				"}";
	}
	
	/**
	 * This is a static method to return an already-created instance of a validator
	 * rule. There are at most about a hundred unique rule objects in use durring
	 * any given execution cycle, but rule objects are instantiated hundreds of
	 * thousands of times. 
	 *
	 * This one genrates a regular expression from an array of regular expressions.  The whole string must match.
	 *
	 * This method follows a modified Singleton pattern.
	 * 
	 * @param string $regex
	 * @return object ValidatorRule
	 * @access public
	 * @static
	 * @since 3/28/05
	 */
	function &getRuleByArray ($options) {
		
		if(!is_array($options) || count($options)==0){
			throwError(new Error("RegexValidatorRule::getRuleByArray() requires an array with at least one value","RegexValidatorRule",true));		
		}
		
		$regex = "^(".$options[0];
		for($i =1; $i<count($options); $i++){
			$regex .= "|".$options[$i];
		}
		$regex.= ")$";
		
		if (!isset($GLOBALS['validator_rules']) || !is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		

		$class = __CLASS__;
		$ruleKey = $class."(".strtolower($regex).")";
		
		if (!isset($GLOBALS['validator_rules'][$ruleKey])){
			eval('$newRule =& new '.$class.'($regex);');
			$GLOBALS['validator_rules'][$ruleKey] =& $newRule;
		}
		return 	$GLOBALS['validator_rules'][$ruleKey];
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