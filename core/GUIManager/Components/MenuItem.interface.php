<?php

require_once(HARMONI."GUIManager/Component.interface.php");

/**
 * <code>MenuItem</code> is an extension of <code>Component</code>; <code>MenuItems</code>
 * have display names and the ability to be added to <code>Menu</code> objects.
 *
 * @package harmoni.gui.components
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MenuItem.interface.php,v 1.2 2005/01/19 21:09:29 adamfranco Exp $
 */
class MenuItemInterface extends ComponentInterface {

	/**
	 * Returns the display name of this menu item.
	 * @access public
	 * @return string The display name of this menu item.
	 **/
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	/**
	 * Sets the display name of this menu item.
	 * @access public
	 * @param string displayName The new display name.
	 **/
	function setDisplayName($displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>