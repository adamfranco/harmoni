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
 * @version $Id: RegexValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
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
}

?>