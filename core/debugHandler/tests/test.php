<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
 * @package harmoni.dbc.tests
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

    $test =& new GroupTest('debugHandler tests');
	$test->addTestFile(HARMONI.'debugHandler/tests/DebugHandlerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>