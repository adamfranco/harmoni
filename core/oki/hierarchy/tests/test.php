<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.9 2003/10/15 15:34:09 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003 
 **/
 
	require_once(dirname(__FILE__)."/../../../../harmoni.inc.php");
        
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

/* 	if (!defined('CONCERTODBID')) { */
/* 		require_once(CONCERTO.'/tests/dbconnect.inc.php'); */
/* 	} */

	require_once(HARMONI."errorHandler/ErrorHandler.class.php");
	$errorHandler =& Services::requireService("ErrorHandler","ErrorHandler");
	$errorHandler->setDebugMode(TRUE);
	
	
    $test =& new GroupTest('Hierarchy Tests');
    $test->addTestFile(HARMONI.'/oki/hierarchy/tests/TreeTestCase.class.php');
    $test->addTestFile(HARMONI.'/oki/hierarchy/tests/NodeTestCase.class.php');
    $test->addTestFile(HARMONI.'/oki/hierarchy/tests/HierarchyTestCase.class.php');
    $test->addTestFile(HARMONI.'/oki/hierarchy/tests/HierarchyManagerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();
	
//	$errorHandler->printErrors(HIGH_DETAIL);
//	print "<pre>";
//	print_r($errorHandler);
?>