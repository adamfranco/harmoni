<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.5 2004/06/22 15:23:08 dobomode Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003 
 **/
 
define("LOAD_DR", false);

require_once dirname(__FILE__)."/../../../../core/utilities/Timer.class.php";
$timer =& new Timer;
$timer->start();

$harmonyLoadupTimer =& new Timer;
$harmonyLoadupTimer->start();

require_once(dirname(__FILE__)."/../../../../harmoni.inc.php");

$harmonyLoadupTimer->end();

        
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

/* 	if (!defined('CONCERTODBID')) { */
/* 		require_once(CONCERTO.'/tests/dbconnect.inc.php'); */
/* 	} */

	require_once(HARMONI."errorHandler/ErrorHandler.class.php");
	$errorHandler =& Services::requireService("ErrorHandler",true);
	$dbHandler =& Services::requireService("DBHandler",true);
	$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
	$dbHandler->pConnect($dbIndex);
	Services::startService("Shared", $dbIndex, "doboHarmoniTest");
	Services::startService("Hierarchy", $dbIndex, "doboHarmoniTest");
	$errorHandler->setDebugMode(TRUE);
	
	
    $test =& new GroupTest('Authorization Tests');
	$test->addTestFile(HARMONI.'/oki/authorization/tests/FunctionTestCase.class.php');
    $test->addTestFile(HARMONI.'/oki/authorization/tests/QualifierTestCase.class.php');
//    $test->addTestFile(HARMONI.'/oki/authorization/tests/AuthorizationTestCase.class.php');
    $test->addTestFile(HARMONI.'/oki/authorization/tests/AuthorizationManagerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();
	
$timer->end();

print "\n<br />Harmoni Load Time: ".$harmonyLoadupTimer->printTime();
print "\n<br />Overall Time: ".$timer->printTime();
print "\n</p>";

$num = $dbHandler->getTotalNumberOfQueries();
debug::output("Total # of queries: ".$num,1,"DBHandler");
debug::printAll();
unset($dbHandler,$errorHandler, $userError);
unset($num);
//	$errorHandler->printErrors(HIGH_DETAIL);
//	print "<pre>";
//	print_r($errorHandler);
?>