<?php

    require_once('MySQLInsertQuery.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @author Dobo Radichkov
 * @version $Id: MySQLInsertQueryTestCase.class.php,v 1.3 2003/06/18 15:31:58 dobomode Exp $
 * @copyright 2003 
 **/

    class MySQLInsertQueryTestCase extends UnitTestCase {

		var $query;

		function MySQLInsertQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->query =& new MySQLInsertQuery();
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
		 * Tests the generateSQLQuery method for inserting one row.
		 */ 
        function test_Generate_SQL_Query_One_Insert() {
			$table = "user";
			$columns = array("user_id","user_uname","user_fname");
			$values = array("5","'dradichk'","'Dobromir'");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->addRowOfValues($values);

			$sql = "INSERT INTO user\n\t(user_id, user_uname, user_fname)\n\tVALUES(5, 'dradichk', 'Dobromir')\n";
	
			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual($sql, $sqlFromObject);
		}
		
		/**
		 * Tests the generateSQLQuery method for inserting many rows.
		 */ 
        function test_Generate_SQL_Query_Many_Inserts() {
			$table = "user";
			$columns = array("user_id","user_uname","user_fname");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);

			$values = array("5","'dradichk'","'Dobromir'");
			$this->query->addRowOfValues($values);

			$values = array("6","'afranco'","'Adam'");
			$this->query->addRowOfValues($values);

			$values = array("7","'movsjani'","'Maks'");
			$this->query->addRowOfValues($values);

			$sql = "INSERT INTO user\n\t(user_id, user_uname, user_fname)\n\tVALUES(5, 'dradichk', 'Dobromir'), (6, 'afranco', 'Adam'), (7, 'movsjani', 'Maks')\n";
	
			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual($sql, $sqlFromObject);
		}
	
		/**
		 * Tests the reset() method and error conditions.
		 */ 
        function test_Reset() {
			$table = "user";
			$columns = array("user_id","user_uname","user_fname");
			$values = array("5","'dradichk'","'Dobromir'");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->addRowOfValues($values);
			$this->query->reset();

			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual("Exception", $sqlFromObject);
			
			// ------- now test reset with many insert rows
			
			$table = "user";
			$columns = array("user_id","user_uname","user_fname");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);

			$values = array("5","'dradichk'","'Dobromir'");
			$this->query->addRowOfValues($values);

			$values = array("6","'afranco'","'Adam'");
			$this->query->addRowOfValues($values);

			$values = array("7","'movsjani'","'Maks'");
			$this->query->addRowOfValues($values);

			$this->query->reset();

			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual("Exception", $sqlFromObject);
			
			// ----- test exception when # fields does not match # columns
			$table = "user";
			$columns = array("user_id","user_uname","user_fname","user_lname");
			$values = array("5","'dradichk'","'Dobromir'");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->addRowOfValues($values);

			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual("Exception", $sqlFromObject);
			
		}
	
    }

?>