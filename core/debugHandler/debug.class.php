<?php

require_once HARMONI . "debugHandler/NewWindowDebugHandlerPrinter.class.php";

/**
 * The debug class is a static abstract class that holds wrapper functions for the DebugHandler service in Harmoni.
 *
 * @see DebugHandlerInterface
 *
 * @package harmoni.utilities.debugging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: debug.class.php,v 1.12 2005/03/29 19:44:14 adamfranco Exp $
 *
 * @static
 **/
class debug {
	/**
	 * Sends $text to the DebugHandler with level $level and category $category.
	 * @static
	 * @access public
	 * @return void
	 **/
	function output( $text, $level = 5, $category = "general") {
		if (!$level) return;
		if (!Services::serviceAvailable("Debug")) return;
		Services::requireService("Debug");
		
		$debugHandler =& Services::getService("Debug");
		$outputLevel = $debugHandler->getOutputLevel();

		if ($level <= $outputLevel)
			$debugHandler->add($text,$level,$category);
	}
	
	/**
	 * Sets the DebugHandler service's output level to $level. If not specified will
	 * return the current output level.
	 * @param optional integer $level
	 * @static
	 * @access public
	 * @return integer The current debug output level.
	 **/
	function level($level=null) {
		if (!Services::serviceAvailable("Debug")) {
			throwError ( new Error("Debug::level($level) called but Debug service isn't available.","debug wrapper",false));
			return;
		}
		
		Services::requireService("Debug");
		
		$debugHandler =& Services::getService("Debug");
		if (is_int($level))
			$debugHandler->setOutputLevel($level);
		return $debugHandler->getOutputLevel();
	}
	
	/**
	 * Prints current debug output using NewWindowDebugHandlerPrinter
	 * @access public
	 * @return void
	 */
	function printAll($debugPrinter = null) {
		// ** parameter validation
		$extendsRule =& ExtendsValidatorRule::getRule("DebugHandlerPrinter");
		ArgumentValidator::validate($id, OptionalRule::getRule($extendsRule), true);
		// ** end of parameter validation
	
		if (is_null($debugPrinter))
			NewWindowDebugHandlerPrinter::printDebugHandler(Services::requireService("Debug"));
		else
			$debugPrinter->printDebugHandler(Services::requireService("Debug"));
	}
	
	/**
	 * Print the MySQL version of a query
	 * 
	 * @param object Query $query
	 * @return void
	 * @access public
	 * @since 3/2/05
	 */
	function printQuery (&$query) {
		print "\n<pre>";
		print_r(MySQL_SQLGenerator::generateSQLQuery($query));	
		print "\n</pre>";
	}
	
	
}

function printpre($array, $return=FALSE) {
	$string = "\n<pre>";
	$string .= var_export($array, TRUE);
	$string .= "\n</pre>";
	
	if ($return)
		return $string;
	else
		print $string;
}

?>