<?php

require_once(HARMONI.'/oki/shared/HarmoniGroup.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: GroupTestCase.class.php,v 1.2 2004/04/13 22:53:32 dobomode Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class GroupTestCase extends UnitTestCase {
	
		var $group;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			$this->id =& new HarmoniId(8);
			$this->type =& new HarmoniType("Look at me!", "I rock...", "I rule!", "And rise!");
			$this->group =& new HarmoniGroup("dobomode", $this->id, $this->type, "Muhaha!", 0, "doboHarmoniTest");
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
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
			$id =& new HarmoniId(1);
			$type =& new HarmoniType("First", "Primero", "Erste", "Parvi");
			$agent1 =& new HarmoniAgent("dobomode", $id, $type);

			$id =& new HarmoniId(2);
			$type =& new HarmoniType("Second", "Segundo", "Zweite", "Vtori");
			$agent2 =& new HarmoniAgent("achapin", $id, $type);

			$id =& new HarmoniId(3);
			$type =& new HarmoniType("Third", "Tercero", "Dritte", "Treti");
			$agent3 =& new HarmoniAgent("afranco", $id, $type);

			// add them to the group
			$this->group->add($agent1);
			$this->group->add($agent2);
			$this->group->add($agent3);
		
			$arr = array();
			$arr[1] =& $agent1;
			$arr[2] =& $agent2;
			$arr[3] =& $agent3;
			$this->assertIdentical($this->group->_agents, $arr);
			
			// now create a new group add a bunch of new users, 
			// and add the group to the original one
			$id =& new HarmoniId(256);
			$type =& new HarmoniType("Fancy", "Mancy", "Shmootsy", "Tootsy");
			$group1 =& new HarmoniGroup("dm", $id, $type, "So lala!", 0, "doboHarmoniTest");
			
			$id =& new HarmoniId(15);
			$type =& new HarmoniType("Fourth", "Cuarto", "Vierte", "Chetvarti");
			$agent15 =& new HarmoniAgent("dobomode", $id, $type);

			$id =& new HarmoniId(16);
			$type =& new HarmoniType("Fifth", "Quinto", "Funfte", "Peti");
			$agent16 =& new HarmoniAgent("achapin", $id, $type);
			
			$group1->add($agent15);
			$group1->add($agent16);
			
			$arr1 = array();
			$arr1[15] =& $agent15;
			$arr1[16] =& $agent16;
			$this->assertIdentical($group1->_agents, $arr1);
			
			$this->group->add($group1);
			$arr2 = array();
			$arr2[256] =& $group1;
			$this->assertIdentical($this->group->_groups, $arr2);
			
			$this->group->remove($agent2);
			$arr = array();
			$arr[1] =& $agent1;
			$arr[3] =& $agent3;
			$this->assertIdentical($this->group->_agents, $arr);
			
			$this->group->remove($group1);
			$arr2 = array();
			$this->assertIdentical($this->group->_groups, $arr2);
		}
		
		function test_getMembersAndGetGroups() {
			// hehe, no hierarchy implied in the examples below ;)
			
			// create a bunch of agents
			$id =& new HarmoniId(1);
			$type =& new HarmoniType("First", "Primero", "Erste", "Parvi");
			$agent1 =& new HarmoniAgent("dobomode", $id, $type);

			$id =& new HarmoniId(2);
			$type =& new HarmoniType("Second", "Segundo", "Zweite", "Vtori");
			$agent2 =& new HarmoniAgent("achapin", $id, $type);

			$id =& new HarmoniId(3);
			$type =& new HarmoniType("Third", "Tercero", "Dritte", "Treti");
			$agent3 =& new HarmoniAgent("afranco", $id, $type);

			// add them to the group
			$this->group->add($agent1);
			$this->group->add($agent2);
			$this->group->add($agent3);
		
			// now create a new group add a bunch of new users, 
			// and add the group to the original one
			$id =& new HarmoniId(256);
			$type =& new HarmoniType("Fancy", "Mancy", "Shmootsy", "Tootsy");
			$group1 =& new HarmoniGroup("dm", $id, $type, "So lala!", 0, "doboHarmoniTest");
			
			$id =& new HarmoniId(15);
			$type =& new HarmoniType("Fourth", "Cuarto", "Vierte", "Chetvarti");
			$agent15 =& new HarmoniAgent("dobomode", $id, $type);

			$id =& new HarmoniId(16);
			$type =& new HarmoniType("Fifth", "Quinto", "Funfte", "Peti");
			$agent16 =& new HarmoniAgent("achapin", $id, $type);
			
			$group1->add($agent15);
			$group1->add($agent16);
			
			$this->group->add($group1);

			$arr1 =& $this->group->_getMembers(false);
			$arr = array();
			$arr[1] =& $agent1;
			$arr[2] =& $agent2;
			$arr[3] =& $agent3;
			$this->assertIdentical($arr, $arr1);
			
			$arr1 =& $this->group->_getMembers(true);
			$arr = array();
			$arr[1] =& $agent1;
			$arr[2] =& $agent2;
			$arr[3] =& $agent3;
			$arr[15] =& $agent15;
			$arr[16] =& $agent16;
			$this->assertIdentical($arr, $arr1);
			
			$members =& $this->group->getMembers(true);
			$this->assertIsA($members, "HarmoniAgentIterator");
			while ($members->hasNext()) {
				$member =& $members->next();
				$this->assertIsA($member, "Agent");
			}
			
			$arr1 =& $this->group->_getMembers(false, false);
			$arr = array();
			$arr[256] =& $group1;
			$this->assertIdentical($arr, $arr1);
			
			// check for uniqueness of returned elements
			$group2 =& new HarmoniGroup("dm", new HarmoniId(300), $type, "So lala!", 0, "doboHarmoniTest");
			$group1->add($group2);
			
			$arr1 =& $this->group->_getMembers(true, false);

			$arr = array();
			$arr[256] =& $group1;
			$arr[300] =& $group2;
			$this->assertIdentical($arr, $arr1);
			
			$members =& $this->group->getMembers(true, false);
			$this->assertIsA($members, "HarmoniAgentIterator");
			while ($members->hasNext()) {
				$member =& $members->next();
				$this->assertIsA($member, "Agent");
			}
		}
		
		function test_contains() {
			// hehe, no hierarchy implied in the examples below ;)
			
			// create a bunch of agents
			$id =& new HarmoniId(1);
			$type =& new HarmoniType("First", "Primero", "Erste", "Parvi");
			$agent1 =& new HarmoniAgent("dobomode", $id, $type);

			$id =& new HarmoniId(2);
			$type =& new HarmoniType("Second", "Segundo", "Zweite", "Vtori");
			$agent2 =& new HarmoniAgent("achapin", $id, $type);

			$id =& new HarmoniId(3);
			$type =& new HarmoniType("Third", "Tercero", "Dritte", "Treti");
			$agent3 =& new HarmoniAgent("afranco", $id, $type);

			// add them to the group
			$this->group->add($agent1);
			$this->group->add($agent2);
			$this->group->add($agent3);
		
			// now create a new group add a bunch of new users, 
			// and add the group to the original one
			$id =& new HarmoniId(256);
			$type =& new HarmoniType("Fancy", "Mancy", "Shmootsy", "Tootsy");
			$group1 =& new HarmoniGroup("dm", $id, $type, "So lala!", 0, "doboHarmoniTest");
			
			$id =& new HarmoniId(15);
			$type =& new HarmoniType("Fourth", "Cuarto", "Vierte", "Chetvarti");
			$agent15 =& new HarmoniAgent("dobomode", $id, $type);

			$id =& new HarmoniId(16);
			$type =& new HarmoniType("Fifth", "Quinto", "Funfte", "Peti");
			$agent16 =& new HarmoniAgent("achapin", $id, $type);
			
			$group1->add($agent15);
			$group1->add($agent16);
			
			$this->group->add($group1);

			// non-recursive search
			$this->assertTrue($this->group->contains($agent1));
			$this->assertTrue($this->group->contains($agent2));
			$this->assertTrue($this->group->contains($agent3));
			$this->assertTrue($this->group->contains($group1));
			
			$id =& new HarmoniId(300);
			$type =& new HarmoniType("Fancy", "Mancy", "Shmootsy", "Tootsy");
			$group2 =& new HarmoniGroup("dm", $id, $type, "So lala!", 0, "doboHarmoniTest");
			$group1->add($group2);

			$this->assertTrue($this->group->contains($agent15, true));
			$this->assertTrue($this->group->contains($agent16, true));
			$this->assertTrue($this->group->contains($group2, true));
			$this->assertFalse($this->group->contains($this->group, true));
		}
		
		
		
		
		
		
		
	}