<?php

/** 
 * @const integer HORIZONTAL Defines a horizontal visual component (eg, a menu).
 * @package harmoni.layout
 **/
define("HORIZONTAL",1);

/** 
 * @const integer VERTICAL Defines a vertical visual component (eg, a menu).
 * @package harmoni.layout
 **/
define("VERTICAL",2);

/**
 * VisualComponent defines the interface for any component within a {@link Layout}.
 *
 * @package harmoni.interfaces.layout
 * @version $Id: VisualComponent.interface.php,v 1.2 2004/03/05 21:39:51 adamfranco Exp $
 * @copyright 2003 
 **/

class VisualComponent {
	/**
	 * Prints the component out using the given theme.
	 * @param ref object $theme The theme object to use.
	 * @param optional integer $orientation The orientation in which we should print. Should be one of either HORIZONTAL or VERTICAL.
	 * @use HORIZONTAL
	 * @use VERTICAL
	 * @access public
	 * @return void
	 **/
	function output(&$theme, $orientation=HORIZONTAL) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns this component's level in the visual hierarchy.
	 * @access public
	 * @return integer The level.
	 **/
	function getLevel() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets this component's level in the visual hierarchy. Spiders down to children (if it has any) and sets their level
	 * to $level+1 if $spiderDown is TRUE.
	 * @param integer $level The level.
	 * @param optional boolean $spiderDown Specifies if the function should spider down to children.
	 * @param optional integer $increment If $spiderDown=true, specifies by how much we should increase childrens' levels.
	 * @access public
	 * @return void 
	 **/
	function setLevel($level, $spiderDown=true, $increment=1) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Gets the ThemeWidget type for this element.
	 * return string The type of the theme widget.
	 */
	function getThemeWidgetType() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the ThemeWidget type for this element.
	 * @param string $type The type of the theme widget.
	 * @return void
	 */
	function setThemeWidgetType( $type ) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Gets the ThemeWidget index for this element.
	 * return integer The index of the theme widget.
	 */
	function getThemeWidgetIndex() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the ThemeWidget index for this element.
	 * @param string $index The index of the theme widget.
	 * @return void
	 */
	function setThemeWidgetIndex( $index ) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
		/**
	 * gets the Vertical Alignment for this element in its parent.
	 * @return string The alignment of the element; TOP, CENTER, BOTTOM.
	 */
	function getVerticalAlignment () {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the Vertical Alignment for this element in its parent.
	 * @param string $valign The alignment of the element; TOP, CENTER, BOTTOM.
	 * @return void
	 */
	function setVerticalAlignment ( $valign ) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Gets the Horizontal Alignment for this element in its parent.
	 * @return string The alignment of the element; LEFT, CENTER, RIGHT.
	 */
	function getHorizontalAlignment () {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the Horizontal Alignment for this element in its parent.
	 * @param string $hvalign The alignment of the element; LEFT, CENTER, RIGHT.
	 * @return void
	 */
	function setHorizontalAlignment ( $halign ) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
}

?>