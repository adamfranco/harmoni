<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchyManager.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');
require_once(HARMONI.'/oki/hierarchy/tests/TestNodeType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HierarchyManagerTestCase.class.php,v 1.13 2003/11/05 22:22:06 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class HierarchyManagerTestCase extends UnitTestCase {
	
		var $manager;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
//        	print "<pre>";
        	
        	$this->manager =& new HarmoniHierarchyManager;
        	$nodeType =& new TestNodeType;
			$nodeTypes = array ($nodeType);
			$this->manager->createHierarchy(FALSE, "A test Hierarchy", "Hierarchy1", $nodeTypes, FALSE);
			$this->manager->createHierarchy(FALSE, "Another test Hierarchy", "Hierarchy2", $nodeTypes, FALSE);
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->manager);
//			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_constructor() {
			$manager =& new HarmoniHierarchyManager();
			$this->assertTrue(is_object($manager));
		}
		
		function test_hierarchy_creation() {
			$manager =& new HarmoniHierarchyManager;
			$nodeType =& new TestNodeType;
			$nodeTypes = array ($nodeType);
			$manager->createHierarchy(FALSE, "A test Hierarchy", "Hierarchy1", $nodeTypes, FALSE);
			$hierarchies =& $manager->getHierarchies();
			$hierarchy =& $hierarchies->next();
			
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
			
			$manager->createHierarchy(FALSE, "Another test Hierarchy", "Hierarchy2", $nodeTypes, FALSE);
			$hierarchies =& $manager->getHierarchies();
			$hierarchies->next();
			$hierarchy =& $hierarchies->next();
			
//			print_r ($manager);
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
		}
		
		function test_get_hierarchies() {
			$manager =& $this->manager;
			
			$nodeType =& new TestNodeType;
			$nodeTypes = array ($nodeType);
			$thirdHierarchy =& $manager->createHierarchy(FALSE, "Yet another test Hierarchy", "Hierarchy3", $nodeTypes, FALSE);
			
			$hierarchies =& $manager->getHierarchies();
			$count = 0;
			while ($hierarchies->hasNext()) {
				$count++;
				$hierarchy =& $hierarchies->next();
			}
			$this->assertEqual($count, 3);
			$this->assertReference($hierarchy, $thirdHierarchy);
		}
		
		function test_get_hierarchy() {
			$manager =& $this->manager;
			
			$nodeType =& new TestNodeType;
			$nodeTypes = array ($nodeType);
			$thirdHierarchy =& $manager->createHierarchy(FALSE, "Yet another test Hierarchy", "Hierarchy3", $nodeTypes, FALSE);
			$thirdHierarchyId = $thirdHierarchy->getId();
			$hierarchy =& $manager->getHierarchy($thirdHierarchyId);
			$this->assertReference($hierarchy, $thirdHierarchy);
		}
		
		function test_delete_hierarchy() {
			$manager =& $this->manager;
			
						$nodeType =& new TestNodeType;
			$nodeTypes = array ($nodeType);
			$thirdHierarchy =& $manager->createHierarchy(FALSE, "Yet another test Hierarchy", "Hierarchy3", $nodeTypes, FALSE);
			$thirdHierarchyId = $thirdHierarchy->getId();
			
			$hierarchies =& $manager->getHierarchies();
			$count = 0;
			while ($hierarchies->hasNext()) {
				$count++;
				$hierarchies->next();
			}
			$this->assertEqual($count, 3);
			
			$manager->deleteHierarchy($thirdHierarchyId);
			
			$hierarchies =& $manager->getHierarchies();
			$count = 0;
			while ($hierarchies->hasNext()) {
				$count++;
				$hierarchies->next();
			}
			$this->assertEqual($count, 2);
		}
	}