<?php

/**
 * Defines the throw function.
 * Defines the throw function.
 * @version $Id: throw.inc.php,v 1.1 2003/06/26 16:18:06 dobomode Exp $
 * @copyright 2003 
 * @package harmoni.errorHandler
 **/


/**
 * Throws an error using the ErrorHandler.
 * Throws an error using the ErrorHandler.
 * @param object Error The error object to throw.
 */
function throw(& $error) {
	// first, make sure that the ErrorHandler service is running
	Services::requireService("ErrorHandler");

	// now that the ErrorHandler is running, we can access it
	$errorHandler =& Services::getService("ErrorHandler");

	// throw the error
	$errorHandler->addError($error);
}


?>