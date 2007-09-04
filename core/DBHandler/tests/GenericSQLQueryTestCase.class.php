<?php
/**
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GenericSQLQueryTestCase.class.php,v 1.5 2007/09/04 20:25:20 adamfranco Exp $
 */
    require_once(HARMONI.'DBHandler/GenericSQLQuery.class.php');
    require_once(HARMONI.'DBHandler/MySQL/MySQL_SQLGenerator.class.php');

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
 * @version $Id: GenericSQLQueryTestCase.class.php,v 1.5 2007/09/04 20:25:20 adamfranco Exp $
 **/

    class GenericSQLQueryTestCase extends UnitTestCase {
	
		var $query;

		function GenericSQLQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->query = new GenericSQLQuery();
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
			$this->assertEqual($this->query->getType(), GENERIC);
		}
		

		/**
		 * Tests one query.
		 */ 
        function test_One_Query() {
			$this->query->reset();
			
			$sql = "SELECT shit FROM crap";
			$this->query->addSQLQuery($sql);

			$sqlFromObject = MySQL_SQLGenerator::generateSQLQuery($this->query);
			$this->assertEqual($sql, $sqlFromObject);
			
		}

		/**
		 * Tests many query.
		 */ 
        function test_Many_Query() {
			$this->query->reset();
			$arr = array();

			$sql = "SELECT shit1 FROM crap1";
			$arr[] = $sql;
			$this->query->addSQLQuery($sql);

			$sql = "SELECT shit2 FROM crap2";
			$this->query->addSQLQuery($sql);
			$arr[] = $sql;

			$sql = "SELECT shit3 FROM crap3";
			$this->query->addSQLQuery($sql);
			$arr[] = $sql;

			
			$sqlFromObject = MySQL_SQLGenerator::generateSQLQuery($this->query);
			$this->assertEqual($arr, $sqlFromObject);
			
		}

    }

?>