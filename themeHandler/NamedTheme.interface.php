<?php

require_once(HARMONI."themeHandler/Theme.interface.php");

/**
 * The NamedTheme interface defines the required method of any NamedTheme class.
 * 
 * A NamedTheme is a simple {@link ThemeInterface Theme} with a name, description,
 * and a preview image.
 *
 * @version $Id: NamedTheme.interface.php,v 1.2 2003/07/23 21:43:58 gabeschine Exp $
 * @copyright 2003 
 * @package harmoni.themes
 **/
class NamedThemeInterface extends ThemeInterface {
	/**
	 * Returns this theme's name.
	 * @access public
	 * @return string The name.
	 **/
	function getName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns this theme's description.
	 * @access public
	 * @return string The description.
	 **/
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an array containing the type & data of a preview image.
	 * @access public
	 * @return array|null A two-element array. [0]=mime-type of the image, [1]=the actual
	 * image data. If there is no preview image, returns NULL.
	 **/
	function getPreviewImage() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>