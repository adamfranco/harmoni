<?php

// include all required files.
require_once("../harmoni.inc.php");
require_once(HARMONI."themeHandler/TestTheme.class.php");
require_once(HARMONI."layoutHandler/components/layouts/SingleContentLayout.class.php");
require_once(HARMONI."layoutHandler/components/layouts/LeftMenuLayout.class.php");
require_once(HARMONI."layoutHandler/components/layouts/TopMenuLayout.class.php");
require_once(HARMONI."layoutHandler/components/Content.class.php");
require_once(HARMONI."layoutHandler/components/Menu.class.php");
require_once(HARMONI."layoutHandler/components/LinkMenuItem.class.php");
require_once(HARMONI."layoutHandler/components/HeaderMenuItem.class.php");

// create new TestTheme object
$theme =& new TestTheme;
$theme->setPageTitle("Page Title!");
$theme->addHeadContent("<style type=text/css>body {font-size:18px}</style>");

// create the two layouts for navigation
$topMenuLayout =& new TopMenuLayout;
$leftMenuLayout =& new LeftMenuLayout;

// create two menus
$topMenu =& new Menu;
$leftMenu =& new Menu;

// add links to the top menu
$topMenu->addItem(new HeaderMenuItem("Top Menu:"));
$topMenu->addItem(new LinkMenuItem("Link1","http://www.middlebury.edu"));
$topMenu->addItem(new LinkMenuItem("New window","http://google.com",false,"_blank"));
$topMenu->addItem(new LinkMenuItem("JavaScript Alert","#",false,null,"onClick='alert(\"testing\")'","style='text-decoration:none' "));

// add links to the left menu
$leftMenu->addItem(new HeaderMenuItem("Left Menu"));
$leftMenu->addItem(new LinkMenuItem("Link1","http://www.middlebury.edu"));
$leftMenu->addItem(new LinkMenuItem("New window","http://google.com",false,"_blank"));
$leftMenu->addItem(new LinkMenuItem("JavaScript Alert","#",false,null,"onClick='alert(\"testing\")'","style='text-decoration:none' "));

// add the menus to their respective layouts
$topMenuLayout->setComponent(0,$topMenu);
$leftMenuLayout->setComponent(0,$leftMenu);

// create a new SingleContentLayout to fill the space in the LefMenuLayout
$contentLayout =& new SingleContentLayout;
//$contentLayout->setComponent(0,new Content("This theme is called: ".$theme->getName().", description: ".$theme->getDescription()));
$content = "<b>The contents of this file:</b><br/>";
$content .= highlight_string(file_get_contents(__FILE__),true);
$content .= "<br/><br/>";
$content .= "<b>The contens of TestTheme's template file (is uses a template):</b><br/>";
$content .= highlight_string(file_get_contents(HARMONI."themeHandler/TestTheme.tpl"),true);
$contentLayout->setComponent(0,new Content($content));
// add it to the left menu
$leftMenuLayout->setComponent(1,$contentLayout);

// add the leftmenulayout to the topmenulayout
$topMenuLayout->setComponent(1,$leftMenuLayout);

// print it all with the theme
$theme->printPageWithLayout($topMenuLayout);

?>