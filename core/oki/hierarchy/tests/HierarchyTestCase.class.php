<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchy.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');
require_once(HARMONI.'/oki/hierarchy/tests/TestNodeType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HierarchyTestCase.class.php,v 1.8 2003/10/13 15:07:42 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class HarmoniHierarcyTestCase extends UnitTestCase {
	
		var $hierarchy;
		
		var $branchNodeLevel0Id;
		var $leafNodeLevel0Id;
		var $branchNodeLevel1Id;
		var $leafNodeLevel1Id;
//		var $branchNodeLevel2Id;
		var $leafNodeLevel2Id;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
        
        	$this->branchNodeLevel0Id = 0;
        	$this->leafNodeLevel0Id = 0;
        	$this->branchNodeLevel1Id = 0;
        	$this->leafNodeLevel1Id = 0;
//        	$this->branchNodeLevel2Id = 0;
        	$this->leafNodeLevel2Id = 0;
        	
			// perhaps, initialize $obj here
//			print "<pre>";
			
			$nodeTypes = array();
			$nodeTypes[] =& new GenericNodeType;
			
			$hierarchyStore =& new MemoryOnlyHierarchyStore;
			
			// The id for each of these will be the initial number of the last part.
			$this->hierarchy =& new HarmoniHierarchy(new HarmoniTestId, "Test Case Hierarchy",
												"A Hierarchy for the HierarchyTestCase",
												$nodeTypes, $hierarchyStore);
			
			// Add some nodes
			$nodeType =& new GenericNodeType;

			$nodeId =& new HarmoniTestId;
			$node =& $this->hierarchy->createRootNode($nodeId, $nodeType, "Collection One", "A Collection, the first root node created");
			
			// Add a children nodes
			$parentId =& $nodeId;
			
			$nodeId =& new HarmoniTestId;
			$firstChildId = $nodeId;
			$node =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Asset One", "The first asset added to Collection One");
			
			// Add a second child node
			$this->leafNodeLevel1Id = $nodeId =& new HarmoniTestId;
			$node =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Asset Two", "The second asset added to Collection One");
			
			// Add a child node to the first child
			$nodeId =& new HarmoniTestId;
			$parentId =& $firstChildId;
			$node =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Sub-Asset One", "The first sub-asset added to Asset One");
			
			// Add another root node
			$this->branchNodeLevel0Id = $nodeId =& new HarmoniTestId;
			$node =& $this->hierarchy->createRootNode($nodeId, $nodeType, "Collection Two", "A Collection, the second root node created");
			
			// Add a children nodes
			$parentId =& $nodeId;
			
			$nodeId =& new HarmoniTestId;
			$firstChildId = $nodeId;
			$node =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Asset Three", "The first asset added to Collection Two");
			
			// Add a second child node
			$this->branchNodeLevel1Id = $nodeId =& new HarmoniTestId;
			$this->branchNodeLevel1 =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Asset Four", "The second asset added to Collection Two");
			
			// Add a child node to the second child
			$parentId =& $nodeId;
			$nodeId =& new HarmoniTestId;
			$node =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Sub-Asset Four", "The first sub-asset added to Asset Four");
			
			// Add a child node to the second child
			$nodeId =& new HarmoniTestId;
			$node =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Sub-Asset Five", "The second sub-asset added to Asset Four");
			
			// Add a child node to the first child
			$nodeId =& new HarmoniTestId;
			$parentId =& $firstChildId;
			$node =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Sub-Asset Two", "The first sub-asset added to Asset Three");
			
			// Add a child node to the first child
			$this->leafNodeLevel2Id = $nodeId =& new HarmoniTestId;
			$parentId =& $firstChildId;
			$node =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Sub-Asset Three", "The second sub-asset added to Asset Three");
			
			// Add another root node
			$this->leafNodeLevel0Id = $nodeId =& new HarmoniTestId;
			$this->leafNodeLevel0 =& $this->hierarchy->createRootNode($nodeId, $nodeType, "Collection Two", "A Collection, the second root node created");
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->hierarchy);
//			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_constructor() {
			$id =& new HarmoniTestId;
			$nodeTypes = array();
			$nodeTypes[] =& new GenericNodeType;
			$hierarchyStore =& new MemoryOnlyHierarchyStore;
			
			// The id for each of these will be the initial number of the last part.
			$hierarchy =& new HarmoniHierarchy($id, "Test Case Hierarchy",
												"A Hierarchy for the HierarchyTestCase",
												$nodeTypes, $hierarchyStore);
