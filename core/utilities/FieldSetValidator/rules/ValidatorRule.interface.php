<?php

/**
 * the ValidatorRuleInterface defines the methods required by any ValidatorRule
 *
 * @package harmoni.utilities.fieldsetvalidator.rules
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ValidatorRule.interface.php,v 1.3 2005/01/19 21:10:16 adamfranco Exp $
 */ 
class ValidatorRuleInterface{
	/**
	 * checks a given value against the rule contained within the class
	 * @param mixed $val the value to check against the rule
	 * @access public
	 * @return boolean true if the check succeeds, false if it (guess...) fails.
	 **/
	function check( & $val ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}

?>