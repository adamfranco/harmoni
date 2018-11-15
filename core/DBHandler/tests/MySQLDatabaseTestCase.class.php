<?php
/**
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLDatabaseTestCase.class.php,v 1.6 2007/09/04 20:25:20 adamfranco Exp $
 */
    require_once(HARMONI.'DBHandler/MySQL/MySQLDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLDatabaseTestCase.class.php,v 1.6 2007/09/04 20:25:20 adamfranco Exp $
 */

class MySQLDatabaseTestCase extends UnitTestCase {
	
		var $database;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->database = new MySQLDatabase("localhost", "test", "test", "test");
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->database);
        }


		/**
		 * Tests the constructor.
		 **/
		function test_constructor() {
			$this->assertEqual("localhost", $this->database->_dbHost);
			$this->assertEqual("test", $this->database->_dbName);
			$this->assertEqual("test", $this->database->_dbUser);
			$this->assertEqual("test", $this->database->_dbPass);
		}
		
		/**
		 * Tests connect() and disconnect().
		 **/
		function test_connect_disconnect() {
			$this->database->connect();
			$this->assertTrue($this->database->_linkId !== false);

			$this->database->disconnect();
			$this->assertFalse($this->database->_linkId);
		}
		
		/**
		 * Tests connect(), disconnect, and isConnected().
		 **/
		function test_connect_disconnect_isConnected() {
			$this->database->connect();
			$this->assertTrue($this->database->isConnected());

			$this->database->disconnect();
			$this->assertFalse($this->database->isConnected());
		}
		
		/**
		 * Tests pconnect().
		 **/
		function test_pconnect() {
			// test pconnect
			$result1 = $this->database->pconnect();
			$this->assertEqual($result1, $this->database->_linkId);
			$this->assertTrue($this->database->isConnected());
		
			// test diconnect
			$result = $this->database->disconnect();
			$this->assertTrue($result);
			$this->assertFalse($this->database->isConnected());

			// test pconnect again
			$result2 = $this->database->pconnect();
			$this->assertEqual($result2, $this->database->_linkId);
			$this->assertTrue($this->database->isConnected());

			// the linkId should be the same as the first pconnect
			// *** actually, it shouldn't be, php would return a different
			// *** linkId, but would still open the same connection
			//$this->assertEqual($result2, $result1);
			$this->assertNotEqual($result2, $result1);
		
		}

		/**
		 * Tests everything.
		 **/
		function test_everything() {
			// test connect
			$result = $this->database->connect();
			$this->assertEqual($result, $this->database->_linkId);
			$this->assertTrue($this->database->isConnected());

			// test bad query
			$query = "BAD QUERY";
			$result = $this->database->_query($query);
			$this->assertFalse($result);
			$this->assertEqual($this->database->getNumberFailedQueries(), 1);
			$this->assertEqual($this->database->getNumberSuccessfulQueries(), 0);
			
			// test good query
			$query = "SELECT * FROM test";
			$result = $this->database->_query($query);
			$this->assertTrue($result !== false);
			$this->assertEqual($this->database->getNumberFailedQueries(), 1);
			$this->assertEqual($this->database->getNumberSuccessfulQueries(), 1);
			
			// test connect, before disconnecting
			$result = $this->database->connect();
			$this->assertFalse($result);

			// test diconnect
			$result = $this->database->disconnect();
			$this->assertTrue($result);
			$this->assertFalse($this->database->isConnected());
		}
		

	}