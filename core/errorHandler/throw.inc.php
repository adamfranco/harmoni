<?php

/**
 * Defines the throw functions.
 * @version $Id: throw.inc.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
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
 * Prints all of the errors in the "UserError" service with a pretty error printer.
 * @access public
 * @return string A string containing the output of the error printer. 
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