<?php

require_once(HARMONI."layoutHandler/components/MenuItem.abstract.php");

/**
 * @const integer LINK Defines that this menu item is a link to another page.
 * @package harmoni.layout.components
 **/
define("LINK",2);

/**
 * The LinkMenuItem is used to add a link to a {@link Menu}. This is useful for navigation
 * among different pages.
 *
 * @package harmoni.layout.components
 * @version $Id: LinkMenuItem.class.php,v 1.1 2003/07/16 23:32:39 gabeschine Exp $
 * @copyright 2003 
 **/
class LinkMenuItem extends MenuItem {
	/**
	 * @access private
	 * @var string $_url The URL to use for the link.
	 **/
	var $_url;
	
	/**
	 * @access private
	 * @var string $_extraAttributes A string of extra attributes to add to the link.
	 **/
	var $_extraAttributes;
	
	/**
	 * @access private
	 * @var string $_target The link target. (ig, _blank, media_window, ...)
	 **/
	var $_target;
	
	/**
	 * @access private
	 * @var boolean $_selected Sets whether this menu item is "selected" or not.
	 **/
	var $_selected;
	
	/**
	 * The constructor.
	 * @param string $label The label for the heading.
	 * @param string $linkURL The URL this link will send you to.
	 * @param optional boolean $isSelected Sets if this link item is selected.
	 * @param optional string $target The window/frame target this link should point to.
	 * @param optional string $attr,... A list of extra attributes to add. See {@link LinkMenuItem::addExtraAttributes}.
	 * @access public
	 * @return void
	 **/
	function LinkMenuItem($label, $linkURL, $isSelected=false, $target=null) {
		$this->_type = LINK;
		$this->_label = $label;
		$this->_url = $linkURL;
		$this->_selected = $isSelected;
		$this->_target = $target;
		$this->_extraAttributes = "";
		
		if (func_num_args() > 4) {
			// looks like they're passing us some extraAttributes
			for($i = 4; $i < func_num_args(); $i++){
				$this->addExtraAttributes(func_get_arg($i));
			} // for
		}
	}
	
	/**
	 * Adds extra HTML attributes to the link.
	 * @param string $attr,... A list of attributes to add, of the format "attr='value'",...
	 * @access public
	 * @return void
	 **/
	function addExtraAttributes($attr) {
		if (func_num_args()) {
			for($i = 0; $i < func_num_args(); $i++) {
				$str = func_get_arg($i);
				if (is_string($str)) $this->_extraAttributes .= " ".$str;
			} // for
		}
	}
	
	/**
	 * Sets the target for this link to $target.
	 * @param string $target The target. eg, _blank, window1, frame2, ...
	 * @access public
	 * @return void
	 **/
	function setTarget($target) {
		$this->_target = $target;
	}
	
	/**
	 * Sets if this menu item is selected or no.
	 * @param boolean $selected TRUE/FALSE if the menu item is selected or not.
	 * @access public
	 * @return void
	 **/
	function setSelected($selected) {
		$this->_selected = $selected;
	}
	
	/**
	 * Returns if this menu item is selected or not.
	 * @access public
	 * @return boolean TRUE if selected, FALSE if not.
	 **/
	function isSelected() {
		return $this->_selected;
	}
	
	/**
	 * Returns the target for this link.
	 * @access public
	 * @return string|null The target for this link, or NULL if none exists.
	 **/
	function getTarget() {
		return $this->_target;
	}
	
	/**
	 * Returns a string of the extra attributes for this link.
	 * @access public
	 * @return string The extra attributes separated by a " " (space).
	 **/
	function getExtraAttributes() {
		return $this->_extraAttributes;
	}
	
	/**
	 * Returns this link's URL.
	 * @access public
	 * @return string The URL.
	 **/
	function getURL() {
		return $this->_url;
	}
	
	/**
	 * Returns the "formatted" menu item text. What is returned really depends
	 * on the menu item type.
	 * @access public
	 * @return string The formatted text.
	 **/
	function getFormattedText() {
		$text = '';
		$text .= '<a href="';
		$text .= $this->getURL();
		$text .= '"';
		if ($target = $this->getTarget()) $text .= ' target="'.$target.'"';
		$text .= $this->getExtraAttributes();
		$text .= '>';
		$text .= $this->getLabel();
		$text .= '</a>';
		return $text;
	}
}

?>
