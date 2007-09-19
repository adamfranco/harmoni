<?php

/**
 * Defines the throw functions.
 *
 * @package harmoni.error_handler
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: throw.inc.php,v 1.15 2007/09/19 14:04:09 adamfranco Exp $
 */

/**
 * Throws an error using the ErrorHandler.
 * @param object Error The error object to throw.
 */
function throwError($error) {
	// new implementation for PHP 5
	throw $error;
}

/**
 * Prints a debug_backtrace() array in a pretty HTML way...
 * @param optional array $trace The array. If null, a current backtrace is used.
 * @param optional boolean $return If true will return the HTML instead of printing it.
 * @access public
 * @return void
 */
 function printDebugBacktrace($trace = null, $return=false)
 {
 	$traceArray = is_array($trace)?$trace:debug_backtrace();

 	if ($return) ob_start();
 	 	
 	print "\n\n<table border='1'>";
 	print "\n\t<thead>";
 	print "\n\t\t<tr>";
 	print "\n\t\t\t<th>#</th>";
 	print "\n\t\t\t<th>File</th>";
 	print "\n\t\t\t<th>Line</th>";
 	print "\n\t\t\t<th>Call</th>";
 	print "\n\t\t</tr>";
 	print "\n\t</thead>";
 	print "\n\t<tbody>";
 	if (is_array($traceArray)) {
 		foreach($traceArray as $i => $trace) {
 			/* each $traceArray element represents a step in the call hiearchy. Print them from bottom up. */
 			$file = basename($trace['file']);
 			$line = $trace['line'];
 			$function = $trace['function'];
 			$class = isset($trace['class'])?$trace['class']:'';
 			$type = isset($trace['type'])?$trace['type']:'';
 			$args = ArgumentRenderer::renderManyArguments($trace['args'], false, false);
			
			print "\n\t\t<tr>";
			print "\n\t\t\t<td>$i</td>";
			print "\n\t\t\t<td title=\"".$trace['file']."\">$file</td>";
			print "\n\t\t\t<td>$line</td>";
			print "\n\t\t\t<td style='font-family: monospace; white-space: nowrap'>$class$type$function($args);</td>";
			print "\n\t\t</tr>";
 		}
 	}
 	print "\n\t</tbody>";
 	print "\n</table>";
 	
 	if ($return) return ob_get_clean();
 }

?>