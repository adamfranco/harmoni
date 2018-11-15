<?php

require_once(HARMONI."GUIManager/MenuTheme.abstract.php");

require_once(HARMONI."GUIManager/Container.class.php");

require_once(HARMONI."GUIManager/StyleCollection.class.php");

require_once(HARMONI."GUIManager/StyleProperty.class.php");

require_once(HARMONI."GUIManager/StyleProperties/FontFamilySP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontWeightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontSizeSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BackgroundColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TextAlignSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/OverflowSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginTopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginLeftSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginRightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TextDecorationSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/WidthSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/HeightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderTopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FloatSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingTopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingBottomSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingLeftSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingRightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/DisplaySP.class.php");

require_once(HARMONI."GUIManager/StyleComponents/ColorSC.class.php");

require_once(HARMONI."GUIManager/Components/Menu.class.php");
require_once(HARMONI."GUIManager/Components/MenuItemLink.class.php");

require_once(HARMONI."GUIManager/Layouts/FlowLayout.class.php");

/**
 * An implementation of a Dobomode theme (as seen on www.dobomode.com)
 * 
 * @package harmoni.gui
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DobomodeTheme.class.php,v 1.2 2007/09/04 20:25:23 adamfranco Exp $
 **/
class DobomodeTheme extends MenuThemeAbstract {

	/**
	 * This is a wrapper component that is used to center and resize the 
	 * contents of the page.
	 * @attribute private object _wrapper
	 */
	var $_wrapper;
	
	/**
	 * This is the main container into which all non-menu content will go.
	 * @attribute private object _main
	 */
	var $_main;

