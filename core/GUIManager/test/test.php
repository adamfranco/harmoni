<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @package harmoni.gui.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: test.php,v 1.14 2007/09/04 20:25:24 adamfranco Exp $
 */

  require_once(dirname(__FILE__)."/../../../../concerto/index.php");
  
  require_once dirname(__FILE__)."/../../../core/utilities/Timer.class.php";
$timer = new Timer;
$timer->start();

$harmonyLoadupTimer = new Timer;
$harmonyLoadupTimer->start();

require_once(dirname(__FILE__)."/../../../harmoni.inc.php");

//require_once(dirname(__FILE__)."/../../../../../concerto/main/include/setup.inc.php");

$harmonyLoadupTimer->end();

/*
 
	define("LOAD_HIERARCHY", false);
	define("LOAD_STORAGE",false);	
	define("LOAD_AGENTINFORMATION", false);
	define("LOAD_DATAMANAGER", false);
	if(!defined("LOAD_AUTHN")) define("LOAD_AUTHN", false);
	define("LOAD_DR", false);
	define("LOAD_SETS", false);

    if (!defined('HARMONI')) {
        require_once("../../../harmoni.inc.php");
    }

	$errorHandler = Services::getService("ErrorHandler");
	$dbHandler = Services::getService("DatabaseManager");
	$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo.middlebury.edu","doboHarmoniTest","test","test") );
	$dbHandler->pConnect($dbIndex);
	Services::startService("Shared", $dbIndex, "doboHarmoniTest");
	$errorHandler->setDebugMode(TRUE);

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }*/

    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');
	
    $test = new GroupTest('GUI tests');
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