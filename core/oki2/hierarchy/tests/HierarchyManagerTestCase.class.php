<?php

require_once(HARMONI.'/oki/hierarchy2/HarmoniHierarchyManager.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HierarchyManagerTestCase.class.php,v 1.1 2005/01/11 17:40:21 adamfranco Exp $
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
			// Set up the database connection
			$dbHandler=&Services::requireService("DBHandler");
			$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			$dbHandler->pConnect($dbIndex);
			unset($dbHandler); // done with that for now
			
			$this->manager =& new HarmoniHierarchyManager($dbIndex, "doboHarmoniTest");
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
        }

		//--------------the tests ----------------------

		function test_get_hierarchy() {
			$hierarchy =& $this->manager->getHierarchy(new HarmoniId("8"));
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
			$this->assertIdentical($hierarchy->getId(), new HarmoniId("8"));
			$this->assertTrue(is_string($hierarchy->getDisplayName()));
			$this->assertTrue(is_String($hierarchy->getDescription()));
			$this->assertIdentical($hierarchy->allowsMultipleParents(), true);
			$this->assertIdentical($hierarchy->allowsRecursion(), false);
			
			// second time should be from cache
			$hierarchy =& $this->manager->getHierarchy(new HarmoniId("8"));
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
			$this->assertIdentical($hierarchy->getId(), new HarmoniId("8"));
			$this->assertTrue(is_string($hierarchy->getDisplayName()));
			$this->assertTrue(is_String($hierarchy->getDescription()));
			$this->assertIdentical($hierarchy->allowsMultipleParents(), true);
			$this->assertIdentical($hierarchy->allowsRecursion(), false);
		}

		function test_get_hierarchies() {
			$hierarchies =& $this->manager->getHierarchies();
			while ($hierarchies->hasNext()) {
				$hierarchy =& $hierarchies->next();
				$this->assertIsA($hierarchy, "HarmoniHierarchy");
			}
		}
		
		function test_create_and_delete_hierarchy() {
			$hierarchy =& $this->manager->createHierarchy("H5", null, "Hierarchy Five", true, false);
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
			$this->assertIdentical($hierarchy->getDisplayName(), "H5");
			$this->assertIdentical($hierarchy->getDescription(), "Hierarchy Five");
			$this->assertIdentical($hierarchy->allowsMultipleParents(), true);
			$this->assertIdentical($hierarchy->allowsRecursion(), false);

			$this->manager->deleteHierarchy($hierarchy->getId());
		}
		
		function test_node() {
			$node =& $this->manager->getNode(new HarmoniId("3"));
			$this->assertIsA($node, "Node");
			$this->assertIdentical($node->getDisplayName(), "C");
			$this->assertIdentical($node->getDescription(), "");
			$deftype =& new DefaultNodeType();
			$type =& $node->getType();
			$this->assertIdentical($type->getAuthority(), $deftype->getAuthority());
			$this->assertIdentical($type->getDomain(), $deftype->getDomain());
			$this->assertIdentical($type->getKeyword(), $deftype->getKeyword());
			$this->assertIdentical($type->getDescription(), $deftype->getDescription());
			
			$this->assertIdentical($node->_cache->_allowsMultipleParents, true);
			
			$hierarchy =& $this->manager->getHierarchy(new HarmoniId("8"));
			$this->assertReference($hierarchy->_cache, $node->_cache);		
		}

	}