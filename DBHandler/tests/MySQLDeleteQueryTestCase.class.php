<?php

    require_once('MySQLDeleteQuery.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @author Dobo Radichkov
 * @version $Id: MySQLDeleteQueryTestCase.class.php,v 1.3 2003/06/18 22:27:46 dobomode Exp $
 * @package harmoni.dbhandler.tests
 * @copyright 2003 
 **/

    class MySQLDeleteQueryTestCase extends UnitTestCase {
	
		var $query;

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
			$this->query =& new MySQLDeleteQuery();
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->query);
        }

		/**
		 * Tests the generateSQLQuery() without WHERE clause.
		 */ 
        function test_Delete_Without_Where() {
			$table = "person";

			$this->query->reset();
			$this->query->setTable($table);

			$sql = "DELETE\nFROM\n\tperson\n";
	
			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual($sql, $sqlFromObject);
			
		}
		
		/**
		 * Tests the generateSQLQuery() with WHERE clause.
		 */ 
        function test_Delete_With_Where() {
			$table = "person";
			$condition = "user_uname = 'dradichk'";

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setWhere($condition);

			$sql = "DELETE\nFROM\n\tperson\nWHERE\n\tuser_uname = 'dradichk'\n";
	
			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual($sql, $sqlFromObject);
			
		}
		
	
		/**
		 * Tests the reset() method and error conditions.
		 */ 
        function test_Reset() {
			$table = "person";
			$condition = "user_uname = 'dradichk'";

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setWhere($condition);
			$this->query->reset();

			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual("Exception", $sqlFromObject);
		}

    }

?>