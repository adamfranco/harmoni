<?php

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: SharedManagerTestCase.class.php,v 1.2 2005/01/18 20:00:39 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

class SharedManagerTestCase extends UnitTestCase {


	var $manager;

	   /**
		*	 Sets up unit test wide variables at the start
		*	 of each test method.
		*	 @public
		*/
	   function setUp() {
		// Set up the database connection
		$dbHandler=&Services::requireService("DBHandler");
		$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
		$dbHandler->pConnect($dbIndex);
		unset($dbHandler); // done with that for now
		
		$this->manager =& new HarmoniSharedManager($dbIndex, "doboHarmoniTest");
	   }
	
	   /**
		*	 Clears the data set in the setUp() method call.
		*	 @public
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
		// create a type
		$type =& new HarmoniType("Agent", "Get", "Test", "A test for getting an agent");
		// create one agent
		$agent =& $this->manager->createAgent("dreckridnow", $type);
		$this->assertIsA($agent, "HarmoniAgent");
		$id =& $agent->getId();

		// clear the cache or else getAgent() will return from cache directly
		$this->manager->clearCache();
		
		// first call gets it from database
		$agent =& $this->manager->getAgent($id);
		$this->assertIsA($agent, "HarmoniAgent");

		// check to see whether its in cache
		$this->assertReference($agent, $this->manager->_agentsCache[$id->getIdString()]);

		// second call gets it from database
		$agent1 =& $this->manager->getAgent($id);
		$this->assertIsA($agent1, "HarmoniAgent");
		$this->assertReference($agent, $agent1);
		
		$this->manager->deleteAgent($id);
	}
	
	/**
	 * Testing createAgent
	 **/
	function test_create_agent() {
		// create a type
		$type =& new HarmoniType("Agent", "Create", "Test", "A test for creating an agent");
		
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
		$type =& new HarmoniType("Agent", "Delete", "Test", "A test for deleting an agent");
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
			$this->assertIsA($agent, "HarmoniAgent");
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
			$this->assertIsA($type, "TypeInterface");
		}
	}

	/**
	 * Testing createAgent
	 **/
	function test_create_group() {
		// create a type
		$type =& new HarmoniType("Group", "Create", "Test", "A test for creating a group");
		
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
		$this->manager->deleteGroup($group1->getId());
		$this->manager->deleteGroup($group2->getId());
	}
	

	/**
	 * Testing getGroup
	 **/
	function test_get_group() {
		$group =& $this->manager->getGroup(new HarmoniId("-9"));
		$group =& $this->manager->getGroup(new HarmoniId("-1"));
		
		$this->assertIsA($group, "HarmoniGroup");
	}

	/**
	 * Testing getGroups
	 **/
	function test_get_groups() {
		$groups =& $this->manager->getGroups();
		$this->assertIsA($groups, "HarmoniAgentIterator");
		while ($groups->hasNext()) {
			$group =& $groups->next();
			$this->assertIsA($group, "HarmoniGroup");
			
//			echo "<pre>\n";
			$id =& $group->getId();
//			echo $id->getIdString();
//			echo " : ".$group->getDisplayName();
//			echo "\n";
//			echo "subgroups:";
//			print_r(array_keys($group->_groups));
//			echo "members:";
//			print_r(array_keys($group->_agents));
//
//			echo "</pre>\n";
//	
		}
	}


	
	/**
	 * Testing createAgent
	 **/
	function test_delete_group() {
		// create a group and then delete it
		$type =& new HarmoniType("Group", "Delete", "Test", "A test for deleting a group");
		$group1 =& $this->manager->createGroup("kokomode", $type, "blah");
		$this->assertIsA($group1, "HarmoniGroup");

		$this->manager->deleteGroup($group1->getId());
	}
	
	
	/**
	 * Testing getAgentTypes
	 **/
	function test_get_group_types() {
		$types =& $this->manager->getGroupTypes();
		$this->assertIsA($types, "HarmoniTypeIterator");
		while ($types->hasNext()) {
			$type =& $types->next();
			$this->assertIsA($type, "TypeInterface");
		}
	}
	
	
}