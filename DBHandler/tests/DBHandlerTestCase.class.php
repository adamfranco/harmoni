<?php

    require_once('DBHandler.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DBHandlerTestCase.class.php,v 1.2 2003/06/20 19:00:56 adamfranco Exp $
 * @package harmoni.dbhandler.tests
 * @copyright 2003 
 **/

    class DBHandlerTestCase extends UnitTestCase {
	
		var $dbhandler;

		function MySQLDeleteQueryTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->dbhandler =& new DBHandler(MYSQL,"devo.middlebury.edu", "test", "test", "test");
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
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
			$this->assertEqual("mysqldatabase", get_class($database));
			$this->assertEqual("devo.middlebury.edu", $database->_dbHost);
			$this->assertEqual("test", $database->_dbName);
			$this->assertEqual("test", $database->_dbUser);
			$this->assertEqual("test", $database->_dbPass);
		}
		
		/**
		 * Test the addition of a new database.
		 **/
		function test_createdatabase() {
			$databaseId = $this->dbhandler->createDatabase(MYSQL,"devo123.middlebury.edu", "test123", "test123", "test123");
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
			
/* 			$result =& $this->dbhandler->query($query); */
/* 			$this->assertTrue($result->isSuccessful()); */
/* 			$this->assertEqual($result->getNumberOfRows(),20); */
/* 			$this->assertEqual($result->getNumberOfFields(),3); */
/* 			$names = $result->getFieldNames(); */
/* 			$this->assertTrue(in_array("test1_value",$names)); */
/* 			$this->assertEqual("This is the value",$result->field("test1_value")); */
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
			
			$query->setWhere("test1.id = 21");
			$queryQueue->add($query);
			
			$resultQueue =& $this->dbhandler->queryQueue($queryQueue);

			// test the first result
			$result =& $resultQueue->next();
			$this->assertTrue($result->isSuccessful());
			$this->assertEqual($result->getNumberOfRows(),20);
			$this->assertEqual($result->getNumberOfFields(),3);
			$names = $result->getFieldNames();
			$this->assertTrue(in_array("test1_value",$names));
			$this->assertEqual("20",$result->field("test1_id"));
			$this->assertEqual("This is the value",$result->field("test1_value"));

			// test the second result
			$result =& $resultQueue->next();
			$this->assertTrue($result->isSuccessful());
			$this->assertEqual($result->getNumberOfRows(),20);
			$this->assertEqual($result->getNumberOfFields(),3);
			$names = $result->getFieldNames();
			$this->assertTrue(in_array("test1_value",$names));
			$this->assertEqual("20",$result->field("test1_id"));
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
			
			$query->setWhere("test1.id = 21");
			$queryQueue->add($query);
			
			$query->addTable("NonexistantTable", NO_JOIN);
			$queryQueue->add($query);
			
			$resultQueue =& $this->dbhandler->queryQueue($queryQueue);
			
			$this->assertEqual($this->dbhandler->getTotalNumberOfQueries(), 3);
			$this->assertEqual($this->dbhandler->getTotalNumberOfSuccessfulQueries(), 2);
			$this->assertEqual($this->dbhandler->getTotalNumberOfFailedQueries(), 1);
		}
	}