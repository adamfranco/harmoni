<?php

require_once(HARMONI.'/oki/hierarchy/Tree.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: TreeTestCase.class.php,v 1.8 2003/10/13 15:08:13 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class TreeTestCase extends UnitTestCase {
	
		var $tree;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
			// perhaps, initialize $obj here
//			print "<pre>";
					
			// The id for each of these will be the initial number of the last part.
			$list = array(
						"1 Collection A",
						"1 Collection A/2 Group A",
						"1 Collection A/2 Group A/3 Asset A",
						"1 Collection A/2 Group A/4 Asset B",
						"1 Collection A/5 Group B",
						"1 Collection A/5 Group B/6 Asset A",
						"1 Collection A/5 Group B/7 Asset B",
						"1 Collection A/5 Group B/8 Asset C",
						"1 Collection A/5 Group B/8 Asset C/9 SubAsset A",
						"10 Collection B",
						"10 Collection B/11 Group A"
					);
			$this->tree =& Tree::createFromList($list, '/');
//			print_r($this->tree);
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			unset($this->tree);
//			print "</pre>";
        }

		//--------------the tests ----------------------
		
		function test_nodeExists() {
			$tree =& $this->tree;
//			print_r($tree);
			$this->assertTrue($tree->nodeExists("7"));
		}
		
		function test_depth_first_traversal() {
			$tree =& $this->tree;
			$traversalArray = $tree->depthFirstEnumeration(0);
			$this->assertEqual("0,1,2,3,4,5,6,7,8,9,10,11",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(1);
			$this->assertEqual("1,2,3,4,5,6,7,8,9",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(10);
			$this->assertEqual("10,11",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(2);
			$this->assertEqual("2,3,4",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(5);
			$this->assertEqual("5,6,7,8,9",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(11);
			$this->assertEqual("11",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(3);
			$this->assertEqual("3",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(8);
			$this->assertEqual("8,9",implode(",",$traversalArray));
			
			$traversalArray = $tree->depthFirstEnumeration(1,0);
			$this->assertEqual("",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(1,1);
			$this->assertEqual("1",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(1,2);
			$this->assertEqual("1,2,5",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(5,2);
			$this->assertEqual("5,6,7,8",implode(",",$traversalArray));
			$traversalArray = $tree->depthFirstEnumeration(5,3);
			$this->assertEqual("5,6,7,8,9",implode(",",$traversalArray));

//			print_r($traversalArray);
		}

		function test_depth () {
			$tree =& $this->tree;
			
			$this->assertEqual(0, $tree->depth(1));
			$this->assertEqual(1, $tree->depth(2));
			$this->assertEqual(2, $tree->depth(3));
			$this->assertEqual(1, $tree->depth(5));
			$this->assertEqual(0, $tree->depth(10));
		}

		function test_setdata_object_consistancy() {
			$tree =& $this->tree;
			$tree2 =& new Tree;
			$tree->setData(2, $tree2);
//			print_r($tree->data);
			
			// make sure the object in the tree's data store is the actual one.
			$this->assertReference($tree2, $tree->data[2]);
			
			// get the object back and check that it is referencing the origional.
			$result =& $tree->getData(2);
			$this->assertReference($tree2, $result);
		}
		
		function test_addNode_object_consistancy() {
			$tree =& $this->tree;
			$tree2 =& new Tree;
			$tree->addNode($tree2, 10);
//			print_r($tree->data);
			
			// make sure the object in the tree's data store is the actual one.
			$this->assertReference($tree2, $tree->data[12]);
			
			// get the object back and check that it is referencing the origional.
			$result =& $tree->getData(12);
			$this->assertReference($tree2, $result);
		}
		
		function test_move_to_with_objects() {
			$tree =& $this->tree;
			$tree2 =& new Tree;
			$tree->addNode($tree2, 10);
			
			// get the object back and check that it is referencing the origional.
			$result =& $tree->getData(12);
			$this->assertReference($tree2, $result);
			
			$tree->moveTo(12,2);
//			print_r($tree);
			
			// get the object back and check that it is referencing the origional.
			$result =& $tree->getData(12);
			$this->assertReference($tree2, $result);
		}

		function test_copy_to_with_objects() {
			$tree =& $this->tree;
			$tree2 =& new Tree;
			$tree->addNode($tree2, 10);
			
			// get the object back and check that it is referencing the origional.
			$result =& $tree->getData(12);
			$this->assertReference($tree2, $result);
			
			$tree->copyTo(12,2);
//			print_r($tree);
			
			// get the object back and check that it is referencing the origional.
			$result =& $tree->getData(13);
			$this->assertReference($tree2, $result);
		}
	}