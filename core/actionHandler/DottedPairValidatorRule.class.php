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
 * @version $Id: DottedPairValidatorRule.class.php,v 1.5 2005/02/07 21:38:18 adamfranco Exp $
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
}

?>