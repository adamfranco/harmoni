<?php

/**
 * 
 *
 * @version $Id: ErrorHandler.interface.php,v 1.4 2003/06/26 16:05:44 movsjani Exp $
 * @package harmoni.errorhandler
 * @copyright 2003 
 **/

class ErrorHandlerInterface{
    

    /**
     * @param object Error An error object to be added to the queue.
     * If the error passed is fatal, then all the errors in the queue are outputed and the execution of the script is halted.
     * @access public
     */

    function addError(& $error){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Create a new Error object based on input and add it to the queue.
     * Same as addError(new Error($description,$type,$isFatal))
     * if isFatal is true then all the errors in the queue should be 
     * outputed and execution of the script halted. 
     *
     * @param string $description Description of the error.
     * @param string $type Type of the error.
     * @param boolean $isFatal Whether the scipt should be halted after this error occured.
     * @return object Error Reference to the error object that was created.
     * @access public
     */

    function addNewError($description,$type = "",$isFatal){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * @return integer The number of errors that are currently in the queue.
     * @access public
     */

    function getNumberOfErrors(){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Clear all error history.
     * @access public
     */

    function clearErrors(){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}

	/**
	 * @return array An array of strings that describe all the errors in the queue.
	 * @access public
	 */

	function generateErrorStringArray(){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Add an ErrorPrinter to the printer Queue, which will be used by the PrintErrors method.
     * Add an ErrorPrinter to the printer Queue, which will be used by the PrintErrors method.
     * @param class ErrorPrinter The Error printer to be added to the queue.
	 * @access public
	 */

	function addErrorPrinter(){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Fetch the Error queue as it is to each ErrorPrinter in the Error Printer queue.
     * Fetch the Error queue as it is to each ErrorPrinter in the Error Printer queue.
	 * @access public
	 */

	function printErrors(){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}


?>