<?php

/**
 * This is a test file for themes, layouts.
 *
 * @version $Id: testThemes.php,v 1.2 2003/07/18 20:26:23 gabeschine Exp $
 * @copyright 2003 
 **/
require_once("../harmoni.inc.php");
require_once(HARMONI."themeHandler/TestTheme.class.php");
require_once(HARMONI."layoutHandler/components/layouts/SingleContentLayout.class.php");
require_once(HARMONI."layoutHandler/components/layouts/LeftMenuLayout.class.php");
require_once(HARMONI."layoutHandler/components/layouts/TopMenuLayout.class.php");
require_once(HARMONI."layoutHandler/components/Content.class.php");
require_once(HARMONI."layoutHandler/components/Menu.class.php");
require_once(HARMONI."layoutHandler/components/LinkMenuItem.class.php");
require_once(HARMONI."layoutHandler/components/HeaderMenuItem.class.php");

// create a new theme Object

$theme =& new TestTheme;
$theme->setPageTitle("Page Title!");
$theme->addHeadContent("<style type=text/css>body {font-size:18px}</style>");

$topMenuLayout =& new TopMenuLayout;
$leftMenuLayout =& new LeftMenuLayout;

$topMenu =& new Menu;
$leftMenu =& new Menu;

$topMenu->addItem(new HeaderMenuItem("Top Menu"));
$topMenu->addItem(new LinkMenuItem("Link1","http://www.middlebury.edu"));
$topMenu->addItem(new LinkMenuItem("New window","http://google.com",false,"_blank"));
$topMenu->addItem(new LinkMenuItem("JavaScript Alert","#",false,null,"onClick='alert(\"testing\")'","style='text-decoration:none' "));

$leftMenu->addItem(new HeaderMenuItem("Left Menu"));
$leftMenu->addItem(new LinkMenuItem("Link1","http://www.middlebury.edu"));
$leftMenu->addItem(new LinkMenuItem("New window","http://google.com",false,"_blank"));
$leftMenu->addItem(new LinkMenuItem("JavaScript Alert","#",false,null,"onClick='alert(\"testing\")'","style='text-decoration:none' "));

$topMenuLayout->setComponent(0,&$topMenu);
$leftMenuLayout->setComponent(0,&$leftMenu);

$contentLayout =& new SingleContentLayout;
$contentLayout->setComponent(0,new Content("This theme is called: ".$theme->getName().", description: ".$theme->getDescription()));
$leftMenuLayout->setComponent(1,&$contentLayout);

$topMenuLayout->setComponent(1,&$leftMenuLayout);

$theme->printPageWithLayout(&$topMenuLayout);

?>