<?php

require_once(HARMONI."utilities/ArgumentValidator.interface.php");
require_once(HARMONI."utilities/ArgumentRenderer.class.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/inc.php");

/**
 * An ArgumentValidator performs validation of function arguments.
 * An ArgumentValidator performs validation of function arguments. The validator
 * makes use of a specified ValidatorRule object. In addition, if validation
 * fails, a new fatal error is added to the default ErrorHandler.
 *
 * @version $Id: ArgumentValidator.class.php,v 1.1 2003/06/26 02:03:27 dobomode Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.utilities
 **/
 
class ArgumentValidator extends ArgumentValidatorInterface {

	/**
	 * Validates a single argument.
	 * Validates a single argument. Uses a specified ValidatorRule object for validation.
	 * @param mixed $argument The argument to be validated.
	 * @param object ValidatorRule $rule The rule to use for validation.
	 * @param boolean $isFatal TRUE, if upon validation failing, a fatal error
	 * is to be thrown.
	 * @access public
	 * @return boolean If validation is successful, returns TRUE. If validation
	 * fails and $isFatal is FALSE, returns FALSE. If $isFatal is TRUE, then
	 * if validation fails, the script would halt and nothing would ever be
	 * returned.
	 * @static
	 **/
	function validate($argument, $rule, $isFatal) {
		// first, make sure that the ErrorHandler service is running
		if (!Services::serviceRunning("ErrorHandler")) {
			$debug = debug_backtrace();
			$str = "<pre>\n";
			$str .= "<b>*** EXCEPTIONALLY FATAL ERROR: Attempted to validate an argument, but the ErrorHandler service ";
			$str .= "is not running.</b><br><br>\n";
			$str .= "<b>Debug backtrace:</b>\n";
			$str .= print_r($debug, true);
			$str .= "\n<br></pre>\n";
			die($str);
		}
		// now that the ErrorHandler is running, we can access it
		$errorHandler =& Services::getService("ErrorHandler");
		
		// now make sure that $rule extends ValidatorRuleInterface object
		$subclassRule =& new ExtendsValidatorRule("ValidatorRuleInterface");
		if (!$subclassRule->check($rule)) {
			$str = "Unable to recognize the ValidatorRule object. Possibly, an invalid argument was passed.";
			$errorHandler->addNewError($str, "system", true);
		}
		
		// now try to validate the argument
		// if argument is invalid
		if (!$rule->check($argument)) {
			// then throw an error
			$description = "";
			$description .= "Argument validation failed in ";

			// get information abour the function that called the ArgumentValidator
			$debugBacktrace = debug_backtrace();
			$class = $debugBacktrace[1]["class"];
			$function = $debugBacktrace[1]["function"];
			$arguments = $debugBacktrace[1]["args"];
						
			$description .= $class."::".$function;
			// print the arguments using the ArgumentRenderer
			$description .= "(";
			$description .= ArgumentRenderer::renderManyArguments($arguments, false, false);
			$description .= ")";
			$description .= ". Argument '";
			$description .= ArgumentRenderer::renderOneArgument($argument, false, false);
			$description .= "' could not be validated using a/an ";
			$description .= get_class($rule);
			$description .= ".";

			// now create the error
			$errorHandler->addNewError($description, "system", $isFatal);
			return false;		    
		}
		
		// validation is successful
		return true;		
	}
	
}

?>