<?php

/**
 * Defines the throw functions.
 * @version $Id: throw.inc.php,v 1.3 2004/05/31 20:32:24 gabeschine Exp $
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
	
	if (haveErrors()) {
		ob_start();
		$handler->printErrorsWithErrorPrinter($printer);
		$contents = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	return "";
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
		// yup
		// capture the output and return it
		ob_start();
		$printer =& new SimpleHTMLErrorPrinter;
		$errorHandler->printErrorsWithErrorPrinter($printer);
		$content = ob_get_contents();
		ob_end_clean();
		$errorHandler->clearErrors();
		return $content;
	}
	return "";
}


?>