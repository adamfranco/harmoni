<?php

require_once(HARMONI.'services/Service.interface.php');

/**
 * 
 *
 * @version $Id: ErrorHandler.interface.php,v 1.2 2003/12/03 02:38:44 gabeschine Exp $
 * @package harmoni.interfaces.errorhandler
 * @copyright 2003 
 **/

class ErrorHandlerInterface extends ServiceInterface {
    

	/**
	 * Sets the debug mode. In debug mode, fatal errors do not kill the script.
	 * @method public setDebugMode
	 * @param boolean debugMode Specifies whether the handler should enter in
	 * debug mode.
	 * @return void 
	 */
	function setDebugMode($debugMode) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
    /**
     * Adds an Error object to the queue. If the error passed is fatal, then all the 
     * errors in the queue are outputed and the execution of the script is halted.
     *
     * @param object Error An error object to be added to the queue.
     * @access public
     */
	function addError(& $error){
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}

	/**
	 * Create a new Error object based on input and add it to the queue.
	 * Same as addError(new Error($description,$type,$isFatal))
	 * if isFatal is true then all the errors in the queue should be 
	 * outputed and execution of the script halted. 
	 *
	 * @param string $description Description of the error.
	 * @param string $type Type of the error.
	 * @param boolean $isFatal The scipt should be halted if this is True.
	 * @return object Error Reference to the error object that was created.
	 * @access public
	 */
    function addNewError($description,$type = "",$isFatal){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Returns the error queue in a {@link Queue} object.
	 * @return object
	 * @access public
	 */
	function &getErrorQueue() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
		
	/**
     * Count the number of errors currently in the queue.
	 * @return integer The number of errors that are currently in the queue.
	 * @access public
	 */
    function getNumberOfErrors(){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

    /**
     * Erase the error history.
	 * @access public
     */
    function clearErrors(){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");}

	/**
     * Generate an array os strings that describe the errors.
	 * @return array An array of strings that describe all the errors in the queue.
	 * @access public
	 */
	function generateErrorStringArray(){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Add an ErrorPrinter to the printer Queue, which will be used by the PrintErrors method.
     * @param object ErrorPrinter The Error printer to be added to the queue.
	 * @access public
	 */
	function addErrorPrinter(){ die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Fetch the Error queue as it is to each ErrorPrinter in the Error Printer queue.
     * @param int $detailLevel The level of detail when printing. Could be
	 * LOW_LEVEL, MEDIUM_LEVEL or HIGH_LEVEL.
	 * @access public
	 */
	function printErrors($detailLevel = MEDIUM_LEVEL) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
     * Prints the errors using the specified ErrorPrinter.
	 * @param object ErrorPrinter The ErrorPrinter to use when printing the errors.
     * @param int $detailLevel The level of detail when printing. Could be
	 * LOW_LEVEL, MEDIUM_LEVEL or HIGH_LEVEL.
	 * @access public
	 */
	function printErrorsWithErrorPrinter($errorPriner, $detailLevel = MEDIUM_LEVEL) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

}


?>