<?php

/**
 * MenuItem interface defines the methods required by any MenuItem
 *
 * @package harmoni.layout.components
 * @version $Id: MenuItem.interface.php,v 1.1 2003/07/15 18:56:19 gabeschine Exp $
 * @copyright 2003 
 **/
class MenuItemInterface {
	/**
	 * Returns the type of this menu item. (eg, header, spacer, link, ...)
	 * @access public
	 * @return mixed The MenuItem type.
	 **/
	function getType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the label associated with this menu item.
	 * @access public
	 * @return string The label.
	 **/
	function getLabel() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Sets the label for this menu item to $label.
	 * @param string $label The label. 
	 * @access public
	 * @return void
	 **/
	function setLabel($label) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>