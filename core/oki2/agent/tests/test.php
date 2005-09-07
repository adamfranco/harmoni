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
 * @version $Id: test.php,v 1.7 2005/09/07 21:17:58 adamfranco Exp $
 */
 
require_once dirname(__FILE__)."/../../../../core/utilities/Timer.class.php";
$timer =& new Timer;
$timer->start();

$harmonyLoadupTimer =& new Timer;
$harmonyLoadupTimer->start();

require_once(dirname(__FILE__)."/../../../../harmoni.inc.php");

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
	
	
	$test =& new GroupTest('Agent Tests');
	$test->addTestFile(dirname(__FILE__).'/SharedManagerTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/AgentTestCase.class.php');
	$test->addTestFile(dirname(__FILE__).'/GroupTestCase.class.php');

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