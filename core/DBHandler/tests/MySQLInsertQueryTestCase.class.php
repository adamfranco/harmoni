<?php
/**
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLInsertQueryTestCase.class.php,v 1.5 2007/09/04 20:25:20 adamfranco Exp $
 */
 
    require_once(HARMONI.'DBHandler/InsertQuery.class.php');
	require_once(HARMONI.'DBHandler/MySQL/MySQL_SQLGenerator.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 *
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLInsertQueryTestCase.class.php,v 1.5 2007/09/04 20:25:20 adamfranco Exp $
 */

    class MySQLInsertQueryTestCase extends UnitTestCase {

		var $query;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->query = new InsertQuery();
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

			$sql = "INSERT\n  INTO user (user_id, user_uname, user_fname)\nVALUES (5, 'dradichk', 'Dobromir')\n";
	
			$sqlFromObject = MySQL_SQLGenerator::generateSQLQuery($this->query);
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

			$sql = "INSERT\n  INTO user (user_id, user_uname, user_fname)\nVALUES (5, 'dradichk', 'Dobromir'),\n       (6, 'afranco', 'Adam'),\n       (7, 'movsjani', 'Maks')\n";
	
			$sqlFromObject = MySQL_SQLGenerator::generateSQLQuery($this->query);
			$this->assertEqual($sql, $sqlFromObject);
		}
	
		/**
		 * Tests the reset() method and error conditions.
		 */ 
/*        function test_Reset() {
			$table = "user";
			$columns = array("user_id","user_uname","user_fname");
			$values = array("5","'dradichk'","'Dobromir'");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->addRowOfValues($values);
			$this->query->reset();

			$sqlFromObject = MySQL_SQLGenerator::generateSQLQuery($this->query);
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

			$sqlFromObject = MySQL_SQLGenerator::generateSQLQuery($this->query);
			$this->assertNull($sqlFromObject);
			
			// ----- test exception when # fields does not match # columns
			$table = "user";
			$columns = array("user_id","user_uname","user_fname","user_lname");
			$values = array("5","'dradichk'","'Dobromir'");

			$this->query->reset();
			$this->query->setTable($table);
			$this->query->setColumns($columns);
			$this->query->addRowOfValues($values);

			$sqlFromObject = MySQL_SQLGenerator::generateSQLQuery($this->query);
			$this->assertNull($sqlFromObject);
			
		}
	*/
    }

?>