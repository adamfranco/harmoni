<?php

/**
 * ArgumentValidator performs validation of function arguments. The validator
 * makes use of a specified ValidatorRule object. In addition, if validation
 * fails, a new fatal error is added to the default ErrorHandler.
 *
 * @version $Id: ArgumentValidator.interface.php,v 1.6 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.interfaces.utilities
 **/
 
class ArgumentValidatorInterface {

	/**
	 * Validates a single argument. Uses a specified ValidatorRule object for validation.
	 * @param mixed $argument The argument to be validated.
	 * @param object ValidatorRule $rule The rule to use for validation.
	 * @param boolean $isFatal If TRUE, upon validation failure, a fatal error
	 * will be thrown.
	 * @access public
	 * @return boolean If validation is successful, returns TRUE. If validation
	 * fails and $isFatal is FALSE, returns FALSE. If $isFatal is TRUE, then
	 * if validation fails, the script would halt and nothing would ever be
	 * returned.
	 * @static
	 **/
	function validate($argument, $rule, $isFatal = true) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	


}

?>