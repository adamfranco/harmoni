<?php

require_once(HARMONI."utilities/FieldSetValidator/rules/RegexValidatorRule.class.php");

/**
 * a FieldRequiredValidatorRule checks a given value to make sure it is set (not blank)
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FieldRequiredValidatorRule.class.php,v 1.2 2005/01/19 21:10:16 adamfranco Exp $
 */
class FieldRequiredValidatorRule
	extends RegexValidatorRule
{
	/**
	 * the constructor
	 * 
	 * @access public
	 * @return void 
	 **/
	function FieldRequiredValidatorRule( ) {
		$this->_regex = "[^[:blank:]]+"; // matches any string with at least one non-blank character
	}
}

?>