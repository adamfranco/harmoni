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
 * @package harmoni.layout.components
 * @version $Id: MenuItem.abstract.php,v 1.3 2003/07/23 21:43:58 gabeschine Exp $
 * @copyright 2003 
 * @abstract
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
	 * @access private
	 * @var string $_extra The extra text to be displayed along with the label.
	 **/
	var $_extra;
	
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
	
	/**
	 * Sets this menu item's "extra text" to $text. Extra text is useful for displaying
	 * administrative links for this menu item or other useful extra information. 
	 * @param string $text The text.
	 * @access public
	 * @return void
	 **/
	function setExtraText($text) {
		$this->_extra = $text;
	}

	/**
	 * Returns the "extra text".
	 * @see {@link MenuItem::setExtraText setExtraText()}
	 * @access public
	 * @return string The text.
	 **/
	function getExtraText() {
		return $this->_extra;
	}
	
	/**
	 * Returns the "formatted" menu item text. What is returned really depends
	 * on the menu item type.
	 * @access public
	 * @return string The formatted text.
	 **/
	function getFormattedText() {
		return $this->getLabel();
	}
}

?>