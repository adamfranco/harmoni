<?php

/**
 * ThemeWidget interface defines what methods are required of any theme widget.
 * 
 * A ThemeWidget is responsible for the look & feel of a given class and index 
 * of objects on a page. MenuThemeWidgets are indexed analogus to the HTML <h1>,
 * <h2>, <h3>, etc headings where the lower the index, the more "prominent" the
 * look of the widget. Indices start at 1 and go as high 
 * (in the sequence; 1, 2, 3, etc) as the theme developer desires.
 *
 * @package harmoni.themes
 * @version $Id: ThemeWidget.interface.php,v 1.1 2004/03/03 19:09:42 adamfranco Exp $
 * @copyright 2004 
 **/

class ThemeWidgetInterface {

	/**
	 * Returns the index of this ThemeWidget.
	 * @access public
	 * @return int The index of this Widget. Widgets are created with an imutable
	 *		index. Indices start at 1 and go as high (in sequence; 1, 2, 3, etc) 
	 *		as the theme developer desires.
	 **/
	function getIndex() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}

	/**
	 * Returns the DisplayName of this ThemeWidget.
	 * @access public
	 * @return string The display name.
	 **/
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the Description of this ThemeWidget.
	 * @access public
	 * @return string The Description name.
	 **/
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}

	/**
	 * Returns a HarmoniIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return object HarmoniIterator An iterator of ThemeSetting objects
	 **/
	function & getSettings() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns if this ThemeWidget supports changing settings or if its static.
	 * @access public
	 * @return boolean TRUE if this ThemeWidget supports settings, FALSE otherwise.
	 **/
	function hasSettings() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's <head><style> section.
	 **/
	function getStyles() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a <div ...> ... </div>
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function print(& $layoutOrContent) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>