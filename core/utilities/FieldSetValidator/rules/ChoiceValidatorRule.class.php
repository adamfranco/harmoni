<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * a ChoiceValidatorRule checks a value against a certain given number of choices
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ChoiceValidatorRule.class.php,v 1.5 2005/03/30 16:08:53 adamfranco Exp $
 */ 
class ChoiceValidatorRule 
	extends ValidatorRuleInterface
{
	/**
	 * an array of choices to allow
	 * 
	 * @access private
	 * @var array $_choices the array of choices
	 */ 
	var $_choices;
	
	/**
	 * the concstructor
	 * 
	 * @param mixed $choice1,$choice2,... a variable-length list of choices to allow
	 * if any of $choiceN are an array, all the values contained within are used
	 * @access public
	 * @return void 
	 **/
	function ChoiceValidatorRule() {
		$a = func_get_args();
		$choices = array();
		foreach ($a as $c) {
			if (is_array($c)) $choices = array_merge($choices,$c);
			else $choices[] = $c;
		}
		$this->_choices = array_unique($choices);
	}
	
	/**
	 * checks a given value against the given choices
	 * @param mixed $val the value to check against the rule
	 * @access public
	 * @return boolean true if the check succeeds, false if it (guess...) fails.
	 **/
	function check( & $val ) {
		// go through the choices array and see if $val is in there somewhere
		foreach ($this->_choices as $choice) if ($val == $choice) return true;
		return false;
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
		$a = func_get_args();

		if (!is_array($GLOBALS['validator_rules']))
			$GLOBALS['validator_rules'] = array();
		
		$class = __CLASS__;
		if (is_array($a)) {
			ob_start();
			print $class."(";
			print_r($a);
			print ")";
			$ruleKey = ob_get_contents();
			ob_end_clean();
		} else
			$ruleKey = $class."(".implode(", ",$a).")";

		if (!$GLOBALS['validator_rules'][$ruleKey]) {
			$evalString = '$GLOBALS[\'validator_rules\'][$ruleKey] =& new '.$class.'(';
			$i = 0;
			foreach (array_keys($a) as $key) {
				if ($i > 0)
					$evalString .= ", ";
				$evalString .= '$a['.$key.']';
				$i++;
			}
			$evalString .= ');';
			eval($evalString);
		}
		
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
		return get_class($this)."(".implode(", ",$this->_choices).")";
	}
}

?>