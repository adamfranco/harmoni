<?php
require_once(HARMONI."layoutHandler/components/MenuItem.interface.php");

/**
 * @const integer MENUITEM_UNKNOWN Defines a {@link MenuItem} as being of unknown type. 
 * @package harmoni.layout.components
 **/
define("MENUITEM_UNKNOWN",-1);

/**
 * The MenuItem lays out groundwork for sub-classes. It should not be instantiated as it has no
 * type.
 * 
 * @abstract
 * @package harmoni.layout.components
 * @version $Id: MenuItem.abstract.php,v 1.1 2003/07/15 18:56:19 gabeschine Exp $
 * @copyright 2003 
 **/
class MenuItem extends MenuItemInterface {
	/**
	 * @access private
	 * @var mixed $_type This MenuItem's type.
	 **/
	var $_type = MENUITEM_UNKNOWN;

	/**
	 * @access private
	 * @var string $_label The MenuItem's label.
	 **/
	var $_label;
	
	/**
	 * Returns the type of this menu item. (eg, header, spacer, link, ...)
	 * @access public
	 * @return mixed The MenuItem type.
	 **/
	function getType() {
		return $this->_type;
	}
	
	/**
	 * Returns the label associated with this menu item.
	 * @access public
	 * @return string The label.
	 **/
	function getLabel() {
		return $this->_label;
	}
	
	/**
	 * Sets the label for this menu item to $label.
	 * @param string $label The label. 
	 * @access public
	 * @return void
	 **/
	function setLabel($label) {
		$this->_label = $label;
	}
}

?>