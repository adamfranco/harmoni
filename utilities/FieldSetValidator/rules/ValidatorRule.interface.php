<?php

/**
 * the ValidatorRuleInterface defines the methods required by any ValidatorRule
 *
 * @version $Id: ValidatorRule.interface.php,v 1.2 2003/06/23 20:42:35 adamfranco Exp $
 * @copyright 2003 
 * @package harmoni.utilities.FieldSetValidator
 **/
 
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