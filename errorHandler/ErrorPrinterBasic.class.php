<?php

require_once(HARMONI."errorHandler/ErrorPrinter.interface.php");

/**
 * An ErrorPrinter provides functionality to output Error objects in any way one's soul may desire.
 * to be used by the ErrorHandler
 *
 * @version $Id: ErrorPrinterBasic.class.php,v 1.3 2003/06/27 01:19:59 dobomode Exp $
 * @package harmoni.errorhandler
 * @copyright 2003
 * @access public
 */

class ErrorPrinterBasic extends ErrorPrinterInterface {

    /**
     * Outputs a queue of errors to any medium.
     * Outputs a queue of errors to any medium.
     * @param object Queue The queue of the errors to be printed
     * @param constant $detailLevel The level of detail when printing. Could be
	 * LOW_LEVEL, MEDIUM_LEVEL or HIGH_LEVEL.
     * @access public
     */
    function printErrors(& $errors, $detailLevel = MEDIUM_LEVEL) { 
		$result = "";
		
		// get header
		$header = $this->printHeader();

		/* We are assuming that only the last Error (first in the reversed queue) can be Fatal.*/
		while($errors->hasNext()) {
			$error =& $errors->next();
			
			$printWithDetails = false;
			
			if ($detailLevel == HIGH_DETAIL)
				$printWithDetails = true;
			elseif ($detailLevel == MEDIUM_DETAIL && $error->isFatal())
				$printWithDetails = true;

			$result .= $this->_printError(& $error, $printWithDetails);
		}
		
		// print result
		echo $result;
		
		// get footer
		$footer = $this->printFooter();

		// return everything that was printed
		return $header.$result.$footer;
	}

    /**
     * Prints the header of the Error output.
     * Prints the header of the Error output. This function will be invoked before Errors  are printed.
     * @access public
     */
    function printHeader() { 
		$result = "\n<br>\n<b>ERRORS:</b><br><br>\n";
		$result .= "<ul>";

		echo $result;
		
		return $result;
	}

    /**
     * Prints the footer of the Error output.
     * Prints the footer of the Error output. This function will be invoked after Errors have been printed.
     * @access public
     */
    function printFooter() {
		$result .= "</ul>";
		
		echo $result;
		
		return $result;
	}

    /**
     * Prints a single error.
     * Prints a single error.
     * @param object Error The Error object to be printed.
     * @param boolean $isDetailed If TRUE, will print the error with details.
     * @access private
     */
    function _printError(& $error, $isDetailed = false) {
		$result = "";
		
		$type = $error->getType();
		if(!$type)
			$type = "N/A";
	
		$description = nl2br($error->getDescription());

		$isFatal = ($error->isFatal()) ? "[FATAL]" : "[NON-FATAL]";
		
		$result .= "<li>\n";
		
		
		$result .= "<b>Type</b>: ".$type." $isFatal<br>\n";
		$result .= "<b>Description</b>: ".$description."<br><br>\n";
	
		if ($isDetailed) {
			/* get the call sequence information */
			$traceArray = $error->getDebugBacktrace();
		
			foreach($traceArray as $trace){
				/* each $traceArray element represents a step in the call hiearchy. Print them from bottom up. */
				$file = substr(strrchr($trace['file'],'/'),1);
				$line = $trace['line'];
				$function = $trace['function'];
				$class = $trace['class'];
				$type = $trace['type'];
				$args = ArgumentRenderer::renderManyArguments($trace['args'], false, false);

				$result .= "in <b>$file:$line</b> $class$type$function($args)<br>\n";
			}
			
			$result .= "<br>";
		}
		
		return $result;
	}

}



?>