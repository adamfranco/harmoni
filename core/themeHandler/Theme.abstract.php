<?php

require_once(HARMONI."/oki/shared/HarmoniIterator.class.php");
require_once(HARMONI."/themeHandler/Theme.interface.php");

/**
 * The abstract Theme class provides some fleshed out methods for easier
 * implimentation of themes.
 * The constructor as well as the print(& $layoutObj) method will need to be
 * implimented for any classes that extend this abstract class.
 *
 * @package harmoni.themes
 * @version $Id: Theme.abstract.php,v 1.3 2004/03/04 00:01:10 adamfranco Exp $
 * @copyright 2004 
 **/

class Theme
	extends ThemeInterface {
	
	/**
	 * @access private
	 * @var string $_displayName The Display Name of this this Theme.
	 **/
	var $_displayName = "";
	
	/**
	 * @access private
	 * @var string $_description The description of this this Theme.
	 **/
	var $_description = "";
	
	/**
	 * @access private
	 * @var string $_pageTitle The title to output.
	 **/
	var $_pageTitle = "";
	
	/**
	 * @access private
	 * @var string $_headContent The string to print in the <head> section.
	 **/
	var $_headContent = "";
	
	/**
	 * @access private
	 * @var string $_headStyles The CSS styles to put between <style> tags 
	 * 		in the <head> section.
	 **/
	var $_headStyles = "";
	
	/**
	 * @access private
	 * @var string $_headJavascript The javascript functions to put between <script> tags 
	 * 		in the <head> section.
	 **/
	var $_headJavascript = "";
	
	/**
	 * Settings should be added by the addSetting( & $setting ) method.
	 * @access private
	 * @var array $_settings An array of the Setting objects for this theme.
	 *		Note: Each element also has its own settings. These settings are for
	 *		non-element-specific settings.
	 **/
	var $_settings;
	
	/**
	 * MenuThemeWigets should be added by the addMenuThemeWidget( & $menuThemeWidget ) method.
	 * @access private
	 * @var array $_menus An array of the MenuThemeWiget objects for this theme.
	 **/
	var $_menus;
	
	/**
	 * MenuItemThemeWigets should be added by the addMenuItemThemeWidget( & $menuItemThemeWidget ) method.
	 * @access private
	 * @var array $_menuItems An array of the MenuItemThemeWiget objects for this theme.
	 **/
	var $_menuItems;
	
	/**
	 * MenuHeadingThemeWigets should be added by the addMenuHeadingThemeWidget( & $menuHeadingThemeWidget ) method.
	 * @access private
	 * @var array $_menuHeadings An array of the MenuHeadingThemeWiget objects for this theme.
	 **/
	var $_menuHeadings;
	
	/**
	 * HeadingThemeWigets should be added by the addHeadingThemeWidget( & $headingThemeWidget ) method.
	 * @access private
	 * @var array $_headings An array of the HeadingThemeWiget objects for this theme.
	 **/
	var $_headings;
	
	/**
	 * FooterThemeWigets should be added by the addFooterThemeWidget( & $footerThemeWidget ) method.
	 * @access private
	 * @var array $_footers An array of the FooterThemeWiget objects for this theme.
	 **/
	var $_footers;
	
	/**
	 * TextBlockThemeWigets should be added by the addTextBlockThemeWidget( & $textBlockThemeWidget ) method.
	 * @access private
	 * @var array $_textBlocks An array of the TextBlockThemeWiget objects for this theme.
	 **/
	var $_textBlocks;
	
	
	
/******************************************************************************
 * Methods
 ******************************************************************************/
	
	/**
	 * Constructor, throws an error since this is an abstract class.
	 * The constructor as well as the print(& $layoutObj) method will need to be
	 * implimented for any classes that extend this abstract class.
	 */
 	function Theme () {
 		die ("Can not instantiate abstract class <b> ".__CLASS__."</b>. Extend with a non-abstract child class and instantiate that instead."); 
 		
//	 	// Sample Constructor:
//
// 		// Set the Display Name:
// 		$this->_displayName = "Pretty Bubble Theme";
// 		
// 		// Set the Descripiton:
// 		$this->_description = "A pretty theme with bubbles.";
// 	
// 		// Set up any Setting objects for this theme and add them.
// 		$this->addSetting(new PrettyBubble_BubbleSizeSetting);
// 		
// 		// Set up our widgets:
// 		// In this example there are two types of menus and one type of everything else.
// 		$this->addMenu(new PrettyBubbleMenu1);
// 		$this->addMenu(new PrettyBubbleMenu2);
// 		$this->addMenuItem(new PrettyBubbleMenuItem1);
// 		$this->addMenuItem(new PrettyBubbleMenuItem2);
// 		$this->addMenuHeading(new PrettyBubbleMenuHeading1);
// 		$this->addMenuHeading(new PrettyBubbleMenuHeading2);
// 		$this->addHeading(new PrettyBubbleHeading1);
// 		$this->addFooter(new PrettyBubbleFooter1);
// 		$this->addTextBlock(new PrettyBubbleTextBlock1);
// 	}

	/**
	 * Returns the DisplayName of this theme.
	 * @access public
	 * @return string The display name.
	 **/
	function getDisplayName () {
		return $this->_displayName;
	}
	
	/**
	 * Returns the Description of this theme.
	 * @access public
	 * @return string The Description name.
	 **/
	function getDescription () {
		return $this->_description;
	}
	
	/**
	 * Returns the ID of this theme.
	 * @access public
	 * @return object Id The ID of this theme.
	 **/
	function & getId () {
		$sharedManager =& Services::getService("Shared");
		return $sharedManager->getId(get_class($this));
	}

	/**
	 * Sets the page title to $title.
	 * @param string $title The page title.
	 * @access public
	 * @return void
	 **/
	function setPageTitle ( $title ) {
		ArgumentValidator::validate($title, new StringValidatorRule);
		
		$this->_pageTitle = $title;
	}
	
	/**
	 * Adds $contentString to the <pre><head>...</head></pre> (head) section of the page.
	 * @param string $content The content to add to the head section.
	 * @access public
	 * @return void
	 **/
	function addHeadContent ( $contentString ) {
		ArgumentValidator::validate($contentString, new StringValidatorRule);
		
		$this->_headContent .= "\n".$contentString;
	}
	
	/**
	 * Adds $styleString to the <pre><style>....</style></pre> (style) section of the head section of the page.
	 * @param string $styleString The style to add to the style section.
	 * @access public
	 * @return void
	 **/
	function addHeadStyle ( $styleString ) {
		ArgumentValidator::validate($styleString, new StringValidatorRule);
		
		$this->_headStyles .= "\n".$styleString;
	}
	
	/**
	 * Adds $javascriptString to the <pre><script ...>....</script></pre> (script) section of the head section of the page.
	 * @param string $javascriptString The javascript to add to the script section.
	 * @access public
	 * @return void
	 **/
	function addHeadJavascript ( $javascriptString ) {
		ArgumentValidator::validate($javascriptString, new StringValidatorRule);
		
		$this->_headJavascript .= "\n".$javascriptString;
	}
	
	/**
	 * Adds a Setting to those known to this Theme.
	 * @access public
	 * @param object SettingInterface The Setting to add.
	 * @return void
	 **/
	function addSetting (& $setting) {
		ArgumentValidator::validate($setting, new ExtendsValidatorRule("ThemeSettingInterface"));
		
		if (!is_array($this->_settings))
			$this->_settings = array();
		
		$id =& $setting->getId();
		$this->_settings[$id->getIdString()] =& $setting;
	}
	
	/**
	 * Returns the Setting known to this manager with the specified Id.
	 * @access public
	 * @param object Id The id of the desired Setting.
	 * @return object SettingInterface The desired Setting object.
	 **/
	function & getSetting (& $id) {
		ArgumentValidator::validate($id, new ExtendsValidatorRule("Id"));
		
		if (!$this->_settings[$id->getIdString()])
			throwError(new Error("Unknown Setting Id.", "Theme", TRUE));
		
		return $this->_settings[$id->getIdString()];
	}
	
	/**
	 * Returns a HarmoniIterator object with this theme's ThemeSetting objects.
	 * @access public
	 * @see {@link ThemeInterface::setSettings}
	 * @return object HarmoniIterator An iterator of ThemeSetting objects
	 **/
	function & getSettings () {
		if (!is_array($this->_settings))
			$this->_settings = array();
		
		return new HarmoniIterator($this->_settings);
	}
	
	/**
	 * Returns if this theme supports changing settings or if its static.
	 * @access public
	 * @return boolean TRUE if this theme supports settings, FALSE otherwise.
	 **/
	function hasSettings () {
		if (!is_array($this->_settings))
			$this->_settings = array();
		
		if (count($this->_settings))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * Takes a {@link Layout} object and outputs a full HTML page with the layout's contents in the body section.
	 * @param ref object $layoutObj The {@link Layout} object.
	 * @access public
	 * @return void
	 **/
	function printPage (& $layoutObj) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
		
//		// Sample implimentation:
// 		print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
// 		print "\n<html>";
// 		print "\n\t<head>";
// 
// 		print "\n\t\t<title>".$this->_pageTitle."</title>";
// 
// 		print "\n\t\t<style type='text/css'>";
// 		print $this->_getAllStyles();
// 		print "\n\t\t</style>";
// 		
// 		print "\n\t\t<script type='text/JavaScript'>";
// 		print $this->_headJavascript;
// 		print "\n\t\t</script>";
// 		
// 		print "\n\t</head>";
// 		print "\n\t<body>";
// 		
// 		$layout->output($this);
// 		
// 		print "\n\t</body>";
// 		print "\n</html>";
	}
	
	/**
	 * Combine the CSS styles for the theme and its widgets into a single string.
	 * @access protected
	 * @return string All of the CSS styles.
	 */
	function _getAllStyles() {
		$allStyles = $this->_headStyle;
		
		$allWidgets =& $this->_getAllWidgets();
		while ($allWidgets->hasNext()) {
			$widget =& $allWidgets->next();
			$allStyles .= $widget->getStyles();
		}
	}
	
	/**
	 * Returns an iterator of all widgets of all indices and classes.
	 * @access protected
	 * @return object HarmoniIterator All the widgets.
	 */
	function _getAllWidgets() {
		$allWidgets =& array_merge($this->_menus, 
									$this->_menuItems,
									$this->_menuHeadings,
									$this->_headings,
									$this->_footers,
									$this->_textBlocks);
		return new HarmoniIterator($allWidgets);
	}
	
	
	
/******************************************************************************
 * 	ThemeWidget access methods
 ******************************************************************************/
	
	/**
	 * Adds a MenuThemeWidget to this Theme.
	 * @access public
	 * @param object MenuThemeWidget The MenuThemeWidget to add.
	 * @return integer The index of the added Widget.
	 **/
	function & addMenu ( & $menuThemeWidget ) {
		ArgumentValidator::validate($menuThemeWidget, new ExtendsValidatorRule("ThemeWidgetInterface"));
		
		if (!is_array($this->_menus))
			$this->_menus = array();
			
		$this->_menus[] =& $menuThemeWidget;
		$index = count($this->_menus);
		$menuThemeWidget->setIndex($index);
		return $index;
	}
	
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
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		if (!count($this->_menus))
			throwError(new Error("Required Widget, MenuThemeWidget has not been added to this Theme.", "Theme", TRUE));
			
		if (count($this->_menus) >= $index)
			return $this->_menus[$index-1];
		else
			return $this->_menus[count($this->_menus)-1];
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all MenuThemeWidgets.
	 **/
	function & getMenus () {
		if (!count($this->_menus))
			throwError(new Error("Required Widget, MenuThemeWidget has not been added to this Theme.", "Theme", TRUE));
			
		return new HarmoniIterator($this->_menus);
	}
	
	
	
	/**
	 * Adds a MenuItemThemeWidget to this Theme.
	 * @access public
	 * @param object MenuItemThemeWidget The MenuItemThemeWidget to add.
	 * @return integer The index of the added Widget.
	 **/
	function & addMenuItem ( & $menuItemThemeWidget ) {
		ArgumentValidator::validate($menuItemThemeWidget, new ExtendsValidatorRule("ThemeWidgetInterface"));
		
		if (!is_array($this->_menuItems))
			$this->_menuItems = array();
		
		$this->_menuItems[] =& $menuItemThemeWidget;
		$index = count($this->_menuItems);
		$menuItemThemeWidget->setIndex($index);
		return $index;
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
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		if (!count($this->_menuItems))
			throwError(new Error("Required Widget, MenuItemThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		if (count($this->_menuItems) >= $index)
			return $this->_menuItems[$index-1];
		else
			return $this->_menuItems[count($this->_menuItems)-1];
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all MenuItemThemeWidgets.
	 **/
	function & getMenuItems () {
		if (!count($this->_menuItems))
			throwError(new Error("Required Widget, MenuItemThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		return new HarmoniIterator($this->_menuItems);
	}
	
	
	
	/**
	 * Adds a MenuHeadingThemeWidget to this Theme.
	 * @access public
	 * @param object MenuHeadingThemeWidget The MenuHeadingThemeWidget to add.
	 * @return integer The index of the added Widget.
	 **/
	function & addMenuHeading ( & $menuHeadingThemeWidget ) {
		ArgumentValidator::validate($menuHeadingThemeWidget, new ExtendsValidatorRule("ThemeWidgetInterface"));
		
		if (!is_array($this->_menuHeadings))
			$this->_menuHeadings = array();
		
		$this->_menuHeadings[] =& $menuHeadingThemeWidget;
		$index = count($this->_menuHeadings);
		$menuHeadingThemeWidget->setIndex($index);
		return $index;
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
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		if (!count($this->_menuHeadings))
			throwError(new Error("Required Widget, MenuHeadingThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		if (count($this->_menuHeadings) >= $index)
			return $this->_menuHeadings[$index-1];
		else
			return $this->_menuHeadings[count($this->_menuHeadings)-1];
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all MenuHeadingThemeWidgets.
	 **/
	function & getMenuHeadings () {
		if (!count($this->_menuHeadings))
			throwError(new Error("Required Widget, MenuHeadingThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		return new HarmoniIterator($this->_menuHeadings);
	}
	
	
	
	/**
	 * Adds a HeadingThemeWidget to this Theme.
	 * @access public
	 * @param object HeadingThemeWidget The HeadingThemeWidget to add.
	 * @return integer The index of the added Widget.
	 **/
	function & addHeading ( & $headingThemeWidget ) {
		ArgumentValidator::validate($headingThemeWidget, new ExtendsValidatorRule("ThemeWidgetInterface"));
		
		if (!is_array($this->_headings))
			$this->_headings = array();
		
		$this->_headings[] =& $headingThemeWidget;
		$index = count($this->_headings);
		$headingThemeWidget->setIndex($index);
		return $index;
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
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		if (!count($this->_headings))
			throwError(new Error("Required Widget, HeadingThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		if (count($this->_headings) >= $index)
			return $this->_headings[$index-1];
		else
			return $this->_headings[count($this->_headings)-1];
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all HeadingThemeWidgets.
	 **/
	function & getHeadings () {
		if (!count($this->_headings))
			throwError(new Error("Required Widget, HeadingThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		return new HarmoniIterator($this->_headings);
	}
	
	
	
	/**
	 * Adds a FooterThemeWidget to this Theme.
	 * @access public
	 * @param object FooterThemeWidget The FooterThemeWidget to add.
	 * @return integer The index of the added Widget.
	 **/
	function & addFooter ( & $footerThemeWidget ) {
		ArgumentValidator::validate($footerThemeWidget, new ExtendsValidatorRule("ThemeWidgetInterface"));
		
		if (!count($this->_footers))
			throwError(new Error("Required Widget, FooterThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		if (!is_array($this->_footers))
			$this->_footers = array();
		
		$this->_footers[] =& $footerThemeWidget;
		$index = count($this->_footers);
		$footerThemeWidget->setIndex($index);
		return $index;
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
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		if (count($this->_footers) >= $index)
			return $this->_footers[$index-1];
		else
			return $this->_footers[count($this->_footers)-1];
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all FooterThemeWidgets.
	 **/
	function & getFooters () {
		if (!count($this->_footers))
			throwError(new Error("Required Widget, FooterThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		return new HarmoniIterator($this->_footers);
	}
	
	
	
	/**
	 * Adds a TextBlockThemeWidget to this Theme.
	 * @access public
	 * @param object TextBlockThemeWidget The TextBlockThemeWidget to add.
	 * @return integer The index of the added Widget.
	 **/
	function & addTextBlock ( & $textBlockThemeWidget ) {
		ArgumentValidator::validate($textBlockThemeWidget, new ExtendsValidatorRule("ThemeWidgetInterface"));
		
		if (!is_array($this->_textBlocks))
			$this->_textBlocks = array();
		
		$this->_textBlocks[] =& $textBlockThemeWidget;
		$index = count($this->_textBlocks);
		$textBlockThemeWidget->setIndex($index);
		return $index;
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
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		if (!count($this->_textBlocks))
			throwError(new Error("Required Widget, TextBlockThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		if (count($this->_textBlocks) >= $index)
			return $this->_textBlocks[$index-1];
		else
			return $this->_textBlocks[count($this->_textBlocks)-1];
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @return object ThemeWidgetIterator An iterator of all TextBlockThemeWidgets.
	 **/
	function & getTextBlocks () {
		if (!count($this->_textBlocks))
			throwError(new Error("Required Widget, TextBlockThemeWidget has not been added to this Theme.", "Theme", TRUE));
		
		return new HarmoniIterator($this->_textBlocks);
	}
}

?>