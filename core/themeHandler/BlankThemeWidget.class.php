<?php

require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");

/**
 * The Blank Widget. Just passes through layouts without any styling.
 *
 * @package harmoni.themes
 * @version $Id: BlankThemeWidget.class.php,v 1.2 2004/03/11 16:57:32 adamfranco Exp $
 * @copyright 2004 
 **/

class Blank
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function Blank () {
		// Set the Display Name:
		$this->_displayName = "Blank";
		
		// Set the Descripiton:
		$this->_description = "An empty widget.";
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's <head><style> section.
	 **/
	function getStyles () {		
		return "";
	}
	
	/**
	 * Takes a {@link Layout} or {@link Content} object and prints a <div ...> ... </div>
	 * block with the layout's contents or content inside.
	 * @param ref object $layoutOrContent The {@link Layout} object or {@link Content} object.
	 * @access public
	 * @return void
	 **/
	function output (& $layoutOrContent, & $currentTheme) {
		ArgumentValidator::validate($layoutOrContent, new ExtendsValidatorRule("VisualComponent"));
		ArgumentValidator::validate($currentTheme, new ExtendsValidatorRule("ThemeInterface"));
		
		$layoutOrContent->output($currentTheme);
	}
}




?>