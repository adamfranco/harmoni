<?php

require_once(HARMONI."/oki/shared/HarmoniIterator.class.php");
require_once(HARMONI."/themeHandler/ThemeWidget.interface.php");

/**
 * The abstract Theme class provides some fleshed out methods for easier
 * implimentation of ThemeWidgets.
 * The constructor as well as the print(& $layoutOrContent) method will need to be
 * implimented for any classes that extend this abstract class.
 *
 * @package harmoni.themes
 * @version $Id: ThemeWidget.abstract.php,v 1.1 2004/03/04 00:01:45 adamfranco Exp $
 * @copyright 2004 
 **/

class ThemeWidget
	extends ThemeWidgetInterface {
	
	/**
	 * @access private
	 * @var integer $_index The Index of this this ThemeWidget.
	 **/
	var $_index;
	
	/**
	 * @access private
	 * @var string $_displayName The Display Name of this this ThemeWidget.
	 **/
	var $_displayName;
	
	/**
	 * @access private
	 * @var string $_description The description of this this ThemeWidget.
	 **/
	var $_description;
	
	/**
	 * @access private
	 * @var array $_settings An array of the Setting objects for this ThemeWidget.
	 **/
	var $_settings;
	
	
	
/******************************************************************************
 * Methods
 ******************************************************************************/
	
	/**
	 * Constructor, throws an error since this is an abstract class.
	 * The constructor as well as the getSettings() and print(& $layoutOrContent) 
	 * methods will need to be implimented for any classes that extend this 
	 * abstract class.
	 */
 	function ThemeWidget () {
 		die ("Can not instantiate abstract class <b> ".__CLASS__."</b>. Extend with a non-abstract child class and instantiate that instead."); 
 		
// 		// Sample Constructor (for a "MenuItem" Widget)
// 
// 		// Set the Display Name:
// 		$this->_displayName = "MenuItem 1";
// 		
// 		// Set the Descripiton:
// 		$this->_description = "A prominent menu item.";
// 		
// 		// Set up any Setting objects for this theme and add them.
// 		$this->_textColorId =& $this->addSetting(new TextColorThemeSetting);
// 		$this->_linkColorId =& $this->addSetting(new LinkColorThemeSetting);
// 		$this->_backgroundColorId =& $this->addSetting(new BackgroundColorThemeSetting);
// 		$this->_hooverBackgroundColorId =& $this->addSetting(new HooverBackgroundColorThemeSetting);
// 		$this->_textSizeId =& $this->addSetting(new TextSizeThemeSetting);
// 		$this->_paddingId =& $this->addSetting(new PaddingThemeSetting);
 	}

	/**
	 * Returns the index of this ThemeWidget.
	 * @access public
	 * @return int The index of this Widget.
	 *		Indices start at 1 and go as high (in sequence; 1, 2, 3, etc) 
	 *		as the theme developer desires.
	 **/
	function getIndex() {
		return $this->_index;
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
		ArgumentValidator::validate($index, new IntegerValidatorRule);
		
		$this->_index = $index;
	}

	/**
	 * Returns the DisplayName of this ThemeWidget.
	 * @access public
	 * @return string The display name.
	 **/
	function getDisplayName() {
		return $this->_displayName;
	}
	
	/**
	 * Returns the Description of this ThemeWidget.
	 * @access public
	 * @return string The Description name.
	 **/
	function getDescription() {
		return $this->_description;
	}
	
	/**
	 * Adds a Setting to those known to this Wiget.
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
			throwError(new Error("Unknown Setting Id.", "ThemeWidget", TRUE));
		
		return $this->_settings[$id->getIdString()];
	}

	/**
	 * Returns a HarmoniIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return object HarmoniIterator An iterator of ThemeSetting objects
	 **/
	function & getSettings() {
		if (!is_array($this->_settings))
			$this->_settings = array();
		
		return new HarmoniIterator($this->_settings);
	}
	
	/**
	 * Returns if this ThemeWidget supports changing settings or if its static.
	 * @access public
	 * @return boolean TRUE if this ThemeWidget supports settings, FALSE otherwise.
	 **/
	function hasSettings() {
		if (!is_array($this->_settings))
			$this->_settings = array();
		
		if (count($this->_settings))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's <head><style> section.
	 **/
	function getStyles () {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
		
//		// Sample implimentation (for a "MenuItem" Widget)
// 
// 		$styles = "\n\n\t\t\t.menuitem1 {";
// 		
// 		$textColor =& $this->getSetting($this->_textColorId);
// 		$styles .= "\n\t\t\t\tcolor: #".$textColor->getValue().";";
// 		
// 		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
// 		$styles .= "\n\t\t\t\tcolor: #".$backgroundColor->getValue().";";
// 		
// 		$textSize =& $this->getSetting($this->_textSizeId);
// 		$styles .= "\n\t\t\t\tfont-size: ".$textSize->getValue().";";
// 		
// 		$padding =& $this->getSetting($this->_paddingId);
// 		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
// 		
// 		$styles .= "\n\t\t\t}";
// 		
// 		$styles = "\n\t\t\ta.menuitem1 {";
// 		$linkColor =& $this->getSetting($this->_linkColorId);
// 		$styles .= "\n\t\t\t\tcolor: #".$linkColor->getValue().";";
// 		$styles .= "\n\t\t\t}";
// 		
// 		$styles = "\n\t\t\ta.menuitem1:hoover {";
// 		$hooverColor =& $this->getSetting($this->_hooverBackgroundColorId);
// 		$styles .= "\n\t\t\t\tbackground-color: #".$hooverColor->getValue().";";
// 		$styles .= "\n\t\t\t}";
// 		
// 		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a <div ...> ... </div>
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function print (& $layoutOrContent) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
		
//		// Sample implimentation (for a "Menu" Widget)
// 
// 		$depth = $layoutOrContent->getDepth();
// 		print "\n".$this->_getTabs($depth)."<div class='menuitem1'>";
// 		
// 		$layoutOrContent->output();
// 		
// 		print "\n".$this->_getTabs($depth)."</div>";
	}
	
	/**
	 * Returns a string of tabs for lining up our HTML Blocks.
	 * @access protected
	 * @param integer $depth The Depth of our layoutOrContent withing the Layout hierarchy.
	 * @return string The tabs.
	 */
	function _getTabs($depth=0) {
		// Set up tabs for nice html output.
		$tabs = "\t\t";
		for ($i = 0; $i < $this->_level; $i++) {
			$tabs .= "\t";
		}
		
		return $tabs;
	}
}

?>