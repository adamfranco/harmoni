<?php

/**
 * Theme interface defines what methods are required of any theme.
 * 
 * A theme is responsible for the look & feel of a website. The methods below
 * are called from various places within a script and all affect how the page
 * ends up looking. The theme is ultimately responsible for outputting the entire
 * HTML page. It is tightly integrated with {@link Layout} classes and its children
 * to create a powerful yet flexible system for content output.
 *
 * @package harmoni.themes
 * @version $Id: Theme.interface.php,v 1.2 2004/03/03 19:09:41 adamfranco Exp $
 * @copyright 2004 
 **/

class ThemeInterface {

	/**
	 * Returns the DisplayName of this theme.
	 * @access public
	 * @return string The display name.
	 **/
	function getDisplayName () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the Description of this theme.
	 * @access public
	 * @return string The Description name.
	 **/
	function getDescription () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the ID of this theme.
	 * @access public
	 * @return object Id The ID of this theme.
	 **/
	function & getId () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}

	/**
	 * Sets the page title to $title.
	 * @param string $title The page title.
	 * @access public
	 * @return void
	 **/
	function setPageTitle ( $title ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Adds $contentString to the <pre><head>...</head></pre> (head) section of the page.
	 * @param string $content The content to add to the head section.
	 * @access public
	 * @return void
	 **/
	function addHeadContent ( $contentString ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Adds $styleString to the <pre><style>....</style></pre> (style) section of the head section of the page.
	 * @param string $styleString The style to add to the style section.
	 * @access public
	 * @return void
	 **/
	function addHeadStyle ( $styleString ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Adds $javascriptString to the <pre><script ...>....</script></pre> (script) section of the head section of the page.
	 * @param string $javascriptString The javascript to add to the script section.
	 * @access public
	 * @return void
	 **/
	function addHeadJavascript ( $javascriptString ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns a HarmoniIterator object with this theme's ThemeSetting objects.
	 * @access public
	 * @see {@link ThemeInterface::setSettings}
	 * @return object HarmoniIterator An iterator of ThemeSetting objects
	 **/
	function & getSettings () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns if this theme supports changing settings or if its static.
	 * @access public
	 * @return boolean TRUE if this theme supports settings, FALSE otherwise.
	 **/
	function hasSettings () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Takes a {@link Layout} object and outputs a full HTML page with the layout's contents in the body section.
	 * @param ref object $layoutObj The {@link Layout} object.
	 * @access public
	 * @return void
	 **/
	function printPage (& $layoutObj) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
/******************************************************************************
 * 	ThemeWidget access methods
 ******************************************************************************/

	/**
	 * Returns a ThemeWidget object with of the MenuThemeWidget class.
	 * @access public
	 * @param integer $index Which MenuThemeWidget to get. MenuThemeWidgets are 
	 *		indexed analogus to the HTML <h1>, <h2>, <h3>, etc headings where the
	 *		lower the index, the more "prominent" the look of the widget. Indices
	 *		start at 1 and go as high (in sequence; 1, 2, 3, etc) as the theme 
	 *		developer desires.
	 * @return object MenuThemeWidget A MenuThemeWidget object. If the requested
	 *		index is higher than the Theme supports, the MenuThemeWidget of the highest 
	 *		index availible is returned.
	 **/
	function & getMenu ( $index = 1 ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all MenuThemeWidgets.
	 **/
	function & getMenus () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns a ThemeWidget object with of the MenuItemThemeWidget class.
	 * @access public
	 * @param integer $index Which MenuItemThemeWidget to get. MenuItemThemeWidgets are 
	 *		indexed analogus to the HTML <h1>, <h2>, <h3>, etc headings where the
	 *		lower the index, the more "prominent" the look of the widget. Indices
	 *		start at one and go as high (in sequence; 1, 2, 3, etc) as the theme 
	 *		developer desires.
	 * @return object MenuItemThemeWidget A MenuItemThemeWidget object. If the requested
	 *		index is higher than the Theme supports, the MenuItemThemeWidget of the highest 
	 *		index availible is returned.
	 **/
	function & getMenuItem ( $index = 1 ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all MenuItemThemeWidgets.
	 **/
	function & getMenuItems () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns a ThemeWidget object with of the MenuHeadingThemeWidget class.
	 * @access public
	 * @param integer $index Which MenuHeadingThemeWidget to get. MenuHeadingThemeWidgets are 
	 *		indexed analogus to the HTML <h1>, <h2>, <h3>, etc headings where the
	 *		lower the index, the more "prominent" the look of the widget. Indices
	 *		start at one and go as high (in sequence; 1, 2, 3, etc) as the theme 
	 *		developer desires.
	 * @return object MenuHeadingThemeWidget A MenuHeadingThemeWidget object. If the requested
	 *		index is higher than the Theme supports, the MenuHeadingThemeWidget of the highest 
	 *		index availible is returned.
	 **/
	function & getMenuHeading ( $index = 1 ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all MenuHeadingThemeWidgets.
	 **/
	function & getMenuHeadings () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns a ThemeWidget object with of the HeadingThemeWidget class.
	 * @access public
	 * @param integer $index Which HeadingThemeWidget to get. HeadingThemeWidgets are 
	 *		indexed analogus to the HTML <h1>, <h2>, <h3>, etc headings where the
	 *		lower the index, the more "prominent" the look of the widget. Indices
	 *		start at one and go as high (in sequence; 1, 2, 3, etc) as the theme 
	 *		developer desires.
	 * @return object HeadingThemeWidget A HeadingThemeWidget object. If the requested
	 *		index is higher than the Theme supports, the HeadingThemeWidget of the highest 
	 *		index availible is returned.
	 **/
	function & getHeading ( $index = 1 ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all HeadingThemeWidgets.
	 **/
	function & getHeadings () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns a ThemeWidget object with of the FooterThemeWidget class.
	 * @access public
	 * @param integer $index Which FooterThemeWidget to get. FooterThemeWidgets are 
	 *		indexed analogus to the HTML <h1>, <h2>, <h3>, etc headings where the
	 *		lower the index, the more "prominent" the look of the widget. Indices
	 *		start at one and go as high (in sequence; 1, 2, 3, etc) as the theme 
	 *		developer desires.
	 * @return object FooterThemeWidget A FooterThemeWidget object. If the requested
	 *		index is higher than the Theme supports, the FooterThemeWidget of the highest 
	 *		index availible is returned.
	 **/
	function & getFooter ( $index = 1 ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all FooterThemeWidgets.
	 **/
	function & getFooters () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns a ThemeWidget object with of the TextBlockThemeWidget class.
	 * @access public
	 * @param integer $index Which TextBlockThemeWidget to get. TextBlockThemeWidgets are 
	 *		indexed analogus to the HTML <h1>, <h2>, <h3>, etc headings where the
	 *		lower the index, the more "prominent" the look of the widget. Indices
	 *		start at one and go as high (in sequence; 1, 2, 3, etc) as the theme 
	 *		developer desires.
	 * @return object TextBlockThemeWidget A TextBlockThemeWidget object. If the requested
	 *		index is higher than the Theme supports, the TextBlockThemeWidget of the highest 
	 *		index availible is returned.
	 **/
	function & getTextBlock ( $index = 1 ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all TextBlockThemeWidgets.
	 **/
	function & getTextBlocks () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>