<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.2 2003/06/23 21:37:22 adamfranco Exp $
 * @copyright 2003 
 **/

require_once("../harmoni.inc.php");
require_once(HARMONI."DBHandler/classes/DBHandler.class.php");

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

    $test =& new GroupTest('Global Test: All Tests');
    $test->addTestFile(HARMONI.'Services/tests/test.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/test.php');
    $test->addTestFile(HARMONI.'errorHandler/tests/test.php');
    $test->addTestFile(HARMONI.'utilities/tests/test.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>