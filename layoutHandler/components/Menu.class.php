<?php
require_once(HARMONI."layoutHandler/components/Menu.interface.php");

/**
 * A Menu is a container for multiple {@link MenuItem}s of various types. Menus
 * are useful in page layouts for navigation. 
 *
 * @package harmoni.layout.components
 * @version $Id: Menu.class.php,v 1.4 2003/07/25 00:53:43 gabeschine Exp $
 * @copyright 2003 
 **/

class Menu extends MenuInterface {
	/**
	 * @access private
	 * @var array $_items An array of {@link MenuItem}s.
	 **/
	var $_items;
	
	/**
	 * The constructor.
	 * @access public
	 * @return void
	 **/
	function Menu() {
		$this->_items = array();
	}
	
	
	/**
	 * Adds a menu item to the menu.
	 * @param object $menuItemObject The {@link MenuItem} to add to the menu.
	 * @access public
	 * @return integer The index of the new menu item.
	 **/
	function addItem(&$menuItemObject) {
		ArgumentValidator::validate($menuItemObject, new ExtendsValidatorRule("MenuItemInterface"));
		
		$this->_items[] =& $menuItemObject;
		return count($this->_items) - 1;
	}
	
	/**
	 * Returns the {@link MenuItem} object at index $index.
	 * @param integer $index The index number of the object desired.
	 * @access public
	 * @return object The MenuItem object.
	 **/
	function &getItem($index) {
		if (isset($this->_items[$index]))
			return $this->_items[$index];
		return null;
	}
	
	/**
	 * Returns the number of MenuItems in the Menu.
	 * @access public
	 * @return integer The number of {@link MenuItem}s in the Menu.
	 **/
	function getCount() {
		return count($this->_items);
	}
	
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @param optional integer $level The current level in the output hierarchy. Default=0.
	 * @param optional integer $orientation The orientation in which we should print. Should be one of either HORIZONTAL or VERTICAL.
	 * @use HORIZONTAL
	 * @use VERTICAL
	 * @access public
	 * @return void
	 **/
	function output(&$theme, $level=0, $orientation=HORIZONTAL) {
		$theme->printMenu($this,$level,$orientation);
	}
}

?>