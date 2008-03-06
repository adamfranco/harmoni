<?php

//require_once(HARMONI."utilities/ArgumentValidator.interface.php");
require_once(HARMONI."utilities/ArgumentRenderer.class.php");
require_once(HARMONI."utilities/FieldSetValidator/rules/inc.php");

/**
 * An ArgumentValidator performs validation of function arguments.
 * An ArgumentValidator performs validation of function arguments. The validator
 * makes use of a specified ValidatorRule object. In addition, if validation
 * fails, a new fatal error is added to the default ErrorHandler.
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ArgumentValidator.class.php,v 1.14 2008/03/06 15:17:02 adamfranco Exp $
 */
class ArgumentValidator {

	/**
	 * Validates a single argument.
	 * Validates a single argument. Uses a specified ValidatorRule object for validation.
	 * @param ref mixed $argument The argument to be validated.
	 * @param ref object ValidatorRule $rule The rule to use for validation.
	 * @param optional boolean $isFatal If TRUE, upon validation failure, a fatal error
	 * will be thrown. Default: FALSE.
	 * @access public
	 * @return boolean If validation is successful, returns TRUE. If validation
	 * fails and $isFatal is FALSE, returns FALSE. If $isFatal is TRUE, then
	 * if validation fails, the script would halt and nothing would ever be
	 * returned.
	 * @static
	 **/
	static function validate($argument, ValidatorRuleInterface $rule, $isFatal = true) {
		if (defined('DISABLE_VALIDATION') && DISABLE_VALIDATION)
			return true;
		
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
			if (isset($debugBacktrace[1]["args"]))
				$arguments = $debugBacktrace[1]["args"];
			else
				$arguments = array();
						
			$description .= "<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;".$class."::".$function;
			// print the arguments using the ArgumentRenderer
			$description .= "(";
			$description .= ArgumentRenderer::renderManyArguments($arguments, false, false);
			$description .= ");";
			$description .= "<br/><br/>Argument '";
			$description .= ArgumentRenderer::renderOneArgument($argument, false, false);
			$description .= "' could not be validated using a/an ";
			$description .= get_class($rule);
			$description .= ".";

			// now create the error
			throw new InvalidArgumentException($description);
		}
		
		// validation is successful
		return true;		
	}

}

?>