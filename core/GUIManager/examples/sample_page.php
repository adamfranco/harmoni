<?php
/**
 * @package  harmoni.gui.examples
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: sample_page.php,v 1.9 2007/09/04 20:25:24 adamfranco Exp $
 */

// =============================================================================
// Load Harmoni stuff.
// =============================================================================

	define("LOAD_HIERARCHY", false);
	define("LOAD_STORAGE",false);
	define("LOAD_AUTHN",false);
	define("LOAD_AGENTINFORMATION", false);
	define("LOAD_DATAMANAGER", false);
	define("LOAD_AUTHN", false);
	define("LOAD_DR", false);
	define("LOAD_SETS", false);
	
	if (!defined('HARMONI')) {
	    require_once("../../../harmoni.inc.php");
	}
	
	$errorHandler = Services::getService("ErrorHandler");

// =============================================================================
// Include all needed files.
// =============================================================================

	require_once(HARMONI."GUIManager/Theme.class.php");

	require_once(HARMONI."GUIManager/Component.class.php");

	require_once(HARMONI."GUIManager/Container.class.php");

	require_once(HARMONI."GUIManager/Layouts/FlowLayout.class.php");
	require_once(HARMONI."GUIManager/Layouts/XLayout.class.php");
	require_once(HARMONI."GUIManager/Layouts/YLayout.class.php");
	
	require_once(HARMONI."GUIManager/StyleProperties/BackgroundColorSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/ColorSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/BorderSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/MarginSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/MarginTopSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/MarginLeftSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/MarginRightSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/MarginBottomSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/PaddingSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/FontSP.class.php");
	require_once(HARMONI."GUIManager/StyleProperties/TextAlignSP.class.php");

// =============================================================================
// Create some styles and register with the Theme. This stuff would go in the Theme.
// =============================================================================

	$bodyStyle = new StyleCollection("body", null, "Body Style", "Global style settings.");
	$bodyStyle->addSP(new BackgroundColorSP("#FFFCF0"));
	$bodyStyle->addSP(new ColorSP("#2E2B33"));
	$bodyStyle->addSP(new FontSP("Verdana", "10pt"));
	$bodyStyle->addSP(new MarginSP("5px"));
	$bodyStyle->addSP(new TextAlignSP("center"));
	
	$mainBoxStyle = new StyleCollection("*.mainBoxStyle", "mainBoxStyle", "Main Box Style", "Style for the main box.");
	$mainBoxStyle->addSP(new BackgroundColorSP("#FFF3C2"));
	$mainBoxStyle->addSP(new BorderSP("1px", "solid", "#2E2B33"));
	$mainBoxStyle->addSP(new WidthSP("750px"));
	$mainBoxStyle->addSP(new MarginTopSP("5px"));
	$mainBoxStyle->addSP(new MarginBottomSP("5px"));
	$mainBoxStyle->addSP(new MarginLeftSP("auto"));
	$mainBoxStyle->addSP(new MarginRightSP("auto"));
	$mainBoxStyle->addSP(new PaddingSP("5px"));
	
	$menuBoxStyle = new StyleCollection("*.menuBoxStyle", "menuBoxStyle", "Menu Box Style", "Style for the menu box.");
	$menuBoxStyle->addSP(new BackgroundColorSP("#AAA58F"));
	$menuBoxStyle->addSP(new BorderSP("1px", "solid", "#2E2B33"));
	$menuBoxStyle->addSP(new MarginSP("5px"));
	$menuBoxStyle->addSP(new PaddingSP("5px"));
	
	$menuItemsStyle = new StyleCollection("*.menuItemsStyle", "menuItemsStyle", "Menu Items Style", "Style for the menu items.");
	$menuItemsStyle->addSP(new BorderSP("1px", "solid", "#2E2B33"));
	$menuItemsStyle->addSP(new BackgroundColorSP("#5B5666"));
	$menuItemsStyle->addSP(new ColorSP("#FFF9E0"));
	$menuItemsStyle->addSP(new WidthSP("80px"));
	$menuItemsStyle->addSP(new MarginSP("5px"));
	$menuItemsStyle->addSP(new PaddingSP("5px"));
	$menuItemsStyle->addSP(new FontSP("Verdana", "10pt", null, "bold"));
	
	$mainContentStyle = new StyleCollection("*.mainContentStyle", "mainContentStyle", "Main Content Style", "Style for the main content.");
	$mainContentStyle->addSP(new BackgroundColorSP("#AAA58F"));
	$mainContentStyle->addSP(new BorderSP("1px", "solid", "#2E2B33"));
	$mainContentStyle->addSP(new MarginSP("5px"));
	$mainContentStyle->addSP(new PaddingSP("5px"));
	$mainContentStyle->addSP(new TextAlignSP("justify"));

