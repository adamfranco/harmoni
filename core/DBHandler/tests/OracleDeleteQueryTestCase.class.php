<?php
/**
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OracleDeleteQueryTestCase.class.php,v 1.4 2005/04/07 16:33:25 adamfranco Exp $
 */
    require_once(HARMONI.'DBHandler/DeleteQuery.class.php');
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
 * @version $Id: OracleDeleteQueryTestCase.class.php,v 1.4 2005/04/07 16:33:25 adamfranco Exp $
 */

    class OracleDeleteQueryTestCase extends UnitTestCase {
	
		var $query;

		function OracleDeleteQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->query =& new DeleteQuery();
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
	
			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
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
	
			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
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

			$sqlFromObject = Oracle_SQLGenerator::generateSQLQuery($this->query);
			$this->assertNull($sqlFromObject);
		}

    }

?>