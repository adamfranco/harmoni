<?php

/**
 * the DebugItem interface defines the required methods for a DebugItem class
 *
 * @version $Id: DebugItem.interface.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.interfaces.utilities.debugging
 **/

class DebugItemInterface {
	/**
	 * Returns the level (0-9) of the debug text.
	 * 
	 * @access public
	 * @return int The debug level.
	 **/
	function getLevel( ) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Returns the category of the debug text.
	 * 
	 * @access public
	 * @return string The category.
	 **/
	function getCategory() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Returns the DebugItem's text.
	 * 
	 * @access public
	 * @return string The text.
	 **/
	function getText() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Sets this Item's debug backtrace array.
	 * @param array $backtrace
	 * @access public
	 * @return void
	 **/
	function setBacktrace($backtrace) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the backtrace array.
	 * @access public
	 * @return array
	 **/
	function getBacktrace() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>