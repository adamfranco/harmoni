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
 * @version $Id: ArgumentValidator.class.php,v 1.4 2003/06/30 22:03:37 dobomode Exp $
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
	 * @param optional boolean $isFatal If TRUE, upon validation failure, a fatal error
	 * will be thrown. Default: FALSE.
	 * @access public
	 * @return boolean If validation is successful, returns TRUE. If validation
	 * fails and $isFatal is FALSE, returns FALSE. If $isFatal is TRUE, then
	 * if validation fails, the script would halt and nothing would ever be
	 * returned.
	 * @static
	 **/
	function validate($argument, $rule, $isFatal = true) {
		// now make sure that $rule extends ValidatorRuleInterface object
		$extendsRule =& new ExtendsValidatorRule("ValidatorRuleInterface");
		if (!$extendsRule->check($rule)) {
			$str = "Unable to recognize the ValidatorRule object. Possibly, an invalid argument was passed.";
			throw(new Error($str, "System", true));
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
			throw(new Error($description, "System", $isFatal));
			return false;		    
		}
		
		// validation is successful
		return true;		
	}
	
}

?>