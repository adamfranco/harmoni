<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.5 2003/06/19 18:28:07 adamfranco Exp $
 * @copyright 2003 
 **/

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', '../simple_test/');
    }
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

    $test =& new GroupTest('All tests');
    $test->addTestFile('tests/QueueTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>