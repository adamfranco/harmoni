<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.2 2003/06/24 21:14:42 adamfranco Exp $
 * @copyright 2003 
 **/

$__services__ = NULL;
define("SERVICES_OBJECT","__services__");

if (!defined('HARMONI')) {
	require_once("../../harmoni.inc.php");
}

require_once(HARMONI."DBHandler/DBHandler.class.php");

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

    $test =& new GroupTest('Services tests');
    $test->addTestFile(HARMONI.'services/tests/ServicesTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>