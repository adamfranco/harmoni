<?php
/**
 * @package harmoni.dbc.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DBHandlerTestCase.class.php,v 1.4 2005/04/07 16:33:25 adamfranco Exp $
 */
    require_once(HARMONI.'DBHandler/DBHandler.class.php');

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
 * @version $Id: DBHandlerTestCase.class.php,v 1.4 2005/04/07 16:33:25 adamfranco Exp $
 */

    class DBHandlerTestCase extends UnitTestCase {
	
		var $dbhandler;

		function MySQLDeleteQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->dbhandler =& new DBHandler();
			$this->dbhandler->createDatabase(MYSQL,"devo.middlebury.edu", "test", "test", "test");
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->dbhandler);
        }


		/**
		 * Tests the constructor.
		 **/
		function test_constructor() {
			$database =& $this->dbhandler->_databases[0];
			$this->assertIsA($database, "mysqldatabase");
			$this->assertEqual("devo.middlebury.edu", $database->_dbHost);
			$this->assertEqual("test", $database->_dbName);
			$this->assertEqual("test", $database->_dbUser);
			$this->assertEqual("test", $database->_dbPass);
		}
		
		/**
		 * Test the addition of a new database.
		 **/
		function test_createdatabase() {
			$mysql =& new MySQLDatabase("devo123.middlebury.edu", "test123", "test123", "test123");
			$databaseId = $this->dbhandler->addDatabase($mysql);
			$this->assertEqual("mysqldatabase", get_class($this->dbhandler->_databases[$databaseId]));
			$this->assertEqual("devo123.middlebury.edu", $this->dbhandler->_databases[$databaseId]->_dbHost);
			$this->assertEqual("test123", $this->dbhandler->_databases[$databaseId]->_dbName);
			$this->assertEqual("test123", $this->dbhandler->_databases[$databaseId]->_dbUser);
			$this->assertEqual("test123", $this->dbhandler->_databases[$databaseId]->_dbPass);
			$this->assertEqual(1,$databaseId);
		}
		
		
		/**
		 * Test connecting and querying to one database
		 **/
		function test_querying_and_connecting_with_one_database() {
			$isSuccessful = $this->dbhandler->connect();
			$this->assertTrue($isSuccessful);
			$this->assertTrue($this->dbhandler->isConnected());
			
			$query =& new SelectQuery();
			$columns = array("test.id AS test_id", "test.value AS test_value", "test1.value AS test1_value");
			$query->setColumns($columns);
			$query->addTable("test", NO_JOIN);
			$query->addTable("test1", INNER_JOIN, "test.FK = test1.id");
			$query->setWhere("test1.id = 20");
			
 			$result =& $this->dbhandler->query($query);
 			$this->assertEqual($result->getNumberOfRows(),20);
 			$this->assertEqual($result->getNumberOfFields(),3);
 			$names = $result->getFieldNames();
 			$this->assertTrue(in_array("test1_value",$names));
 			$this->assertEqual("This is the value",$result->field("test1_value"));
		}
		
		/**
		 * Test connecting and querying a queue on one database
		 **/
		function test_querying_a_queue_and_connecting_with_one_database() {
			$isSuccessful = $this->dbhandler->connect();
			$this->assertTrue($isSuccessful);
			$this->assertTrue($this->dbhandler->isConnected());
			
			// create a new queue of queries to execuete
			$queryQueue =& new Queue();
			
			$query =& new SelectQuery();
			$columns = array("test1.id AS test1_id", "test.value AS test_value", "test1.value AS test1_value");
			$query->setColumns($columns);
			$query->addTable("test", NO_JOIN);
			$query->addTable("test1", INNER_JOIN, "test.FK = test1.id");
			$query->setWhere("test1.id = 20");
			$queryQueue->add($query);
			
			$query2 = $query;
			$query2->setWhere("test1.id = 21");
			$queryQueue->add($query2);
			
			$resultQueue =& $this->dbhandler->queryQueue($queryQueue);

			// test the first result
			$result =& $resultQueue->next();
			$this->assertEqual($result->getNumberOfRows(),20);
			$this->assertEqual($result->getNumberOfFields(),3);
			$names = $result->getFieldNames();
			$this->assertTrue(in_array("test1_value",$names));
			$this->assertEqual("20",$result->field("test1_id"));
			$this->assertEqual("This is the value",$result->field("test1_value"));

			// test the second result
			$result =& $resultQueue->next();
			$this->assertEqual($result->getNumberOfRows(),20);
			$this->assertEqual($result->getNumberOfFields(),3);
			$names = $result->getFieldNames();
			$this->assertTrue(in_array("test1_value",$names));
			$this->assertEqual("21",$result->field("test1_id"));
			$this->assertEqual("This is the value",$result->field("test1_value"));
		}
		
		function test_connect_and_disconnect() {
			// test connectinng			
			$isSuccessful = $this->dbhandler->connect();
			$this->assertTrue($isSuccessful);
			$this->assertTrue($this->dbhandler->isConnected());
			
			//test disconnecting
			$isSuccessful = $this->dbhandler->disconnect();
			$this->assertTrue($isSuccessful);
			$this->assertFalse($this->dbhandler->isConnected());

			// test persistant connectinng			
			$isSuccessful = $this->dbhandler->pConnect();
			$this->assertTrue($isSuccessful);
			$this->assertTrue($this->dbhandler->isConnected());
			
			//test disconnecting from a persistant Connection
			$isSuccessful = $this->dbhandler->disconnect();
			$this->assertTrue($isSuccessful);
			$this->assertFalse($this->dbhandler->isConnected());
		}
		
		function test_number_of_queries() {
			$this->dbhandler->connect();
			
			// create a new queue of queries to execuete
			$queryQueue =& new Queue();
			
			$query =& new SelectQuery();
			$columns = array("test1.id AS test1_id", "test.value AS test_value", "test1.value AS test1_value");
			$query->setColumns($columns);
			$query->addTable("test", NO_JOIN);
			$query->addTable("test1", INNER_JOIN, "test.FK = test1.id");
			$query->setWhere("test1.id = 20");
			$queryQueue->add($query);
			
			$query2 = $query;
			$query2->setWhere("test1.id = 21");
			$queryQueue->add($query2);
			
			$query3 = $query;
			$query3->addTable("NonexistantTable", NO_JOIN);
			$queryQueue->add($query3);
			
			$resultQueue =& $this->dbhandler->queryQueue($queryQueue);
			
			$this->assertEqual($this->dbhandler->getTotalNumberOfQueries(), 3);
			$this->assertEqual($this->dbhandler->getTotalNumberOfSuccessfulQueries(), 2);
			$this->assertEqual($this->dbhandler->getTotalNumberOfFailedQueries(), 1);
		}
		
		// test SELECT, INSERT, DELETE, and UPDATE queries.
		function test_All_Queries() {
			$value = "'Depeche Mode rocks!'";
			$this->dbhandler->connect();

			// create a new queue of queries to execuete
			$queryQueue =& new Queue();
		
			$query =& new InsertQuery();
			$query->setTable("test1");
			$query->setColumns(array("value"));
			$query->addRowOfValues(array($value));
			$queryQueue->add($query);
			
			$query =& new InsertQuery();
			$query->setTable("test1");
			$query->setColumns(array(id, value));
			$query->addRowOfValues(array("3000000", $value));
			$queryQueue->add($query);

			$query =& new DeleteQuery();
			$query->setTable("test1");
			$query->setWhere("id = 3000000");
			$queryQueue->add($query);
			
			$query =& new UpdateQuery();
			$query->setTable("test1");
			$query->setColumns(array("value"));
			$query->setValues(array($value));
			$query->setWhere("id > 1000 AND id < 1006");
			$queryQueue->add($query);
			
			$resultQueue =& $this->dbhandler->queryQueue($queryQueue);
			
			$this->assertEqual($this->dbhandler->getTotalNumberOfQueries(), 4);
			$this->assertEqual($this->dbhandler->getTotalNumberOfSuccessfulQueries(), 4);
			$this->assertEqual($this->dbhandler->getTotalNumberOfFailedQueries(), 0);
			
			$result =& $resultQueue->next();
			$this->assertEqual($result->getNumberOfRows(), 1);
			$this->assertNotNull($result->getLastAutoIncrementValue());
			$id = $result->getLastAutoIncrementValue();
			
			$result =& $resultQueue->next();
			$this->assertEqual($result->getNumberOfRows(), 1);
			$this->assertNotNull($result->getLastAutoIncrementValue());

			$result =& $resultQueue->next();
			$this->assertEqual($result->getNumberOfRows(), 1);

			$result =& $resultQueue->next();

			$query =& new SelectQuery();
			$query->setColumns(array("value"));
			$query->addTable("test1");
			$query->setWhere("id = $id");
			$result =& $this->dbhandler->query($query);
			
			$this->assertEqual($this->dbhandler->getTotalNumberOfQueries(), 5);
			$this->assertEqual($this->dbhandler->getTotalNumberOfSuccessfulQueries(), 5);
			$this->assertEqual($this->dbhandler->getTotalNumberOfFailedQueries(), 0);
			$this->assertEqual("'".$result->field("value")."'", $value);
		}
	}