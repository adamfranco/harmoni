<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @author Dobo Radichkov
 * @version $Id: test.php,v 1.4 2003/06/19 15:28:00 dobomode Exp $
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