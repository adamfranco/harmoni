<?php

/**
 * the DebugHandlerPrinter interface defines the required methods for a DebugHandlerPrinter class
 *
 * @version $Id: DebugHandlerPrinter.interface.php,v 1.2 2003/06/28 01:01:51 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.debugHandler
 **/

class DebugHandlerPrinterInterface {
	/**
	 * Outputs the DebugItems in $debugHandler.
	 *
	 * @param object DebugHandler $debugHandler The DebugHandler object to output.
	 * @param int $level The level to output. All output < $level will be displayed. Default = print all.
	 * @param optional string $category Limit output to only items under $category.
	 * @access public
	 * @return void
	 **/
	function printDebugHandler( $debugHandler, $level = 9, $category = "" ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}

?>