<?php

require_once(HARMONI."debugHandler/DebugHandlerPrinter.interface.php");

/**
 * the PlainTextDebugHandlerPrinter prints debug items right to stdout
 *
 * @package harmoni.utilities.debugging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PlainTextDebugHandlerPrinter.class.php,v 1.5 2007/09/04 20:25:33 adamfranco Exp $
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
		print "Printing all debug output for $level and category '$category'\n\n";
		$items =  $debugHandler->getDebugItems($category);
		if ($level == 0) return true;
		
		print "\n<pre>\n";
		foreach (array_keys($items) as $key) {
			if ($items[$key]->getLevel() <= $level)
				print "[".$items[$key]->getCategory().":".$items[$key]->getLevel()."] ".$items[$key]->getText()."\n";
		}
		print "\n</pre>\n";
	}
}

?>