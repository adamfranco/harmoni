<?php

/**
 * Theme interface defines what methods are required of any theme.
 * 
 * A theme is responsible for the look & feel of a website. The methods below
 * are called from various places within a script and all affect how the page
 * ends up looking. The theme is ultimately responsible for outputting the entire
 * HTML page. It is tightly integrated with {@link Layout} classes and their children
 * to create a powerful yet flexible system for content output.
 *
 * @package harmoni.themes
 * @version $Id: Theme.interface.php,v 1.4 2003/07/25 07:27:15 gabeschine Exp $
 * @copyright 2003 
 **/

class ThemeInterface {
	/**
	 * Sets the page title to $title.
	 * @param string $title The page title.
	 * @access public
	 * @return void
	 **/
	function setPageTitle($title) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Adds $content to the <pre><head>...</head></pre> (head) section of the page.
	 * @param string $content The content to add to the head section.
	 * @access public
	 * @return void
	 **/
	function addHeadContent($content) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Prints a {@link Menu}, with specified orientation.
	 * @param ref object $menuObj The {@link Menu} object to print.
	 * @param integer $otientation The orientation. Either HORIZONTAL or VERTICAL.
	 * @access public
	 * @return void
	 **/
	function printMenu(&$menuObj, $orientation) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Prints a {@link Content} object out using the theme. $level can be used to specify
	 * changing look the deeper into a layout you go.
	 * @param ref object $contentObj The {@link Content} object to use.
	 * @access public
	 * @return void
	 **/
	function printContent(&$contentObj) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Prints a {@link Layout} object.
	 * @param ref object $layoutObj The Layout object.
	 * @access public
	 * @return void
	 **/
	function printLayout(&$layoutObj) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Takes a {@link Layout} object and outputs a full HTML page with the layout's contents in the body section.
	 * @param ref object $layoutObj The {@link Layout} object.
	 * @access public
	 * @return void
	 **/
	function printPageWithLayout(&$layoutObj) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Sets this theme's settings to $serializedSettings.
	 * @param string $serializedSettings A serialized string representing the optional
	 * settings for this theme. Most of the time, this string will have come from {@link ThemeInterface::getSettings getSettings()},
	 * stored in a database and then retrieved.
	 * @access public
	 * @see {@link ThemeInterface::getSettings}
	 * @return void
	 **/
	function setSettings($serializedSettings) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns a serialized string of this theme's settings.
	 * @access public
	 * @see {@link ThemeInterface::setSettings}
	 * @return string A serialized string representing the settings.
	 **/
	function getSettings() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * This method servers two purposes: to output an HTML form and handle the conversion
	 * of the user's input into a form the theme understands, storing it for later usage. Probably, 
	 * the stored value will be retrieved using {@link ThemeInterface::getSettings getSettings()} for storage
	 * in a database or similar storage method.
	 * @access public
	 * @return boolean Returns FALSE as long as it's not "happy" with the input it got. Either
	 * it hasn't gotten any input from the user (eg, first page load) or the user entered
	 * some invalid content. When everything has been verified and stored in a member variable,
	 * the method can return TRUE.
	 **/
	function handleSettingsChange() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns if this theme supports changing settings or if its static.
	 * @access public
	 * @return boolean TRUE if this theme supports settings, FALSE otherwise.
	 **/
	function hasSettings() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns this Theme's base color. This is usually used for color conformance
	 * of certain elements in the output to a color scheme, like alternating table-row
	 * background colors, etc. 
	 * @access public
	 * @return object An {@link HTMLColor} object.
	 **/
	function getBaseColor() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>