<?php

require_once(HARMONI."errorHandler/ErrorPrinter.interface.php");

/**
 * An ErrorPrinter provides functionality to output Error objects in any way one's soul may desire.
 * to be used by the ErrorHandler
 *
 * @package harmoni.errorhandler
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleHTMLErrorPrinter.class.php,v 1.3 2007/09/04 20:25:35 adamfranco Exp $
 */

class SimpleHTMLErrorPrinter extends ErrorPrinterInterface {

    /**
     * Outputs a queue of errors to any NORMAL. This function will call
	 * printHeader() at the beginning and printFooter() at the end.
     * @param object Queue $errors The queue of the errors to be printed
     * @param int $detailLevel The level of detail when printing. Could be
	 * LOW_DETAIL, NORMAL_DETAIL or HIGH_DETAIL.
     * @access public
     */
    function printErrors($errors, $detailLevel = NORMAL_DETAIL) { 
		$result = "";
		
		// get header
		$header = $this->printHeader($errors);

		// be nice and rewind the error queue.
		$errors->rewind();

		/* We are assuming that only the last Error (first in the reversed queue) can be Fatal.*/
		while($errors->hasNext()) {
			$error =$errors->next();
			
			$result .= $this->_printError( $error );
		}
		
		// print result
		echo $result;
		
		// get footer
		$footer = $this->printFooter($errors);

		// return everything that was printed
		return $header.$result.$footer;
	}

    /**
     * Prints the header of the Error output. This function will be invoked before Errors  are printed.
     * @param object Queue $errors The queue of the errors to be printed
     * @access public
     */
    function printHeader($errors) { 
		$result = "<div style='color: red'>\n";
		$result .= "<ul>";

		echo $result;
		
		return $result;
	}

    /**
     * Prints the footer of the Error output. This function will be invoked after Errors have been printed.
     * @param object Queue $errors The queue of the errors to be printed
     * @access public
     */
    function printFooter($errors) {
		$result = "</ul></div>";
		
		echo $result;
		
		return $result;
	}

    /**
     * Prints a single error.
     * @param object Error The Error object to be printed.
     * @param boolean $isDetailed If TRUE, will print the error with details.
     * @access private
     */
    function _printError($error, $isDetailed = false) {
		$result = "";
		
		$type = $error->getType();
			
		$description = $error->getDescription();
		
		$result .= "<li />";
		
		$result .= $type?"[".$type."] ":"";
		$result .= $description;
		
		return $result;
	}

}



?>