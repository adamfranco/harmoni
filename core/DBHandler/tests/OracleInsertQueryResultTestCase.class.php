<?php

    require_once(HARMONI.'DBHandler/Oracle/OracleDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: OracleInsertQueryResultTestCase.class.php,v 1.3 2005/02/07 21:38:13 adamfranco Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

    class OracleInsertQueryResultTestCase extends UnitTestCase {
	
		// OracleDatabase object
		var $db;
	
		function OracleINSERTQueryResultTestCase() {
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
			$this->db =& new OracleDatabase("devo.middlebury.edu", "harmoniTest", "test", "test");
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
			$rid = $this->db->_query("INSERT INTO test1 (value) VALUES('depeche')");
			$queryResult =& new OracleInsertQueryResult($rid);
			
			$this->assertEqual($rid, $queryResult->_resourceId);
		}
		
		/**
		 * Tests one insert.
		 */ 
        function test_One_Insert() {
			// get the query result
			$rid = $this->db->_query("INSERT INTO test1 (value) VALUES('depeche')");
			$lastIdQuery = "SELECT CURRVAL('test1_id_seq')";
			$lastIdResourceId = $this->db->_query($lastIdQuery);
			$arr = pg_fetch_row($lastIdResourceId, 0);
			$lastId = intval($arr[0]);

			$queryResult =& new OracleInsertQueryResult($rid, $lastId);

			$this->assertNotNull($queryResult->getLastAutoIncrementValue());
			$this->assertEqual($queryResult->getNumberOfRows(), 1);
		}

		
		/**
		 * Tests many inserts.
		 */ 
        function test_Many_Inserts() {
			// get the query result
			$sql = "INSERT INTO test1 (value) VALUES('depeche1');\n";
			$sql .= "INSERT INTO test1 (value) VALUES('depeche2');\n";
			$sql .= "INSERT INTO test1 (value) VALUES('depeche3')";

			$rid = $this->db->_query($sql);
			$lastIdQuery = "SELECT CURRVAL('test1_id_seq')";
			$lastIdResourceId = $this->db->_query($lastIdQuery);
			$arr = pg_fetch_row($lastIdResourceId, 0);
			$lastId = intval($arr[0]);

			$queryResult =& new OracleInsertQueryResult($rid, $lastId);

			$this->assertNotNull($queryResult->getLastAutoIncrementValue());
			$this->assertEqual($queryResult->getNumberOfRows(), 1);
		}
	
		
		
    }

?>