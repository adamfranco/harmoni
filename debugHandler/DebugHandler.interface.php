<?php

/**
 * the DebugHandler interface defines the required methods for a DebugHandler class
 *
 * @version $Id: DebugHandler.interface.php,v 1.2 2003/06/24 20:21:47 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.utilities.debugHandler
 **/

class DebugHandlerInterface {
	/**
	 * Adds debug text to the handler.
	 *
	 * @param mixed $debug Either a string with debug text or a DebugItem object.
	 * @param int [$level] (optional) The detail level of the debug text.
	 * @param string [$category] (optional) The text category.
	 * @access public
	 * @return void
	 **/
	function add( $debug, $level=5, $category="general") { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Returns the number of DebugItems registered.
	 * 
	 * @access public
	 * @return int The DebugItem count.
	 **/
	function getDebugItemCount() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Returns an array of DebugItems, optionally limited to category $category.
	 * 
	 * @param string [$category] (optional) The category.
	 * @access public
	 * @return array The array of DebugItems.
	 **/
	function getDebugItems( $category="" ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
}

?>