<?

require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");



/**
 * The main Heading Widget for the ImageBox theme.
 *
 * @package harmoni.themes
 * @version $Id: ImageBoxFooter1.widget.php,v 1.1 2004/04/06 20:16:47 adamfranco Exp $
 * @copyright 2004 
 **/

class ImageBoxFooter1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function ImageBoxFooter1 () {
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
	 *		are to be inserted into the page's <head><style> section.
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
	 * Takes a {@link Layout} or {@link Content} object and prints a <div ...> ... </div>
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

?>