<?php

/**
 * An ErrorPrinter interface provides functionality to output Error objects in any way one's soul may desire.
 * to be used by the ErrorHandler
 *
 * @version $Id: ErrorPrinter.interface.php,v 1.1 2003/06/26 16:30:25 movsjani Exp $
 * @package harmoni.errorhandler
 * @copyright 2003
 * @access public
 */

class ErrorPrinterInterface {

    /**
     * Outputs a queue of errors to any medium.
     * Outputs a queue of errors to any medium.
     * @param object Queue of Errors The queue of the errors to be printed
     * @access public
     */
    function printErrors($errors) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

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