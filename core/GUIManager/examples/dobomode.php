<?php
/**
 * @package harmoni.gui.examples
 */

// =============================================================================
// Load Harmoni stuff.
// =============================================================================

	define("LOAD_HIERARCHY", false);
	define("LOAD_STORAGE",false);
	define("LOAD_AUTHENTICATION",false);
	define("LOAD_AUTHN",false);
	define("LOAD_AGENTINFORMATION", false);
	define("LOAD_DATAMANAGER", false);
	define("LOAD_AUTHN", false);
	define("LOAD_DR", false);
	define("LOAD_SETS", false);
	define("LOAD_THEMES", false);
	define("LOAD_SHARED", false);
	define("OKI_VERSION", false);
	
	if (!defined('HARMONI')) {
	    require_once("../../../harmoni.inc.php");
	}
	
	$errorHandler =& Services::getService("ErrorHandler");

// =============================================================================
// Include all needed files.
// =============================================================================

	require_once(HARMONI."GUIManager/Themes/DobomodeTheme.class.php");

	require_once(HARMONI."GUIManager/Component.class.php");

	require_once(HARMONI."GUIManager/Components/Block.class.php");
	require_once(HARMONI."GUIManager/Components/Menu.class.php");
	require_once(HARMONI."GUIManager/Components/MenuItemLink.class.php");
	require_once(HARMONI."GUIManager/Components/MenuItemHeading.class.php");
//	require_once(HARMONI."GUIManager/Components/Heading.class.php");
//	require_once(HARMONI."GUIManager/Components/Footer.class.php");
//	require_once(HARMONI."GUIManager/Container.class.php");

//	require_once(HARMONI."GUIManager/Layouts/XLayout.class.php");
//	require_once(HARMONI."GUIManager/Layouts/YLayout.class.php");
//	require_once(HARMONI."GUIManager/Layouts/FlowLayout.class.php");
	
// =============================================================================
// Create some containers & components. This stuff would normally go in an action.
// =============================================================================

	// initialize layouts and theme
	$theme =& new DobomodeTheme();
	
	// create and add menus
	
	// create and add components
	$main =& new Block($theme->getDisplayName().": ".$theme->getDescription()."\n", 0);
	
	// create menus
	$menu1 =& new Menu(new FlowLayout(), 1);
	$menu1->add(new MenuItemHeading("Main Menu", 1));
	$menu1->add(new MenuItemLink("Home", "http://www.google.com", true, 1, null, null, "Home"));
	$menu1->add(new MenuItemLink("Alone", "http://www.depeche-mode.org", false, 1, null, null, "Alone"));
	
	$menu2 =& new Menu(new FlowLayout(), 2);
	$menu2->add(new MenuItemHeading("Sub-menu", 2));
	$menu2->add(new MenuItemLink("Up", "http://www.google.com", true, 2, null, null, "Up"));
	$menu2->add(new MenuItemLink("Down", "http://www.depeche-mode.org", false, 2, null, null, "Down"));
	
	// print the page
	$theme->setComponent($main);
	$theme->addMenu($menu1, 1);	
	$theme->addMenu($menu2, 2);	
	$theme->printPage();
	
	// instead of td with XLayout, tables one after another?

?>