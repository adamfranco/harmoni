<?php

/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @package harmoni.utilities.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: testStats.php,v 1.3 2005/04/07 16:33:31 adamfranco Exp $
 **/

    if (!defined('HARMONI')) {
        require_once("../../harmoni.inc.php");
    }

    if (!defined('SIMPLE_TEST')) {
        define('SIMPLE_TEST', HARMONI.'simple_test/');
    }
       

	if (!Services::serviceAvailable("ErrorHandler")) {
	   	Services::registerService("ErrorHandler","ErrorHandler");
	   	
		require_once(OKI2."osid/OsidContext.php");
		$context =& new OsidContext;
		$context->assignContext('harmoni', $harmoni);
		require_once(HARMONI."oki2/shared/ConfigurationProperties.class.php");
		$configuration =& new ConfigurationProperties;
		Services::startManagerAsService("ErrorHandler", $context, $configuration);
	}

error_reporting(15);
    require_once(SIMPLE_TEST . 'simple_unit.php');
    require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');
	
    $test =& new GroupTest('Statistics tests');
    $test->addTestFile(HARMONI.'utilities/tests/StatisticsHandlerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();
?>