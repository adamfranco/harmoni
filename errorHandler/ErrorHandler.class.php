<?php

require_once(HARMONI."utilities/Queue.class.php");
require_once(HARMONI."errorHandler/Error.class.php");
require_once(HARMONI."errorHandler/ErrorHandler.interface.php");
require_once(HARMONI."errorHandler/ErrorPrinterBasic.class.php");

/**
 *  
 * @version $Id: ErrorHandler.class.php,v 1.12 2003/06/27 02:09:52 dobomode Exp $
 * @package harmoni.errorhandler
 * @copyright 2003 
 */

class ErrorHandler extends ErrorHandlerInterface{
	
	/**
	 * @var object QueueInterface $_errorQueue A Queue of the errors.
	 * @access private
	 */
	var $_errorQueue;

	/**
	 * @var object QueueInterface $_errorQueue A Queue of the Error Printers.
	 * @access private
	 */
	var $_printerQueue;
   

	/**
	 * The Constructor.
	 * The Constructor. It creates a new ErrorHandler.
	 *
	 * @access public
	 */
	function ErrorHandler(){
		$this->_errorQueue = new Queue(true);
		$this->_printerQueue = new Queue();
		$this->addErrorPrinter(new ErrorPrinterBasic());
	}

    /**
     * Adds an Error object to the queue.
     * Adds an Error object to the queue. If the error passed is fatal, then all the 
     * errors in the queue are outputed and the execution of the script is halted.
     *
     * @param object Error An error object to be added to the queue.
     * @access public
     */
	function addError(& $error){
		$this->_errorQueue->add($error);
		if($error->isFatal()){
			$this->printErrors();
			die();
		}
	}

	/**
	 * Create a new Error object based on input and add it to the queue.
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
	function & addNewError($description,$type,$isFatal = false){
		$newError =& new Error($description,$type,$isFatal);
		$this->addError($newError);

		return $newError;
	}

	/**
     * Generate an array os strings that describe the errors.
     * Generate an array os strings that describe the errors.
	 * @return array An array of strings that describe all the errors in the queue.
	 * @access public
	 */
	function generateErrorStringArray(){
		$errorArray = array();

		while($this->_errorQueue->hasNext()){
			$error =& $this->_errorQueue->next();
			
			$str = "";
			if ($error->getType())
				$str .= "[".$error->getType()."] ";
			$str .= $error->getDescription();
			
			$errorArray[] = $str;
		}
		
		return $errorArray;
	}

	/**
     * Count the number of errors currently in the queue.
     * Count the number of errors currently in the queue.
	 * @return integer The number of errors that are currently in the queue.
	 * @access public
	 */
	function getNumberOfErrors(){
		return $this->_errorQueue->getSize();
	}


    /**
     * Erase the error history.
     * Erase the error history.
	 * @access public
     */
    function clearErrors(){
		$this->_errorQueue->clear();
	}

	/**
     * Add an ErrorPrinter to the printer Queue, which will be used by the PrintErrors method.
     * Add an ErrorPrinter to the printer Queue, which will be used by the PrintErrors method.
     * @param object ErrorPrinter The Error printer to be added to the queue.
	 * @access public
	 */
	function addErrorPrinter(& $printer){
		$this->_printerQueue->add($printer);
	}

	/**
     * Fetch the Error queue as it is to each ErrorPrinter in the Error Printer queue.
     * Fetch the Error queue as it is to each ErrorPrinter in the Error Printer queue.
     * @param constant $detailLevel The level of detail when printing. Could be
	 * LOW_DETAIL, NORMAL_DETAIL or HIGH_DETAIL.
	 * @access public
	 */
	function printErrors($detailLevel = NORMAL_DETAIL) {
		while($this->_printerQueue->hasNext()){
			$printer =& $this->_printerQueue->next();
			$printer->printErrors($this->_errorQueue, $detailLevel);
		}
	}
}
?>