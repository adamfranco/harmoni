<?php

require_once("../../utilities/Queue.class.php");
require_once("Error.class.php");
require_once("ErrorHandler.interface.php");


/**
 *  
 * @version $Id: ErrorHandler.class.php,v 1.3 2003/06/25 15:13:07 movsjani Exp $
 * @package harmoni.errorhandler
 * @copyright 2003 
 */

class ErrorHandler extends ErrorHandlerInterface{
	

	var $_errorQueue;

	function ErrorHandler(){
		$this->_errorQueue = new Queue(true);
	}

	/**
	 * @param object Error An error object to be added to the queue.
	 * If the error passed is fatal, then all the errors in the queue are outputed and the execution of the script is halted.
	 * @access public
	 */

	function addError(& $error){
		if($error->isFatal())
			$this->_outputFatal(& $error);
		else
			$this->_errorQueue->add(& $error);
	}

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

	function addNewError($description,$type,$isFatal = false){
		$newError = new Error($description,$type,$isFatal);
		$this->addError(& $newError);

		return $newError;
	}

	/**
	 * @return array An array of strings that describe all the errors in the queue.
	 * @access public
	 */

	function generateErrorStringArray(){
		$errorArray = array();

		while($this->_errorQueue->hasNext()){
			$error =& $this->_errorQueue->next();
			$errorArray[] = (($error->getType())?"[".$error->getType()."] ":"").$error->getDescription();
		}
		return $errorArray;
	}

	/**
	 * @return integer The number of errors that are currently in the queue.
	 * @access public
	 */

	function getNumberOfErrors(){
		return $this->_errorQueue->getSize();
	}


    /**
     * Erase all error history.
	 * @access public
     */

    function clearErrors(){
		$this->_errorQueue->clear();
	}

    /**
     * Output formatted messages about error history in the case of a fatal error. Terminate the execution of the script afterwards.
	 * @access private
     */

	function _outputFatal(& $error){
		/* Print the information about the last Error and the sequence of commands that caused it */
  	
		print "<h3>Fatal error:</h3>";

		if($error->getType())
			print "Type: ".$error->getType()."<br>";
		
		print "Description: ".$error->getDescription()."<br><br>";

		/* get the call sequence information */
		$traceArray = debug_backtrace();
		
		foreach($traceArray as $trace){
			/* each $traceArray element represents a step in the call hiearchy. Print them from bottom up. */
			$file = substr(strrchr($trace['file'],'/'),1);
			$line = $trace['line'];
			$function = $trace['function'];
			$class = $trace['class'];
			$type = $trace['type'];
			$args = "";

			/* Get comma delimited arguements of the calls.  Arrays and Objects are not expanded */
			foreach($trace['args'] as $argument)
				$args.= $argument.",";

			$args = substr($args,0,-1);
				
			print "in <b>$file:$line</b> $class$type$function($args)<br>\n";
		}

		/* Now output all the errors in the queue as a bulleted indented list */

		$errors = $this->generateErrorStringArray();
		
		print "<h4>Previous Errors:</h4>";

		print "<ul>";

	    foreach($errors as $error){
			print "<li>$error</li>";
		}

		print "</ul>";
	   
		exit();
	}
}
?>