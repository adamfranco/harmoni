<?php

require_once(HARMONI.'services/Service.interface.php');

/**
 * the DebugHandler interface defines the required methods for a DebugHandler class
 *
 * @version $Id: DebugHandler.interface.php,v 1.6 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.interfaces.utilities.debugging
 **/

class DebugHandlerInterface extends ServiceInterface {
	/**
	 * Adds debug text to the handler.
	 *
	 * @param mixed $debug Either a string with debug text or a DebugItem object.
	 * @param optional int $level The detail level of the debug text.
	 * @param optional string $category The text category.
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
	 * @param optional string $category The category.
	 * @access public
	 * @return array The array of DebugItems.
	 **/
	function getDebugItems( $category="" ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Sets the internal output level to $level. This can be overridden at output time.
	 * @param integer $level
	 * @access public
	 * @return void
	 **/
	function setOutputLevel($level) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the internal output level.
	 * @access public
	 * @return integer
	 **/
	function getOutputLevel() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>