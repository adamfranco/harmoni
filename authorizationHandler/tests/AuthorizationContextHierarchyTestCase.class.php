<?php

require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchy.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthorizationContextHierarchyTestCase.class.php,v 1.5 2003/07/08 03:33:47 dobomode Exp $
 * @copyright 2003 
 */

    class AuthorizationContextHierarchyTestCase extends UnitTestCase {
		
		function ExampleClassTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			// perhaps, unset $obj here
		}
	
		/**
		 *    Test the constructor
		 */ 
		function test_everything() {
			// initialize
			$hierarchy =& new AuthorizationContextHierarchy();
			
			$this->assertNotNull($hierarchy);
			
			$this->assertIdentical($hierarchy->getSize(), 0);
			$this->assertIdentical($hierarchy->getHeight(), 0);
			$this->assertIdentical($hierarchy->getRoots(), array());
			
			// create two root nodes
			$node1 =& $hierarchy->addNewNode(1);
			$node2 =& $hierarchy->addNewNode(2);
			
			$this->assertTrue(is_a($node1, "AuthorizationContextHierarchyNodeInterface"));
			$this->assertTrue(is_a($node2, "AuthorizationContextHierarchyNodeInterface"));
			$this->assertIdentical($hierarchy->getSize(), 2);
			$this->assertIdentical($hierarchy->getHeight(), 1);
			$this->assertIdentical($hierarchy->getRoots(), array($node1, $node2));
			$this->assertIdentical($hierarchy->getNodesAtLevel(0), array(1 => $node1, 2 => $node2));
			$this->assertReference($hierarchy->getNodeAtLevel(0, 1), $node1);
			$this->assertReference($hierarchy->getNodeAtLevel(0, 2), $node2);
			
			// insert some children
			$node2_1 =& $hierarchy->addNewNode(1, $node2);
			$node2_2 =& $hierarchy->addNewNode(2, $node2);
			$node2_1_1 =& $hierarchy->addNewNode(1, $node2_1);
			$this->assertIdentical($hierarchy->getSize(), 5);
			$this->assertIdentical($hierarchy->getHeight(), 3);

			$roots =& $hierarchy->getRoots();
			$this->assertReference($roots[0], $node1);
			$this->assertReference($roots[1], $node2);
			
			$roots =& $hierarchy->getNodesAtLevel(0);
			$this->assertReference($roots[1], $node1);
			$this->assertReference($roots[2], $node2);
			
			$this->assertReference($hierarchy->getNodeAtLevel(0, 1), $node1);
			$this->assertReference($hierarchy->getNodeAtLevel(0, 2), $node2);
			$this->assertReference($hierarchy->getNodeAtLevel(1, 1), $node2_1);
			$this->assertReference($hierarchy->getNodeAtLevel(1, 2), $node2_2);
			$this->assertReference($hierarchy->getNodeAtLevel(2, 1), $node2_1_1);
			
			$node =& $hierarchy->getNodeAtLevel(2, 1);
			$node =& $node->getParent();
			$node =& $node->getParent();
			$this->assertReference($node, $node2);
			
			
			$node =& new AuthorizationContextHierarchyNode(10, 10);
			$hierarchy->addNode($node);
			
			$this->assertIdentical($hierarchy->getHeight(), 11);
		}
		
	
		/**
		 *    Test traversal
		 */ 
		function test_traversal() {
			// initialize
			$hierarchy =& new AuthorizationContextHierarchy();
		
			// create a hierarchy
			$node1 =& $hierarchy->addNewNode(1);
			$node1_1 =& $hierarchy->addNewNode(1, $node1);
			$node1_2 =& $hierarchy->addNewNode(2, $node1);
			$node1_2_1 =& $hierarchy->addNewNode(1, $node1_2);
			$node1_2_2 =& $hierarchy->addNewNode(2, $node1_2);
			$node1_2_2_1 =& $hierarchy->addNewNode(1, $node1_2_2);
			$node1_2_2_2 =& $hierarchy->addNewNode(2, $node1_2_2);
			$node2 =& $hierarchy->addNewNode(2);
			$node2_3 =& $hierarchy->addNewNode(3, $node2);
			$node2_3_3 =& $hierarchy->addNewNode(3, $node2_3);
			$node2_3_4 =& $hierarchy->addNewNode(4, $node2_3);
			$node3 =& new AuthorizationContextHierarchyNode(100, 10);
			$hierarchy->addNode($node3);
			$node3_1 =& $hierarchy->addNewNode(1, $node3);
			$node3_1_1 =& $hierarchy->addNewNode(2, $node3_1);
			
			$this->assertIdentical($hierarchy->getSize(), 14);
			$this->assertIdentical($hierarchy->getHeight(), 13);

			$resultFromObject =& $hierarchy->traverse();
			
			$this->assertIdentical(count($resultFromObject), 14);
			$this->assertReference($resultFromObject[0], $node1);
			$this->assertReference($resultFromObject[1], $node1_1);
			$this->assertReference($resultFromObject[2], $node1_2);
			$this->assertReference($resultFromObject[3], $node1_2_1);
			$this->assertReference($resultFromObject[4], $node1_2_2);
			$this->assertReference($resultFromObject[5], $node1_2_2_1);
			$this->assertReference($resultFromObject[6], $node1_2_2_2);
			$this->assertReference($resultFromObject[7], $node2);
			$this->assertReference($resultFromObject[8], $node2_3);
			$this->assertReference($resultFromObject[9], $node2_3_3);
			$this->assertReference($resultFromObject[10], $node2_3_4);
			$this->assertReference($resultFromObject[11], $node3);
			$this->assertReference($resultFromObject[12], $node3_1);
			$this->assertReference($resultFromObject[13], $node3_1_1);

			$resultFromObject =& $hierarchy->traverse($node2_3);
			
			$this->assertIdentical(count($resultFromObject), 3);
			$this->assertReference($resultFromObject[0], $node2_3);
			$this->assertReference($resultFromObject[1], $node2_3_3);
			$this->assertReference($resultFromObject[2], $node2_3_4);
			
			$nodes =& $hierarchy->getAllNodes();
			$this->assertIdentical(count($nodes), 14);
			$this->assertReference($nodes[0], $node1);
			$this->assertReference($nodes[1], $node2);
			$this->assertReference($nodes[2], $node1_1);
			$this->assertReference($nodes[3], $node1_2);
			$this->assertReference($nodes[4], $node2_3);
			$this->assertReference($nodes[5], $node1_2_1);
			$this->assertReference($nodes[6], $node1_2_2);
			$this->assertReference($nodes[7], $node2_3_3);
			$this->assertReference($nodes[8], $node2_3_4);
			$this->assertReference($nodes[9], $node1_2_2_1);
			$this->assertReference($nodes[10], $node1_2_2_2);
			$this->assertReference($nodes[11], $node3);
			$this->assertReference($nodes[12], $node3_1);
			$this->assertReference($nodes[13], $node3_1_1);
			
			$roots =& $hierarchy->getRoots();
			$this->assertIdentical(count($roots), 3);
			$this->assertReference($roots[0], $node1);
			$this->assertReference($roots[1], $node2);
			$this->assertReference($roots[2], $node3);

			$leaves =& $hierarchy->getLeaves();
			$this->assertIdentical(count($leaves), 7);
			$this->assertReference($leaves[0], $node1_1);
			$this->assertReference($leaves[1], $node1_2_1);
			$this->assertReference($leaves[2], $node2_3_3);
			$this->assertReference($leaves[3], $node2_3_4);
			$this->assertReference($leaves[4], $node1_2_2_1);
			$this->assertReference($leaves[5], $node1_2_2_2);
			$this->assertReference($leaves[6], $node3_1_1);
		}
		
		/**
		 *    Test addNode
		 */ 
		function test_addNode() {
			// initialize
			$hierarchy =& new AuthorizationContextHierarchy();
		
			// create a hierarchy
			$node1 =& new AuthorizationContextHierarchyNode(1, 10);
			$node2 =& new AuthorizationContextHierarchyNode(1, 15);
			$node3 =& new AuthorizationContextHierarchyNode(2, 20);
			
			$hierarchy->addNewNode(1);
			$hierarchy->addNode($node1);
			$hierarchy->addNode($node2, $node1);
			$hierarchy->addNode($node3, $node1);
			
			$this->assertIdentical($node2->getDepth(), 11);
			$this->assertIdentical($node3->getDepth(), 11);
		}
		
		/**
		 *    Test getAncestors()
		 */ 
		function test_getAncestors() {
			// initialize
			$hierarchy =& new AuthorizationContextHierarchy();
		
			// create a hierarchy
			$node1 =& $hierarchy->addNewNode(1);
			$node1_1 =& $hierarchy->addNewNode(1, $node1);
			$node1_2 =& $hierarchy->addNewNode(2, $node1);
			$node1_2_1 =& $hierarchy->addNewNode(1, $node1_2);
			$node1_2_2 =& $hierarchy->addNewNode(2, $node1_2);
			$node1_2_2_1 =& $hierarchy->addNewNode(1, $node1_2_2);
			$node1_2_2_2 =& $hierarchy->addNewNode(2, $node1_2_2);
			$node2 =& $hierarchy->addNewNode(2);
			$node2_3 =& $hierarchy->addNewNode(3, $node2);
			$node2_3_3 =& $hierarchy->addNewNode(3, $node2_3);
			$node2_3_4 =& $hierarchy->addNewNode(4, $node2_3);

			$ancestors =& $hierarchy->getAncestors($node2_3_3);
			$this->assertEqual($ancestors, array(1 => 3, 0 => 2));

			$ancestors1 =& $hierarchy->getAncestors($node1_2_2_1);
			$ancestors2 =& $hierarchy->getAncestors($node1_2_2_1);
			$this->assertEqual($ancestors1, $ancestors2);
			$this->assertEqual($ancestors1, array(2 => 2, 1 => 2, 0 => 1));
		}
		
		
    }

?>