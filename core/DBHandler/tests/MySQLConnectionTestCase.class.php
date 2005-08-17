<?php
/**
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLConnectionTestCase.class.php,v 1.1 2005/08/17 23:17:13 adamfranco Exp $
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
 * @version $Id: MySQLConnectionTestCase.class.php,v 1.1 2005/08/17 23:17:13 adamfranco Exp $
 */

class MySQLConnectionTestCase extends UnitTestCase {
	
		var $databaseA;
		var $databaseB;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->databaseA =& new MySQLDatabase("localhost", "test", "test", "test");
			$this->databaseB =& new MySQLDatabase("localhost", "testB", "test", "test");
			
			$this->tablesA = array (
					'courses',
					'decisions',
					'dm',
					'imtest',
					'login',
					'storage',
					'students',
					'test',
					'test1',
					'user',
					'users'
			);
			$this->tablesB = array (
					'table1',
					'table2'
			);
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->databaseA);
			unset($this->databaseB);
        }


		/**
		 * Tests the constructor.
		 **/
		function test_constructor() {
			$this->assertEqual("localhost", $this->databaseA->_dbHost);
			$this->assertEqual("test", $this->databaseA->_dbName);
			$this->assertEqual("test", $this->databaseA->_dbUser);
			$this->assertEqual("test", $this->databaseA->_dbPass);
			
			$this->assertEqual("localhost", $this->databaseB->_dbHost);
			$this->assertEqual("testB", $this->databaseB->_dbName);
			$this->assertEqual("test", $this->databaseB->_dbUser);
			$this->assertEqual("test", $this->databaseB->_dbPass);
		}
		
		/**
		 * Tests that the correct database is selected when a single database is
		 * connected to at a time.
		 **/
		function test_single_connect() {
			$this->databaseA->connect();
			$this->assertTrue($this->databaseA->_linkId !== false);
			
			$this->assertTrue($this->databaseA->getTableList() == $this->tablesA);
			$this->assertFalse($this->databaseA->getTableList() == $this->tablesB);

			$this->databaseA->disconnect();
			$this->assertFalse($this->databaseA->_linkId);
			
			
			
			$this->databaseB->connect();
			$this->assertTrue($this->databaseB->_linkId !== false);
			
			$this->assertTrue($this->databaseB->getTableList() == $this->tablesB);
			$this->assertFalse($this->databaseB->getTableList() == $this->tablesA);

			$this->databaseB->disconnect();
			$this->assertFalse($this->databaseB->_linkId);
		}

		/**
		 * Tests that the correct database is selected when two databases are
		 * connected to at the same time.
		 **/
		function test_dual_connect() {
			// Connect to both databases
			$this->assertFalse($this->databaseA->_linkId);
			$this->databaseA->connect();
			$this->assertTrue($this->databaseA->_linkId !== false);
			
			$this->assertFalse($this->databaseB->_linkId);
			$this->databaseB->connect();
			$this->assertTrue($this->databaseB->_linkId !== false);
			
// 			$this->assertNotEqual($this->databaseA->_linkId, $this->databaseB->_linkId);
			
			
			// Check that the appropriate db is selected for both databases.
			$this->assertTrue($this->databaseA->getTableList() == $this->tablesA);
			$this->assertFalse($this->databaseA->getTableList() == $this->tablesB);
			
			$this->assertTrue($this->databaseB->getTableList() == $this->tablesB);
			$this->assertFalse($this->databaseB->getTableList() == $this->tablesA);
			
			
			// Disconnect from both databases
			$this->databaseA->disconnect();
			$this->assertFalse($this->databaseA->_linkId);

			$this->databaseB->disconnect();
			$this->assertFalse($this->databaseB->_linkId);
		}
		
		/**
		 * Tests that the correct database is selected when a single database is
		 * connected to at a time.
		 **/
		function test_single_pconnect() {
			$this->databaseA->pConnect();
			$this->assertTrue($this->databaseA->_linkId !== false);
			
			$this->assertTrue($this->databaseA->getTableList() == $this->tablesA);
			$this->assertFalse($this->databaseA->getTableList() == $this->tablesB);

			$this->databaseA->disconnect();
			$this->assertFalse($this->databaseA->_linkId);
			
			
			
			$this->databaseB->pConnect();
			$this->assertTrue($this->databaseB->_linkId !== false);
			
			$this->assertTrue($this->databaseB->getTableList() == $this->tablesB);
			$this->assertFalse($this->databaseB->getTableList() == $this->tablesA);

			$this->databaseB->disconnect();
			$this->assertFalse($this->databaseB->_linkId);
		}

		/**
		 * Tests that the correct database is selected when two databases are
		 * connected to at the same time.
		 **/
		function test_dual_pconnect() {
			// Connect to both databases
			$this->assertFalse($this->databaseA->_linkId);
			$this->databaseA->pConnect();
			$this->assertTrue($this->databaseA->_linkId !== false);
			
			$this->assertFalse($this->databaseB->_linkId);
			$this->databaseB->pConnect();
			$this->assertTrue($this->databaseB->_linkId !== false);
			
// 			$this->assertNotEqual($this->databaseA->_linkId, $this->databaseB->_linkId);
			
			
			// Check that the appropriate db is selected for both databases.
			$this->assertTrue($this->databaseA->getTableList() == $this->tablesA);
			$this->assertFalse($this->databaseA->getTableList() == $this->tablesB);
			
			$this->assertTrue($this->databaseB->getTableList() == $this->tablesB);
			$this->assertFalse($this->databaseB->getTableList() == $this->tablesA);
			
			
			// Disconnect from both databases
			$this->databaseA->disconnect();
			$this->assertFalse($this->databaseA->_linkId);

			$this->databaseB->disconnect();
			$this->assertFalse($this->databaseB->_linkId);
		}

	}