<?php

    require_once('MySQLInsertQuery.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @author Dobo Radichkov
 * @version $Id: MySQLInsertQueryTestCase.class.php,v 1.1 2003/06/16 22:10:32 dobomode Exp $
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
        function testGenerateSQLQueryOneInsert() {
			$table = "user";
			$columns = array("user_id","user_uname","user_fname");
			$values = array("5","'dradichk'","'Dobromir'");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->addRowOfValues($values);

			$sql = "INSERT INTO user\n\t(user_id, user_uname, user_fname)\n\tVALUES(5, 'dradichk', 'Dobromir');";
	
			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual($sql, $sqlFromObject);
		}
		
		/**
		 * Tests the generateSQLQuery method for inserting many rows.
		 */ 
        function testGenerateSQLQueryManyInserts() {
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

			$sql = "INSERT INTO user\n\t(user_id, user_uname, user_fname)\n\tVALUES(5, 'dradichk', 'Dobromir'), (6, 'afranco', 'Adam'), (7, 'movsjani', 'Maks');";
	
			$sqlFromObject = $this->query->generateSQLQuery();
			$this->assertEqual($sql, $sqlFromObject);
		}
		
    }

?>