<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * an AlwaysTrueValidatorRule will always return valid for a given value
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AlwaysTrueValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
 */
class AlwaysTrueValidatorRule
	extends ValidatorRuleInterface
{
	/**
	 * returns true no matter what
	 * @param mixed $val the value to check against the regex
	 * @access public
	 * @return boolean true if the check succeeds, false if it (guess...) fails.
	 **/
	function check( & $val ) {
		return true;
	}
}

?>