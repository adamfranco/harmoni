<?

require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");


/**
 * The main Heading Widget for the ImageBox theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: ImageBoxHeading1.widget.php,v 1.2 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class ImageBoxHeading1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function ImageBoxHeading1 () {
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

?>