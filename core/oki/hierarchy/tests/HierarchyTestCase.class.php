<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniHierarchy.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTestId.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HierarchyTestCase.class.php,v 1.2 2003/10/08 21:14:48 adamfranco Exp $
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
			
			// The id for each of these will be the initial number of the last part.
			$this->hierarchy =& new HarmoniHierarchy(new HarmoniTestId, "Test Case Hierarchy",
												"A Hierarchy for the HierarchyTestCase",
												array(
													new GenericNodeType
												));
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

		function test_setdata_object_consistancy() {
			$hierarchy =& $this->hierarchy;
			print_r($hierarchy);
			
			// make sure the object in the tree's data store is the actual one.
/* 			$this->assertReference($tree2, $tree->data[2]); */
/* 			 */
/* 			// get the object back and check that it is referencing the origional. */
/* 			$result =& $tree->getData(2); */
/* 			$this->assertReference($tree2, $result); */
		}

	}