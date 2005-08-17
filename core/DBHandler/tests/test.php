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
 * @version $Id: test.php,v 1.6 2005/08/17 19:46:59 adamfranco Exp $
 */
 
    if (!defined('HARMONI')) {
        require_once("../../../harmoni.inc.php");
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
		require_once(OKI2."osid/OsidContext.php");
		$context =& new OsidContext;
		$context->assignContext('harmoni', $harmoni);
		require_once(HARMONI."oki2/shared/ConfigurationProperties.class.php");
		$configuration =& new ConfigurationProperties;
		Services::startManagerAsService("ErrorHandler", $context, $configuration);
	}
	
	$errorHandler =& Services::getService("ErrorHandler");
	$errorHandler->setDebugMode(true);
	
	// connect to some database and set up our tables
	$this->db =& new MySQLDatabase("localhost", "test", "test", "test");
	$this->db->connect();
	
	// Build our test database
	$queryString = SQLUtils::parseSQLFile(dirname(__FILE__)."/test.sql");
	// break up the query string.
	$queryStrings = explode(";", $queryString);
	// Run each query
	foreach ($queryStrings as $string) {
		$string = trim($string);
		if ($string) {
			$this->db->_query($string);
		}
	}

    $test =& new GroupTest('DBHandler tests');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLInsertQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLUpdateQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLDeleteQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLSelectQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLDatabaseTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLSelectQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLInsertQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/MySQLComprehensiveTestCase.class.php');
/*	
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleDeleteQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleUpdateQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleInsertQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleSelectQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleDatabaseTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleInsertQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleSelectQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/OracleComprehensiveTestCase.class.php');

    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreDeleteQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreUpdateQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreInsertQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreSelectQueryTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreDatabaseTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreInsertQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreSelectQueryResultTestCase.class.php');
    $test->addTestFile(HARMONI.'DBHandler/tests/PostGreComprehensiveTestCase.class.php');
*/
    $test->addTestFile(HARMONI.'DBHandler/tests/GenericSQLQueryTestCase.class.php');

    $test->addTestFile(HARMONI.'DBHandler/tests/DBHandlerTestCase.class.php');
    $test->attachObserver(new DoboTestHtmlDisplay());
    $test->run();

?>