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
 * @version $Id: VisualComponent.interface.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns this component's level in the visual hierarchy.
	 * @access public
	 * @return integer The level.
	 **/
	function getLevel() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
}

?>