<?php

/**
 * The debug class is a static abstract class that holds wrapper functions for the DebugHandler service in Harmoni.
 *
 * @see DebugHandlerInterface
 * @static
 * @abstract
 * @version $Id: debug.class.php,v 1.1 2003/06/26 18:12:34 gabeschine Exp $
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
		Services::requireService("DebugHandler");
		
		$debugHandler =& Services::getService("DebugHandler");
		$debugHandler->add($text,$level,$category);
	}
	
}

?>