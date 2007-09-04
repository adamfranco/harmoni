<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 * @package harmoni.osid_v2.authorization.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: test.php,v 1.8 2007/09/04 20:25:39 adamfranco Exp $
 */


require_once dirname(__FILE__)."/../../../../core/utilities/Timer.class.php";
$timer = new Timer;
$timer->start();

$harmonyLoadupTimer = new Timer;
$harmonyLoadupTimer->start();

require_once(dirname(__FILE__)."/../../../../harmoni.inc.php");

$harmonyLoadupTimer->end();

		
	require_once(SIMPLE_TEST . 'simple_unit.php');
	require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

	require_once(HARMONI."errorHandler/ErrorHandler.class.php");
	$errorHandler = Services::getService("ErrorHandler");
	$dbHandler = Services::getService("DatabaseManager");
	$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
	$dbHandler->pConnect($dbIndex);
	Services::startService("Shared", $dbIndex, "doboHarmoniTest");
	Services::startService("Hierarchy", $dbIndex, "doboHarmoniTest");
	Services::startService("AuthN", $dbIndex, "doboHarmoniTest");
	$errorHandler->setDebugMode(TRUE);
	
	
	$test = new GroupTest('Authorization Tests');
	$test->addTestFile(HARMONI.'/oki/authorization/tests/FunctionTestCase.class.php');
	$test->addTestFile(HARMONI.'/oki/authorization/tests/QualifierTestCase.class.php');
	$test->addTestFile(HARMONI.'/oki/authorization/tests/AuthorizationTestCase.class.php');
	$test->addTestFile(HARMONI.'/oki/authorization/tests/AuthorizationManagerTestCase.class.php');
	$test->attachObserver(new DoboTestHtmlDisplay());
	$test->run();
	
$timer->end();

print "\n<br />Harmoni Load Time: ".$harmonyLoadupTimer->printTime();
print "\n<br />Overall Time: ".$timer->printTime();
print "\n</p>";

$num = $dbHandler->getTotalNumberOfQueries();
debug::output("Total # of queries: ".$num,1,"DBHandler");
debug::printAll();
unset($dbHandler,$errorHandler, $userError);
unset($num);
//	$errorHandler->printErrors(HIGH_DETAIL);
//	print "<pre>";
//	print_r($errorHandler);
?>