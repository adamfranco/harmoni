<?php

require_once(HARMONI."GUIManager/Theme.interface.php");
require_once(HARMONI."GUIManager/Menu.interface.php");

/**
 * A <code>MenuTheme</code> is an extension of the generic <code>Theme</code> interface
 * that adds support for multi-level navigation menus. A <code>MenuTheme</code>, 
 * like a normal </code>Theme</code> has a single <code>Component</code>; however,
 * it allows the user to surround that component with multi-level navigation menus.
 *
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MenuTheme.interface.php,v 1.2 2007/09/04 20:25:21 adamfranco Exp $
 **/
class MenuThemeInterface {
	
	/**
	 * Adds a new menu to this theme.
	 * @access public
	 * @param ref object menu A <code>Menu</code> object to be added to this theme.
	 * @param integer level A postivive integer specifying the <code>level</code> of the
	 * menu that is being added. Only one menu can exist at any given level. 
	 * Levels cannot be skipped. Levels allow the user to create a hierarchy of menus.
	 **/
	function addMenu($menu, $level) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the menu (if exists) at the given level.
	 * @access public
	 * @param integer level An integer specifying the <code>level</code> of the
	 * menu that is to be returned. Levels start at 1. Only one menu can exist at any given level.
	 * Levels cannot be skipped. Levels allow the user to create a hierarchy of menus.
	 * @return ref object The <code>Menu</code> object at the specified level, or <code>NULL</code>
	 * if no menu was found.
	 **/
	function getMenu($menu, $level) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Returns the number of menus in this Theme.
	 * @access public
	 * @return integer The number of menus.
	 **/
	function getNumberOfMenus() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
}

?>