<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @version $Id: test.php,v 1.1 2003/06/26 19:19:48 adamfranco Exp $
 * @copyright 2003 
 **/

    if (!defined('HARMONI')) {
        require_once("../../harmoni.inc.php");
    }

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }
    
    require_once(HARMONI.'authenticationHandler/AuthenticationHandler.class.php');
       
	if (!Services::serviceAvailable("authHandler")) {
	   	Services::registerService("authHandler","AuthenticationHandler");
		Services::startService("authHandler");
	}
	
//	require_once(HARMONI.'authenticationHandler/AgentInformationHandler.class.php');
	
	if (!Services::serviceAvailable("AIHandler")) {
//	   	Services::registerService("AIHandler","AgentInformationHandler");
//		Services::startService("AIHandler");
	}

    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');
	
    $test =& new GroupTest('Authentication tests');
    $test->addTestFile(HARMONI.'authenticationHandler/tests/AgentInformationHandlerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>