<?php

/**
 * the DebugItem interface defines the required methods for a DebugItem class
 *
 * @version $Id: DebugItem.interface.php,v 1.3 2003/08/06 22:32:40 gabeschine Exp $
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
}

?>