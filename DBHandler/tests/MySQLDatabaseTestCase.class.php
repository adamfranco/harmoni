<?php

    require_once(HARMONI.'DBHandler/classes/MySQL/MySQLDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: MySQLDatabaseTestCase.class.php,v 1.4 2003/06/24 18:27:46 dobomode Exp $
 * @package harmoni.dbhandler.tests
 * @copyright 2003 
 **/

    class MySQLDatabaseTestCase extends UnitTestCase {
	
		var $database;

		function MySQLDeleteQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->database =& new MySQLDatabase("et.middlebury.edu", "dobo", "dobo", "dobo");
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->database);
        }


		/**
		 * Tests the constructor.
		 **/
		function test_constructor() {
			$this->assertEqual("et.middlebury.edu", $this->database->_dbHost);
			$this->assertEqual("dobo", $this->database->_dbName);
			$this->assertEqual("dobo", $this->database->_dbUser);
			$this->assertEqual("dobo", $this->database->_dbPass);
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
			$query = "SELECT * FROM gb";
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