<?php
require_once(HARMONI."layoutHandler/VisualComponent.interface.php");

/**
 * @const string MENU The constant defined for a menu, to be used with {@link Layout::addComponent()}.
 * @package harmoni.layout.components
 **/
define("MENU","MenuInterface");
 
/**
 * The Menu interface defines the methods required by any {@link Menu} class.
 *
 * @package harmoni.interfaces.layout.components
 * @version $Id: Menu.interface.php,v 1.2 2004/03/05 21:40:05 adamfranco Exp $
 * @copyright 2003 
 **/

class MenuInterface extends VisualComponent {
	/**
	 * Adds a menu item to the menu.
	 * @param object $menuItemObject The {@link MenuItem} to add to the menu.
	 * @access public
	 * @return integer The index of the new menu item.
	 **/
	function addItem($menuItemObject) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the {@link MenuItem} object at index $index.
	 * @param integer $index The index number of the object desired.
	 * @access public
	 * @return object The MenuItem object.
	 **/
	function &getItem($index) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the number of MenuItems in the Menu.
	 * @access public
	 * @return integer The number of {@link MenuItem}s in the Menu.
	 **/
	function getCount() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
}

?>