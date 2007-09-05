<?php

require_once(HARMONI."errorHandler/HarmoniException.class.php");

/**
 * This class is a hold-over from Harmoni's old error Handler, which tried to
 * do some exception-like things in PHP4. The new implementation, just extends
 * the default exception for compatability purposes
 *
 * @package harmoni.errorhandler
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Error.class.php,v 1.7 2007/09/05 19:55:20 adamfranco Exp $
 */

class Error 
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

class UnknownDBError extends Error {
	function __construct($type) {
		parent::Error("An unkonwn Database error occured.", $type, true);
	}
}

?>