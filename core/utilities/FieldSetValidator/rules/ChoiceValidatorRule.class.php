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
 * @version $Id: ChoiceValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
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
}

?>