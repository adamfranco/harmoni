<?

require_once(HARMONI."/themeHandler/ThemeWidget.abstract.php");
require_once(HARMONI."/themeHandler/common_settings/ColorSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/SizeSetting.class.php");
require_once(HARMONI."/themeHandler/common_settings/BorderSetting.class.php");

require_once(dirname(__FILE__)."/ImageBoxImageSetting.class.php");

/**
 * The main TextBlock Widget for the ImageBox theme.
 *
 * @package harmoni.themes
 * @version $Id: ImageBoxTextBlock1.widget.php,v 1.2 2004/04/06 21:34:43 adamfranco Exp $
 * @copyright 2004 
 **/

class ImageBoxTextBlock1
	extends ThemeWidget {
	
	/**
	 * Constructor.
	 */
 	function ImageBoxTextBlock1 () {
		// Set the Display Name:
		$this->_displayName = "TextBlock 1";
		
		// Set the Descripiton:
		$this->_description = "The main block that most of the page content goes in.";
		
		// Set up any Setting objects for this theme and add them.
		$this->_borderImageId =& $this->addSetting(new ImageBoxImageSetting, "Image Set", "Which image set to use for the main block's border.", "dropshadow");
		$this->_backgroundColorId =& $this->addSetting(new ColorSetting, "Background Color", "The color of the main block background.", "ffffff");
		$this->_borderColorId =& $this->addSetting(new ColorSetting, "Border Color", "The color of the main block's border.", "000000");
		$this->_leftTopBorderThicknessId =& $this->addSetting(new SizeSetting, "Top/Left Border Size", "The size of the top and left sides of the main block's border.", "1px");
		$this->_rightBottomBorderThicknessId =& $this->addSetting(new SizeSetting, "Bottom/Right Border Size", "The size of the top and left sides of the main block's border.", "3px");
		$this->_paddingId =& $this->addSetting(new SizeSetting, "Padding", "The size (in px) of padding on the inside of the main block.", "10px");
 	}

	/**
	 * Returns a SettingsIterator object with this ThemeWidget's ThemeSetting objects.
	 * @access public
	 * @return string A set of CSS styles corresponding to this widget's settings. These
	 *		are to be inserted into the page's <head><style> section.
	 **/
	function getStyles () {	 
		$styles = "\n\n\t\t\t.textblock1 {";
		
		$backgroundColor =& $this->getSetting($this->_backgroundColorId);
		$styles .= "\n\t\t\t\tbackground-color: #".$backgroundColor->getValue().";";
	
 		$borderColor =& $this->getSetting($this->_borderColorId);
 		$leftTopBorderThickness =& $this->getSetting($this->_leftTopBorderThicknessId);
 		$rightBottomBorderThickness =& $this->getSetting($this->_rightBottomBorderThicknessId);
 		$borderImage =& $this->getSetting($this->_borderImageId);
 		
// 		$styles .= "\n\t\t\t\tborder-top: ".$leftTopBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
//  		$styles .= "\n\t\t\t\tborder-left: ".$leftTopBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
//  		$styles .= "\n\t\t\t\tborder-right: ".$rightBottomBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
//  		$styles .= "\n\t\t\t\tborder-bottom: ".$rightBottomBorderThickness->getValue()." ".$borderStyle->getValue()." #".$borderColor->getValue().";";
//  
		$padding =& $this->getSetting($this->_paddingId);
		$styles .= "\n\t\t\t\tpadding: ".$padding->getValue().";";

		$styles .= "\n\t\t\t\tmargin: 0px;";
		
		$styles .= "\n\t\t\t\tmin-width: 800px;";
//		$styles .= "\n\t\t\t\toverflow: visible;";
		
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t.imageborder {";
		$styles .= "\n\t\t\t\tmargin: 0px";
		$styles .= "\n\t\t\t\tpadding: 0px";
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t#topleft {";
		$styles .= "\n\t\t\t\tbackground: url('".$this->_getImageDir()."topleft.png') no-repeat;";
		$styles .= "\n\t\t\t\twidth: 25px;";
		$styles .= "\n\t\t\t\theight: 25px;";
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t#top {";
		$styles .= "\n\t\t\t\tbackground: url('".$this->_getImageDir()."top.png') repeat-x;";
		$styles .= "\n\t\t\t\theight: 25px;";
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t#topright {";
		$styles .= "\n\t\t\t\tbackground: url('".$this->_getImageDir()."topright.png') no-repeat;";
		$styles .= "\n\t\t\t\twidth: 25px;";
		$styles .= "\n\t\t\t\theight: 25px;";
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t#left {";
		$styles .= "\n\t\t\t\tbackground: url('".$this->_getImageDir()."left.png') repeat-y;";
		$styles .= "\n\t\t\t\twidth: 25px;";
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t#right {";
		$styles .= "\n\t\t\t\tbackground: url('".$this->_getImageDir()."right.png') repeat-y;";
		$styles .= "\n\t\t\t\twidth: 25px;";
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t#bottomleft {";
		$styles .= "\n\t\t\t\tbackground: url('".$this->_getImageDir()."bottomleft.png') no-repeat;";
		$styles .= "\n\t\t\t\twidth: 25px;";
		$styles .= "\n\t\t\t\theight: 25px;";
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t#bottom {";
		$styles .= "\n\t\t\t\tbackground: url('".$this->_getImageDir()."bottom.png') repeat-x;";
		$styles .= "\n\t\t\t\theight: 25px;";
		$styles .= "\n\t\t\t}";
		
		$styles .= "\n\n\t\t\t#bottomright {";
		$styles .= "\n\t\t\t\tbackground: url('".$this->_getImageDir()."bottomright.png') no-repeat;";
		$styles .= "\n\t\t\t\twidth: 25px;";
		$styles .= "\n\t\t\t\theight: 25px;";
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
		
		print "\n".$this->_getTabs($depth)."<table cellspacing='0px' cellpadding='0px' class='imageborder'>";
		
		//Top border row
		print "\n".$this->_getTabs($depth)."\t<tr>";
		print "\n".$this->_getTabs($depth)."\t\t<td class='imageborder' id='topleft'></td>";
		print "\n".$this->_getTabs($depth)."\t\t<td class='imageborder' id='top'></td>";
		print "\n".$this->_getTabs($depth)."\t\t<td class='imageborder' id='topright'></td>";
		print "\n".$this->_getTabs($depth)."\t</tr>";
		
		// Center border/content/border row
		print "\n".$this->_getTabs($depth)."\t<tr>";
		print "\n".$this->_getTabs($depth)."\t\t<td class='imageborder' id='left'></td>";
//		print "\n".$this->_getTabs($depth)."\t\t<td class='imageborder' id='left' valign='top'><img src='".$this->_getImageDir()."lefttop.png'></td>";
		print "\n".$this->_getTabs($depth)."\t\t<td>";
		
		// Content
		print "\n".$this->_getTabs($depth)."<div class='textblock1'>";
		$layoutOrContent->output($currentTheme);
		print "\n".$this->_getTabs($depth)."</div>";
		
		print "\n".$this->_getTabs($depth)."\t\t</td>";
		print "\n".$this->_getTabs($depth)."\t\t<td class='imageborder' id='right'> &nbsp; </td>";
		print "\n".$this->_getTabs($depth)."\t</tr>";
		
		// Bottom border row
		print "\n".$this->_getTabs($depth)."\t<tr>";
		print "\n".$this->_getTabs($depth)."\t\t<td class='imageborder' id='bottomleft'></td>";
		print "\n".$this->_getTabs($depth)."\t\t<td class='imageborder' id='bottom'></td>";
		print "\n".$this->_getTabs($depth)."\t\t<td class='imageborder' id='bottomright'></td>";
		print "\n".$this->_getTabs($depth)."\t</tr>";
		
		print "\n".$this->_getTabs($depth)."</table>";
	}
	
	function _getImageDir() {
		$borderImage =& $this->getSetting($this->_borderImageId);
		
		$themedir = str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(__FILE__));
		
		$imageDir = $themedir."/images/".$borderImage->getValue()."/";
		
		return $imageDir;
	}
}

?>