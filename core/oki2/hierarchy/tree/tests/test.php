<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.1 2005/01/11 17:40:22 adamfranco Exp $
 * @copyright 2003 
 **/

	define("LOAD_HIERARCHY", false);

    if (!defined('HARMONI')) {
        require_once("../../../../../harmoni.inc.php");
    }

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }

    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');
	
    $test =& new GroupTest('Tree tests');
    $test->addTestFile(HARMONI.'oki/hierarchy2/tree/tests/TreeTestCase.class.php');
    $test->addTestFile(HARMONI.'oki/hierarchy2/tree/tests/TreeNodeTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

	
?>