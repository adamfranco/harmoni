<?

require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");


/**
 * A secondary Heading Widget for the ImageBox theme.
 *
 * @package harmoni.themes
 * @version $Id: ImageBoxHeading2.widget.php,v 1.1 2004/04/06 20:16:47 adamfranco Exp $
 * @copyright 2004 
 **/

class ImageBoxHeading2
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function ImageBoxHeading2 () {
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
	 *		are to be inserted into the page's <head><style> section.
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
	 * Takes a {@link Layout} or {@link Content} object and prints a <div ...> ... </div>
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

?>