<?php

	// Define some constants for the detail level when printing

	/**
	 * Low detail level of printing.
	 * Low detail level of printing.
	 * @const LOW_DETAIL Low detail level of printing.
	 * @access public
	 */
	define(LOW_DETAIL, 1);
	
	/**
	 * Normal detail level of printing.
	 * Normal detail level of printing.
	 * @const NORMAL_DETAIL Normal detail level of printing.
	 * @access public
	 */
	define(NORMAL_DETAIL, 2);
	
	/**
	 * High detail level of printing.
	 * High detail level of printing.
	 * @const HIGH_DETAIL High detail level of printing.
	 * @access public
	 */
	define(HIGH_DETAIL, 3);
	
/**
 * An ErrorPrinter interface provides functionality to output Error objects in any way one's soul may desire.
 * to be used by the ErrorHandler
 *
 * @version $Id: ErrorPrinter.interface.php,v 1.2 2003/06/27 01:19:59 dobomode Exp $
 * @package harmoni.errorhandler
 * @copyright 2003
 * @access public
 */

class ErrorPrinterInterface {

    /**
     * Outputs a queue of errors to any medium.
     * Outputs a queue of errors to any medium.
     * @param object Queue The queue of the errors to be printed
     * @param constant $detailLevel The level of detail when printing. Could be
	 * LOW_LEVEL, MEDIUM_LEVEL or HIGH_LEVEL.
     * @access public
     */
    function printErrors($errors, $detailLevel = MEDIUM_LEVEL) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Prints the header of the Error output.
     * Prints the header of the Error output. This function will be invoked before Errors  are printed.
     * @access public
     */
    function printHeader() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Prints the footer of the Error output.
     * Prints the footer of the Error output. This function will be invoked after Errors have been printed.
     * @access public
     */
    function printFooter() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}



?>