//			print_r($hierarchy);
			
			$returnedId =& $hierarchy->getId();
			$this->assertReference($id,	$returnedId);
			$this->assertTrue($id->isEqual($returnedId));
			
			$nodeTypesIterator =& $hierarchy->getNodeTypes();
			$returnedNodeType =& $nodeTypesIterator->next();
			$this->assertReference($nodeTypes[0], $returnedNodeType);
			$this->assertTrue($nodeTypes[0]->isEqual($returnedNodeType));
			
			$this->assertEqual("Test Case Hierarchy",$hierarchy->getDisplayName());
			$this->assertEqual("A Hierarchy for the HierarchyTestCase",$hierarchy->getDescription());
			$hierarchy->updateDescription("My new Description");
			$this->assertEqual("My new Description",$hierarchy->getDescription());
		}

		function test_node_creation () {
			$id =& new HarmoniTestId;
			$nodeTypes = array();
			$nodeTypes[] =& new GenericNodeType;
			$hierarchyStore =& new MemoryOnlyHierarchyStore;
			
			// The id for each of these will be the initial number of the last part.
			$hierarchy =& new HarmoniHierarchy($id, "Test Case Hierarchy",
												"A Hierarchy for the HierarchyTestCase",
												$nodeTypes, $hierarchyStore);
												
			// Add a root Node
			$nodeId =& new HarmoniTestId;
			$nodeType =& new GenericNodeType;
			$node =& $hierarchy->createRootNode($nodeId, $nodeType, "Collection One", "A Collection, the first root node created");
			
			$this->assertReference($node, $hierarchy->_hierarchyStore->_tree->data[$nodeId->getIdString()]);
			$nodeIterator =& $hierarchy->getAllNodes();
			$returnedNode =& $nodeIterator->next();
			$this->assertReference($node, $returnedNode);
			$this->assertReference($node->getId(), $returnedNode->getId());
			$this->assertReference($node->getType(), $returnedNode->getType());
			
			// Add a child node
			$parentId =& $nodeId;
			$nodeId =& new HarmoniTestId;
			$firstChildId = $nodeId;
			$node =& $hierarchy->createNode($nodeId, $parentId, $nodeType, "Asset One", "The first asset added to Collection One");
			
			$this->assertReference($node, $hierarchy->_hierarchyStore->_tree->data[$nodeId->getIdString()]);
			$nodeIterator =& $hierarchy->getAllNodes();
			$nodeIterator->next(); // the root node
			$returnedNode =& $nodeIterator->next(); // the first child of the root
			$this->assertReference($node, $returnedNode);
			$this->assertReference($node->getId(), $returnedNode->getId());
			$this->assertReference($node->getType(), $returnedNode->getType());
			
			// Add a second child node
			$nodeId =& new HarmoniTestId;
			$node =& $hierarchy->createNode($nodeId, $parentId, $nodeType, "Asset Two", "The second asset added to Collection One");
			
			$this->assertReference($node, $hierarchy->_hierarchyStore->_tree->data[$nodeId->getIdString()]);
			$nodeIterator =& $hierarchy->getAllNodes();
			$nodeIterator->next(); // pull the root node
			$nodeIterator->next(); // the first child of the root
			$returnedNode =& $nodeIterator->next(); // the next child of the root node
			$this->assertReference($node, $returnedNode);
			$this->assertReference($node->getId(), $returnedNode->getId());
			$this->assertReference($node->getType(), $returnedNode->getType());
			
			// Add a child node to the first child
			$nodeId =& new HarmoniTestId;
			$parentId =& $firstChildId;
			$node =& $hierarchy->createNode($nodeId, $parentId, $nodeType, "Sub-Asset One", "The first sub-asset added to Collection One");
			
			$this->assertReference($node, $hierarchy->_hierarchyStore->_tree->data[$nodeId->getIdString()]);
			$nodeIterator =& $hierarchy->getAllNodes();
			$nodeIterator->next(); // pull the root node
			$nodeIterator->next(); // the first child of the root
			$returnedNode =& $nodeIterator->next(); // the next child of the child node
			$this->assertReference($node, $returnedNode);
			$this->assertReference($node->getId(), $returnedNode->getId());
			$this->assertReference($node->getType(), $returnedNode->getType());
		}
		
		function test_node_deletion () {
			$hierarchy =& $this->hierarchy;

			//$hierarchy->deleteNode($this->branchNodeLevel0Id); // throws a proper error
			$hierarchy->deleteNode($this->leafNodeLevel0Id);
			$this->assertFalse($hierarchy->_hierarchyStore->nodeExists($this->leafNodeLevel0Id->getIdString()));
			
			//$hierarchy->deleteNode($this->branchNodeLevel1Id); // throws a proper error
			$hierarchy->deleteNode($this->leafNodeLevel1Id);
			$this->assertFalse($hierarchy->_hierarchyStore->nodeExists($this->leafNodeLevel1Id->getIdString()));
			
			$hierarchy->deleteNode($this->leafNodeLevel2Id);
			$this->assertFalse($hierarchy->_hierarchyStore->nodeExists($this->leafNodeLevel2Id->getIdString()));
		}
		
		function test_get_node () {
			$hierarchy =& $this->hierarchy;
			
			$node =& $hierarchy->getNode($this->branchNodeLevel1Id);
			$this->assertTrue($this->branchNodeLevel1Id->isEqual($node->getId()));
			$this->assertReference($node ,$this->branchNodeLevel1);
			
			$node =& $hierarchy->getNode($this->branchNodeLevel0Id);
			$this->assertTrue($this->branchNodeLevel0Id->isEqual($node->getId()));
			
			$node =& $hierarchy->getNode($this->leafNodeLevel2Id);
			$this->assertTrue($this->leafNodeLevel2Id->isEqual($node->getId()));
			
			$node =& $hierarchy->getNode($this->leafNodeLevel1Id);
			$this->assertTrue($this->leafNodeLevel1Id->isEqual($node->getId()));
		}
		
		function test_get_all_nodes () {
			$hierarchy =& $this->hierarchy;
			
			$nodeIterator =& $hierarchy->getAllNodes();
			$nodeCount = 0;
			while ($nodeIterator->hasNext()) {
				$nodeCount++;
				if ($nodeCount == 9)
					$resultNode =& $nodeIterator->next();
				else
					$nodeIterator->next();
			}
			
			$this->assertEqual(12, $nodeCount);
			$this->assertReference($resultNode ,$this->branchNodeLevel1);
		}
		
		function test_get_root_nodes () {
			$hierarchy =& $this->hierarchy;
			
			$nodeIterator =& $hierarchy->getRootNodes();
			$nodeCount = 0;
			while ($nodeIterator->hasNext()) {
				$nodeCount++;
				if ($nodeCount == 3)
					$resultNode =& $nodeIterator->next();
				else
					$nodeIterator->next();
			}
			
			$this->assertEqual(3, $nodeCount);
			$this->assertReference($resultNode ,$this->leafNodeLevel0);
		}
				
		function test_traverse () {
			$hierarchy =& $this->hierarchy;
//			print_r($hierarchy);
			
			$travInfoIterator =& $hierarchy->traverse($this->branchNodeLevel0Id, TRAVERSE_MODE_DEPTH_FIRST, TRAVERSE_DIRECTION_DOWN, TRAVERSE_LEVELS_INFINITE);
//			print_r($travInfoIterator);
			
			$count = 0;
			while ($travInfoIterator->hasNext()) {
				$count++;
				if ($count == 5)
					$resultInfo =& $travInfoIterator->next();
				else
					$travInfoIterator->next();
			}
			
			$this->assertEqual(7, $count);
			$resultId =& $resultInfo->getNodeId();
			$this->assertTrue($resultId->isEqual($this->branchNodeLevel1Id));
			$this->assertEqual(1, $resultInfo->getLevel());
			
			// try more shallow
			$travInfoIterator =& $hierarchy->traverse($this->branchNodeLevel0Id, TRAVERSE_MODE_DEPTH_FIRST, TRAVERSE_DIRECTION_DOWN, 1);
//			print_r($travInfoIterator);
			
			$count = 0;
			while ($travInfoIterator->hasNext()) {
				$count++;
				if ($count == 5)
					$resultInfo =& $travInfoIterator->next();
				else
					$travInfoIterator->next();
			}
			
			$this->assertEqual(3, $count);
			$resultId =& $resultInfo->getNodeId();
			$this->assertTrue($resultId->isEqual($this->branchNodeLevel1Id));
			$this->assertEqual(1, $resultInfo->getLevel());
			
			// try from a branch
			$travInfoIterator =& $hierarchy->traverse($this->branchNodeLevel1Id, TRAVERSE_MODE_DEPTH_FIRST, TRAVERSE_DIRECTION_DOWN, TRAVERSE_LEVELS_INFINITE);
//			print_r($travInfoIterator);
			
			$count = 0;
			while ($travInfoIterator->hasNext()) {
				$count++;
				if ($count == 1)
					$resultInfo =& $travInfoIterator->next();
				else
					$travInfoIterator->next();
			}
			
			$this->assertEqual(3, $count);
			$resultId =& $resultInfo->getNodeId();
			$this->assertTrue($resultId->isEqual($this->branchNodeLevel1Id));
			$this->assertEqual(1, $resultInfo->getLevel());
		}
		
		function test_add_node_type () {
			$hierarchy =& $this->hierarchy;
			
//			$hierarchy->addNodeType(new GenericNodeType); //Fails properly
			$testNodeType =& new TestNodeType();
			$hierarchy->addNodeType($testNodeType);
			
			$testNodeTypeExists = FALSE;
			foreach ($hierarchy->_nodeTypes as $key => $val) {
				if ($testNodeType->isEqual($hierarchy->_nodeTypes[$key]))
					$testNodeTypeExists = TRUE;
			}
			$this->assertTrue($testNodeTypeExists);
		}
		
		function test_remove_node_type () {
			$hierarchy =& $this->hierarchy;
			
//			$hierarchy->removeNodeType(new GenericNodeType); //Fails properly
			
			// add a nodetype and make sure its in there
			$testNodeType =& new TestNodeType();
			$hierarchy->addNodeType($testNodeType);
	
			$testNodeTypeExists = FALSE;
			foreach ($hierarchy->_nodeTypes as $key => $val) {
				if ($testNodeType->isEqual($hierarchy->_nodeTypes[$key]))
					$testNodeTypeExists = TRUE;
			}
			$this->assertTrue($testNodeTypeExists);
			
			// remove the node type and make sure its gone.
			$testNodeType =& new TestNodeType();
			$hierarchy->removeNodeType($testNodeType);
			
			$testNodeTypeExists = FALSE;
			foreach ($hierarchy->_nodeTypes as $key => $val) {
				if ($testNodeType->isEqual($hierarchy->_nodeTypes[$key]))
					$testNodeTypeExists = TRUE;
			}
			$this->assertFalse($testNodeTypeExists);
		}
		
		function test_get_node_types () {
			$hierarchy =& $this->hierarchy;
			
			$nodeTypeIterator =& $hierarchy->getNodeTypes();
			$count = 0;
			while ($nodeTypeIterator->hasNext()) {
				$count++;
				$nodeType =& $nodeTypeIterator->next();
				$this->assertTrue($nodeType->isEqual(new GenericNodeType));
			}
			$this->assertEqual(1, $count);
			
			$testNodeType =& new TestNodeType();
			$hierarchy->addNodeType($testNodeType);
			
			$nodeTypeIterator =& $hierarchy->getNodeTypes();
			$count = 0;
			while ($nodeTypeIterator->hasNext()) {
				$count++;
				$nodeType =& $nodeTypeIterator->next();
			}
			$this->assertEqual(2, $count);
		}

	}