<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchy.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: NodeTestCase.class.php,v 1.11 2005/01/19 16:32:59 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class HarmoniNodeTestCase extends UnitTestCase {
	
		var $hierarchy;
		var $node;
		
		var $branchNodeLevel0Id;
		var $leafNodeLevel0Id;
		var $branchNodeLevel1Id;
		var $leafNodeLevel1Id;
//		var $branchNodeLevel2Id;
		var $leafNodeLevel2Id;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// perhaps, initialize $obj here
//			print "<pre>";
			
        	$this->branchNodeLevel0Id = 0;
        	$this->leafNodeLevel0Id = 0;
        	$this->branchNodeLevel1Id = 0;
        	$this->leafNodeLevel1Id = 0;
//        	$this->branchNodeLevel2Id = 0;
        	$this->leafNodeLevel2Id = 0;
        	
			$nodeTypes = array();
			$nodeTypes[] =& new GenericNodeType;
			
			$hierarchyId =& new HarmoniTestId;
			
			$hierarchyStore =& new MemoryOnlyHierarchyStore;
			
			// The id for each of these will be the initial number of the last part.
			$this->hierarchy =& new HarmoniHierarchy($hierarchyId, "Test Case Hierarchy",
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
			$this->branchNodeLevel0 =& $this->hierarchy->createRootNode($nodeId, $nodeType, "Collection Two", "A Collection, the second root node created");
			
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
			$this->leafNodeLevel2 =& $this->hierarchy->createNode($nodeId, $parentId, $nodeType, "Sub-Asset Five", "The second sub-asset added to Asset Four");
			
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
			
			$this->node =& $this->hierarchy->getNode($this->branchNodeLevel1Id);
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->node);
			unset($this->hierarchy);
//			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_get_id_and_strings() {
			$node =& $this->node;
			
//			print_r($node);
			$this->assertTrue($this->branchNodeLevel1Id->isEqual($node->getId()));
			$this->assertEqual("Asset Four",$node->getDisplayName());
			$this->assertEqual("The second asset added to Collection Two",$node->getDescription());
		}
		
		function test_get_parents () {
			$node =& $this->node;
			
			$nodeIterator =& $node->getParents();
			
			$count = 0;
			while ($nodeIterator->hasNext()) {
				$count++;
				$parentNode =& $nodeIterator->next();
			}
			
			$this->assertEqual(1, $count);
			$this->assertReference($parentNode, $this->branchNodeLevel0);
		}
		
		function test_get_children () {
			$node =& $this->node;
			
			$nodeIterator =& $node->getChildren();
			
			$count = 0;
			while ($nodeIterator->hasNext()) {
				$count++;
				if ($count == 2)
					$childNode =& $nodeIterator->next();
				else
					$nodeIterator->next();
			}
			
			$this->assertEqual(2, $count);
			$this->assertReference($childNode, $this->leafNodeLevel2);
		}
		
		function test_update_description_displayname () {
			$node =& $this->node;
			
			$node->updateDisplayName("This is my new Display Name");
			$node->updateDescription("This is my new Description");
			$this->assertEqual("This is my new Display Name",$node->getDisplayName());
			$this->assertEqual("This is my new Description",$node->getDescription());
		}
		
		function test_is_leaf () {			
			$this->assertFalse($this->node->isLeaf());
			$this->assertFalse($this->branchNodeLevel0->isLeaf());
			$this->assertTrue($this->leafNodeLevel2->isLeaf());
		}
		
		function test_is_root () {
			$this->assertFalse($this->node->isRoot());
			$this->assertTrue($this->branchNodeLevel0->isRoot());
			$this->assertFalse($this->leafNodeLevel2->isRoot());
		}

	}