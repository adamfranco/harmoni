<?php
/**
 * A group test template using the SimpleTest unit testing package.
 * Just add the UnitTestCase files below using addTestFile().
 *
 *
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: test.php,v 1.9 2007/09/10 20:52:31 adamfranco Exp $
 */
 
ini_set('display_errors', true);
 
if (!defined('HARMONI')) {
	require_once("../../../harmoni.inc.php");
}

if (!defined('SIMPLE_TEST')) {
	define('SIMPLE_TEST', HARMONI.'simple_test/');
}
require_once(SIMPLE_TEST . 'simple_unit.php');
require_once(SIMPLE_TEST . 'dobo_simple_html_test.php');

$context = new OsidContext;
$context->assignContext('harmoni', $harmoni);
$configuration = new ConfigurationProperties;
Services::startManagerAsService("DatabaseManager", $context, $configuration);
$dbc = Services::getService("DBHandler");

require_once(HARMONI."errorHandler/throw.inc.php");
require_once(HARMONI."utilities/ArgumentValidator.class.php");

// 	if (!Services::serviceAvailable("ErrorHandler")) {
// 	   	Services::registerService("ErrorHandler","ErrorHandler");
// 		require_once(OKI2."osid/OsidContext.php");
// 		
// 		require_once(HARMONI."oki2/shared/ConfigurationProperties.class.php");
// 		$configuration = new ConfigurationProperties;
// 		Services::startManagerAsService("ErrorHandler", $context, $configuration);
// 	}
// 	
// 	$errorHandler = Services::getService("ErrorHandler");
// 	$errorHandler->setDebugMode(true);

 $test = new GroupTest('DBHandler tests');

$dbSystem = 'postgresql';

switch ($dbSystem) {
// MYSQL
case 'mysql':
	// connect to some database and set up our tables
	$db = new MySQLDatabase("localhost", "test", "test", "test");
	$db->connect();
	// Build our test database
	SQLUtils::runSQLfile(dirname(__FILE__)."/test.sql");
	$db->disconnect();
	
	// connect to some database and set up our tables
	$db = new MySQLDatabase("localhost", "testB", "test", "test");
	$db->connect();
	// Build our test database
	SQLUtils::runSQLfile(dirname(__FILE__)."/testB.sql");
	$db->disconnect();

    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLInsertQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLUpdateQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLDeleteQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLSelectQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLDatabaseTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLSelectQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLInsertQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLComprehensiveTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLConnectionTestCase.class.php');
    
   	break;

case 'postgresql':
	$dbIndex = $dbc->createDatabase(POSTGRESQL, "localhost", "harmoniTest", "test", "test");
	$dbc->connect($dbIndex);
	// Build our test database
	SQLUtils::runSQLfile(dirname(__FILE__)."/test_PostgreSQL.sql", $dbIndex);
	$dbc->disconnect($dbIndex);
	
// 	// connect to some database and set up our tables
// 	$dbIndexB = $dbc->createDatabase(POSTGRESQL, "localhost", "harmoniTestB", "test", "test");
// 	$db->connect($dbIndexB);
// 	// Build our test database
// 	SQLUtils::runSQLfile(dirname(__FILE__)."/testB.sql", $dbIndexB);
// 	$db->disconnect($dbIndexB);
// 	
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreDatabaseTestCase.class.php');

	$test->addTestFile(HARMONI.'DBHandler/tests/PostGreDeleteQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreUpdateQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreInsertQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreSelectQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreInsertQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreSelectQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreComprehensiveTestCase.class.php');
   
   break;
}
/*	
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleDeleteQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleUpdateQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleInsertQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleSelectQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleDatabaseTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleInsertQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleSelectQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleComprehensiveTestCase.class.php');

    
*/
    $test->addTestFile(HARMONI.'DBHandler/tests/GenericSQLQueryTestCase.class.php');

    $test->addTestFile(HARMONI.'DBHandler/tests/DBHandlerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>