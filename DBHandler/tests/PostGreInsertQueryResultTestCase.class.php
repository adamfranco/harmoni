<?php

    require_once(HARMONI.'DBHandler/PostGre/PostGreDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: PostGreInsertQueryResultTestCase.class.php,v 1.1 2003/07/16 02:55:58 dobomode Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

    class PostGreInsertQueryResultTestCase extends UnitTestCase {
	
		// PostGreDatabase object
		var $db;
	
		function PostGreINSERTQueryResultTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here

			// connect to some database and do a INSERT query
			$this->db =& new PostGreDatabase("devo.middlebury.edu", "harmoniTest", "test", "test");
			$this->db->connect();
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
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
			$queryResult =& new PostGreInsertQueryResult($rid);
			
			$this->assertEqual($rid, $queryResult->_resourceId);
		}
		
		/**
		 * Tests one insert.
		 */ 
        function test_One_Insert() {
			// get the query result
			$rid = $this->db->_query("INSERT INTO test1 (value) VALUES('depeche')");
			$queryResult =& new PostGreInsertQueryResult($rid);

			$this->assertNotNull($queryResult->getLastAutoIncrementValue());
			$this->assertEqual($queryResult->getNumberOfRows(), 1);
			
			echo $queryResult->getLastAutoIncrementValue()."<br>*********";
		}
		
		
    }

?>