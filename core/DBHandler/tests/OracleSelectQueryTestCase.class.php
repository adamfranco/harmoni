<?php
/**
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OracleSelectQueryTestCase.class.php,v 1.5 2007/09/04 20:25:21 adamfranco Exp $
 */
    require_once(HARMONI.'DBHandler/SelectQuery.class.php');
	require_once(HARMONI.'DBHandler/Oracle/Oracle_SQLGenerator.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OracleSelectQueryTestCase.class.php,v 1.5 2007/09/04 20:25:21 adamfranco Exp $
 */

    class OracleSelectQueryTestCase extends UnitTestCase {
	
		var $query;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->query = new SelectQuery();
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
			$this->assertEqual($this->query->getType(), SELECT);
		}


		/**
		 * Tests a simple SELECT with one column and table. No WHERE, ORDER BY, GROUP BY, etc.
		 */ 
        function test_One_Table_And_One_Column_No_Other_Clauses_No_Joins() {
			$table = "person";
			$columns = array("user_id");

			$this->query->reset();
			$this->query->addTable($table, NO_JOIN);
			$this->query->setColumns($columns);

			$sql = "SELECT\n\tuser_id\nFROM\n\tperson\n";
	
			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
			$this->assertEqual($sql, $sqlFromObject);
		}
		
		/**
		 * Tests a simple SELECT with multiple columns and tables. No WHERE, ORDER BY, GROUP BY, etc.
		 */ 
        function test_Many_Tables_And_Many_Columns_No_Other_Clauses_No_Joins() {
			$columns = array("user_id", "user_uname as username", "COUNT(*)");

			$this->query->reset();
			$this->query->setColumns($columns);
			$this->query->addTable("user", NO_JOIN);
			$this->query->addTable("class", NO_JOIN);
			$this->query->addTable("person", NO_JOIN);

			$sql = "SELECT\n\tuser_id,\n\tuser_uname as username,\n\tCOUNT(*)\nFROM\n\tuser,\n\tclass,\n\tperson\n";
	
			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
			$this->assertEqual($sql, $sqlFromObject);
		}
		
		/**
		 * Tests a simple SELECT with multiple columns and tables including WHERE, ORDER BY, and GROUP BY clauses.
		 */ 
        function test_Many_Tables_And_Many_Columns_All_Clauses_No_Joins() {
			$this->query->reset();
			$this->query->setColumns(array("user_id", "user_uname as username", "COUNT(*)"));
			$this->query->addTable("user", NO_JOIN);
			$this->query->addTable("class", NO_JOIN);
			$this->query->addTable("person", NO_JOIN);
			$this->query->setWhere("user_id = 5");
			$this->query->setGroupBy(array("user_id", "user_sex"), "user_age = 38");
			$this->query->addOrderBy("user_lname", ASCENDING);
			$this->query->addOrderBy("user_fname", DESCENDING);
			
			$sql = "SELECT\n\tuser_id,\n\tuser_uname as username,\n\tCOUNT(*)\nFROM\n\tuser,\n\tclass,\n\tperson\nWHERE\n\tuser_id = 5\nGROUP BY\n\tuser_id,\n\tuser_sex\nHAVING\n\tuser_age = 38\nORDER BY\n\tuser_lname ASC,\n\tuser_fname DESC\n";
	
			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
			$this->assertEqual($sql, $sqlFromObject);
		}
		
		/**
		 * Tests a SELECT with joins, and multiple columns and tables including WHERE, ORDER BY, and GROUP BY clauses.
		 */ 
        function test_Many_Tables_And_Many_Columns_All_Clauses_All_Joins() {
			$this->query->reset();
			$this->query->setColumns(array("user_id AS 1"));
			$this->query->addColumn("user_uname", "username", "db");
			$this->query->addColumn("COUNT(*)", "c");
			$this->query->addTable("user", NO_JOIN);
			$this->query->addTable("class", INNER_JOIN, "user.user_weight = class.class_id");
			$this->query->addTable("person", NO_JOIN, "", "PERSON");
			$this->query->addTable("tree", LEFT_JOIN, "person.person_id = tree.tree_height - 10");
			$this->query->addTable("bush", RIGHT_JOIN, "tree.tree_leaves = 3000", "BUSH");
			$this->query->addTable("sand", NO_JOIN);
			$this->query->addWhere("user_id = 5");
			$this->query->addWhere("user_id = 8", _AND);
			$this->query->addWhere("user_id = 10", _OR);
			$this->query->addWhere("user_id = 12", _OR);
			$this->query->setGroupBy(array("user_id", "user_sex"), "user_age = 38");
			$this->query->addOrderBy("user_lname", ASCENDING);
			$this->query->addOrderBy("user_fname", DESCENDING);
			$this->query->setDistinct(true);
			$this->query->limitNumberOfRows(100);
			$this->query->startFromRow(10);
			
			$tables = "\n\tuser\n\t\tINNER JOIN\n\tclass\n\t\tON user.user_weight = class.class_id,\n\tperson PERSON\n\t\tLEFT JOIN\n\ttree\n\t\tON person.person_id = tree.tree_height - 10\n\t\tRIGHT JOIN\n\tbush BUSH\n\t\tON tree.tree_leaves = 3000,\n\tsand";
			$sql = "SELECT DISTINCT\n\tuser_id AS 1,\n\tdb.user_uname AS username,\n\tCOUNT(*) AS c\nFROM{$tables}\nWHERE\n\tuser_id = 5\n\t\tAND\n\tuser_id = 8\n\t\tOR\n\tuser_id = 10\n\t\tOR\n\tuser_id = 12\nGROUP BY\n\tuser_id,\n\tuser_sex\nHAVING\n\tuser_age = 38\nORDER BY\n\tuser_lname ASC,\n\tuser_fname DESC\n";
			$sql = "SELECT *\nFROM (\nSELECT\n\tuser_id AS 1,\n\tdb.user_uname AS username,\n\tCOUNT(*) AS c,\n\tROWNUM ROW_NUM_UNIQUE_\nFROM (\n".$sql.")\nWHERE ROWNUM < 110\n)\nWHERE ROW_NUM_UNIQUE_ >= 10 AND ROW_NUM_UNIQUE_ <= 109\n";
	
			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
			$this->assertEqual($sql, $sqlFromObject);
		}
		
    }

?>