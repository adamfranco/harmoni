<?php

require_once(HARMONI."debugHandler/DebugHandlerPrinter.interface.php");

/**
 * the PlainTextDebugHandlerPrinter prints debug items right to stdout
 *
 * @version $Id: PlainTextDebugHandlerPrinter.class.php,v 1.4 2003/06/28 01:01:51 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.debugHandler
 **/

class PlainTextDebugHandlerPrinter extends DebugHandlerPrinterInterface {
	/**
	 * Outputs the DebugItems in $debugHandler.
	 *
	 * @param object DebugHandler $debugHandler The DebugHandler object to output.
	 * @param optional int $level The level to output. All output <= $level will be displayed. Default = 9.
	 * @param optional string $category Limit output to only items under $category.
	 * @access public
	 * @return void
	 **/
	function printDebugHandler( $debugHandler, $level = 9, $category = "" ) {
		$items = & $debugHandler->getDebugItems($category);
		if ($level == 0) return true;
		
		foreach (array_keys($items) as $key) {
			if ($items[$key]->getLevel() <= $level)
				print "[".$items[$key]->getCategory().":".$items[$key]->getLevel()."] ".$items[$key]->getText()."\n";
		}
	}
}

?>