<?php

/**
 * the DebugHandlerPrinter interface defines the required methods for a DebugHandlerPrinter class
 *
 * @version $Id: DebugHandlerPrinter.interface.php,v 1.2 2004/04/20 19:49:46 adamfranco Exp $
 * @copyright 2003 
 * @package harmoni.utilities.debugging
 **/

class DebugHandlerPrinterInterface {
	/**
	 * Outputs the DebugItems in $debugHandler.
	 *
	 * @param object DebugHandler $debugHandler The DebugHandler object to output.
	 * @param int $level The level to output. All output < $level will be displayed. Default = user Handler's internal output level.
	 * @param optional string $category Limit output to only items under $category.
	 * @access public
	 * @return void
	 **/
	function printDebugHandler( $debugHandler, $level = null, $category = "" ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}

?>