<?php

/**
 * The debug class is a static abstract class that holds wrapper functions for the DebugHandler service in Harmoni.
 *
 * @see {@link DebugHandlerInterface}
 * @static
 * @version $Id: debug.class.php,v 1.4 2003/08/06 22:32:40 gabeschine Exp $
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
		Services::requireService("DebugHandler");
		
		$debugHandler =& Services::getService("DebugHandler");
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
		Services::requireService("DebugHandler");
		
		$debugHandler =& Services::getService("DebugHandler");
		if ($level)
			$debugHandler->setOutputLevel($level);
		$debugHandler->getOutputLevel();
	}
	
}

?>