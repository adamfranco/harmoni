<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @author Dobo Radichkov
 * @version $Id: grouptest.php,v 1.1 2003/06/16 20:01:08 dobomode Exp $
 * @copyright 2003 
 **/

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', '/www/simple_test/');
    }
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'simple_html_test.php');

    $test =& new GroupTest('All tests');
    $test->addTestFile('test.php');
    $test->attachObserver(new TestHtmlDisplay());
    $test->run();

?>