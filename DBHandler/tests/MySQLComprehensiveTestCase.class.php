<?php

    require_once(HARMONI.'DBHandler/MySQL/MySQLDatabase.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: MySQLComprehensiveTestCase.class.php,v 1.1 2003/07/17 01:05:55 dobomode Exp $
 * @package harmoni.dbc.tests
 * @copyright 2003 
 **/

    class MySQLComprehensiveTestCase extends UnitTestCase {
		
		var $db;
	
		function MySQLComprehensiveTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here
			$this->db =& new MySQLDatabase("devo.middlebury.edu", "harmoniTest", "test", "test");
			$this->db->connect();
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
        }


		/**
		 * Tests the generateSQLQuery() without WHERE clause.
		 */ 
        function test() {
			// insert one row
			$query =& new InsertQuery();
			$query->setTable("test1");
			$query->setColumns(array("value"));
			$query->addRowOfValues(array("'Spaceboy'"));
			$query->setAutoIncrementColumn("id", "test1_id_seq");

			$result =& $this->db->query($query);
			
			$lastId = $result->getLastAutoIncrementValue();
			
			// insert it again, the id must have increased by one

			$result =& $this->db->query($query);
			
			$this->assertIdentical($result->getNumberOfRows(), 1);
			$this->assertIdentical($result->getLastAutoIncrementValue(), $lastId + 1);

			// add several rows at the same time
			$query->addRowOfValues(array("'Astrogirl'"));

			$result =& $this->db->query($query);
			
			$this->assertIdentical($result->getLastAutoIncrementValue(), $lastId + 3);
			
			// now insert in the other test table
			$query =& new InsertQuery();
			$query->setTable("test");
			$query->setColumns(array("FK", "value"));
			$query->addRowOfValues(array($lastId, "'Ziggy'"));
			$query->addRowOfValues(array($lastId + 1, "'Lost in the Stars'"));
			$query->addRowOfValues(array($lastId + 2, "'Headstar'"));
			$query->addRowOfValues(array($lastId + 3, "'Stardust'"));
			$query->setAutoIncrementColumn("id", "test1_id_seq");
			$result =& $this->db->query($query);
			
			// join the inserted rows
			$query =& new SelectQuery();
			$query->addTable("test1");
			$query->addTable("test", INNER_JOIN, "test.FK = test1.id");
			$query->addColumn("id", "dm86_id", "test");
			$query->addColumn("FK", "dm86_fk", "test");
			$query->addColumn("value", "dm86_value", "test");
			$query->addColumn("id", "dm98_id", "test1");
			$query->addColumn("value", "dm98_value", "test1");
			$query->addWhere("test1.id >= ".$lastId);
			$result =& $this->db->query($query);
			
			$this->assertIdentical($result->getNumberOfRows(), 4);

			$this->assertIdentical((int)$result->field("dm86_fk"), $lastId);
			$this->assertIdentical($result->field("dm86_value"), "Ziggy");
			$this->assertIdentical((int)$result->field("dm98_id"), $lastId);
			$this->assertIdentical($result->field("dm98_value"), "Spaceboy");

			$result->advanceRow();
			$this->assertIdentical((int)$result->field("dm86_fk"), $lastId + 1);
			$this->assertIdentical($result->field("dm86_value"), "Lost in the Stars");
			$this->assertIdentical((int)$result->field("dm98_id"), $lastId + 1);
			$this->assertIdentical($result->field("dm98_value"), "Spaceboy");

			$result->advanceRow();
			$this->assertIdentical((int)$result->field("dm86_fk"), $lastId + 2);
			$this->assertIdentical($result->field("dm86_value"), "Headstar");
			$this->assertIdentical((int)$result->field("dm98_id"), $lastId + 2);
			$this->assertIdentical($result->field("dm98_value"), "Spaceboy");

			$result->advanceRow();
			$this->assertIdentical((int)$result->field("dm86_fk"), $lastId + 3);
			$this->assertIdentical($result->field("dm86_value"), "Stardust");
			$this->assertIdentical((int)$result->field("dm98_id"), $lastId + 3);
			$this->assertIdentical($result->field("dm98_value"), "Astrogirl");
			
			$query =& new UpdateQuery();
			$query->setTable("test1");
			$query->setColumns(array("value"));
			$query->setValues(array("'I changed you MF!'"));
			$query->addWhere("id = ".$lastId);
			$result =& $this->db->query($query);
			
			$this->assertIdentical($result->getNumberOfRows(), 1);
			
			$query =& new SelectQuery();
			$query->addTable("test1");
			$query->addColumn("value");
			$query->addWhere("test1.id = ".$lastId);
			$result =& $this->db->query($query);
			$this->assertIdentical($result->getNumberOfRows(), 1);
			$this->assertIdentical($result->field("value"), "I changed you MF!");
			
			$query =& new DeleteQuery();
			$query->setTable("test1");
			$query->addWhere("id = ".$lastId);
			$result =& $this->db->query($query);
			
			$this->assertIdentical($result->getNumberOfRows(), 1);
			
			$query =& new SelectQuery();
			$query->addTable("test1");
			$query->addColumn("value");
			$query->addWhere("test1.id = ".$lastId);
			$result =& $this->db->query($query);
			$this->assertIdentical($result->getNumberOfRows(), 0);
		}

    }

?>