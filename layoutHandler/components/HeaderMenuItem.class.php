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
 * @version $Id: HeaderMenuItem.class.php,v 1.1 2003/07/16 23:32:39 gabeschine Exp $
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
		$this->_type = HEADING;
		$this->_label = $label;
	}
}

?>
