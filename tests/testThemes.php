<?php

/**
 * This is a test file for themes, layouts.
 *
 * @version $Id: testThemes.php,v 1.1 2003/07/18 03:23:14 gabeschine Exp $
 * @copyright 2003 
 **/
require_once("../harmoni.inc.php");
//require_once(HARMONI."themeHandler/TestTheme.class.php");

// create a new theme Object
exit;
$theme =& new TestTheme;

$layout =& new SingleContentLayout;
$layout->setComponent(0,new Content("this is some content!"));

$theme->printPageWithLayout($layout);

?>