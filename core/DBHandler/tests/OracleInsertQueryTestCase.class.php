<?php

    require_once(HARMONI.'DBHandler/InsertQuery.class.php');
	require_once(HARMONI.'DBHandler/Oracle/Oracle_SQLGenerator.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: OracleInsertQueryTestCase.class.php,v 1.2 2005/01/19 16:31:31 adamfranco Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

    class OracleInsertQueryTestCase extends UnitTestCase {

		var $query;

		function OracleInsertQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->query =& new InsertQuery();
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->query);
        }



		/**
		 * Tests the getType function.
		 **/
		function test_getType(){
			$this->assertEqual($this->query->getType(), INSERT);
			
			$this->query->setAutoIncrementColumn("id", "seq");
			
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
	
			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
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
			$this->query->setAutoIncrementColumn("id", "seq");

			$values = array("5","'dradichk'","'Dobromir'");
			$this->query->addRowOfValues($values);

			$values = array("6","'afranco'","'Adam'");
			$this->query->addRowOfValues($values);

			$values = array("7","'movsjani'","'Maks'");
			$this->query->addRowOfValues($values);

			$sql = array();
			$sql[] = "INSERT INTO user\n\t(user_id, user_uname, user_fname, id)\n\tVALUES(5, 'dradichk', 'Dobromir', seq.NEXTVAL)\n";
			$sql[] = "INSERT INTO user\n\t(user_id, user_uname, user_fname, id)\n\tVALUES(6, 'afranco', 'Adam', seq.NEXTVAL)\n";
			$sql[] = "INSERT INTO user\n\t(user_id, user_uname, user_fname, id)\n\tVALUES(7, 'movsjani', 'Maks', seq.NEXTVAL)\n";
	
			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
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

			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
			$this->assertNull($sqlFromObject);
			
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

			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
			$this->assertNull($sqlFromObject);
			
			// ----- test exception when # fields does not match # columns
			$table = "user";
			$columns = array("user_id","user_uname","user_fname","user_lname");
			$values = array("5","'dradichk'","'Dobromir'");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->addRowOfValues($values);

			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
			$this->assertNull($sqlFromObject);
			
		}
	
    }

?>