// =============================================================================
// Create some containers & components. This stuff would normally go in an action.
// =============================================================================

	$xLayout = new XLayout();
	$yLayout = new YLayout();

	$mainBox = new Container($yLayout, BLANK, 1, $mainBoxStyle);

	$h1 = new Component("Home", MENU_ITEM_LINK_SELECTED, 1, $menuItemsStyle);
	$h2 = new Component("Pictures", MENU_ITEM_LINK_SELECTED, 1, $menuItemsStyle);
	$h3 = new Component("Guestbook", MENU_ITEM_LINK_SELECTED, 1, $menuItemsStyle);
	$h4 = new Component("Links", MENU_ITEM_LINK_SELECTED, 1, $menuItemsStyle);
	
	$menuBox = new Container($xLayout, BLANK, 1, $menuBoxStyle);
	$menuBox->add($h1, null, null, CENTER, CENTER);
	$menuBox->add($h2, null, null, CENTER, CENTER);
	$menuBox->add($h3, null, null, CENTER, CENTER);
	$menuBox->add($h4, null, null, CENTER, CENTER);
	$temp = new Container($yLayout, BLANK, 3);
	$temp->add($menuBox, null, null, RIGHT);
	
	$menuBox1 = $menuBox;
	$menuBox1->setLayout($yLayout);
		
	$mainContent = new Container($xLayout, BLANK, 1);
	$mainText = new Component("<p>Angelo de la Cruz, 46, was released Tuesday -- one day after the Philippine government completed the withdrawal of its 51-member humanitarian contingent from Iraq in compliance with kidnappers' demands.</p><p>De la Cruz was turned over to officials at the United Arab Emirates Embassy in Baghdad before he was transferred to the Philippine Embassy. He will be flown to Abu Dhabi for a medical evaluation, a UAE government statement said.  </p><p>&quot;I am very, very happy. His health is okay ... His family is waiting for him,&quot; a tearful Arsenia de la Cruz told reporters at her country's embassy in Amman, minutes after talking by telephone to her husband in Baghdad. </p><p>Mrs. de la Cruz had been staying in the Jordanian capital, awaiting word on her husband.</p><p>&quot;I would not let him go back to the Middle East another time,&quot; The Associated Press quoted her as saying.</p><p>Earlier Tuesday, the Philippine President Gloria Macapagal Arroyo said on national television she had also spoken to the former hostage. </p><p>&quot;I'm happy to announce that our long national vigil involving Angelo [de] la Cruz is over. I thank the Lord Almighty for his blessings,&quot; Arroyo said.</p><p>&quot;His health is good, his spirits high and he sends best wishes to every Filipino for their thoughts and prayers.&quot; </p><p>Initial reports on de la Cruz's condition appeared promising. &quot;He's here. He's with us. He's fine,&quot; a UAE Embassy official said before the transfer.</p><p>Kidnappers had threatened to behead the father of eight children, who was taken hostage on July 7, if the Philippines did not withdraw its forces from Iraq. </p><p>The Arabic-language news network Al-Jazeera read a statement from the kidnappers last week, saying they would free de la Cruz when &quot;the last Filipino leaves Iraq on a date that doesn't go beyond the end of this month.&quot;</p>", BLANK, 1);
	$mainText->addStyle($mainContentStyle);
	$mainContent->add($menuBox1, null, null, null, TOP);
	$mainContent->add($mainText, "100%", null, null, TOP);

	$mainBox->add($temp, "100%", null, RIGHT, CENTER);
	$mainBox->add($mainContent, "100%", null, null, null);
	
	$theme = new Theme("Sample Page Theme","This is the theme from examples/sample_page.php");
	$theme->addGlobalStyle($bodyStyle);
	$theme->setComponent($mainBox);
	$theme->printPage();
	
?>
