<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.5 2003/07/10 02:34:20 gabeschine Exp $
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

	require_once(HARMONI."errorHandler/ErrorHandler.class.php");
	require_once(HARMONI."utilities/ArgumentValidator.class.php");

	if (!Services::serviceAvailable("ErrorHandler")) {
	   	Services::registerService("ErrorHandler","ErrorHandler");
		Services::startService("ErrorHandler");
	}

    $test =& new GroupTest('DBHandler tests');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLInsertQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLUpdateQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLDeleteQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLSelectQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLDatabaseTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLSelectQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLInsertQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/DBHandlerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>