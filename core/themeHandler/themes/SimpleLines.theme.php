<?php

require_once(HARMONI."/themeHandler/Theme.abstract.php");
require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/BlankThemeWidget.class.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");

/**
 * A simple line and color-block based theme.
 *
 * @package harmoni.themes
 * @version $Id: SimpleLines.theme.php,v 1.3 2004/03/05 22:26:18 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesTheme
	extends Theme {
	
	/**
	 * Constructor, throws an error since this is an abstract class.
	 * The constructor as well as the print(& $layoutObj) method will need to be
	 * implimented for any classes that extend this abstract class.
	 */
 	function SimpleLinesTheme () {
 
		// Set the Display Name:
		$this->_displayName = "Simple Lines Theme";
		
		// Set the Descripiton:
		$this->_description = "A simple line and color-block based theme.";
	
		// Set up any Setting objects for this theme and add them.
		$this->_bodyColorId =& $this->addSetting(new ColorSetting, "Body Color", "The color of the page body.", "aaaaaa");
				
		// Set up our widgets:
		// In this example there are two types of menus and one type of everything else.
		$this->addWidget(BLANK_WIDGET, new Blank);
		$this->addWidget(TEXT_BLOCK_WIDGET, new SimpleLinesTextBlock1);
		$this->addWidget(MENU_WIDGET, new SimpleLinesMenu1);
		$this->addWidget(HEADING_WIDGET, new SimpleLinesHeading1);
// 		$this->addMenuItem(new SimpleLinesMenuItem1);
// 		$this->addMenuHeading(new SimpleLinesMenuHeading1);
// 		$this->addHeading(new SimpleLinesHeading1);
// 		$this->addFooter(new SimpleLinesFooter1);
// 		$this->addTextBlock(new SimpleLinesTextBlock1);
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
		$styles = "\n\t\t\tbody {";
		$bodyColor =& $this->getSetting($this->_bodyColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$bodyColor->getValue().";";
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} object and outputs a full HTML page with the layout's contents in the body section.
	 * @param ref object $layoutObj The {@link Layout} object.
	 * @access public
	 * @return void
	 **/
	function printPage (& $layoutObj) {
		ArgumentValidator::validate($layoutObj, new ExtendsValidatorRule("LayoutInterface"));
		
		print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
		print "\n<html>";
		print "\n\t<head>";

		print "\n\t\t<title>".$this->_pageTitle."</title>";

		print "\n\t\t<style type='text/css'>";
		print $this->_getAllStyles();
		print "\n\t\t</style>";
		
		print "\n\t\t<script type='text/JavaScript'>";
		print $this->_headJavascript;
		print "\n\t\t</script>";
		
		print "\n\t</head>";
		print "\n\t<body>";
		
		$widget =& $this->getWidget($layoutObj->getThemeWidgetType(), 
									$layoutObj->getThemeWidgetIndex());
		$widget->output($layoutObj, $this);
		
		print "\n\t</body>";
		print "\n</html>";
	}
}




/**
 * The main TextBlock Widget for the SimpleLines theme.
 *
 * @package harmoni.themes
 * @version $Id: SimpleLines.theme.php,v 1.3 2004/03/05 22:26:18 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesTextBlock1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesTextBlock1 () {
		// Set the Display Name:
		$this->_displayName = "TextBlockItem 1";
		
		// Set the Descripiton:
		$this->_description = "The main block that most of the page content goes in.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of the main block background.", "ffffff");
//		$this->_borderColorId =& $this->addSetting(new BorderColorSetting);
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's <head><style> section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.textblock1 {";
		
		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
	
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
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a <div ...> ... </div>
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='textblock1'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}


/**
 * The main Menu Widget for the SimpleLines theme.
 *
 * @package harmoni.themes
 * @version $Id: SimpleLines.theme.php,v 1.3 2004/03/05 22:26:18 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesMenu1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesMenu1 () {
		// Set the Display Name:
		$this->_displayName = "MenuItem 1";
		
		// Set the Descripiton:
		$this->_description = "A prominent menu item.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_textColorId =& $this->addSetting(new ColorSetting);
// 		$this->_linkColorId =& $this->addSetting(new LinkColorSetting);
// 		$this->_backgroundColorId =& $this->addSetting(new BackgroundColorSetting);
// 		$this->_hooverBackgroundColorId =& $this->addSetting(new HooverBackgroundColorSetting);
// 		$this->_textSizeId =& $this->addSetting(new TextSizeSetting);
// 		$this->_paddingId =& $this->addSetting(new PaddingSetting);
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's <head><style> section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.menu1 {";
		
		$textColor =& $this->getSetting($this->_textColorId);
		$styles .= "\n\t\t\t\tcolor: #".$textColor->getValue().";";
		
// 		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
// 		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
// 		
// 		$textSize =& $this->getSetting($this->_textSizeId);
// 		$styles .= "\n\t\t\t\tfont-size: ".$textSize->getValue().";";
// 		
// 		$padding =& $this->getSetting($this->_paddingId);
// 		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a <div ...> ... </div>
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='menuitem1'>";
		
		$layoutOrContent->output();
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}

/**
 * The main Heading Widget for the SimpleLines theme.
 *
 * @package harmoni.themes
 * @version $Id: SimpleLines.theme.php,v 1.3 2004/03/05 22:26:18 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesHeading1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesHeading1 () {
		// Set the Display Name:
		$this->_displayName = "HeadingItem 1";
		
		// Set the Descripiton:
		$this->_description = "A prominent heading item.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_textColorId =& $this->addSetting(new ColorSetting);
// 		$this->_linkColorId =& $this->addSetting(new LinkColorSetting);
// 		$this->_backgroundColorId =& $this->addSetting(new BackgroundColorSetting);
// 		$this->_hooverBackgroundColorId =& $this->addSetting(new HooverBackgroundColorSetting);
// 		$this->_textSizeId =& $this->addSetting(new TextSizeSetting);
// 		$this->_paddingId =& $this->addSetting(new PaddingSetting);
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's <head><style> section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.heading1 {";
		
		$textColor =& $this->getSetting($this->_textColorId);
		$styles .= "\n\t\t\t\tcolor: #".$textColor->getValue().";";
		
// 		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
// 		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
// 		
// 		$textSize =& $this->getSetting($this->_textSizeId);
// 		$styles .= "\n\t\t\t\tfont-size: ".$textSize->getValue().";";
// 		
// 		$padding =& $this->getSetting($this->_paddingId);
// 		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a <div ...> ... </div>
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='headingitem1'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}




?>