<?php

require_once('ErrorPrinter.interface.php');
require_once(HARMONI.'utilities/ArgumentRenderer.class.php');


/**
 * An ErrorPrinter provides functionality to output Error objects in any way one's soul may desire.
 * to be used by the ErrorHandler
 *
 * @version $Id: ErrorPrinterBasic.class.php,v 1.1 2003/06/26 16:30:25 movsjani Exp $
 * @package harmoni.errorhandler
 * @copyright 2003
 * @access public
 */

class ErrorPrinterBasic extends ErrorPrinterInterface {

    /**
     * Outputs a queue of errors to any medium.
     * Outputs a queue of errors to any medium.
     * @param object Queue of Errors The queue of the errors to be printed
     * @access public
     */
    function printErrors(& $errors) { 
		/* Print the information about the last Error and the sequence of commands that caused it */

		$error = $errors->next();

		/* We are assuming that only the last Error (first in the reversed queue) can be Fatal.*/
		if($error->isFatal()){
			print "<br><b>FATAL ERROR:</b><br><br>\n";
			
			$argumentRenderer = new ArgumentRenderer();

			if($error->getType())
				print "<b>Type</b>: ".$error->getType()."<br>";
		
			print "<b>Description</b>: ".$error->getDescription()."<br><br>\n";

			/* get the call sequence information */
			$traceArray = $error->getDebugBacktrace();
		
			foreach($traceArray as $trace){
				/* each $traceArray element represents a step in the call hiearchy. Print them from bottom up. */
				$file = substr(strrchr($trace['file'],'/'),1);
				$line = $trace['line'];
				$function = $trace['function'];
				$class = $trace['class'];
				$type = $trace['type'];
				$args = "";
				
				/* Get comma delimited arguements of the calls.  Arrays and Objects are not expanded */
				/*				$argsArray = array();
				
				foreach ($trace["args"] as $arg)
					$argsArray[] = $this->_renderVariable($arg);
				
				$args = implode(", ", $argsArray);*/
				if($trace['args'])
					$args = $argumentRenderer->renderOneArgument($trace['args'],true);

				print "in <b>$file:$line</b> $class$type$function($args)<br>\n";
			}
			print "<br>----------------<br><br><b>PREVIOUS ERRORS:</b><br><ul>\n";
		}
		else{
			print "<ul>";
			$this->_printError(& $error);
		}
	  
		while($errors->hasNext()){
			$error = $errors->next();
			$this->_printError(& $error);
		}

		print "</ul>\n";
	}

    /**
     * Prints the header of the Error output.
     * Prints the header of the Error output. This function will be invoked before Errors  are printed.
     * @access public
     */
    function printHeader() { 
		
	}

    /**
     * Prints the footer of the Error output.
     * Prints the footer of the Error output. This function will be invoked after Errors have been printed.
     * @access public
     */
    function printFooter() {
		
	}

    /**
     * Prints a single error.
     * @param object Error The Error object to be printed.
     * @access private
     */
    function _printError(& $error) {
		print "<li>";
		$description = nl2br($error->getDescription());
		$type = $error->getType();
		echo "[$type] $description<br>";
	}

   /**
     *    Renders a variable in a shorter form than print_r().
	 *    Renders a variable in a shorter form than print_r(). Borrowed from
	 *    the SimpleTest PHP unit test framework.
	 *    @param $var        Variable to render as a string.
	 *    @protected
	 */

	function _renderVariable($var) {
	    if (!isset($var)) {
	        return "NULL";
	    } elseif (is_bool($var)) {
	        return "Boolean: " . ($var ? "true" : "false");
	    } elseif (is_string($var)) {
	        return "String: \"$var\"";
	    } elseif (is_integer($var)) {
	        return "Integer: $var";
	    } elseif (is_float($var)) {
	        return "Float: $var";
	    } elseif (is_array($var)) {
	        return "Array: " . count($var) . " items";
	    } elseif (is_resource($var)) {
	        return "Resource: $var";
	    } elseif (is_object($var)) {
	        return "Object: " . get_class($var);
	    }
	    return "Unknown";
	}
}



?>