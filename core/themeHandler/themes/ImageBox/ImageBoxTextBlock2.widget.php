<?

require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");


/**
 * A TextBlock Widget for the ImageBox theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: ImageBoxTextBlock2.widget.php,v 1.2 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class ImageBoxTextBlock2
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function ImageBoxTextBlock2 () {
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
	 * Takes a {@link Layout} or {@link Content} object and prints a &lt;div ...&gt; ... &lt;div&gt;
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


?>