<?php

    require_once(HARMONI.'DBHandler/DeleteQuery.class.php');
    require_once(HARMONI.'DBHandler/PostGre/PostGre_SQLGenerator.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: PostGreDeleteQueryTestCase.class.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

    class PostGreDeleteQueryTestCase extends UnitTestCase {
	
		var $query;

		function PostGreDeleteQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->query =& new DeleteQuery();
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
		 * Tests the getType function.
		 **/
		function test_getType(){
			$this->assertEqual($this->query->getType(), DELETE);
		}
		

		/**
		 * Tests the generateSQLQuery() without WHERE clause.
		 */ 
        function test_Delete_Without_Where() {
			$table = "person";

			$this->query->reset();
			$this->query->setTable($table);

			$sql = "DELETE\nFROM\n\tperson\n";
	
			$sqlFromObject = PostGre_SQLGenerator::generateSQLQuery($this->query);
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
			$this->query->addWhere($condition);
			$this->query->addWhere($condition);

			$sql = "DELETE\nFROM\n\tperson\nWHERE\n\tuser_uname = 'dradichk'\n\t\tAND\n\tuser_uname = 'dradichk'\n";
	
			$sqlFromObject = PostGre_SQLGenerator::generateSQLQuery($this->query);
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

			$sqlFromObject = PostGre_SQLGenerator::generateSQLQuery($this->query);
			$this->assertNull($sqlFromObject);
		}

    }

?>