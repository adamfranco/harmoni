<?php

require_once(HARMONI."GUIManager/Component.interface.php");

/**
 * A <code>Menu</code> is a <code>Container</code> that stores a number of 
 * MenuItem objects. The familiar add/get/remove <code>Container</code> methods 
 * can be used to manage the <code>MenuItems</code>.
 * @version $Id: Menu.interface.php,v 1.1 2004/07/23 02:44:17 dobomode Exp $
 * @package harmoni.gui.components
 * @author Middlebury College, ETS
 * @copyright 2004 Middlebury College, ETS
 * @access public
 **/

class MenuInterface extends ContainerInterface {

	/**
	 * Returns the menu item that is currently selected.
	 * @access public
	 * @return ref object The menu item that is currently selected.
	 **/
	function & getSelected() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	

	/**
	 * Determines whether the <code>MenuItem</code> with the given id is selected. Ids
	 * reflect the order in which menu items are added. That is, the very first 
	 * menu item has an id of 1, the second menu item has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the menu item.
	 * @return boolean <code>TRUE</code>, if the menu item with the given id is selected.
	 **/
	function isSelected($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Selects the <code>MenuItem</code> with the given id, and deselects all the
	 * others. Ids reflect the order in which menu items are added. That is, the very first 
	 * menu item has an id of 1, the second menu item has an id of 2, and so forth.
	 * @access public
	 * @param integer id The id of the menu item to select.
	 **/
	function select($id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

}

?>