<?php

/**
 * Defines the throw functions.
 * @version $Id: throw.inc.php,v 1.6 2004/08/30 20:14:16 adamfranco Exp $
 * @copyright 2003 
 * @package harmoni.errorhandler
 **/


/**
 * Throws an error using the ErrorHandler.
 * @param object Error The error object to throw.
 * @package harmoni.errorhandler
 */
function throwError(& $error) {
	// first, make sure that the ErrorHandler service is running
	Services::requireService("ErrorHandler");

	// now that the ErrorHandler is running, we can access it
	$errorHandler =& Services::getService("ErrorHandler");

	// throw the error
	$errorHandler->addError($error);
}

/**
 * Try a function and catch any errors. If an error has occured,
 * the try will return FALSE. The error can then be accessed and
 * printed from the ErrorHandler if desired.
 *
 * @param mixed $operation The operation to run. Of the form:
 *  	try("$function($arg1, $arg2, etc)")
 * 	or
 *  	try("$object->$function($arg1, $arg2, etc)")
 * @return boolean TRUE if successful, FALSE if an error occurred.
 */
function try ($operation) {
	
	die (UNIMPLEMENTED); 
	
	$errorHandler =& Services::getService("ErrorHandler");
	
	/* Several problems with implementing this function: 
		- Debug mode (or equivalent without "die()" call) may allow unsafe
		  execution to continue if the throwError() call was being used
		  to stop exectution
		  
		- It seems that die() and exit() are the only functions that can 
		  escape out of multiple functions. I can't figure out any way to
		  get back to the try function and allow it to continue, while stopping
		  the execution of the functions called withing try().
		
		- unclear how references may be handeled in the evaled string. Need
		  to check on this.
	*/
	
	eval ($operation);
}

/**
 * Throws an error using the UserErrorHandler.
 * @param object Error The error object to throw.
 * @package harmoni.errorhandler
 */
function userError(& $error) {
	// first, make sure that the ErrorHandler service is running
	Services::requireService("UserError");

	// now that the ErrorHandler is running, we can access it
	$errorHandler =& Services::getService("UserError");

	// throw the error
	$errorHandler->addError($error);
}

/**
 * Prints out all of the errors from the ErrorHandler using the specified printer and returns the output in a string.
 * @package harmoni.errorhandler
 * @param ref object $printer The {@link ErrorPrinter} to use.
 * @return void
 */
function printErrors(&$printer)
{
	$handler =& Services::requireService("ErrorHandler");
	
	if (haveErrors())
		return $handler->printErrorsWithErrorPrinter($printer);
}

/**
 * Returns if we have errors in the ErrorHandler service.
 * @package harmoni.errorhandler
 * @return boolean
 */
function haveErrors()
{
	$handler =& Services::requireService("ErrorHandler");
	
	if ($handler->getNumberOfErrors()) {
		return true;
	}
	return false;
}

/**
 * Prints all of the errors in the "UserError" service with a pretty error printer.
 * @access public
 * @return string A string containing the output of the error printer. 
 * @package harmoni.errorhandler
 **/
function printUserErrors() {
	// require the service
	Services::requireService("UserError");
	
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
 * @package harmoni.errorhandler
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