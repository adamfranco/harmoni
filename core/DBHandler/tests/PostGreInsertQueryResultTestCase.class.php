<?php
/**
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostGreInsertQueryResultTestCase.class.php,v 1.7 2007/09/10 20:52:31 adamfranco Exp $
 */
    require_once(HARMONI.'DBHandler/PostGre/PostGreDatabase.class.php');

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
 * @version $Id: PostGreInsertQueryResultTestCase.class.php,v 1.7 2007/09/10 20:52:31 adamfranco Exp $
 */

    class PostGreInsertQueryResultTestCase extends UnitTestCase {
	
		// PostGreDatabase object
		var $db;
	
		function PostGreINSERTQueryResultTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here

			// connect to some database and do a INSERT query
			$this->db = new PostGreDatabase("localhost", "harmoniTest", "test", "test");
			$this->db->connect();
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->db);
        }

		/**
		 * Tests constructor.
		 */ 
        function test_Constructor() {
			// get the query result
			$rid = $this->db->_query("INSERT INTO test1 (id, value) VALUES(NEXTVAL('test1_id_seq'), 'depeche')");
			$lastIdQuery = "SELECT CURRVAL('test1_id_seq')";
			$lastIdResourceId = $this->db->_query($lastIdQuery);
			$arr = pg_fetch_row($lastIdResourceId, 0);
			$lastId = intval($arr[0]);
			$queryResult = new PostGreInsertQueryResult($rid, $lastId);
			
			$this->assertEqual($rid, $queryResult->_resourceId);
		}
		
		/**
		 * Tests one insert.
		 */ 
        function test_One_Insert() {
			// get the query result
			$rid = $this->db->_query("INSERT INTO test1 (id, value) VALUES(NEXTVAL('test1_id_seq'), 'depeche')");
			$lastIdQuery = "SELECT CURRVAL('test1_id_seq')";
			$lastIdResourceId = $this->db->_query($lastIdQuery);
			$arr = pg_fetch_row($lastIdResourceId, 0);
			$lastId = intval($arr[0]);

			$queryResult = new PostGreInsertQueryResult($rid, $lastId);

			$this->assertNotNull($queryResult->getLastAutoIncrementValue());
			$this->assertEqual($queryResult->getNumberOfRows(), 1);
		}

		
		/**
		 * Tests many inserts.
		 */ 
        function test_Many_Inserts() {
			// get the query result
			$sql = "INSERT INTO test1 (id, value) VALUES(NEXTVAL('test1_id_seq'), 'depeche1');\n";
			$sql .= "INSERT INTO test1 (id, value) VALUES(NEXTVAL('test1_id_seq'), 'depeche2');\n";
			$sql .= "INSERT INTO test1 (id, value) VALUES(NEXTVAL('test1_id_seq'), 'depeche3')";

			$rid = $this->db->_query($sql);
			$lastIdQuery = "SELECT CURRVAL('test1_id_seq')";
			$lastIdResourceId = $this->db->_query($lastIdQuery);
			$arr = pg_fetch_row($lastIdResourceId, 0);
			$lastId = intval($arr[0]);

			$queryResult = new PostGreInsertQueryResult($rid, $lastId);

			$this->assertNotNull($queryResult->getLastAutoIncrementValue());
			$this->assertEqual($queryResult->getNumberOfRows(), 1);
		}
	
		
		
    }

?>