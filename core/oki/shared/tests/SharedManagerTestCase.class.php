<?php

require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: SharedManagerTestCase.class.php,v 1.5 2004/04/12 22:58:26 dobomode Exp $
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
		
		$dataContainer->set("groupTable", "groups");
		$dataContainer->set("groupTable_idColumn", "group_id");
		$dataContainer->set("groupTable_displayNameColumn", "group_display_name");
		$dataContainer->set("groupTable_fkTypeColumn", "fk_type");
		$dataContainer->set("groupTable_description", "group_description");

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
		$type =& new HarmoniType("Create", "Agent", "Test", "A test for creating an agent");
		
		// create one agent
		$agent1 =& $this->manager->createAgent("dreckridnow", $type);
		$this->assertIsA($agent1, "HarmoniAgent");

		// create another one		
		$agent2 =& $this->manager->createAgent("dreckridnow", $type);
		$this->assertIsA($agent2, "HarmoniAgent");
		
		// they should be distinct
		$this->assertNotIdentical($agent1, $agent2);
		
		// now use getAgent to fetch the created agent and verify identity
		$agent3 =& $this->manager->getAgent($agent2->getId());
		$this->assertReference($agent2, $agent3);
		
		// delete the agents
		$this->manager->deleteAgent($agent1->getId());
		$this->manager->deleteAgent($agent2->getId());
	}
	
	/**
	 * Testing createAgent
	 **/
	function test_delete_agent() {
		// create an agent and then delete it
		$type =& new HarmoniType("Delete", "Agent", "Test", "A test for deleting an agent");
		$agent1 =& $this->manager->createAgent("kokomode", $type);
		$this->assertIsA($agent1, "HarmoniAgent");

		// first call gets it from database
		$this->manager->deleteAgent($agent1->getId());
	}
	
	/**
	 * Testing getAgents
	 **/
	function test_get_agents() {
		$agents =& $this->manager->getAgents();
		$this->assertIsA($agents, "HarmoniAgentIterator");
		while ($agents->hasNext()) {
			$agent =& $agents->next();
			$this->assertIsA($agent, "Agent");
		}
	}

	/**
	 * Testing getAgentTypes
	 **/
	function test_get_agent_types() {
		$types =& $this->manager->getAgentTypes();
		$this->assertIsA($types, "HarmoniTypeIterator");
		while ($types->hasNext()) {
			$type =& $types->next();
			$this->assertIsA($type, "Type");
		}
	}

	/**
	 * Testing createAgent
	 **/
	function test_create_group() {
		// create a type
		$type =& new HarmoniType("Create", "Group", "Test", "A test for creating a group");
		
		// create one group
		$group1 =& $this->manager->createGroup("depeche", $type, "The greatest band.");
		$this->assertIsA($group1, "HarmoniGroup");

		// create another one		
		$group2 =& $this->manager->createGroup("u2", $type, "Another great one, but not as great.");
		$this->assertIsA($group2, "HarmoniGroup");
		
		// they should be distinct
		$this->assertNotIdentical($group1, $group2);
		
		// now use getGroup to fetch the created group and verify identity
//		$group3 =& $this->manager->getGroup($group2->getId());
//		$this->assertReference($group2, $group3);
		
		// delete the groups
//		$this->manager->deleteGroup($group1->getId());
//		$this->manager->deleteGroup($group2->getId());
	}
	
}