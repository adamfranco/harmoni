<?

require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");

/**
 * A MenuHeading Widget for the ImageBox theme.
 *
 * @package harmoni.themes
 * @version $Id: ImageBoxMenuHeading1.widget.php,v 1.1 2004/04/06 20:16:47 adamfranco Exp $
 * @copyright 2004 
 **/

class ImageBoxMenuHeading1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function ImageBoxMenuHeading1 () {
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
	 *		are to be inserted into the page's <head><style> section.
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
	 * Takes a {@link Layout} or {@link Content} object and prints a <div ...> ... </div>
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

?>