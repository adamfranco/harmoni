<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.2 2004/04/01 22:44:14 dobomode Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003 
 **/
 
	require_once "../../../utilities/Timer.class.php";
	$timer =& new Timer();
	$timer->start();
	$harmonyLoadupTimer =& new Timer;
	$harmonyLoadupTimer->start();
	
    if (!defined('HARMONI')) {
        require_once("../../../../harmoni.inc.php");
    }

	$harmonyLoadupTimer->end();

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }
        
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

	$errorHandler =& Services::requireService("ErrorHandler",true);
	$dbHandler =& Services::requireService("DBHandler", true);
	$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("localhost","harmoniAuthzTest","test","test") );
	$dbHandler->pConnect($dbIndex);
	// Set up the SharedManager as this is required for the ID service
	Services::startService("Shared", $dbIndex);
	// Set up the DataManager
	//HarmoniDataManager::setup($dbIndex);
	$shared =& Services::getService("Shared",false);

	$id =& $shared->createId();
	echo "<pre>\n";
	print_r($id);
	echo "</pre>\n";
//	$errorHandler->setDebugMode(TRUE);
	
    $test =& new GroupTest('Hierarchy Tests');
    $test->addTestFile(HARMONI.'oki/authorization/tests/HarmoniFunctionTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();
		
/* remove these */
require_once(HARMONI.'oki/authorization/HarmoniFunctionIterator.class.php');
require_once(HARMONI.'oki/authorization/HarmoniFunction.class.php');
require_once(HARMONI.'oki/authorization/HarmoniFunctionDBE.class.php');
require_once(HARMONI.'oki/authorization/HarmoniQualifierIterator.class.php');
require_once(HARMONI.'oki/authorization/HarmoniQualifier.class.php');
require_once(HARMONI.'oki/authorization/HarmoniAuthorizationIterator.class.php');
require_once(HARMONI.'oki/authorization/HarmoniAuthorization.class.php');
require_once(HARMONI.'oki/authorization/HarmoniAuthorizationManager.class.php');
require_once(HARMONI.'utilities/DBE.interface.php');
	
$timer->end();

print "\n\n<p>Harmoni Load Time: ".$harmonyLoadupTimer->printTime();
//print "\n<br />Execution Time: ".$counter->getTime();
print "\n<br />Overall Time: ".$timer->printTime();
print "\n</p>";

?>