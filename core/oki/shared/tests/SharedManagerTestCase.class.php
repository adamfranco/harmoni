<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchyManager.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');
require_once(HARMONI.'/oki/hierarchy/tests/TestNodeType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: SharedManagerTestCase.class.php,v 1.2 2004/03/30 23:38:43 dobomode Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class SharedManagerTestCase extends UnitTestCase {
	
		var $manager;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// Set up the database connection
			$dbHandler=&Services::requireService("DBHandler");
			$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			$dbHandler->pConnect($dbIndex);
			unset($dbHandler); // done with that for now
			
			// set up data  container
			$dataContainer =& new HarmoniSharedManagerDataContainer();
			$dataContainer->set("dbIndex", $dbIndex);
			$dataContainer->set("sharedDB", "doboHarmoniTest");
			
			$dataContainer->set("idTable", "id");
			$dataContainer->set("idTable_valueColumn", "id_value");
			$dataContainer->set("idTable_sequenceName", "irrelevant in mysql");
			
			$dataContainer->set("agentTable", "agent");
			$dataContainer->set("groupTable", "group");
			$dataContainer->set("agentGroupJoinTable", "j_agent_group");

        	$this->manager =& new HarmoniSharedManager($dataContainer);
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->manager);
        }

		//--------------the tests ----------------------

		function test_createId() {
			$id = $this->manager->createId();
			$this->assertIsA($id, "Id");
			$this->assertNotNull($id);
		}
		
		
	}