<?php

require_once(HARMONI."errorHandler/HarmoniException.class.php");
require_once(HARMONI."errorHandler/HarmoniErrorHandler.class.php");

/**
 * This class is a hold-over from Harmoni's old error Handler, which tried to
 * do some exception-like things in PHP4. The new implementation, just extends
 * the default exception for compatability purposes
 *
 * @package harmoni.error_handler
 *
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Error.class.php,v 1.10 2008/04/18 14:58:26 adamfranco Exp $
 */

class HarmoniError
	extends HarmoniException
{

	/**
	 * The constructor. Create a new error.
	 * @param string $description A description of the error.
	 * @param string $type The type of error. For sorting purposes. ie.: "user", "db", etc.
	 * @param boolean $isFatal True if the error should halt execution.
	 * @access public
	 */

    function __construct ($description,$type = "",$isFatal = true) {
		parent::__construct($description, 0, $type, $isFatal);
    }
}

/**
 * This class is a hold-over from Harmoni's old error Handler, which tried to
 * do some exception-like things in PHP4. The new implementation, just extends
 * the default exception for compatability purposes
 *
 * @package harmoni.error_handler
 *
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Error.class.php,v 1.10 2008/04/18 14:58:26 adamfranco Exp $
 */
class UnknownDBError extends HarmoniError {
	function __construct($type) {
		parent::Error("An unkonwn Database error occured.", $type, true);
	}
}


/**
 * Throws an error using the ErrorHandler.
 * @param object Error The error object to throw.
 */
function throwError(Exception $error) {
	// new implementation for PHP 5
	throw $error;
}

?>