	/**
	 * The constructor. All initialization and Theme customization is performed
	 * here.
	 * @access public
	 **/
	function __construct() {
		parent::__construct("Dobomode Theme", "The Dobomode Theme by Dobo Radichkov. Visit <a href=\"http://www.dobomode.com\">www.dobomode.com</a> for more information.");

		// Add some global styles

		// =====================================================================
		// body
		$style = new StyleCollection("body", null, "Global Style", "Style settings affecting the overall look and feel.");
		$style->addSP(new FontFamilySP("'Arial', 'Helvetica', 'Verdana'"));
		$style->addSP(new FontSizeSP("10pt"));
		$style->addSP(new ColorSP("#262D34"));
		$style->addSP(new BackgroundColorSP("#5D7D9C"));
		$style->addSP(new TextAlignSP("center"));
		$style->addSP(new OverflowSP("auto"));
		$style->addSP(new MarginSP("0px"));
		// the following scrollbar style properties are not part of GUIManager
		// create them manually
		$sp = new StyleProperty("scrollbar-face-color","Scrollbar Face Color","Scrollbar Face Color");
		$sp->addSC(new ColorSC("#A4B9CD")); $style->addSP($sp);
		$sp = new StyleProperty("scrollbar-shadow-color","Scrollbar Shadow Color","Scrollbar Shadow Color");
		$sp->addSC(new ColorSC("#A4B9CD")); $style->addSP($sp);
		$sp = new StyleProperty("scrollbar-highlight-color","Scrollbar Highlight Color","Scrollbar Highlight Color");
		$sp->addSC(new ColorSC("#FFFFFF")); $style->addSP($sp);
		$sp = new StyleProperty("scrollbar-darkshadow-color","Scrollbar Darkshadow Color","Scrollbar Darkshadow Color");
		$sp->addSC(new ColorSC("#262D34")); $style->addSP($sp);
		$sp = new StyleProperty("scrollbar-3dlight-color","Scrollbar 3D Light Color","Scrollbar 3D Light Color");
		$sp->addSC(new ColorSC("#262D34")); $style->addSP($sp);
		$sp = new StyleProperty("scrollbar-track-color","Scrollbar Track Track","Scrollbar Track Color");
		$sp->addSC(new ColorSC("#4C5A68")); $style->addSP($sp);
		$sp = new StyleProperty("scrollbar-arrow-color","Scrollbar Arrow Color","Scrollbar Arrow Color");
		$sp->addSC(new ColorSC("#262D34")); $style->addSP($sp);
		$this->addGlobalStyle($style);		
		
		// =====================================================================
		// anchors
		$style = new StyleCollection("a", null, "Link Style", "Style settings affecting the look and feel of links.");
		$style->addSP(new TextDecorationSP("none"));
		$style->addSP(new FontFamilySP("'Verdana', 'Arial', 'Helvetica'"));
		$style->addSP(new ColorSP("#323B44"));
		$this->addGlobalStyle($style);
		$style = new StyleCollection("a:hover", null, "Link Hover Style", "Style settings affecting the look and feel of links when the mouse pointer is over them.");
		$style->addSP(new ColorSP("#FFFFFF"));
		$this->addGlobalStyle($style);
		
		
		
		// =====================================================================
		// initialize wrapper object
		$style = new StyleCollection("*.wrapper", "wrapper", "Wrapper Style", "Style settings for wrapper component.");
		$style->addSP(new WidthSP("700px"));
		$style->addSP(new MarginSP("auto"));
		$style->addSP(new TextAlignSP("left"));
		$this->_wrapper = new Container(new FlowLayout(), BLOCK, 0, $style);
		
		// =====================================================================
		// initialize main container object
		$style = new StyleCollection("*.main", "main", "Main Box Style", "Style settings for main content box.");
		$style->addSP(new FloatSP("right"));
		// total width with borders and padding = 500
		$style->addSP(new WidthSP("468px"));
		// total height with borders and padding = 400
		$style->addSP(new HeightSP("356px"));
		$style->addSP(new OverflowSP("auto"));
		$style->addSP(new BackgroundColorSP("#CFDBE6"));
		$style->addSP(new BorderSP("1px", "solid", "#262D34"));
		$style->addSP(new BorderTopSP("3px", "solid", "#262D34"));
		$style->addSP(new MarginTopSP("20px"));
		$style->addSP(new MarginLeftSP("10px"));
		$style->addSP(new PaddingTopSP("20px"));
		$style->addSP(new PaddingBottomSP("20px"));
		$style->addSP(new PaddingLeftSP("15px"));
		$style->addSP(new PaddingRightSP("15px"));
		$this->_main = new Container(new FlowLayout(), BLOCK, 0, $style);
		$this->_wrapper->add($this->_main);
		
		// =====================================================================
		// initialize main menu
		// styles for level 1 menu
		$style = new StyleCollection("*.menu_1", "menu_1", "Level 1 Menu Style", "Style settings for level 1 menus.");
		$style->addSP(new FloatSP("left"));
		// total width with borders and padding = 160
		$style->addSP(new WidthSP("138px"));
		$style->addSP(new OverflowSP("hidden"));
		$style->addSP(new BackgroundColorSP("#CFDBE6"));
		$style->addSP(new BorderSP("1px", "solid", "#262D34"));
		$style->addSP(new BorderTopSP("3px", "solid", "#262D34"));
		$style->addSP(new MarginTopSP("20px"));
		$style->addSP(new MarginRightSP("10px"));
		$style->addSP(new PaddingBottomSP("10px"));
		$style->addSP(new PaddingLeftSP("10px"));
		$style->addSP(new PaddingRightSP("10px"));
		$this->addStyleForComponentType($style, MENU, 1);
		// styles for level 1 menu item links
		$style = new StyleCollection("*.menu_item_link_1 a", "menu_item_link_1", "Level 1 Menu Link Style", "Style settings for level 1 menu links.");
		$style->addSP(new BackgroundColorSP("#A4B9CD"));
		$style->addSP(new ColorSP("#262D34"));
		$style->addSP(new BorderSP("1px", "solid", "#262D34"));
		$style->addSP(new FontFamilySP("'Verdana', 'Arial', 'Helvetica'"));
		$style->addSP(new FontWeightSP("bold"));
		$style->addSP(new TextAlignSP("center"));
		$style->addSP(new MarginSP("8px"));
		$style->addSP(new MarginTopSP("15px"));
		$style->addSP(new PaddingSP("3px"));
		$style->addSP(new DisplaySP("block"));
		$this->addStyleForComponentType($style, MENU_ITEM_LINK_SELECTED, 1);
		$this->addStyleForComponentType($style, MENU_ITEM_LINK_UNSELECTED, 1);
		$style = new StyleCollection("*.menu_item_link_1 a:hover", "menu_item_link_1", "Level 1 Menu Link Hover Style", "Hover style settings for level 1 menu links.");
		$style->addSP(new BackgroundColorSP("#4C5A68"));
		$style->addSP(new ColorSP("#FFFFFF"));
		$this->addStyleForComponentType($style, MENU_ITEM_LINK_UNSELECTED, 1);
		$style = new StyleCollection("*.menu_item_link_selected_1 a", "menu_item_link_selected_1", "Level 1 Selected Menu Link Style", "Style settings for level 1 selected menu links.");
		$style->addSP(new BorderSP("2px", "solid", "#262D34"));
		$style->addSP(new BackgroundColorSP("#4C5A68"));
		$style->addSP(new ColorSP("#FFFFFF"));
		$this->addStyleForComponentType($style, MENU_ITEM_LINK_SELECTED, 1);
		// styles for level 1 menu item headings
		$style = new StyleCollection("*.menu_item_heading_1", "menu_item_heading_1", "Level 1 Menu Heading", "Style settings for level 1 menu heading.");
		$style->addSP(new ColorSP("#000000"));
		$style->addSP(new FontFamilySP("'Verdana', 'Arial', 'Helvetica'"));
		$style->addSP(new FontWeightSP("bold"));
		$style->addSP(new TextAlignSP("center"));
		$style->addSP(new MarginTopSP("10px"));
		$style->addSP(new DisplaySP("block"));
		$this->addStyleForComponentType($style, MENU_ITEM_HEADING, 1);
		// styles for level 2 menu
		$style = new StyleCollection("*.menu_2", "menu_2", "Level 2 Menu Style", "Style settings for level 2 menus.");
		$style->addSP(new FloatSP("left"));
		$style->addSP(new FontSizeSP("8pt"));
		// total width with borders and padding = 120
		$style->addSP(new WidthSP("108px"));
		$style->addSP(new OverflowSP("hidden"));
		$style->addSP(new BackgroundColorSP("#CFDBE6"));
		$style->addSP(new BorderSP("1px", "solid", "#262D34"));
		$style->addSP(new BorderTopSP("3px", "solid", "#262D34"));
		$style->addSP(new MarginTopSP("20px"));
		$style->addSP(new MarginLeftSP("20px"));
		$style->addSP(new MarginRightSP("20px"));
		$style->addSP(new PaddingBottomSP("5px"));
		$style->addSP(new PaddingLeftSP("5px"));
		$style->addSP(new PaddingRightSP("5px"));
		$this->addStyleForComponentType($style, MENU, 2);
		// styles for level 2 menu item links
		$style = new StyleCollection("*.menu_item_link_2 a", "menu_item_link_2", "Level 2 Menu Link Style", "Style settings for level 2 menu links.");
		$style->addSP(new BackgroundColorSP("#A4B9CD"));
		$style->addSP(new ColorSP("#262D34"));
		$style->addSP(new BorderSP("1px", "solid", "#262D34"));
		$style->addSP(new FontFamilySP("'Verdana', 'Arial', 'Helvetica'"));
		$style->addSP(new FontWeightSP("bold"));
		$style->addSP(new TextAlignSP("center"));
		$style->addSP(new MarginSP("5px"));
		$style->addSP(new MarginTopSP("5px"));
		$style->addSP(new PaddingSP("1px"));
		$style->addSP(new DisplaySP("block"));
		$this->addStyleForComponentType($style, MENU_ITEM_LINK_SELECTED, 2);
		$this->addStyleForComponentType($style, MENU_ITEM_LINK_UNSELECTED, 2);
		$style = new StyleCollection("*.menu_item_link_2 a:hover", "menu_item_link_2", "Level 2 Menu Link Hover Style", "Hover style settings for level 2 menu links.");
		$style->addSP(new BackgroundColorSP("#4C5A68"));
		$style->addSP(new ColorSP("#FFFFFF"));
		$this->addStyleForComponentType($style, MENU_ITEM_LINK_UNSELECTED, 2);
		$style = new StyleCollection("*.menu_item_link_selected_2 a", "menu_item_link_selected_2", "Level 2 Selected Menu Link Style", "Style settings for level 2 selected menu links.");
		$style->addSP(new BorderSP("2px", "solid", "#262D34"));
		$style->addSP(new BackgroundColorSP("#4C5A68"));
		$style->addSP(new ColorSP("#FFFFFF"));
		$this->addStyleForComponentType($style, MENU_ITEM_LINK_SELECTED, 2);
		
	}
	
	
	/**
	 * Overloads the normal <code>setComponent</code> method - sets the Theme
	 * component to the wrapper component and adds the argument to the latter.
	 * @access public
	 * @param ref object A component.
	 **/
	function setComponent($component) {
		parent::setComponent($this->_wrapper);
		$this->_main->removeAll();
		$this->_main->add($component);
	}	

