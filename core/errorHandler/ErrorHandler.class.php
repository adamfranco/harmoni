<?php

require_once(HARMONI."utilities/Queue.class.php");
require_once(HARMONI."errorHandler/Error.class.php");
require_once(HARMONI."errorHandler/ErrorHandler.interface.php");
require_once(HARMONI."errorHandler/ErrorPrinterBasic.class.php");
require_once(HARMONI."errorHandler/SimpleHTMLErrorPrinter.class.php");

/**
 *  
 * @version $Id: ErrorHandler.class.php,v 1.2 2003/08/20 21:20:15 adamfranco Exp $
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
	 * The debug mode variable.
	 * @attribute private boolean _debugMode
	 */
	var $_debugMode;
	
   

	/**
	 * The Constructor. It creates a new ErrorHandler.
	 *
	 * @access public
	 */
	function ErrorHandler(){
		$this->_errorQueue = new Queue(true);
		$this->_printerQueue = new Queue();
		$this->addErrorPrinter(new ErrorPrinterBasic());
		$this->_debugMode = false;
	}
	
	
	/**
	 * Sets the debug mode. In debug mode, fatal errors do not kill the script.
	 * @method public setDebugMode
	 * @param boolean debugMode Specifies whether the handler should enter in
	 * debug mode.
	 * @return void 
	 */
	function setDebugMode($debugMode) {
		$this->_debugMode = $debugMode;
	}
	
	

    /**
     * Adds an Error object to the queue. If the error passed is fatal, then all the 
     * errors in the queue are outputed and the execution of the script is halted.
     *
     * @param object Error An error object to be added to the queue.
     * @access public
     */
	function addError(& $error){
		$this->_errorQueue->add($error);
		
		if($error->isFatal()){
			$this->printErrors(HIGH_DETAIL);
			if ($this->_debugMode == false)
				die();
		}
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
	function & addNewError($description,$type,$isFatal = false){
		$newError =& new Error($description,$type,$isFatal);
		$this->addError($newError);

		return $newError;
	}

	/**
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
	 * @return integer The number of errors that are currently in the queue.
	 * @access public
	 */
	function getNumberOfErrors(){
		return $this->_errorQueue->getSize();
	}


    /**
     * Erase the error history.
	 * @access public
     */
    function clearErrors(){
		$this->_errorQueue->clear();
	}

	/**
     * Add an ErrorPrinter to the printer Queue, which will be used by the PrintErrors method.
     * @param object ErrorPrinter The Error printer to be added to the queue.
	 * @access public
	 */
	function addErrorPrinter(& $printer){
		$this->_printerQueue->add($printer);
	}

	/**
     * Fetch the Error queue as it is to each ErrorPrinter in the Error Printer queue.
     * @param int $detailLevel The level of detail when printing. Could be
	 * LOW_DETAIL, NORMAL_DETAIL or HIGH_DETAIL.
	 * @use LOW_DETAIL
	 * @use NORMAL_DETAIL
	 * @use HIGH_DETAIL
	 * @access public
	 */
	function printErrors($detailLevel = NORMAL_DETAIL) {
		while($this->_printerQueue->hasNext()){
			$printer =& $this->_printerQueue->next();
			$printer->printErrors($this->_errorQueue, $detailLevel);
		}
		$this->_printerQueue->rewind();
		$this->_errorQueue->rewind();
	}


	/**
     * Prints the errors using the specified ErrorPrinter.
	 * @param object ErrorPrinter The ErrorPrinter to use when printing the errors.
     * @param int $detailLevel The level of detail when printing. Could be
	 * LOW_LEVEL, MEDIUM_LEVEL or HIGH_LEVEL.
	 * @access public
	 */
	function printErrorsWithErrorPrinter($errorPrinter, $detailLevel = MEDIUM_LEVEL) { 
		$errorPrinter->printErrors($this->_errorQueue, $detailLevel);
	}


	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
	}
	

}
?>