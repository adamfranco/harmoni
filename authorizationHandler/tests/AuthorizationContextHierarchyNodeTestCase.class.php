<?php

require_once(HARMONI."authorizationHandler/generator/AuthorizationContextHierarchyNode.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthorizationContextHierarchyNodeTestCase.class.php,v 1.1 2003/07/01 23:51:50 dobomode Exp $
 * @copyright 2003 
 */

    class AuthorizationContextHierarchyNodeTestCase extends UnitTestCase {
		
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
			unset($this->node);
		}
	
		/**
		 *    Test the constructor
		 */ 
		function test_everything() {
			// create a few root nodes
			$node1 =& new AuthorizationContextHierarchyNode(1);
			
			$this->assertIdentical($node1->getSystemId(), 1);

			$this->assertIdentical($node1->getDepth(), 0);

			$this->assertNull($node1->getParent());
			
			$this->assertEqual($node1->getChildren(), array());
			
			$this->assertFalse($node1->hasChildren());

			$this->assertIdentical($node1->getChildrenCount(), 0);
			
			// create some children
			$node1_1 =& new AuthorizationContextHierarchyNode(1);
			$node1_2 =& new AuthorizationContextHierarchyNode(2);
			$node1->addChild($node1_1);
			$node1->addChild($node1_2);
			$node1_1_1 =& new AuthorizationContextHierarchyNode(1);
			$node1_1->addChild($node1_1_1);
			
			$this->assertReference($node1, $node1_1->getParent());
			$this->assertReference($node1, $node1_2->getParent());
			$this->assertReference($node1_1, $node1_1_1->getParent());
			
			$this->assertIdentical($node1_1->getSystemId(), 1);
			$this->assertIdentical($node1_2->getSystemId(), 2);
			$this->assertIdentical($node1_1_1->getSystemId(), 1);
			
			$this->assertIdentical($node1_1->getDepth(), 1);
			$this->assertIdentical($node1_2->getDepth(), 1);
			$this->assertIdentical($node1_1_1->getDepth(), 2);
			
			$this->assertTrue($node1->hasChildren());
			$this->assertTrue($node1_1->hasChildren());
			$this->assertFalse($node1_2->hasChildren());

			$this->assertIdentical($node1->getChildrenCount(), 2);
			
			$children =& $node1->getChildren();
			$this->assertReference($children[0], $node1_1);
			$this->assertReference($children[1], $node1_2);
			$children =& $node1_1->getChildren();
			$this->assertReference($children[0], $node1_1_1);
			
			// create a new root
			$node =& new AuthorizationContextHierarchyNode(100);
			$node->addChild($node1);
			
			$this->assertIdentical($node->getDepth(), 0);
			$this->assertIdentical($node1->getDepth(), 1);
			$this->assertIdentical($node1_1->getDepth(), 2);
			$this->assertIdentical($node1_2->getDepth(), 2);
			$this->assertIdentical($node1_1_1->getDepth(), 3);
			
//			echo "<pre>Tree:"; print_r($node); echo "</pre>"
			
		}
		
    }

?>