<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.9 2003/06/30 14:50:37 adamfranco Exp $
 * @copyright 2003 
 **/

require_once("../harmoni.inc.php");
require_once(HARMONI."DBHandler/DBHandler.class.php");
require_once(HARMONI."errorHandler/ErrorHandler.class.php");

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

    $test =& new GroupTest('Global Test: All Tests');
    $test->addTestFile(HARMONI.'authenticationHandler/tests/test.php');
    $test->addTestFile(HARMONI.'services/tests/test.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/test.php');
    $test->addTestFile(HARMONI.'utilities/tests/test.php');
// DON'T ADD THE ERROR HANDLER TESTS! THEY HALT THE SYSTEM, BECAUSE THEY TEST A FATAL ERROR!
//    $test->addTestFile(HARMONI.'errorHandler/tests/test.php');
	$test->addTestFile(HARMONI.'storageHandler/tests/test.php');
	$test->addTestFile(HARMONI.'debugHandler/tests/test.php');
	$test->addTestFile(HARMONI.'authorizationHandler/tests/test.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();
	
$errorHandler =& Services::getService("ErrorHandler");
$errorHandler->printErrors(LOW_DETAIL);

?>