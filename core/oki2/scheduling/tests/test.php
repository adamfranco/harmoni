<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @package harmoni.osid_v2.agent.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: test.php,v 1.1 2006/07/17 19:55:39 jwlee100 Exp $
 */
 
 require_once(dirname(__FILE__)."/../../../../../concerto/index.php");
 
require_once dirname(__FILE__)."/../../../../core/utilities/Timer.class.php";
$timer =& new Timer;
$timer->start();

$harmonyLoadupTimer =& new Timer;
$harmonyLoadupTimer->start();

require_once(dirname(__FILE__)."/../../../../harmoni.inc.php");

//require_once(dirname(__FILE__)."/../../../../../concerto/main/include/setup.inc.php");

$harmonyLoadupTimer->end();

		
	require_once(SIMPLE_TEST . 'simple_unit.php');
	require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

/*	if (!defined('CONCERTODBID')) { */
/*		require_once(CONCERTO.'/tests/dbconnect.inc.php'); */
/*	} */

	require_once(HARMONI."errorHandler/ErrorHandler.class.php");
	$errorHandler =& Services::getService("ErrorHandler");
	$context =& new OsidContext;
	$configuration =& new ConfigurationProperties;
	Services::startManagerAsService("DatabaseManager", $context, $configuration);
	
	
	$test =& new GroupTest('SchedulingTest');
	
	$test->addTestFile(dirname(__FILE__).'/SchedulingTest.class.php');

	$test->attachObserver(new DoboTestHtmlDisplay());
	$test->run();
	
$timer->end();

print "\n<br />Harmoni Load Time: ".$harmonyLoadupTimer->printTime();
print "\n<br />Overall Time: ".$timer->printTime();
print "\n</p>";

// $num = $dbHandler->getTotalNumberOfQueries();
// debug::output("Total # of queries: ".$num,1,"DBHandler");
//debug::printAll();
// unset($dbHandler,$errorHandler, $userError);
// unset($num);
//	$errorHandler->printErrors(HIGH_DETAIL);
//	print "<pre>";
//	print_r($errorHandler);
?>