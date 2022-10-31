<?php

require_once(HARMONI."GUIManager/Theme.class.php");

require_once(HARMONI."GUIManager/StyleCollection.class.php");

require_once(HARMONI."GUIManager/StyleProperties/BackgroundColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderTopSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderRightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderBottomSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/BorderLeftSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontFamilySP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontSizeSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/FontWeightSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TextAlignSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/TextDecorationSP.class.php");
require_once(HARMONI."GUIManager/StyleProperties/DisplaySP.class.php");

/**
 * A very basic theme based on simple borders and colored blocks.
 * <br /><br />
 * A <code>Theme</code> is a combination of two things: first, it stores a variety
 * of reusable <code>StyleCollections</code> and second, it offers a mechanism for
 * printing an HTML web page.
 * <br /><br />
 * Each <code>Theme</code> has a set of style collections that correspond to 
 * each component type.
 * <br /><br />
 * Each <code>Theme</code> has a single component (could be container) that will
 * be printed when <code>printPage()</code> is called.
 *
 * @package harmoni.gui.themes
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: NiksTheme.class.php,v 1.3 2007/09/04 20:25:23 adamfranco Exp $
 */
class NiksTheme extends Theme {

	/**
	 * The constructor. All initialization and Theme customization is performed
	 * here.
	 * @access public
	 **/
	function __construct() {
		parent::__construct("Nik's Theme", "A basic theme based on simple borders and colored blocks.");
		
		// =====================================================================
		// global Theme style
		$body = new StyleCollection("body", null, "Global Style", "Style settings affecting the overall look and feel.");
		$sp1 = new BackgroundColorSP("#AAA");
		$body->addSP($sp1);
		$this->registerSP($sp1);
		$body->addSP(new ColorSP("#000"));
		$sp2 = new FontSP("Times New Roman","12px");
		$this->registerSP($sp2);
		$body->addSP($sp2);
		$body->addSP(new PaddingSP("0px"));
		$body->addSP(new MarginSP("0px"));
		$this->addGlobalStyle($body);

		$links = new StyleCollection("a", null, "Link Style", "Style settings affecting the look and feel of links.");
		$links->addSP(new TextDecorationSP("underline"));
		$this->addGlobalStyle($links);

		$links_hover = new StyleCollection("a:hover", null, "Link Hover Style", "Style settings affecting the look and feel of hover links.");
		$links_hover->addSP(new TextDecorationSP("underline"));
		$this->addGlobalStyle($links_hover);

		// =====================================================================
		// Block 1 style
		$block1 = new StyleCollection("*.block1", "block1", "Block 1", "The main block where normally all of the page content goes in.");
		$block1->addSP(new BackgroundColorSP("#FFFFFF"));
		$block1->addSP(new ColorSP("#000"));
		$block1->addSP(new BorderTopSP("1px", "solid", "#000"));
		$block1->addSP(new BorderRightSP("3px", "solid", "#000"));
		$block1->addSP(new BorderBottomSP("3px", "solid", "#000"));
		$block1->addSP(new BorderLeftSP("1px", "solid", "#000"));
		$block1->addSP(new PaddingSP("10px"));
		$block1->addSP(new MarginSP("10px"));
		$this->addStyleForComponentType($block1, BLOCK, 1);
		
		// =====================================================================
		// Block 2 style
		$block2 = new StyleCollection("*.block2", "block2", "Block 2", "A 2nd level block.");
		//$block2->addSP(new PaddingSP("10px"));
		$block2->addSP(new TextAlignSP("justify"));
		$this->addStyleForComponentType($block2, BLOCK, 2);
		
		// =====================================================================
		// Block 3 style
		$block3 = new StyleCollection("*.block3", "block3", "Block 3", "A 3rd level block.");
		//$block3->addSP(new BackgroundColorSP("#FFFFFF"));
		//$block3->addSP(new ColorSP("#000"));
		//$block3->addSP(new BorderSP("1px", "solid", "#000"));
		$block3->addSP(new PaddingSP("10px"));
		$block3->addSP(new TextAlignSP("justify"));
		$this->addStyleForComponentType($block3, BLOCK, 3);
		
		// =====================================================================
		// Block 4 style
		$block4 = new StyleCollection("*.block4", "block4", "Block 4", "A 4th level block.");
		$block4->addSP(new BackgroundColorSP("#D4D4D4"));
		$block4->addSP(new ColorSP("#000"));
		$block4->addSP(new BorderTopSP("1px", "solid", "#000"));
		$block4->addSP(new BorderRightSP("1px", "solid", "#000"));
		$block4->addSP(new BorderBottomSP("1px", "solid", "#000"));
		$block4->addSP(new BorderLeftSP("1px", "solid", "#000"));
		$block4->addSP(new PaddingSP("10px"));
		$block4->addSP(new MarginSP("10px"));
		$this->addStyleForComponentType($block4, BLOCK, 4);
		
		// =====================================================================
		// Heading 1 style
		$heading1 = new StyleCollection("*.heading1", "heading1", "Heading 1", "A 1st level heading.");
		$heading1->addSP(new ColorSP("#F00"));
		$heading1->addSP(new FontSizeSP("200%"));
		$this->addStyleForComponentType($heading1, HEADING, 1);
		
		// =====================================================================
		// Heading 2 style
		$heading2 = new StyleCollection("*.heading2", "heading2", "Heading 2", "A 2nd level heading.");
		$heading2->addSP(new BackgroundColorSP("#D4D4D4"));
		$heading2->addSP(new ColorSP("#007"));
		$heading2->addSP(new FontSizeSP("125%"));
		$heading2->addSP(new PaddingSP("10px"));
		$heading2->addSP(new MarginSP("10px"));
		$heading2->addSP(new BorderTopSP("1px", "solid", "#000"));
		$this->addStyleForComponentType($heading2, HEADING, 2);

		// =====================================================================
		// Footer 1 style
		$footer1 = new StyleCollection("*.footer1", "footer1", "Footer 1", "A 1st level footer.");
		$footer1->addSP(new ColorSP("#959595"));
		$footer1->addSP(new MarginSP("10px"));
		$footer1->addSP(new FontSizeSP("125%"));
		$this->addStyleForComponentType($footer1, FOOTER, 1);
		
		// =====================================================================
		// Menu 1 style
		$menu1 = new StyleCollection("*.menu1", "menu1", "Menu 1", "A 1st level menu.");
		$menu1->addSP(new BackgroundColorSP("#D4D4D4"));
		$menu1->addSP(new ColorSP("#000"));
		$menu1->addSP(new BorderSP("1px", "solid", "#000"));
		$this->addStyleForComponentType($menu1, MENU, 1);
		
		// =====================================================================
		// Menu Heading 1 style
		$menuHeading1 = new StyleCollection("*.menuHeading1", "menuHeading1", "Menu Heading 1", "A 1st level menu heading.");
		$menuHeading1->addSP(new DisplaySP("block"));
		$menuHeading1->addSP(new BackgroundColorSP("#AAA"));
		$menuHeading1->addSP(new PaddingSP("10px"));
		//$menuHeading1->addSP(new FontWeightSP("bold"));
		$this->addStyleForComponentType($menuHeading1, MENU_ITEM_HEADING, 1);
		
		// =====================================================================
		// Menu Unselected Link 1 style
		$menuLink1_unselected = new StyleCollection("*.menuLink1_unselected a", "menuLink1_unselected", "Unselected Menu Link 1", "A 1st level unselected menu link.");
		$menuLink1_unselected->addSP(new DisplaySP("block"));
		$menuLink1_unselected->addSP(new BackgroundColorSP("#D4D4D4"));
		$menuLink1_unselected->addSP(new PaddingSP("10px"));
		$this->addStyleForComponentType($menuLink1_unselected, MENU_ITEM_LINK_UNSELECTED, 1);
		
		$menuLink1_hover = new StyleCollection("*.menuLink1_hover a:hover", "menuLink1_hover", "Menu Link 1 Hover", "A 1st level menu link hover behavior.");
		$menuLink1_hover->addSP(new BackgroundColorSP("#AAA"));
		$this->addStyleForComponentType($menuLink1_hover, MENU_ITEM_LINK_UNSELECTED, 1);
		
		// =====================================================================
		// Menu Selected Link 1 style
		$menuLink1_selected = new StyleCollection("*.menuLink1_selected a", "menuLink1_selected", "Selected Menu Link 1", "A 1st level selected menu link.");
		$menuLink1_selected->addSP(new DisplaySP("block"));
		$menuLink1_selected->addSP(new BackgroundColorSP("#AAA"));
		$menuLink1_selected->addSP(new PaddingSP("10px"));
		$this->addStyleForComponentType($menuLink1_selected, MENU_ITEM_LINK_SELECTED, 1);
	}


}

?>