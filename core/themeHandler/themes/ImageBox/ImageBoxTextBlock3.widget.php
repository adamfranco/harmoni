<?

require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");


/**
 * A TextBlock Widget for the ImageBox theme.
 *
 * @package harmoni.themes.included_themes
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ImageBoxTextBlock3.widget.php,v 1.4 2005/01/19 21:10:15 adamfranco Exp $
 */
class ImageBoxTextBlock3
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function ImageBoxTextBlock3 () {
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
		$styles .= "\n\t\t\t\tmargin: 10px;";
		
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
		print "\n".$this->_getTabs($depth)."<div class='textblock3'>";
		
		$layoutOrContent->output($currentTheme);
		
		print "\n".$this->_getTabs($depth)."</div>";
	}
}

?>