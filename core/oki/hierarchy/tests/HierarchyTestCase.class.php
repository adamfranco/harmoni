<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchy.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HierarchyTestCase.class.php,v 1.3 2003/10/08 22:04:39 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class HarmoniHierarcyTestCase extends UnitTestCase {
	
		var $hierarchy;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here
			print "<pre>";
			
			$nodeTypes = array();
			$nodeTypes[] =& new GenericNodeType;
			
			// The id for each of these will be the initial number of the last part.
			$this->hierarchy =& new HarmoniHierarchy(new HarmoniTestId, "Test Case Hierarchy",
												"A Hierarchy for the HierarchyTestCase",
												$nodeTypes);
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->hierarchy);
			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_constructor() {
			$id =& new HarmoniTestId;
			$nodeTypes = array();
			$nodeTypes[] =& new GenericNodeType;
			
			// The id for each of these will be the initial number of the last part.
			$hierarchy =& new HarmoniHierarchy($id, "Test Case Hierarchy",
												"A Hierarchy for the HierarchyTestCase",
												$nodeTypes);
			print_r($hierarchy);
			
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
			$this->assertEqual("Node creation","tested.");
		}		

	}