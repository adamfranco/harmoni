<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchyManager.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');
require_once(HARMONI.'/oki/hierarchy/tests/TestNodeType.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HierarchyManagerTestCase.class.php,v 1.1 2003/10/10 17:32:54 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class HarmoniHierarcyManagerTestCase extends UnitTestCase {
	
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
			
			// The id for each of these will be the initial number of the last part.
			$this->hierarchy =& new HarmoniHierarchy(new HarmoniTestId, "Test Case Hierarchy",
												"A Hierarchy for the HierarchyTestCase",
												$nodeTypes);
			
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
			$this->assertTrue(FALSE);
		}
	}