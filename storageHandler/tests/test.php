<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.6 2003/07/04 14:04:34 gabeschine Exp $
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
	
    $test =& new GroupTest('StorageHandler tests');
    $test->addTestFile(HARMONI.'storageHandler/tests/FileStorableTestCase.class.php');
 //   $test->addTestFile(HARMONI.'storageHandler/tests/DatabaseStorableTestCase.class.php');
    $test->addTestFile(HARMONI.'storageHandler/tests/FileStorageMethodTestCase.class.php');
    $test->addTestFile(HARMONI.'storageHandler/tests/StorageHandlerTestCase.class.php');
	$test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>