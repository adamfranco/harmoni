<?php

require_once(HARMONI."/themeHandler/Theme.abstract.php");
require_once(HARMONI."/themeHandler/BlankThemeWidget.class.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");

require_once(dirname(__FILE__)."/ImageBoxFooter1.widget.php");
require_once(dirname(__FILE__)."/ImageBoxHeading1.widget.php");
require_once(dirname(__FILE__)."/ImageBoxHeading2.widget.php");
require_once(dirname(__FILE__)."/ImageBoxMenu1.widget.php");
require_once(dirname(__FILE__)."/ImageBoxMenuHeading1.widget.php");
require_once(dirname(__FILE__)."/ImageBoxMenuItem1.widget.php");
require_once(dirname(__FILE__)."/ImageBoxSelectedMenuItem1.widget.php");
require_once(dirname(__FILE__)."/ImageBoxTextBlock1.widget.php");
require_once(dirname(__FILE__)."/ImageBoxTextBlock2.widget.php");
require_once(dirname(__FILE__)."/ImageBoxTextBlock3.widget.php");

/**
 * A simple line and color-block based theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: ImageBox.theme.php,v 1.2 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class ImageBoxTheme
	extends Theme {
	
	/**
	 * Constructor, throws an error since this is an abstract class.
	 * The constructor as well as the print(& $layoutObj) method will need to be
	 * implimented for any classes that extend this abstract class.
	 */
 	function ImageBoxTheme () {
 
		// Set the Display Name:
		$this->_displayName = "Image Box Theme";
		
		// Set the Descripiton:
		$this->_description = "A Theme highlight by a drop-shadow/bevel/etc around the main text block.";
	
		// Set up any Setting objects for this theme and add them.
		$this->_bodyColorId =& $this->addSetting(new ColorSetting, "Body Color", "The color of the page body.", "aaaaaa");
				
		// Set up our widgets:
		// In this example there are two types of menus and one type of everything else.
		$this->addWidget(BLANK_WIDGET, new Blank);
		$this->addWidget(TEXT_BLOCK_WIDGET, new ImageBoxTextBlock1);
		$this->addWidget(TEXT_BLOCK_WIDGET, new ImageBoxTextBlock2);
		$this->addWidget(TEXT_BLOCK_WIDGET, new ImageBoxTextBlock3);
		$this->addWidget(MENU_WIDGET, new ImageBoxMenu1);
		$this->addWidget(MENU_ITEM_WIDGET, new ImageBoxMenuItem1);
		$this->addWidget(SELECTED_MENU_ITEM_WIDGET, new ImageBoxSelectedMenuItem1);
		$this->addWidget(MENU_HEADING_WIDGET, new ImageBoxMenuHeading1);
		$this->addWidget(HEADING_WIDGET, new ImageBoxHeading1);
		$this->addWidget(HEADING_WIDGET, new ImageBoxHeading2);
		$this->addWidget(FOOTER_WIDGET, new ImageBoxFooter1);
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

?>