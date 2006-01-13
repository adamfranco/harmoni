<?php
/**
 * @package harmoni.errorhandler
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ErrorPrinterBasic.class.php,v 1.10 2006/01/13 16:11:05 adamfranco Exp $
 */
 
require_once(HARMONI."errorHandler/ErrorPrinter.interface.php");

/**
 * An ErrorPrinter provides functionality to output Error objects in any way one's soul may desire.
 * to be used by the ErrorHandler
 *
 * @package harmoni.errorhandler
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ErrorPrinterBasic.class.php,v 1.10 2006/01/13 16:11:05 adamfranco Exp $
 */

class ErrorPrinterBasic extends ErrorPrinterInterface {
	
	/**
	* Outputs a queue of errors to any NORMAL. This function will call
	* printHeader() at the beginning and printFooter() at the end.
	* @param object Queue $errors The queue of the errors to be printed
	* @param int $detailLevel The level of detail when printing. Could be
	* LOW_DETAIL, NORMAL_DETAIL or HIGH_DETAIL.
	* @access public
	*/
	function printErrors($errors, $detailLevel = NORMAL_DETAIL) {
		$result = "";
		
		// get header
		$header = $this->printHeader($errors);
		
		// be nice and rewind the error queue.
		$errors->rewind();
		
		/* We are assuming that only the last Error (first in the reversed queue) can be Fatal.*/
		while($errors->hasNext()) {
			$error =& $errors->next();
			
			$printWithDetails = false;
			
			if ($detailLevel == HIGH_DETAIL)
				$printWithDetails = true;
			if ($error->isFatal())
				$printWithDetails = true;
			
			$result .= $this->_printError( $error, $printWithDetails);
		}
		
		// print result
		echo $result;
		
		// get footer
		$footer = $this->printFooter($errors);
		
		// return everything that was printed
		return $header.$result.$footer;
	}
	
	/**
	* Prints the header of the Error output. This function will be invoked before Errors  are printed.
	* @param object Queue $errors The queue of the errors to be printed
	* @access public
	*/
	function printHeader($errors) {
		$result = "\n<br />\n<b>ERRORS:</b><br /><br />\n";
		$result .= "<ul>";
		
		echo $result;
		
		return $result;
	}
	
	/**
	* Prints the footer of the Error output. This function will be invoked after Errors have been printed.
	* @param object Queue $errors The queue of the errors to be printed
	* @access public
	*/
	function printFooter($errors) {
		$result = "</ul>";
		
		$result .= "\nTotal: ";
		$result .= $errors->getSize();
		$result .= " errors.<br />\n";
		
		echo $result;
		
		return $result;
	}
	
	/**
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
		
		
		$result .= "<b>Type</b>: ".$type." $isFatal<br />\n";
		$result .= "<b>Description</b>: ".$description."<br /><br />\n";
		
		if ($isDetailed) {
			/* get the call sequence information */
			$traceArray = $error->getDebugBacktrace();
			
			if (is_array($traceArray)) {
				foreach($traceArray as $trace){
					/* each $traceArray element represents a step in the call hiearchy. Print them from bottom up. */
					$file = basename($trace['file']);
					$line = $trace['line'];
					$function = $trace['function'];
					
					if (isset($trace['class']))
						$class = $trace['class'];
					else
						$class = '';
					
					if (isset($trace['type']))
						$type = $trace['type'];
					else
						$type = '';
					
					if (isset($trace['args']))
						$args = ArgumentRenderer::renderManyArguments($trace['args'], false, false, 2*1024);
					else
						$args = '';
					
					$result .= "in <b>$file:$line</b> $class$type$function($args)<br />\n";
				}
			}
			$result .= "<br />";
		}
		
		return $result;
	}
	
}



?>
