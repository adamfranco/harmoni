<?php

require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchy.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthorizationContextHierarchyTestCase.class.php,v 1.1 2003/07/01 23:51:50 dobomode Exp $
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
			$node1 =& $hierarchy->addNode(1);
			$node2 =& $hierarchy->addNode(2);
			
			$this->assertTrue(is_a($node1, "AuthorizationContextHierarchyNodeInterface"));
			$this->assertTrue(is_a($node2, "AuthorizationContextHierarchyNodeInterface"));
			$this->assertIdentical($hierarchy->getSize(), 2);
			$this->assertIdentical($hierarchy->getHeight(), 1);
			$this->assertIdentical($hierarchy->getRoots(), array(1 => $node1, 2 => $node2));
			$this->assertIdentical($hierarchy->getNodesAtLevel(0), array(1 => $node1, 2 => $node2));
			$this->assertReference($hierarchy->getNodeAtLevel(0, 1), $node1);
			$this->assertReference($hierarchy->getNodeAtLevel(0, 2), $node2);
			
			// insert some children
			$node2_1 =& $hierarchy->addNode(1, $node2);
			$node2_2 =& $hierarchy->addNode(2, $node2);
			$node2_1_1 =& $hierarchy->addNode(1, $node2_1);
			$this->assertIdentical($hierarchy->getSize(), 5);
			$this->assertIdentical($hierarchy->getHeight(), 3);

			$roots =& $hierarchy->getRoots();
			$this->assertReference($roots[1], $node1);
			$this->assertReference($roots[2], $node2);
			
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
		}
		
    }

?>