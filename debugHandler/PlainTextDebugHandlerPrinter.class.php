<?php

require_once(HARMONI."debugHandler/DebugHandlerPrinter.interface.php");

/**
 * the PlainTextDebugHandlerPrinter prints debug items right to stdout
 *
 * @version $Id: PlainTextDebugHandlerPrinter.class.php,v 1.6 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.debugging
 **/

class PlainTextDebugHandlerPrinter extends DebugHandlerPrinterInterface {
	/**
	 * Outputs the DebugItems in $debugHandler.
	 *
	 * @param object DebugHandler $debugHandler The DebugHandler object to output.
	 * @param int $level The level to output. All output < $level will be displayed. Default = user Handler's internal output level.
	 * @param optional string $category Limit output to only items under $category.
	 * @access public
	 * @return void
	 **/
	function printDebugHandler( $debugHandler, $level = null, $category = "" ) {
		if ($level == null) $level = $debugHandler->getOutputLevel();
		$items = & $debugHandler->getDebugItems($category);
		if ($level == 0) return true;
		
		foreach (array_keys($items) as $key) {
			if ($items[$key]->getLevel() <= $level)
				print "[".$items[$key]->getCategory().":".$items[$key]->getLevel()."] ".$items[$key]->getText()."\n";
		}
	}
}

?>