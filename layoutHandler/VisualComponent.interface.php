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
 * @package harmoni.layout
 * @version $Id: VisualComponent.interface.php,v 1.2 2003/07/16 23:32:39 gabeschine Exp $
 * @copyright 2003 
 **/

class VisualComponent {
	/**
	 * Prints the component out using the given theme.
	 * @param object $theme The theme object to use.
	 * @param optional integer $level The current level in the output hierarchy. Default=0.
	 * @param optional integer $orientation The orientation in which we should print. Should be one of either HORIZONTAL or VERTICAL.
	 * @use HORIZONTAL
	 * @use VERTICAL
	 * @access public
	 * @return void
	 **/
	function output($theme, $level=0, $orientation=HORIZONTAL) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>