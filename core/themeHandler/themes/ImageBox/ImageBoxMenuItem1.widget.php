<?

require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");


/**
 * A MenuItem Widget for the ImageBox theme.
 *
 * @package harmoni.themes.included_themes
 * @version $Id: ImageBoxMenuItem1.widget.php,v 1.2 2004/04/21 17:55:44 adamfranco Exp $
 * @copyright 2004 
 **/

class ImageBoxMenuItem1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function ImageBoxMenuItem1 () {
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


?>