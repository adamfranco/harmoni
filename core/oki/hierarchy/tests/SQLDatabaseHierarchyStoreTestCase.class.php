<?php

require_once(HARMONI.'/oki/hierarchy/SQLDatabaseHierarchyStore.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: SQLDatabaseHierarchyStoreTestCase.class.php,v 1.4 2003/11/03 22:55:07 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class SQLDatabaseHierarchyStoreTestCase extends UnitTestCase {
		
		var $store;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
        	print "<pre>";
        	$this->dbc =& Services::requireService("DBHandler","DBHandler");
 			$this->dbindex = $this->dbc->createDatabase(MYSQL,"devo.middlebury.edu", "harmoniTest", "test", "test");
 			$this->dbc->connect($this->dbindex);
 			
			$this->store =& new SQLDatabaseHierarchyStore(1, $this->dbindex, 
				"hierarchy", "id","display_name","description",
				"hierarchy_node","fk_hierarchy","id","lk_parent","display_name",
				"description");
			$this->store->load();
			
			$sharedManager =& Services::getService("Shared");
			$this->newRootId =& $sharedManager->createId();
			$this->newRootIdString = $this->newRootId->getIdString();
			$this->newRoot =& new HarmoniNode($this->newRootId, $this->store, NULL, "Testing Root","The Root of my test nodes");
			$this->store->addNode($this->newRoot,0,$this->newRootIdString);
			
			$this->node2Id =& $sharedManager->createId();
			$this->node2IdString = $this->node2Id->getIdString();
			$this->node2 =& new HarmoniNode($this->node2Id, $this->store, NULL, "Node 2","The first child of the test Root node.");
			$this->store->addNode($this->node2,$this->newRootIdString,$this->node2IdString);
			
			$this->node3Id =& $sharedManager->createId();
			$this->node3IdString = $this->node3Id->getIdString();
			$this->node3 =& new HarmoniNode($this->node3Id, $this->store, NULL, "Node 3","The second child of the test Root node.");
			$this->store->addNode($this->node3,$this->newRootIdString,$this->node3IdString);
			
			$this->node4Id =& $sharedManager->createId();
			$this->node4IdString = $this->node4Id->getIdString();
			$this->node4 =& new HarmoniNode($this->node4Id, $this->store, NULL, "Node 4","The first child of node 2.");
			$this->store->addNode($this->node4,$this->node2IdString,$this->node4IdString);

			$this->node5Id =& $sharedManager->createId();
			$this->node5IdString = $this->node5Id->getIdString();
			$this->node5 =& new HarmoniNode($this->node5Id, $this->store, NULL, "Node 5","The second child of node 2.");
			$this->store->addNode($this->node5,$this->node2IdString,$this->node5IdString);
			
			$this->store->save();
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			$this->store->removeNode($this->newRootIdString);
			$this->store->save();
			
//			$this->dbc->disconnect($this->dbindex);
			
			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_add_node() {
			$store =& $this->store;
			
			$this->assertEqual(count($store->_added),0);
			$this->assertEqual(count($store->_changed),0);
			$this->assertEqual(count($store->_deleted),0);
			
			$sharedManager =& Services::getService("Shared");
			$nodeId =& $sharedManager->createId();
			$nodeIdString = $nodeId->getIdString();
			$testObj =& new HarmoniNode($nodeId, $store, NULL, "Yet another node","my interesting description");
			
			$store->addNode($testObj,$this->newRootIdString,$nodeIdString);
			
			$this->assertEqual(count($store->_added),1);
			$this->assertTrue(in_array($nodeIdString,$store->_added));
			$this->assertEqual(count($store->_changed),0);
			$this->assertEqual(count($store->_deleted),0);
			$this->assertReference($testObj, $store->getData($nodeIdString));

/* 			print_r($store->depthFirstEnumeration(0)); */
			$store->save();
			
			$storedHierarchy =& new SQLDatabaseHierarchyStore(1, $this->dbindex, 
					"hierarchy", "id","display_name","description",
					"hierarchy_node","fk_hierarchy","id","lk_parent","display_name",
					"description");
			$storedHierarchy->load();
			$storedNodeObj =& $storedHierarchy->getData($nodeIdString);
			
			$this->assertEqual($storedHierarchy->getParentId($nodeIdString), $store->getParentId($nodeIdString));
			$this->assertEqual($storedHierarchy->depth($nodeIdString), $store->depth($nodeIdString));
			$this->assertEqual($storedHierarchy->hasChildren($nodeIdString), $store->hasChildren($nodeIdString));
			$this->assertEqual($storedHierarchy->numChildren($nodeIdString), $store->numChildren($nodeIdString));
			
			$this->assertEqual($testObj->getDescription(), $storedNodeObj->getDescription());
			$this->assertEqual($testObj->getDisplayName(), $storedNodeObj->getDisplayName());
		}
		
		function test_remove_node() {
			$store =& $this->store;
			
			// make sure that the node and its children exist.
			$this->assertTrue($store->nodeExists($this->node2IdString));
			$this->assertTrue($store->nodeExists($this->node4IdString));
			$this->assertTrue($store->nodeExists($this->node5IdString));
			
			$store->removeNode($this->node2IdString);
			$store->save();
			
			// make sure that the node and its children are gone, but the rest of the
			// hierarchy is still there.
			$this->assertFalse($store->nodeExists($this->node2IdString));
			$this->assertFalse($store->nodeExists($this->node4IdString));
			$this->assertFalse($store->nodeExists($this->node5IdString));
			$this->assertTrue($store->nodeExists($this->newRootIdString));
			$this->assertTrue($store->nodeExists($this->node3IdString));
						
			$storedHierarchy =& new SQLDatabaseHierarchyStore(1, $this->dbindex, 
					"hierarchy", "id","display_name","description",
					"hierarchy_node","fk_hierarchy","id","lk_parent","display_name",
					"description");
			$storedHierarchy->load();
			
			// make sure that the node and its children are gone, but the rest of the
			// hierarchy is still there.
			$this->assertFalse($storedHierarchy->nodeExists($this->node2IdString));
			$this->assertFalse($storedHierarchy->nodeExists($this->node4IdString));
			$this->assertFalse($storedHierarchy->nodeExists($this->node5IdString));
			$this->assertTrue($storedHierarchy->nodeExists($this->newRootIdString));
			$this->assertTrue($storedHierarchy->nodeExists($this->node3IdString));
//			print_r ($this->dbc);
		}
		
		function test_numbers() {
			$store =& $this->store;
			
			// totals
			$this->assertEqual($store->totalNodes(),count($store->_tree->structure));
			
			// depths
			$this->assertEqual($store->depth($this->newRootIdString),0);
			$this->assertEqual($store->depth($this->node2IdString),1);
			$this->assertEqual($store->depth($this->node3IdString),1);
			$this->assertEqual($store->depth($this->node4IdString),2);
			$this->assertEqual($store->depth($this->node5IdString),2);

			// hasChildren
			$this->assertTrue($store->hasChildren($this->newRootIdString));
			$this->assertTrue($store->hasChildren($this->node2IdString));
			$this->assertFalse($store->hasChildren($this->node3IdString));
			$this->assertFalse($store->hasChildren($this->node4IdString));
			$this->assertFalse($store->hasChildren($this->node5IdString));
			
			// numChildren
			$this->assertEqual($store->numChildren($this->newRootIdString),2);
			$this->assertEqual($store->numChildren($this->node2IdString),2);
			$this->assertEqual($store->numChildren($this->node3IdString),0);
			$this->assertEqual($store->numChildren($this->node4IdString),0);
			$this->assertEqual($store->numChildren($this->node5IdString),0);
			
			// get children
			$children = $store->getChildren($this->node2IdString);
			$this->assertEqual(count($children),2);
			$this->assertTrue(in_array($this->node4IdString, $children));
			$this->assertTrue(in_array($this->node5IdString, $children));
		}

		function test_relations() {
			$store =& $this->store;
			
			// parentIds
			$this->assertEqual($store->getParentId($this->newRootIdString),0);
			$this->assertEqual($store->getParentId($this->node2IdString),$this->newRootIdString);
			$this->assertEqual($store->getParentId($this->node3IdString),$this->newRootIdString);
			$this->assertEqual($store->getParentId($this->node4IdString),$this->node2IdString);
			$this->assertEqual($store->getParentId($this->node5IdString),$this->node2IdString);
			
			// is child of
			$this->assertTrue($store->isChildOf($this->node2IdString,$this->newRootIdString));
			$this->assertTrue($store->isChildOf($this->node3IdString,$this->newRootIdString));
			$this->assertFalse($store->isChildOf($this->node3IdString,$this->node2IdString));
			$this->assertTrue($store->isChildOf($this->node4IdString,$this->node2IdString));
			$this->assertTrue($store->isChildOf($this->node5IdString,$this->node2IdString));

		}
		
		function test_leaf_moveTo() {
			$store =& $this->store;
			
			$store->moveTo($this->node4IdString,$this->node3IdString);
			$this->assertEqual($store->numChildren($this->node2IdString),1);
			$this->assertEqual($store->numChildren($this->node3IdString),1);
			$children = $store->getChildren($this->node3IdString);
			$this->assertEqual(count($children),1);
			$this->assertTrue(in_array($this->node4IdString, $children));
			
			$store->save();
			
			$store =& new SQLDatabaseHierarchyStore(1, $this->dbindex, 
					"hierarchy", "id","display_name","description",
					"hierarchy_node","fk_hierarchy","id","lk_parent","display_name",
					"description");
			$store->load($this->newRootIdString);
			
			$this->assertEqual($store->numChildren($this->node2IdString),1);
			$this->assertEqual($store->numChildren($this->node3IdString),1);
			$children = $store->getChildren($this->node3IdString);
			$this->assertEqual(count($children),1);
			$this->assertTrue(in_array($this->node4IdString, $children));
		}

		function test_branch_moveTo() {
			$store =& $this->store;
			
			$store->moveTo($this->node2IdString,$this->node3IdString);
			
			$this->assertEqual($store->numChildren($this->node2IdString),2);
			$this->assertEqual($store->numChildren($this->node3IdString),1);
			$this->assertEqual($store->numChildren($this->node3IdString),1);
			$children = $store->getChildren($this->node3IdString);
			$this->assertEqual(count($children),1);
			$this->assertTrue(in_array($this->node2IdString, $children));
			
			$store->save();
			
			$store =& new SQLDatabaseHierarchyStore(1, $this->dbindex, 
					"hierarchy", "id","display_name","description",
					"hierarchy_node","fk_hierarchy","id","lk_parent","display_name",
					"description");
			$store->load($this->newRootIdString);
			
			$this->assertEqual($store->numChildren($this->node2IdString),2);
			$this->assertEqual($store->numChildren($this->node3IdString),1);
			$children = $store->getChildren($this->node3IdString);
			$this->assertEqual(count($children),1);
			$this->assertTrue(in_array($this->node2IdString, $children));
			$children = $store->getChildren($this->newRootIdString);
		}
		
		function test_leaf_moveChildrenTo() {
			$store =& $this->store;
			
			$store->moveChildrenTo($this->node2IdString,$this->node3IdString);
			$this->assertEqual($store->numChildren($this->node2IdString),0);
			$this->assertEqual($store->numChildren($this->node3IdString),2);
			$children = $store->getChildren($this->node3IdString);
			$this->assertEqual(count($children),2);
			$this->assertTrue(in_array($this->node4IdString, $children));
			$this->assertTrue(in_array($this->node5IdString, $children));
			
			$store->save();
			
			$store =& new SQLDatabaseHierarchyStore(1, $this->dbindex, 
					"hierarchy", "id","display_name","description",
					"hierarchy_node","fk_hierarchy","id","lk_parent","display_name",
					"description");
			$store->load($this->newRootIdString);
			
			$this->assertEqual($store->numChildren($this->node2IdString),0);
			$this->assertEqual($store->numChildren($this->node3IdString),2);
			$children = $store->getChildren($this->node3IdString);
			$this->assertEqual(count($children),2);
			$this->assertTrue(in_array($this->node4IdString, $children));
			$this->assertTrue(in_array($this->node5IdString, $children));
		}
	}