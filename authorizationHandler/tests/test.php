<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.5 2003/07/04 03:32:35 dobomode Exp $
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
	
    $test =& new GroupTest('AuthorizationHandler tests');
    $test->addTestFile(HARMONI.'authorizationHandler/tests/AuthorizationAgentTestCase.class.php');
    $test->addTestFile(HARMONI.'authorizationHandler/tests/AuthorizationFunctionTestCase.class.php');
    $test->addTestFile(HARMONI.'authorizationHandler/tests/HierarchicalAuthorizationContextTestCase.class.php');
    $test->addTestFile(HARMONI.'authorizationHandler/tests/AuthorizationContextHierarchyNodeTestCase.class.php');
    $test->addTestFile(HARMONI.'authorizationHandler/tests/AuthorizationContextHierarchyTestCase.class.php');
    $test->addTestFile(HARMONI.'authorizationHandler/tests/DatabaseAuthorizationContextHierarchyGeneratorTestCase.class.php');
    $test->addTestFile(HARMONI.'authorizationHandler/tests/DatabaseHierarchicalAuthorizationMethodTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>