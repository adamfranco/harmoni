<?php

require_once(HARMONI."layoutHandler/components/MenuItem.abstract.php");

/**
 * @const integer HEADING Defines that this menu item is a heading in the menu. 
 * @package harmoni.layout.components
 **/
define("HEADING",1);

/**
 * The HeaderMenuItem puts a text heading in a navigation menu. It's much more attractive
 * on vertical menus, but works on both.
 *
 * @package harmoni.layout.components
 * @version $Id: HeaderMenuItem.class.php,v 1.3 2004/03/10 00:10:29 adamfranco Exp $
 * @copyright 2003 
 **/
class HeaderMenuItem extends MenuItem {
	/**
	 * The constructor.
	 * @param string $label The label for the heading.
	 * @access public
	 * @return void
	 **/
	function HeaderMenuItem($label) {
		$this->setThemeWidgetType(MENU_HEADING_WIDGET);
		
		// This will be set by the Menu later
		$this->setThemeWidgetIndex(1);
		
		$this->_label = $label;
	}

	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @access public
	 * @return void
	 **/
	function output(&$themeWidget) {
		print "\n\t\t".$this->_label;
		//$themeWidget->output($this);
	}	
}

?>
