<?php
/**
 * @package harmoni.osid_v2.agent.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GroupTestCase.class.php,v 1.9 2005/04/07 16:33:28 adamfranco Exp $
 */
 
require_once(HARMONI.'/oki2/agent/HarmoniGroup.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.osid_v2.agent.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: GroupTestCase.class.php,v 1.9 2005/04/07 16:33:28 adamfranco Exp $
 */

	class GroupTestCase extends UnitTestCase {
	
		var $group;
		var $manager;

		/**
		 *	  Sets up unit test wide variables at the start
		 *	  of each test method.
		 *	  @access public
		 */
		function setUp() {
			// Set up the database connection
			$dbHandler=&Services::getService("DatabaseManager");
			$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			$dbHandler->pConnect($dbIndex);
			unset($dbHandler); // done with that for now
			
			$this->manager =& new HarmoniAgentManager($dbIndex, "doboHarmoniTest");
	
			$this->type =& new HarmoniType("Look at me!", "I rock...", "I rule!", "And rise!");
			$this->group =& $this->manager->createGroup("dobomode", $this->type, "Muhaha!");
			$this->id =& $this->group->getId();

		}
		
		/**
		 *	  Clears the data set in the setUp() method call.
		 *	  @access public
		 */
		function tearDown() {
			// perhaps, unset $obj here
			$this->manager->deleteGroup($this->group->getId());
			unset($this->group);
		}

		//--------------the tests ----------------------

		function test_constructor() {
			$this->assertIsA($this->group, "HarmoniGroup");
			$this->assertIdentical($this->group->getDisplayName(), "dobomode");
			$this->assertReference($this->group->getId(), $this->id);
			$this->assertReference($this->group->getType(), $this->type);
			$this->assertIdentical($this->group->getDescription(), "Muhaha!");
		}
		
		
		function test_add_and_remove() {
			// hehe, no hierarchy implied in the examples below ;)
			
			// create a bunch of agents
			$type =& new HarmoniType("First", "Primero", "Erste", "Parvi");
			$agent1 =& $this->manager->createAgent("dobomode", $this->type);
			$id_a1 =& $agent1->getId();
			
			$type =& new HarmoniType("Second", "Segundo", "Zweite", "Vtori");
			$agent2 =& $this->manager->createAgent("achapin", $this->type);
			$id_a2 =& $agent2->getId();

			$type =& new HarmoniType("Third", "Tercero", "Dritte", "Treti");
			$agent3 =& $this->manager->createAgent("afranco", $this->type);
			$id_a3 =& $agent3->getId();

			// add them to the group
			$this->group->add($agent1);
			$this->group->add($agent2);
			$this->group->add($agent3);
		
			$arr = array();
			$arr[$id_a1->getIdString()] =& $agent1;
			$arr[$id_a2->getIdString()] =& $agent2;
			$arr[$id_a3->getIdString()] =& $agent3;
			$this->assertIdentical($this->group->_agents, $arr);
			
			// now create a new group add a bunch of new users, 
			// and add the group to the original one
			$type =& new HarmoniType("Fancy", "Mancy", "Shmootsy", "Tootsy");
			$group1 =& $this->manager->createGroup("dm", $this->type, "so lala");
			$id_g1 =& $group1->getId();
			
			$type =& new HarmoniType("Fourth", "Cuarto", "Vierte", "Chetvarti");
			$agent4 =& $this->manager->createAgent("gschine", $this->type);
			$id_a4 =& $agent4->getId();

			$type =& new HarmoniType("Fifth", "Quinto", "Funfte", "Peti");
			$agent5 =& $this->manager->createAgent("movsjani", $this->type);
			$id_a5 =& $agent5->getId();
			
			$group1->add($agent4);
			$group1->add($agent5);
			
			$arr1 = array();
			$arr1[$id_a4->getIdString()] =& $agent4;
			$arr1[$id_a5->getIdString()] =& $agent5;
			$this->assertIdentical($group1->_agents, $arr1);
			
			$this->group->add($group1);
			$arr2 = array();
			$arr2[$id_g1->getIdString()] =& $group1;
			$this->assertIdentical($this->group->_groups, $arr2);
			
			$this->group->remove($agent2);
			$arr = array();
			$arr[$id_a1->getIdString()] =& $agent1;
			$arr[$id_a3->getIdString()] =& $agent3;
			$this->assertIdentical($this->group->_agents, $arr);
			
			$this->group->remove($group1);
			$arr2 = array();
			$this->assertIdentical($this->group->_groups, $arr2);
			
			$this->manager->deleteAgent($agent1->getId());
			$this->manager->deleteAgent($agent2->getId());
			$this->manager->deleteAgent($agent3->getId());
			$this->manager->deleteAgent($agent4->getId());
			$this->manager->deleteAgent($agent5->getId());
			$this->manager->deleteGroup($group1->getId());
		}
		
		function test_getMembersAndGetGroups() {
			// hehe, no hierarchy implied in the examples below ;)
			
			// create a bunch of agents
			$type =& new HarmoniType("First", "Primero", "Erste", "Parvi");
			$agent1 =& $this->manager->createAgent("dobomode", $this->type);
			$id_a1 =& $agent1->getId();
			
			$type =& new HarmoniType("Second", "Segundo", "Zweite", "Vtori");
			$agent2 =& $this->manager->createAgent("achapin", $this->type);
			$id_a2 =& $agent2->getId();

			$type =& new HarmoniType("Third", "Tercero", "Dritte", "Treti");
			$agent3 =& $this->manager->createAgent("afranco", $this->type);
			$id_a3 =& $agent3->getId();

			// add them to the group
			$this->group->add($agent1);
			$this->group->add($agent2);
			$this->group->add($agent3);
		
			$arr = array();
			$arr[$id_a1->getIdString()] =& $agent1;
			$arr[$id_a2->getIdString()] =& $agent2;
			$arr[$id_a3->getIdString()] =& $agent3;
			$this->assertIdentical($this->group->_agents, $arr);
			
			// now create a new group add a bunch of new users, 
			// and add the group to the original one
			$type =& new HarmoniType("Fancy", "Mancy", "Shmootsy", "Tootsy");
			$group1 =& $this->manager->createGroup("dm", $this->type, "so lala");
			$id_g1 =& $group1->getId();
			
			$type =& new HarmoniType("Fourth", "Cuarto", "Vierte", "Chetvarti");
			$agent4 =& $this->manager->createAgent("gschine", $this->type);
			$id_a4 =& $agent4->getId();

			$type =& new HarmoniType("Fifth", "Quinto", "Funfte", "Peti");
			$agent5 =& $this->manager->createAgent("movsjani", $this->type);
			$id_a5 =& $agent5->getId();
			
			$group1->add($agent4);
			$group1->add($agent5);
			
			$arr1 = array();
			$arr1[$id_a4->getIdString()] =& $agent4;
			$arr1[$id_a5->getIdString()] =& $agent5;
			$this->assertIdentical($group1->_agents, $arr1);
			
			$this->group->add($group1);

			$arr1 =& $this->group->_getMembers(false);
			$arr = array();
			$arr[$id_a1->getIdString()] =& $agent1;
			$arr[$id_a2->getIdString()] =& $agent2;
			$arr[$id_a3->getIdString()] =& $agent3;
			$this->assertIdentical($arr, $arr1);
			
			$arr1 =& $this->group->_getMembers(true);
			$arr = array();
			$arr[$id_a1->getIdString()] =& $agent1;
			$arr[$id_a2->getIdString()] =& $agent2;
			$arr[$id_a3->getIdString()] =& $agent3;
			$arr[$id_a4->getIdString()] =& $agent4;
			$arr[$id_a5->getIdString()] =& $agent5;
			$this->assertIdentical($arr, $arr1);
			
			$members =& $this->group->getMembers(true);
			$this->assertIsA($members, "HarmoniAgentIterator");
			while ($members->hasNext()) {
				$member =& $members->next();
				$this->assertIsA($member, "Agent");
			}
			
			$arr1 =& $this->group->_getMembers(false, false);
			$arr = array();
			$arr[$id_g1->getIdString()] =& $group1;
			$this->assertIdentical($arr, $arr1);
			
			// check for uniqueness of returned elements
			$group2 =& $this->manager->createGroup("dm", $this->type, "So lala");
			$id_g2 =& $group2->getId();
			$group1->add($group2);
			
			$arr1 =& $this->group->_getMembers(true, false);

			$arr = array();
			$arr[$id_g1->getIdString()] =& $group1;
			$arr[$id_g2->getIdString()] =& $group2;
			$this->assertIdentical($arr, $arr1);
			
			$members =& $this->group->getMembers(true, false);
			$this->assertIsA($members, "HarmoniAgentIterator");
			while ($members->hasNext()) {
				$member =& $members->next();
				$this->assertIsA($member, "Agent");
			}

			$this->manager->deleteAgent($agent1->getId());
			$this->manager->deleteAgent($agent2->getId());
			$this->manager->deleteAgent($agent3->getId());
			$this->manager->deleteAgent($agent4->getId());
			$this->manager->deleteAgent($agent5->getId());
			$this->manager->deleteGroup($group1->getId());
			$this->manager->deleteGroup($group2->getId());
		}
		
		function test_contains() {
			// hehe, no hierarchy implied in the examples below ;)
			
			// create a bunch of agents
			$type =& new HarmoniType("First", "Primero", "Erste", "Parvi");
			$agent1 =& $this->manager->createAgent("dobomode", $this->type);
			$id_a1 =& $agent1->getId();
			
			$type =& new HarmoniType("Second", "Segundo", "Zweite", "Vtori");
			$agent2 =& $this->manager->createAgent("achapin", $this->type);
			$id_a2 =& $agent2->getId();

			$type =& new HarmoniType("Third", "Tercero", "Dritte", "Treti");
			$agent3 =& $this->manager->createAgent("afranco", $this->type);
			$id_a3 =& $agent3->getId();

			// add them to the group
			$this->group->add($agent1);
			$this->group->add($agent2);
			$this->group->add($agent3);
		
			$arr = array();
			$arr[$id_a1->getIdString()] =& $agent1;
			$arr[$id_a2->getIdString()] =& $agent2;
			$arr[$id_a3->getIdString()] =& $agent3;
			$this->assertIdentical($this->group->_agents, $arr);
			
			// now create a new group add a bunch of new users, 
			// and add the group to the original one
			$type =& new HarmoniType("Fancy", "Mancy", "Shmootsy", "Tootsy");
			$group1 =& $this->manager->createGroup("dm", $this->type, "so lala");
			$id_g1 =& $group1->getId();
			
			$type =& new HarmoniType("Fourth", "Cuarto", "Vierte", "Chetvarti");
			$agent4 =& $this->manager->createAgent("gschine", $this->type);
			$id_a4 =& $agent4->getId();

			$type =& new HarmoniType("Fifth", "Quinto", "Funfte", "Peti");
			$agent5 =& $this->manager->createAgent("movsjani", $this->type);
			$id_a5 =& $agent5->getId();
			
			$group1->add($agent4);
			$group1->add($agent5);
			
			$arr1 = array();
			$arr1[$id_a4->getIdString()] =& $agent4;
			$arr1[$id_a5->getIdString()] =& $agent5;
			$this->assertIdentical($group1->_agents, $arr1);
			
			$this->group->add($group1);

			// non-recursive search
			$this->assertTrue($this->group->contains($agent1));
			$this->assertTrue($this->group->contains($agent2));
			$this->assertTrue($this->group->contains($agent3));
			$this->assertTrue($this->group->contains($group1));
			
			$group2 =& $this->manager->createGroup("dm", $this->type, "nicht so lala");
			$id_g2 =& $group2->getId();
			$group1->add($group2);

			$this->assertTrue($this->group->contains($agent4, true));
			$this->assertTrue($this->group->contains($agent5, true));
			$this->assertTrue($this->group->contains($group2, true));
			$this->assertFalse($this->group->contains($this->group, true));

			$this->manager->deleteAgent($agent1->getId());
			$this->manager->deleteAgent($agent2->getId());
			$this->manager->deleteAgent($agent3->getId());
			$this->manager->deleteAgent($agent4->getId());
			$this->manager->deleteAgent($agent5->getId());
			$this->manager->deleteGroup($group1->getId());
			$this->manager->deleteGroup($group2->getId());
		}
		
		
		function test_update_description() {
			// create a type
			$type =& new HarmoniType("Create", "Group", "Test", "A test for updating a group\'s description");
	
			// create one group
			$group =& $this->manager->createGroup("depeche", $type, "The greatest band.");
	
			$group->updateDescription("Hoho!");
	
			$this->assertIdentical($group->getDescription(), "Hoho!");

			$this->manager->deleteGroup($group->getId());
		}
	
		
		
		
		
		
		
	}