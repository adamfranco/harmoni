<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.2 2003/06/26 16:05:45 movsjani Exp $
 * @package harmoni.errorhandler.tests
 * @copyright 2003 
 **/
    if (!defined('HARMONI')) {
        require_once("../../harmoni.inc.php");
    }

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }

    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

    $test =& new GroupTest('ErrorHandler tests');

    $test->addTestFile(HARMONI.'errorHandler/tests/ErrorTestCase.class.php');
    $test->addTestFile(HARMONI.'errorHandler/tests/ErrorHandlerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();
?>