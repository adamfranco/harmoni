<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.1 2004/03/11 22:43:28 dobomode Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003 
 **/
 
    if (!defined('HARMONI')) {
        require_once("../../../../harmoni.inc.php");
    }

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }
        
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

	require_once(HARMONI."errorHandler/ErrorHandler.class.php");
	$errorHandler =& Services::requireService("ErrorHandler","ErrorHandler");
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
	
//	echo (is_numeric(1))?"true":"false";
//	echo "<br>";
//	echo (is_numeric("1"))?"true":"false";
//	echo "<br>";
//	echo (is_numeric(" 1"))?"true":"false";
//	echo "<br>";
//	echo (is_numeric(" +1.0"))?"true":"false";
//	echo "<br>";
//	echo (is_numeric("1E1"))?"true":"false";
//	echo "<br>";
//
//	$errorHandler->printErrors(HIGH_DETAIL);
//	print "<pre>";
//	print_r($errorHandler);
?>