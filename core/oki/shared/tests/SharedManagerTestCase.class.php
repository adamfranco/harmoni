<?php

require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: SharedManagerTestCase.class.php,v 1.3 2004/04/01 22:44:14 dobomode Exp $
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
			
			$dataContainer->set("typeTable", "type");
			$dataContainer->set("typeTable_idColumn", "type_id");
			$dataContainer->set("typeTable_domainColumn", "type_domain");
			$dataContainer->set("typeTable_authorityColumn", "type_authority");
			$dataContainer->set("typeTable_keywordColumn", "type_keyword");
			$dataContainer->set("typeTable_descriptionColumn", "type_description");

			$dataContainer->set("idTable", "id");
			$dataContainer->set("idTable_valueColumn", "id_value");
			$dataContainer->set("idTable_sequenceName", "irrelevant in mysql");
			
			$dataContainer->set("agentTable", "agent");
			$dataContainer->set("agentTable_idColumn", "agent_id");
			$dataContainer->set("agentTable_displayNameColumn", "agent_display_name");
			$dataContainer->set("agentTable_fkTypeColumn", "fk_type");
			
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

		function test_create_id() {
			$id = $this->manager->createId();
			$this->assertIsA($id, "Id");
			$this->assertNotNull($id);
		}
		
		/**
		 * Testing getAgent
		 **/
		function test_get_agent() {
			// first call gets it from database
			$agent =& $this->manager->getAgent(new HarmoniId(19));
			$this->assertIsA($agent, "HarmoniAgent");

			// check to see whether its in cache
			$this->assertReference($agent, $this->manager->_agentsCache[19]);

			// second call gets it from database
			$agent1 =& $this->manager->getAgent(new HarmoniId(19));
			$this->assertIsA($agent1, "HarmoniAgent");
			$this->assertReference($agent, $agent1);
		}
		
		/**
		 * Testing createAgent
		 **/
		function test_create_agent() {
			// create a type
			$type =& new HarmoniType("I", "Am", "As Cool", "As I Want");
			
			// create one agent
			$agent1 =& $this->manager->createAgent($type, "dreckridnow");
			$this->assertIsA($agent1, "HarmoniAgent");

			// create another one		
			$agent2 =& $this->manager->createAgent($type, "dreckridnow");
			$this->assertIsA($agent2, "HarmoniAgent");
			
			// they should be distinct
			$this->assertNotIdentical($agent1, $agent2);
		}
		
		
	}