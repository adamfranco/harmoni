<?php

    require_once('MySQLUpdateQuery.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @author Dobo Radichkov
 * @version $Id: MySQLUpdateQueryTestCase.class.php,v 1.3 2003/06/18 20:33:18 adamfranco Exp $
 * @package harmoni.dbhandler.tests
 * @copyright 2003 
 **/

    class MySQLUpdateQueryTestCase extends UnitTestCase {
	
		var $query;

		function MySQLUpdateQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->query =& new MySQLUpdateQuery();
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
		 * Tests the generateSQLQuery() method for updating only one column   
		 */ 
        function test_Update_Without_Where_And_Only_One_Update_Field() {
			$table = "person";
			$columns = array("user_uname");
			$values = array("'dradichk'");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->setValues($values);

			$sql = "UPDATE person\nSET\n\tuser_uname = 'dradichk'\n";
	
			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual($sql, $sqlFromObject);
			
		}
		
		/**
		 * Tests the generateSQLQuery() method for updating multiple columns
		 */ 
        function test_Update_Without_Where_And_Many_Update_Fields() {
			$table = "person";
			$columns = array("user_uname", "user_fname", "user_id");
			$values = array("'dradichk'", "'Dobo'", "5");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->setValues($values);

			$sql = "UPDATE person\nSET\n\tuser_uname = 'dradichk',\n\tuser_fname = 'Dobo',\n\tuser_id = 5\n";
	
			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual($sql, $sqlFromObject);
		}
		
		
		/**
		 * Tests the generateSQLQuery() method for updating multiple columns that meet certain condition
		 */ 
        function test_Update_With_Where_And_Many_Update_Fields() {
			$table = "person";
			$columns = array("user_uname", "user_fname", "user_id");
			$values = array("'dradichk'", "'Dobo'", "5");
			$condition = "user_id = 3";
			
			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->setValues($values);
			$this->query->setCondition($condition);
			

			$sql = "UPDATE person\nSET\n\tuser_uname = 'dradichk',\n\tuser_fname = 'Dobo',\n\tuser_id = 5\nWHERE\n\tuser_id = 3\n";
	
			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual($sql, $sqlFromObject);
		}

		
		
		/**
		 * Tests the reset() method and error conditions.
		 */ 
        function test_Reset() {
			$table = "person";
			$columns = array("user_uname", "user_fname", "user_id");
			$values = array("'dradichk'", "'Dobo'", "5");
			$condition = "user_id = 3";

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->setValues($values);
			$this->query->setCondition($condition);
			$this->query->reset();

			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual("Exception", $sqlFromObject);
			
			// ----- test exception when # fields does not match # columns
			$table = "person";
			$columns = array("user_uname", "user_fname", "user_id");
			$values = array("'dradichk'", "'Dobo'", "5", "6");
			$condition = "user_id = 3";

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->setValues($values);
			$this->query->setCondition($condition);

			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual("Exception", $sqlFromObject);
			
		}

    }

?>