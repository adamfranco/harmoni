<?php

/**
 * MenuItem interface defines the methods required by any MenuItem
 *
 * @package harmoni.layout.components
 * @version $Id: MenuItem.interface.php,v 1.2 2003/07/16 23:32:39 gabeschine Exp $
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
	
	/**
	 * Sets this menu item's "extra text" to $text. Extra text is useful for displaying
	 * administrative links for this menu item or other useful extra information. 
	 * @param string $text The text.
	 * @access public
	 * @return void
	 **/
	function setExtraText($text) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the "extra text".
	 * @see {@link MenuItemInterface::setExtraText setExtraText()}
	 * @access public
	 * @return string The text.
	 **/
	function getExtraText() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	
	/**
	 * Returns the "formatted" menu item text. What is returned really depends
	 * on the menu item type.
	 * @access public
	 * @return string The formatted text.
	 **/
	function getFormattedText() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>