	/**
	 * Prints the HTML page.
	 * @access public
	 **/
	function printPage() {
		// before printing, add menus to Theme component
		foreach (array_keys($this->_menus) as $i => $level)
			$this->_wrapper->add($this->_menus[$level]);
		
		parent::printPage();
	}	
}


//
//ul {
//	margin-left: 65px;
//}
//
//ul.sub {
//	list-style: circle;
//}
//
//div.text {
//	text-align: justify;
///*	text-indent: 3em; */
//	cursor: default;
//}
//
//div.text:first-letter {
///*	font-weight: bold; */
//	text-transform: capitalize;
//}
//
//div.title1 {
//	text-align: center;
//	font-size: small;
//	cursor: default;
//	font-family: "Arial Black", sans-serif;
//}
//
//span {
//	text-align: justify;
//}
//
//
//
//
//form {
//	text-align: center;
//}
//
//input, textarea {
//	margin-bottom: 5px;
//	border: 1px solid #262D34;
//	font-size: xx-small;
//	font-family: 'Verdana','Helvetica';
//}
//
//input:focus, textarea:focus {
//	border-color: #036;
//}
//
//input.textfield, textarea {
//	width: 300px;
//}
//
//textarea {
//	overflow: auto;
//	height: 140px;
//}
//
//input.button {
//	cursor: hand;
//}
//
//span.label {
//	cursor: default;
//	width: 65px;
//	text-align: right;
//	font-size: xx-small;
//	font-weight: bolder;
//	vertical-align: top;
//	color: #036;
//}
//
//hr {
//	color: #262D34;
//	height: 1px;
//}
//
//div.col1 {
//	padding: 10px;
//	background-color: #A4B9CD;
//	text-align: left;
//}
//
//div.col2 {
//	padding: 10px;
//	background-color: #CFDBE6;
//	text-align: left;
//}
//
//div.cnt {
//	background-color: #CFDBE6;
//	width: 500px;
//	float: right;
//	border-top: 0px solid #262D34;
//	border-right: 1px solid #262D34;
//	border-bottom: 1px solid #262D34;
//	border-left: 1px solid #262D34;
//	text-align: right;
//	font-size: xx-small;
//	padding: 2px 5px 1px 5px;
//}
//
//img {
//	border: #262D34 solid 1px;
//}
//
?>