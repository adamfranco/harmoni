<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.7 2005/02/07 21:38:18 adamfranco Exp $
 * @copyright 2003 
 **/

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

    if (!defined('HARMONI')) {
        require_once("../../../harmoni.inc.php");
    }

	$errorHandler =& Services::requireService("ErrorHandler",true);
	
	$dbHandler =& Services::requireService("DBHandler",true);
	$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
	$dbHandler->pConnect($dbIndex);
	Services::startService("Shared", $dbIndex, "doboHarmoniTest");
	$errorHandler->setDebugMode(TRUE);

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }

    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');
	
    $test =& new GroupTest('GUI tests');
    $test->addTestFile(HARMONI.'GUIManager/test/StylePropertiesTestCase.class.php');
    $test->addTestFile(HARMONI.'GUIManager/test/StyleComponentsTestCase.class.php');
    $test->addTestFile(HARMONI.'GUIManager/test/StyleCollectionsTestCase.class.php');
    $test->addTestFile(HARMONI.'GUIManager/test/ComponentsTestCase.class.php');
    $test->addTestFile(HARMONI.'GUIManager/test/ThemesTestCase.class.php');
    $test->addTestFile(HARMONI.'GUIManager/test/GUIManagerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();
	
	echo printErrors(new SimpleHTMLErrorPrinter());

?>