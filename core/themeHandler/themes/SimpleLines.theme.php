<?php

require_once(HARMONI."/themeHandler/Theme.abstract.php");
require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/BlankThemeWidget.class.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");

/**
 * A simple line and color-block based theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
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
		$this->addWidget(TEXT_BLOCK_WIDGET, new SimpleLinesTextBlock2);
		$this->addWidget(TEXT_BLOCK_WIDGET, new SimpleLinesTextBlock3);
		$this->addWidget(MENU_WIDGET, new SimpleLinesMenu1);
		$this->addWidget(MENU_ITEM_WIDGET, new SimpleLinesMenuItem1);
		$this->addWidget(SELECTED_MENU_ITEM_WIDGET, new SimpleLinesSelectedMenuItem1);
		$this->addWidget(MENU_HEADING_WIDGET, new SimpleLinesMenuHeading1);
		$this->addWidget(HEADING_WIDGET, new SimpleLinesHeading1);
		$this->addWidget(HEADING_WIDGET, new SimpleLinesHeading2);
		$this->addWidget(FOOTER_WIDGET, new SimpleLinesFooter1);
	}

	/**
	 * Returns a SettingsIterator object with this Theme's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this theme's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
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
		
		print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN' 'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>";
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
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesTextBlock1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesTextBlock1 () {
		// Set the Display Name:
		$this->_displayName = "TextBlock 1";
		
		// Set the Descripiton:
		$this->_description = "The main block that most of the page content goes in.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of the main block background.", "ffffff");
		$this->_borderColorId =& $this->addSetting(new ColorSetting, "Border Color", "The color of the main block's border.", "000000");
		$this->_leftTopBorderThicknessId =& $this->addSetting(new SizeSetting, "Top/Left Border Size", "The size of the top and left sides of the main block's border.", "1px");
		$this->_rightBottomBorderThicknessId =& $this->addSetting(new SizeSetting, "Bottom/Right Border Size", "The size of the top and left sides of the main block's border.", "3px");
		$this->_borderStyleId =& $this->addSetting(new BorderSetting, "Border Style", "The style of the main block's border.", "solid");
		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of padding on the inside of the main block.", "10px");
		$this->_marginId =& $this->addSetting(new SizeSetting, "Margin", "The size (in px) of margin around the outside of the main block.", "5px");
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.textblock1 {";
		
		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
	
 		$borderColor =& $this->getSetting($this->_borderColorId);
 		$leftTopBorderThickness =& $this->getSetting($this->_leftTopBorderThicknessId);
 		$rightBottomBorderThickness =& $this->getSetting($this->_rightBottomBorderThicknessId);
 		$borderStyle =& $this->getSetting($this->_borderStyleId);
 		
		$styles .= "\n\t\t\t\tborder-top: ".$leftTopBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
 		$styles .= "\n\t\t\t\tborder-left: ".$leftTopBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
 		$styles .= "\n\t\t\t\tborder-right: ".$rightBottomBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
 		$styles .= "\n\t\t\t\tborder-bottom: ".$rightBottomBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
 
		$padding =& $this->getSetting($this->_paddingId);
		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";

		$margin =& $this->getSetting($this->_marginId);
		$styles .= "\n\t\t\t\tmargin: ".$margin->getValue().";";
		
		$styles .= "\n\t\t\t\tmin-width: 800px;";
//		$styles .= "\n\t\t\t\toverflow: visible;";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;/div&gt;
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
 * A TextBlock Widget for the SimpleLines theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesTextBlock2
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesTextBlock2 () {
		// Set the Display Name:
		$this->_displayName = "TextBlock 2";
		
		// Set the Descripiton:
		$this->_description = "A text-block to go inside the main block.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of padding on the inside of this block.", "10px");
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.textblock2 {";
		
		$padding =& $this->getSetting($this->_paddingId);
		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;/div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='textblock2'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}



/**
 * A TextBlock Widget for the SimpleLines theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesTextBlock3
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesTextBlock3 () {
		// Set the Display Name:
		$this->_displayName = "TextBlock 3";
		
		// Set the Descripiton:
		$this->_description = "A third-level text block.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of this block's background.", "dddddd");
		$this->_borderColorId =& $this->addSetting(new ColorSetting, "Border Color", "The color of this block's border.", "000000");
		$this->_borderThicknessId =& $this->addSetting(new SizeSetting, "Top/Left Border Size", "The size of the top and left sides of this block's border.", "1px");
		$this->_borderStyleId =& $this->addSetting(new BorderSetting, "Border Style", "The style of this block's border.", "solid");
		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of padding on the inside of this block.", "10px");
//		$this->_marginId =& $this->addSetting(new SizeSetting, "Margin", "The size (in px) of margin around the outside of this block.", "0px");
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.textblock3 {";
		
		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
	
 		$borderColor =& $this->getSetting($this->_borderColorId);
 		$borderThickness =& $this->getSetting($this->_borderThicknessId);
 		$borderStyle =& $this->getSetting($this->_borderStyleId);
 		
		$styles .= "\n\t\t\t\tborder: ".$borderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";

		$padding =& $this->getSetting($this->_paddingId);
		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
// 
// 		$margin =& $this->getSetting($this->_marginId);
// 		$styles .= "\n\t\t\t\tmargin: ".$margin->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;/div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='textblock3'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}




/**
 * The main Heading Widget for the SimpleLines theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesHeading1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesHeading1 () {
		// Set the Display Name:
		$this->_displayName = "Heading 1";
		
		// Set the Descripiton:
		$this->_description = "A prominent heading item.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_textColorId =& $this->addSetting(new ColorSetting, "Main Heading Text Color", "The text-color of the main heading.", "ff0000");
// 		$this->_linkColorId =& $this->addSetting(new LinkColorSetting);
// 		$this->_backgroundColorId =& $this->addSetting(new BackgroundColorSetting);
// 		$this->_hooverBackgroundColorId =& $this->addSetting(new HooverBackgroundColorSetting);
 		$this->_textSizeId =& $this->addSetting(new SizeSetting, "Main Heading TextSize", "Size of the Header text in pixels", "200%");
// 		$this->_paddingId =& $this->addSetting(new PaddingSetting);
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.heading1 {";
		
		$textColor =& $this->getSetting($this->_textColorId);
		$styles .= "\n\t\t\t\tcolor: #".$textColor->getValue().";";
		
// 		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
// 		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
// 		
 		$textSize =& $this->getSetting($this->_textSizeId);
 		$styles .= "\n\t\t\t\tfont-size: ".$textSize->getValue().";";
// 		
// 		$padding =& $this->getSetting($this->_paddingId);
// 		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='heading1'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}



/**
 * A secondary Heading Widget for the SimpleLines theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesHeading2
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesHeading2 () {
		// Set the Display Name:
		$this->_displayName = "Heading 2";
		
		// Set the Descripiton:
		$this->_description = "A less-prominent heading item.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_textColorId =& $this->addSetting(new ColorSetting, "Text Color", "The text-color of the main heading.", "111177");
 		$this->_textSizeId =& $this->addSetting(new SizeSetting, "Text-Size", "Size of the Header text in pixels", "125%");
 		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of padding on the inside of this block.", "10px");
 		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of margin around this block.", "10px");
 		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of this block's background.", "dddddd");
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.heading2 {";
		
		$textColor =& $this->getSetting($this->_textColorId);
		$styles .= "\n\t\t\t\tcolor: #".$textColor->getValue().";";
		
		$styles .= "\n\t\t\t\tborder-top: 1px solid #000000;";
		
 		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
 		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
 		
 		$textSize =& $this->getSetting($this->_textSizeId);
 		$styles .= "\n\t\t\t\tfont-size: ".$textSize->getValue().";";
		
		$padding =& $this->getSetting($this->_paddingId);
		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t\tmargin: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='heading2'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}




/**
 * The main Heading Widget for the SimpleLines theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesFooter1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesFooter1 () {
		// Set the Display Name:
		$this->_displayName = "Footer 1";
		
		// Set the Descripiton:
		$this->_description = "A prominent footer item.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_textColorId =& $this->addSetting(new ColorSetting, "Main Footer Text Color", "The text-color of the main footer.", "999999");
// 		$this->_linkColorId =& $this->addSetting(new LinkColorSetting);
// 		$this->_backgroundColorId =& $this->addSetting(new BackgroundColorSetting);
// 		$this->_hooverBackgroundColorId =& $this->addSetting(new HooverBackgroundColorSetting);
 		$this->_textSizeId =& $this->addSetting(new SizeSetting, "Main Footer TextSize", "Size of the Header text in pixels", "125%");
// 		$this->_paddingId =& $this->addSetting(new PaddingSetting);
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.footer1 {";
		
		$textColor =& $this->getSetting($this->_textColorId);
		$styles .= "\n\t\t\t\tcolor: #".$textColor->getValue().";";
		
// 		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
// 		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
// 		
 		$textSize =& $this->getSetting($this->_textSizeId);
 		$styles .= "\n\t\t\t\tfont-size: ".$textSize->getValue().";";
// 		
// 		$padding =& $this->getSetting($this->_paddingId);
// 		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='footer1'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}




/**
 * A Menu Widget for the SimpleLines theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesMenu1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesMenu1 () {
		// Set the Display Name:
		$this->_displayName = "Menu 1";
		
		// Set the Descripiton:
		$this->_description = "A prominent Menu.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of this block's background.", "dddddd");
		$this->_borderColorId =& $this->addSetting(new ColorSetting, "Border Color", "The color of this block's border.", "000000");
		$this->_borderThicknessId =& $this->addSetting(new SizeSetting, "Top/Left Border Size", "The size of the top and left sides of this block's border.", "1px");
		$this->_borderStyleId =& $this->addSetting(new BorderSetting, "Border Style", "The style of this block's border.", "solid");
// 		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of padding on the inside of this block.", "10px");
//		$this->_marginId =& $this->addSetting(new SizeSetting, "Margin", "The size (in px) of margin around the outside of this block.", "0px");
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.menu1 {";
		
		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
	
 		$borderColor =& $this->getSetting($this->_borderColorId);
 		$borderThickness =& $this->getSetting($this->_borderThicknessId);
 		$borderStyle =& $this->getSetting($this->_borderStyleId);
 		
		$styles .= "\n\t\t\t\tborder: ".$borderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";

// 		$padding =& $this->getSetting($this->_paddingId);
// 		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
// 
// 		$margin =& $this->getSetting($this->_marginId);
// 		$styles .= "\n\t\t\t\tmargin: ".$margin->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='menu1'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}




/**
 * A MenuHeading Widget for the SimpleLines theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesMenuHeading1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesMenuHeading1 () {
		// Set the Display Name:
		$this->_displayName = "MenuHeading 1";
		
		// Set the Descripiton:
		$this->_description = "A prominent Menu Heading.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of this block's background.", "dddddd");
		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of padding on the inside of this block.", "10px");
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.menuheading1 {";
		
		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";

		$padding =& $this->getSetting($this->_paddingId);
		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t\tfont-weight: bold;";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='menuheading1'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}




/**
 * A MenuItem Widget for the SimpleLines theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesMenuItem1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesMenuItem1 () {
		// Set the Display Name:
		$this->_displayName = "MenuItem 1";
		
		// Set the Descripiton:
		$this->_description = "A main-menu item.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of this block's background.", "dddddd");
		$this->_hoverBackgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of this block's background when hovering.", "aaaaaa");
		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of padding on the inside of this block.", "10px");
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.menuitem1 {";
		
		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
	
		$padding =& $this->getSetting($this->_paddingId);
		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t.menuitem1:hover {";
		
		$hoverBackgroundColor =& $this->getSetting($this->_hoverBackgroundColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$hoverBackgroundColor->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='menuitem1'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}


/**
 * A MenuItem Widget for the SimpleLines theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: SimpleLines.theme.php,v 1.9 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class SimpleLinesSelectedMenuItem1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function SimpleLinesSelectedMenuItem1 () {
		// Set the Display Name:
		$this->_displayName = "SelectedMenuItem 1";
		
		// Set the Descripiton:
		$this->_description = "A selected menu item corresponding to MenuItem1";
		
		// Set up any Setting objects for this theme and add them.
		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of this block's background.", "aaaaaa");
		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of padding on the inside of this block.", "10px");
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's &lt;head&gt;&lt;style&gt; section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.selectedmenuitem1 {";
		
		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
	
		$padding =& $this->getSetting($this->_paddingId);
		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";
		
		$styles .= "\n\t\t\t}";
		
		return $styles;
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;div&gt;
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		$depth = $layoutOrContent->getLevel();
		print "\n".$this->_getTabs($depth)."<div class='selectedmenuitem1'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}
?>