<?php

    require_once(HARMONI.'DBHandler/PostGre/PostGreDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: PostGreDatabaseTestCase.class.php,v 1.3 2005/02/07 21:38:13 adamfranco Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

    class PostGreDatabaseTestCase extends UnitTestCase {
	
		var $database;

		function PostGreDeleteQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->database =& new PostGreDatabase("devo.middlebury.edu", "harmoniTest", "test", "test");
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
			$this->assertEqual("devo.middlebury.edu", $this->database->_dbHost);
			$this->assertEqual("harmoniTest", $this->database->_dbName);
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