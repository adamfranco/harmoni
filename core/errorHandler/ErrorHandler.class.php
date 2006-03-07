<?php

require_once(HARMONI."utilities/Queue.class.php");
require_once(HARMONI."errorHandler/Error.class.php");
require_once(HARMONI."errorHandler/ErrorHandler.interface.php");
require_once(HARMONI."errorHandler/ErrorPrinterBasic.class.php");
require_once(HARMONI."errorHandler/SimpleHTMLErrorPrinter.class.php");

/**
 *
 * @package harmoni.errorhandler
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ErrorHandler.class.php,v 1.13 2006/03/07 21:34:12 adamfranco Exp $
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
	 * @var boolean _debugMode 
	 * @access private
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
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	database_index			integer
	 *	database_name			string
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.OsidException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.OsidException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
	}

	/**
	 * Return context of this OsidManager.
	 *	
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function &getOsidContext () { 
		return $this->_osidContext;
	} 

	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( &$context ) { 
		$this->_osidContext =& $context;
	} 
	
	/**
	 * Sets the debug mode. In debug mode, fatal errors do not kill the script.
	 * @access public
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
		
		if (Services::serviceAvailable("Logging")) {
			$loggingManager =& Services::getService("Logging");
			$log =& $loggingManager->getLogForWriting("Harmoni");
			$formatType =& new Type("logging", "edu.middlebury", "AgentsAndNodes",
							"A format in which the acting Agent[s] and the target nodes affected are specified.");
			$priorityType =& new Type("logging", "edu.middlebury", "Fatal_Error",
							"Events involving critical system errors.");
			
			$item =& new AgentNodeEntryItem($error->getType(), $error->getDescription());
			$item->setBacktrace($error->getDebugBacktrace());
			$log->appendLogWithTypes($item,	$formatType, $priorityType);
			
		}
		
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
	function &addNewError($description,$type,$isFatal = false){
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
	 * Returns the error queue in a {@link Queue} object.
	 * @return object
	 * @access public
	 */
	function &getErrorQueue() {
		return $this->_errorQueue;
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
}
?>