<?php

    require_once('MySQLDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: MySQLSelectQueryResultTestCase.class.php,v 1.1 2003/06/20 19:04:28 dobomode Exp $
 * @package harmoni.dbhandler.tests
 * @copyright 2003 
 **/

    class MySQLSelectQueryResultTestCase extends UnitTestCase {
	
		// MySQLSelectQueryResult object
		var $queryResult;
		
		// MySQLDatabase object
		var $db;
		
		// Resource id
		var $rid;
	
		function MySQLSelectQueryResultTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here

			// connect to some database and do a select query
			$this->db =& new MySQLDatabase("devo.middlebury.edu", "test", "test", "test");
			$this->db->connect();
			$this->rid = $this->db->_query("SELECT * FROM test LIMIT 100,100");
			
			// create the query result
			$this->queryResult =& new MySQLSelectQueryResult($this->rid, $this->db->_linkId);
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->queryResult);
        }

		/**
		 * Tests a simple SELECT with one column and table. No WHERE, ORDER BY, GROUP BY, etc.
		 */ 
        function test_Constructor() {
			$this->assertEqual($this->rid, $this->queryResult->_resourceId);
			$this->assertEqual($this->db->_linkId, $this->queryResult->_linkId);
			$this->assertEqual($this->queryResult->getResourceId(), $this->queryResult->_resourceId);
		}
		
		/**
		 * Tests all functions.
		 */ 
        function test_All_Functions() {
			$this->assertEqual($this->queryResult->getNumberOfFields(), 3);

			$this->assertEqual($this->queryResult->getNumberOfRows(), 100);
		
			$this->assertTrue($this->queryResult->hasMoreRows());
		}
		
    }

?>