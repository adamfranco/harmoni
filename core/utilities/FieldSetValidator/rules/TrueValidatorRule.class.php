<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/ValidatorRule.interface.php");

/**
 * the TrueValidatorRule checks a given value to make sure it's true.
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TrueValidatorRule.class.php,v 1.1 2005/03/10 03:14:39 dobomode Exp $
 */ 
class TrueValidatorRule
	extends ValidatorRuleInterface 
{
	/**
	 * checks a given value to make sure it's True
	 * @param mixed $val the value to check
	 * @access public
	 * @return True true if the value is True, false if it is not
	 **/
	function check( & $val ) {
		return $val === true;
	}
}

?>