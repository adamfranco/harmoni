<?php

require_once(HARMONI."/oki/shared/HarmoniIterator.class.php");
require_once(HARMONI."/themeHandler/Theme.interface.php");

define ("MENU_WIDGET", "menu");
define ("MENU_ITEM_WIDGET", "menuItem");
define ("SELECTED_MENU_ITEM_WIDGET", "selectedMenuItem");
define ("MENU_HEADING_WIDGET", "menuHeading");
define ("HEADING_WIDGET", "heading");
define ("FOOTER_WIDGET", "footer");
define ("TEXT_BLOCK_WIDGET", "textBlock");
define ("BLANK_WIDGET", "blank");

/**
 * The abstract Theme class provides some fleshed out methods for easier
 * implimentation of themes.
 * The constructor as well as the print(& $layoutObj) method will need to be
 * implimented for any classes that extend this abstract class.
 *
 * @package harmoni.themes
 * @version $Id: Theme.abstract.php,v 1.7 2004/03/12 23:35:32 adamfranco Exp $
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
// 		$this->_displayName = "Simple Shadow Theme";
// 		
// 		// Set the Descripiton:
// 		$this->_description = "A pretty theme with drop shadows.";
// 	
// 		// Set up any Setting objects for this theme and add them.
// 		$this->_bodyColorId =& $this->addSetting(new ColorSetting, "Body Color", "The color of the page body.", "aaaaaa");
// 		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of the main block background.", "ffffff");
// 		$this->_borderColorId =& $this->addSetting(new BorderColorSetting);
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
	}

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
	 * @param object SettingInterface $setting The Setting to add.
	 * @param string $displayName A display name to over-ride the setting default.
	 * @param string $description A description to over-ride the setting default.
	 * @param string $defaultValue A default value to over-ride the setting default.
	 * @return The id (unique in this theme object) of the setting.
	 **/
	function addSetting (& $setting, $displayName = NULL, $description = NULL, $defaultValue = NULL) {
		ArgumentValidator::validate($setting, new ExtendsValidatorRule("ThemeSettingInterface"));
		
		if (!is_array($this->_settings))
			$this->_settings = array();
		
		$idString = count($this->_settings);
		$sharedManager =& Services::getService("Shared");
		$id =& $sharedManager->getId($idString);
		$setting->setId($id);
		
		if ($displayName !== NULL)
			$setting->setDisplayName($displayName);
		if ($description !== NULL)
			$setting->setDescription($description);
		if ($defaultValue !== NULL) {
			$setting->setDefaultValue($defaultValue);
			$setting->setValue($defaultValue);
		}
		
		$this->_settings[$id->getIdString()] =& $setting;
		return $id;
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
	 * Returns a SettingsIterator object with this Theme's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this theme's settings. These
	 *		are to be inserted into the page's <head><style> section.
	 *		Note: these styles do not include those of the theme's child widgets.
	 *		Those must be accessed otherwise.
	 **/
	function getStyles () {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
		
//		// Sample implimentation (for a "MenuItem" Widget)
// 
// 		$styles = "\n\n\t\t\t.mainblock {";
// 		
// 		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
// 		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
// 	
// 		$borderColor =& $this->getSetting($this->_borderColorId);
// 		$leftTopBorderThickness =& $this->getSetting($this->_leftTopBorderThicknessId);
// 		$rightBottomBorderThickness =& $this->getSetting($this->_rightBottomBorderThicknessId);
// 		$borderStyle =& $this->getSetting($this->_borderStyleId);
// 		
// 		$styles .= "\n\t\t\t\tborder-top: ".$leftTopBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
// 		$styles .= "\n\t\t\t\tborder-left: ".$leftTopBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
// 		$styles .= "\n\t\t\t\tborder-right: ".$rightBottomBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
// 		$styles .= "\n\t\t\t\tborder-bottom: ".$rightBottomBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
// 
// 		$padding =& $this->getSetting($this->_paddingId);
// 		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
// 
// 		$margin =& $this->getSetting($this->_marginId);
// 		$styles .= "\n\t\t\t\tmargin: ".$margin->getValue().";";
// 		
// 		$styles .= "\n\t\t\t}";
// 		
// 		$styles = "\n\t\t\tbody {";
// 		$bodyColor =& $this->getSetting($this->_bodyColorId);
// 		$styles .= "\n\t\t\t\tbackground-color: #".$bodyColor->getValue().";";
// 		$styles .= "\n\t\t\t}";
// 		
// 		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} object and outputs a full HTML page with the layout's contents in the body section.
	 * @param ref object $layoutObj The {@link Layout} object.
	 * @access public
	 * @return void
	 **/
	function printPage (& $layoutObj) {
		(throwError(new Error("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.", "Interface", TRUE)) || die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.")); 
		
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
//		print "\n\t\t<div class='mainblock'>";
// 		$layout->output($this);
//		print "\n\t\t</div>";
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
		$allStyles .= $this->getStyles();
		
		$allWidgets =& $this->getAllWidgets();
		while ($allWidgets->hasNext()) {
			$widget =& $allWidgets->next();
			$allStyles .= $widget->getStyles();
		}
		
		return $allStyles;
	}
	
	
	
/******************************************************************************
 * 	ThemeWidget access methods
 ******************************************************************************/
	
	/**
	 * Adds a ThemeWidget to this Theme.
	 * @access public
	 * @param object MenuThemeWidget The MenuThemeWidget to add.
	 * @return integer The index of the added Widget.
	 **/
	function & addWidget (  $type, & $themeWidget ) {
		ArgumentValidator::validate($themeWidget, new ExtendsValidatorRule("ThemeWidgetInterface"));
		if (!in_array($type, array(MENU_WIDGET, MENU_ITEM_WIDGET, SELECTED_MENU_ITEM_WIDGET, MENU_HEADING_WIDGET, HEADING_WIDGET, FOOTER_WIDGET, TEXT_BLOCK_WIDGET, BLANK_WIDGET)))
			throwError(new Error("Unsupported widget type, '".$type."'.", "Theme", TRUE));
		
		$currentString = "_".$type."s";
		$widgetArray =& $this->$currentString;
				
		if (!is_array($widgetArray))
			$widgetArray = array();
		
		$widgetArray[] =& $themeWidget;
		$index = count(widgetArray);
		$themeWidget->setIndex($index);
		$themeWidget->setType($type);
		return $index;
	}
	
	/**
	 * Returns a ThemeWidget object with of the $type class.
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
	function & getWidget ( $type, $index = 1 ) {
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		if (!in_array($type, array(MENU_WIDGET, MENU_ITEM_WIDGET, SELECTED_MENU_ITEM_WIDGET, MENU_HEADING_WIDGET, HEADING_WIDGET, FOOTER_WIDGET, TEXT_BLOCK_WIDGET, BLANK_WIDGET)))
			throwError(new Error("Unsupported widget type, '".$type."'.", "Theme", TRUE));
		
		$currentString = "_".$type."s";
		$widgetArray =& $this->$currentString;
		
		if (!count($widgetArray))
			throwError(new Error("Required Widget, ".$type."ThemeWidget has not been added to this Theme.", "Theme", TRUE));
			
		if (count($widgetArray) >= $index)
			return $widgetArray[$index-1];
		else
			return $widgetArray[count($widgetArray)-1];
	}
	
	/**
	 * Returns an iterator of all ThemeWidget objects.
	 * @access public
	 * @param string $type The type of theme widget to get.
	 * @return object ThemeWidgetIterator An iterator of all $typeThemeWidgets.
	 **/
	function & getWidgets ( $type ) {
		if (!in_array($type, array(MENU_WIDGET, MENU_ITEM_WIDGET, SELECTED_MENU_ITEM_WIDGET, MENU_HEADING_WIDGET, HEADING_WIDGET, FOOTER_WIDGET, TEXT_BLOCK_WIDGET, BLANK_WIDGET)))
			throwError(new Error("Unsupported widget type, '".$type."'.", "Theme", TRUE));
		
		$currentString = "_".$type."s";
		$widgetArray =& $this->$currentString;
		
		if (!count($widgetArray))
			throwError(new Error("Required Widget, ".$type."ThemeWidget has not been added to this Theme.", "Theme", TRUE));
			
		return new HarmoniIterator($widgetArray);
	}
	
	/**
	 * Returns an iterator of all widgets of all indices and classes.
	 * @access protected
	 * @return object HarmoniIterator All the widgets.
	 */
	function getAllWidgets() {
		$allWidgets =& array_merge($this->_textBlocks,
									$this->_headings,
									$this->_footers,
									$this->_menus, 
									$this->_menuItems,
									$this->_selectedMenuItems,
									$this->_menuHeadings,
									$this->_blanks);
		return new HarmoniIterator($allWidgets);
	}
}

?>