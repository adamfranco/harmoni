<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchyManager.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');
require_once(HARMONI.'/oki/hierarchy/tests/TestNodeType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HierarchyManagerSQLTestCase.class.php,v 1.4 2005/01/19 22:28:09 adamfranco Exp $
 * @package harmoni.tests.metadata
 * @copyright 2003
 **/

    class HierarchyManagerSQLTestCase extends UnitTestCase {
	
		var $manager;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
//        	print "<pre>";
        	
        	$this->dbc =& Services::requireService("DBHandler","DBHandler");
 			$this->dbindex = $this->dbc->createDatabase(MYSQL,"devo.middlebury.edu", "harmoniTest", "test", "test");
 			$this->dbc->connect($this->dbindex);

			$configuration = array(
				"type" => SQL_DATABASE,
				"database_index" => $this->dbindex,
				"hierarchy_table_name" => "hierarchy",
				"hierarchy_id_column" => "id",
				"hierarchy_display_name_column" => "display_name",
				"hierarchy_description_column" => "description",
				"node_table_name" => "hierarchy_node",
				"node_hierarchy_key_column" => "fk_hierarchy",
				"node_id_column" => "id",
				"node_parent_key_column" => "lk_parent",
				"node_display_name_column" => "display_name",
				"node_description_column" => "description"
			);
        	
        	$this->manager =& new HarmoniHierarchyManager($configuration);
        	
        	$this->numPreExisting = 0;
        	$hierarchyIterator =& $this->manager->getHierarchies();
        	while ($hierarchyIterator->hasNext()) {
        		$this->numPreExisting++;
        		$hierarchyIterator->next();
        	}
        	
        	$nodeType =& new TestNodeType;
			$nodeTypes = array ($nodeType);
			$this->hierarchy1 =& $this->manager->createHierarchy(FALSE, "A test Hierarchy", "Hierarchy1", $nodeTypes, FALSE);
			$this->hierarchy1Id =& $this->hierarchy1->getId();
			$this->hierarchy2 =& $this->manager->createHierarchy(FALSE, "Another test Hierarchy", "Hierarchy2", $nodeTypes, FALSE);
			$this->hierarchy2Id =& $this->hierarchy2->getId();
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
			
			$this->manager->deleteHierarchy($this->hierarchy1Id);
			$this->manager->deleteHierarchy($this->hierarchy2Id);
			$this->manager->save();
			
			unset($this->manager);
//			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_constructor() {
			$manager =& new HarmoniHierarchyManager;
			$this->assertTrue(is_object($manager));
		}
		
		function test_hierarchy_creation() {
			$manager =& $this->manager;
			$nodeType =& new TestNodeType;
			$nodeTypes = array ($nodeType);
			$hierarchy1 =& $manager->createHierarchy(FALSE, "A test Hierarchy", "Hierarchy1", $nodeTypes, FALSE);
			$hierarchy1Id =& $hierarchy1->getId();
			$hierarchy =& $manager->getHierarchy($hierarchy1Id);
			
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
			
			$hierarchy2 =& $manager->createHierarchy(FALSE, "Another test Hierarchy", "Hierarchy2", $nodeTypes, FALSE);
			$hierarchy2Id = $hierarchy2->getId();
//			print $this->dbc->getTotalNumberOfQueries($this->dbindex)."\n";
//			print_r($manager);
			$manager->save();
//			print $this->dbc->getTotalNumberOfQueries($this->dbindex)."\n";
			
			$configuration = array(
				"type" => SQL_DATABASE,
				"database_index" => $this->dbindex,
				"hierarchy_table_name" => "hierarchy",
				"hierarchy_id_column" => "id",
				"hierarchy_display_name_column" => "display_name",
				"hierarchy_description_column" => "description",
				"node_table_name" => "hierarchy_node",
				"node_hierarchy_key_column" => "fk_hierarchy",
				"node_id_column" => "id",
				"node_parent_key_column" => "lk_parent",
				"node_display_name_column" => "display_name",
				"node_description_column" => "description"
			);
        	
        	$manager2 =& new HarmoniHierarchyManager($configuration);
			
			$hierarchies =& $manager2->getHierarchy($hierarchy2Id);
			
//			print_r ($manager);
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
			
			$manager->deleteHierarchy($hierarchy1Id);
			$manager->deleteHierarchy($hierarchy2Id);
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
			$this->assertEqual($count, (3 + $this->numPreExisting));
			$this->assertReference($hierarchy, $thirdHierarchy);
			
			$id =& $thirdHierarchy->getId();
			$manager->deleteHierarchy($id);
		}
		
		function test_get_hierarchy() {
			$manager =& $this->manager;
			
			$nodeType =& new TestNodeType;
			$nodeTypes = array ($nodeType);
			$thirdHierarchy =& $manager->createHierarchy(FALSE, "Yet another test Hierarchy", "Hierarchy3", $nodeTypes, FALSE);
			$thirdHierarchyId = $thirdHierarchy->getId();
			$hierarchy =& $manager->getHierarchy($thirdHierarchyId);
			$this->assertReference($hierarchy, $thirdHierarchy);
			
			$manager->deleteHierarchy($thirdHierarchyId);
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
			$this->assertEqual($count, (3 + $this->numPreExisting));
			
			$manager->deleteHierarchy($thirdHierarchyId);
			
			$hierarchies =& $manager->getHierarchies();
			$count = 0;
			while ($hierarchies->hasNext()) {
				$count++;
				$hierarchies->next();
			}
			$this->assertEqual($count, (2 + $this->numPreExisting));
		}
		
		function test_insterting_and_working_once() {
		
		}
	}