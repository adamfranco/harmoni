<?php

/**
 * ThemeWidget interface defines what methods are required of any theme widget.
 * 
 * A ThemeWidget is responsible for the look & feel of a given class and index 
 * of objects on a page. MenuThemeWidgets are indexed analogus to the HTML &lt;h1&gt;,
 * &lt;h2&gt;, &lt;h3&gt;, etc headings where the lower the index, the more "prominent" the
 * look of the widget. Indices start at 1 and go as high 
 * (in the sequence; 1, 2, 3, etc) as the theme developer desires.
 *
 * @package harmoni.themes
 * @version $Id: ThemeWidget.interface.php,v 1.6 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class ThemeWidgetInterface {

	/**
	 * Returns the index of this ThemeWidget.
	 * @access public
	 * @return int The index of this Widget.
	 *		Indices start at 1 and go as high (in sequence; 1, 2, 3, etc) 
	 *		as the theme developer desires.
	 **/
	function getIndex() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Sets the index of this ThemeWidget.
	 * @access public
	 * @param int The index of this Widget.
	 *		Indices start at 1 and go as high (in sequence; 1, 2, 3, etc) 
	 *		as the theme developer desires.
	 * @return void
	 **/
	function setIndex( $index ) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}

	/**
	 * Returns the DisplayName of this ThemeWidget.
	 * @access public
	 * @return string The display name.
	 **/
	function getDisplayName() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the Description of this ThemeWidget.
	 * @access public
	 * @return string The Description name.
	 **/
	function getDescription() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Adds a Setting to those known to this Wiget.
	 * @access public
	 * @param object SettingInterface The Setting to add.
	 * @return void
	 **/
	function addSetting (& $setting) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns the Setting known to this manager with the specified Key.
	 * @access public
	 * @param string $key The id of the desired Setting.
	 * @return object SettingInterface The desired Setting object.
	 **/
	function & getSetting ( $key ) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}

	/**
	 * Returns a HarmoniIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return object HarmoniIterator An iterator of ThemeSetting objects
	 **/
	function & getSettings() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns if this ThemeWidget supports changing settings or if its static.
	 * @access public
	 * @return boolean TRUE if this ThemeWidget supports settings, FALSE otherwise.
	 **/
	function hasSettings() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles() {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;/div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output(& $layoutOrContent) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
	}
}

?>