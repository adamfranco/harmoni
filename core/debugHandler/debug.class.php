<?php

require_once HARMONI . "debugHandler/NewWindowDebugHandlerPrinter.class.php";

/**
 * The debug class is a static abstract class that holds wrapper functions for the DebugHandler service in Harmoni.
 *
 * @see {@link DebugHandlerInterface}
 * @static
 * @version $Id: debug.class.php,v 1.3 2003/11/26 02:35:00 gabeschine Exp $
 * @package harmoni.debug
 * @copyright 2003 
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
	function printAll() {
		NewWindowDebugHandlerPrinter::printDebugHandler(Services::requireService("Debug"));
	}
	
}

?>