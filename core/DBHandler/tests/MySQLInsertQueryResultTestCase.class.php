<?php

    require_once(HARMONI.'DBHandler/MySQL/MySQLDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: MySQLInsertQueryResultTestCase.class.php,v 1.2 2005/01/19 16:31:30 adamfranco Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

    class MySQLINSERTQueryResultTestCase extends UnitTestCase {
	
		// MySQLDatabase object
		var $db;
	
		function MySQLINSERTQueryResultTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here

			// connect to some database and do a INSERT query
			$this->db =& new MySQLDatabase("devo.middlebury.edu", "test", "test", "test");
			$this->db->connect();
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->db);
        }

		/**
		 * Tests constructor.
		 */ 
        function test_Constructor() {
			// get the query result
			$rid = $this->db->_query("INSERT INTO test1 SET value = 'depeche'");
			$queryResult =& new MySQLInsertQueryResult($this->db->_linkId);

			$this->assertEqual($this->db->_linkId, $queryResult->_linkId);
		}
		
		/**
		 * Tests one insert.
		 */ 
        function test_One_Insert() {
			// get the query result
			$rid = $this->db->_query("INSERT INTO test1 SET value = 'depeche'");
			$queryResult =& new MySQLInsertQueryResult($this->db->_linkId);

			$this->assertNotNull($queryResult->getLastAutoIncrementValue());
			$this->assertEqual($queryResult->getNumberOfRows(), 1);
		}
		
		
		/**
		 * Tests many inserts.
		 */ 
        function test_Many_Inserts() {
			// get the query result
			$rid = $this->db->_query("INSERT INTO test1 (value) VALUES('depeche'),('depeche1'),('depeche2')");
			$queryResult =& new MySQLInsertQueryResult($this->db->_linkId);

			$this->assertNotNull($queryResult->getLastAutoIncrementValue());
			$this->assertEqual($queryResult->getNumberOfRows(), 3);
		}
		
    }

?>