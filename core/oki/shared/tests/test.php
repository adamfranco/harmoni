<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.9 2005/01/19 22:28:12 adamfranco Exp $
 * @package harmoni.tests.metadata
 * @copyright 2003 
 **/
 
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
	$errorHandler->setDebugMode(TRUE);
	
	
    $test =& new GroupTest('Shared Tests');
    $test->addTestFile(HARMONI.'/oki/shared/tests/SharedManagerTestCase.class.php');
    $test->addTestFile(HARMONI.'/oki/shared/tests/AgentTestCase.class.php');
    $test->addTestFile(HARMONI.'/oki/shared/tests/GroupTestCase.class.php');

    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();
	
$timer->end();

print "\n<br />Harmoni Load Time: ".$harmonyLoadupTimer->printTime();
print "\n<br />Overall Time: ".$timer->printTime();
print "\n</p>";

$num = $dbHandler->getTotalNumberOfQueries();
debug::output("Total # of queries: ".$num,1,"DBHandler");
//debug::printAll();
unset($dbHandler,$errorHandler, $userError);
unset($num);
//	$errorHandler->printErrors(HIGH_DETAIL);
//	print "<pre>";
//	print_r($errorHandler);
?>