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
 * @version $Id: HeaderMenuItem.class.php,v 1.2 2004/03/08 22:28:38 adamfranco Exp $
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
	
	/**
	 * Returns this component's level in the visual hierarchy.
	 * @access public
	 * @return integer The level.
	 **/
	function getLevel() {
		return $this->_level;
	}
	
	/**
	 * Sets this component's level in the visual hierarchy. Spiders down to children (if it has any) and sets their level
	 * to $level+1 if $spiderDown is TRUE.
	 * @param integer $level The level.
	 * @param optional boolean $spiderDown Specifies if the function should spider down to children.
	 * @access public
	 * @return void 
	 **/
	function setLevel($level, $spiderDown=true) {
		$this->_level = $level;
	}
	
	/**
	 * Gets the ThemeWidget type for this element.
	 * return string The type of the theme widget.
	 */
	function getThemeWidgetType() {
		return $this->_themeWidgetType;
	}
	
	/**
	 * Sets the ThemeWidget type for this element.
	 * @param string $type The type of the theme widget.
	 * @return void
	 */
	function setThemeWidgetType( $type ) {
		ArgumentValidator::validate($type, new StringValidatorRule);
		
		$this->_themeWidgetType = $type;
	}
	
	/**
	 * Gets the ThemeWidget index for this element.
	 * return integer The index of the theme widget.
	 */
	function getThemeWidgetIndex() {
		return $this->_themeWidgetIndex;
	}
	
	/**
	 * Sets the ThemeWidget index for this element.
	 * @param string $index The index of the theme widget.
	 * @return void
	 */
	function setThemeWidgetIndex( $index ) {
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		$this->_themeWidgetIndex = $index;
	}
	
	/**
	 * gets the Vertical Alignment for this element in its parent.
	 * @return string The alignment of the element; TOP, CENTER, BOTTOM.
	 */
	function getVerticalAlignment () {
		return $this->_verticalAlignment;
	}
	
	/**
	 * Sets the Vertical Alignment for this element in its parent.
	 * @param string $valign The alignment of the element; TOP, CENTER, BOTTOM.
	 * @return void
	 */
	function setVerticalAlignment ( $valign ) {
		ArgumentValidator::validate($valign, new StringValidatorRule);
		if ($valign != TOP && $valign != CENTER && $valign != BOTTOM)
 			throwError(new Error("Could not set vertical alignment, parameter out of range.","Layout",true));
 		
		$this->_verticalAlignment = $valign;
	}
	
	/**
	 * Gets the Horizontal Alignment for this element in its parent.
	 * @return string The alignment of the element; LEFT, CENTER, RIGHT.
	 */
	function getHorizontalAlignment () {
		return $this->_horizontalAlignment;
	}
	
	/**
	 * Sets the Horizontal Alignment for this element in its parent.
	 * @param string $hvalign The alignment of the element; LEFT, CENTER, RIGHT.
	 * @return void
	 */
	function setHorizontalAlignment ( $halign ) {
		ArgumentValidator::validate($halign, new StringValidatorRule);
		if ($halign != LEFT && $halign != CENTER && $halign != RIGHT)
 			throwError(new Error("Could not set horizontal alignment, parameter out of range.","Layout",true));
		
		$this->_horizontalAlignment = $halign;
	}
	
}

?>
