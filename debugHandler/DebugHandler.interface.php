<?php

require_once(HARMONI.'services/Service.interface.php');

/**
 * @const integer DEBUG_API1 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API1",6);

/**
 * @const integer DEBUG_API2 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API2",7);

/**
 * @const integer DEBUG_API3 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API3",8);

/**
 * @const integer DEBUG_API4 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API4",9);

/**
 * @const integer DEBUG_API5 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_API5",10);

/**
 * @const integer DEBUG_USER1 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER1",1);

/**
 * @const integer DEBUG_USER2 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER2",2);

/**
 * @const integer DEBUG_USER3 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER3",3);

/**
 * @const integer DEBUG_USER4 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER4",4);

/**
 * @const integer DEBUG_USER5 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_USER5",5);

/**
 * @const integer DEBUG_SYS1 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS1",11);

/**
 * @const integer DEBUG_SYS2 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS2",12);

/**
 * @const integer DEBUG_SYS3 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS3",13);

/**
 * @const integer DEBUG_SYS4 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS4",14);

/**
 * @const integer DEBUG_SYS5 Debug level constant
 * @package harmoni.utilities.debugging
 **/
define("DEBUG_SYS5",15);

/**
 * the DebugHandler interface defines the required methods for a DebugHandler class
 *
 * @version $Id: DebugHandler.interface.php,v 1.7 2003/08/08 22:07:31 gabeschine Exp $
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