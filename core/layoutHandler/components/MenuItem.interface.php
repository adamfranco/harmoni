<?php

/**
 * MenuItem interface defines the methods required by any MenuItem
 *
 * @package harmoni.layout.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MenuItem.interface.php,v 1.7 2005/02/07 21:15:17 adamfranco Exp $
 **/
class MenuItemInterface {
	/**
	 * Returns the type of this menu item. (eg, header, spacer, link, ...)
	 * @access public
	 * @return mixed The MenuItem type.
	 **/
	function getType() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the label associated with this menu item.
	 * @access public
	 * @return string The label.
	 **/
	function getLabel() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the label for this menu item to $label.
	 * @param string $label The label. 
	 * @access public
	 * @return void
	 **/
	function setLabel($label) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets this menu item's "extra text" to $text. Extra text is useful for displaying
	 * administrative links for this menu item or other useful extra information. 
	 * @param string $text The text.
	 * @access public
	 * @return void
	 **/
	function setExtraText($text) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the "extra text".
	 * @see MenuItemInterface::setExtraText setExtraText()
	 * @access public
	 * @return string The text.
	 **/
	function getExtraText() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	
	/**
	 * Returns the "formatted" menu item text. What is returned really depends
	 * on the menu item type.
	 * @access public
	 * @return string The formatted text.
	 **/
	function getFormattedText() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
}

?>