<?php

require_once(HARMONI.'/oki/hierarchy/HarmoniNode.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: NodeTestCase.class.php,v 1.2 2003/10/08 21:14:48 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class HarmoniNodeTestCase extends UnitTestCase {
	
		var $node;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here
			print "<pre>";
			
			// The id for each of these will be the initial number of the last part.
			$this->node =& new HarmoniNode(
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->node);
			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_setdata_object_consistancy() {
			$node =& $this->node;
//			print_r($node);
			
			// make sure the object in the tree's data store is the actual one.
/* 			$this->assertReference($tree2, $tree->data[2]); */
/* 			 */
/* 			// get the object back and check that it is referencing the origional. */
/* 			$result =& $tree->getData(2); */
/* 			$this->assertReference($tree2, $result); */
		}

	}