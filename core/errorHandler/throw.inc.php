<?php

/**
 * Defines the throw functions.
 *
 * @package harmoni.errorhandler
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: throw.inc.php,v 1.10 2005/04/12 18:09:32 adamfranco Exp $
 */

/**
 * Throws an error using the ErrorHandler.
 * @param object Error The error object to throw.
 */
function throwError(& $error) {
	$errorHandler =& Services::getService("ErrorHandler");

	// throw the error
	$errorHandler->addError($error);
}

/**
 * Throws an error using the UserErrorHandler.
 * @param object Error The error object to throw.
 */
function userError(& $error) {
	$errorHandler =& Services::getService("UserError");

	// throw the error
	$errorHandler->addError($error);
}

/**
 * Prints out all of the errors from the ErrorHandler using the specified printer and returns the output in a string.
 * @param ref object $printer The {@link ErrorPrinter} to use.
 * @return void
 */
function printErrors(&$printer)
{
	$handler =& Services::getService("ErrorHandler");
	
	if (haveErrors())
		return $handler->printErrorsWithErrorPrinter($printer);
}

/**
 * Returns if we have errors in the ErrorHandler service.
 * @return boolean
 */
function haveErrors()
{
	$handler =& Services::getService("ErrorHandler");
	
	if ($handler->getNumberOfErrors()) {
		return true;
	}
	return false;
}

/**
 * Prints all of the errors in the "UserError" service with a pretty error printer.
 * @access public
 * @return string A string containing the output of the error printer. 
 */
function printUserErrors() {
	// get it
	$errorHandler =& Services::getService("UserError");
	
	// check if we have any
	if ($errorHandler->getNumberOfErrors()) {
		$printer =& new SimpleHTMLErrorPrinter;
		return $errorHandler->printErrorsWithErrorPrinter($printer);
	}
		
}

/**
 * Prints a debug_backtrace() array in a pretty HTML way...
 * @param optional array $trace The array. If null, a current backtrace is used.
 * @param optional boolean $return If true will return the HTML instead of printing it.
 * @access public
 * @return void
 */
 function printDebugBacktrace($trace = null, $return=false)
 {
 	$traceArray = is_array($trace)?$trace:debug_backtrace();

 	$result='';
 	
 	if (is_array($traceArray)) {
 		foreach($traceArray as $trace){
 			/* each $traceArray element represents a step in the call hiearchy. Print them from bottom up. */
 			$file = basename($trace['file']);
 			$line = $trace['line'];
 			$function = $trace['function'];
 			$class = $trace['class'];
 			$type = $trace['type'];
 			$args = ArgumentRenderer::renderManyArguments($trace['args'], false, false);

 			$result .= "in <b>$file:$line</b> $class$type$function($args)<br />\n";
 		}
 	}
 	$result .= "<br />";
 	
 	if ($return) return $result;
 	print $result;
 }

?>