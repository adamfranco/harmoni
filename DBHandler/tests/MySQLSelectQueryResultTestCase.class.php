<?php

    require_once('MySQLDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: MySQLSelectQueryResultTestCase.class.php,v 1.2 2003/06/21 00:30:25 dobomode Exp $
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
			$this->rid = $this->db->_query("SELECT * FROM test LIMIT 100,4");
			
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
			// number of fields must be 3
			$this->assertEqual($this->queryResult->getNumberOfFields(), 3);

			// only 4 rows must be returned
			$this->assertEqual($this->queryResult->getNumberOfRows(), 4);
		
			// we have more rows left
			$this->assertTrue($this->queryResult->hasMoreRows());
			
			// see if field names are correct
			$fieldNames = $this->queryResult->getFieldNames();
			$this->assertEqual($fieldNames, array("id", "FK", "value"));
			
			$id = $this->queryResult->field("id");
			$FK = $this->queryResult->field("FK");
			$value = $this->queryResult->field("value");
			$row["id"] = $id;
			$row["FK"] = $FK;
			$row["value"] = $value;
			$this->assertEqual($id, "101");
			$this->assertEqual($FK, "5");
			$this->assertEqual($value, "This is the value");
			$this->assertEqual($row, $this->queryResult->getCurrentRow());
			
			// after 4 advances, no more rows should be left
			for ($i = 0; $i < 4; $i++)
				$this->queryResult->advanceRow();
			$this->assertFalse($this->queryResult->hasMoreRows());
		}
		
    }

?>