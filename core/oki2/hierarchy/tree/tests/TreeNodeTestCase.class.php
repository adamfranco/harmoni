<?php

require_once(dirname(__FILE__)."/../TreeNode.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.osid_v2.hierarchy.tree.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TreeNodeTestCase.class.php,v 1.7 2007/09/04 20:25:42 adamfranco Exp $ 
 */

	class TreeNodeTestCase extends UnitTestCase {
	
		/**
		*  Sets up unit test wide variables at the start
		*	 of each test method.
		*	 @access public
		*/
		function setUp() {
			// perhaps, initialize $obj here
		}
		
		/**
		 *	  Clears the data set in the setUp() method call.
		 *	  @access public
		 */
		function tearDown() {
			// perhaps, unset $obj here
			unset($this->node);
		}
	
		/**
		 *	  Test the constructor
		 */ 
		function test_everything() {
			// create a few root nodes
			$node1 = new TreeNode('1');
			
			$this->assertIdentical($node1->getId(), '1');

			$this->assertFalse($node1->hasParents());
			
			$this->assertEqual($node1->getChildren(), array());
			
			$this->assertFalse($node1->hasChildren());

			$this->assertIdentical($node1->getChildrenCount(), 0);
			
			// create some children
			$node1_1 = new TreeNode('2');
			$node1_2 = new TreeNode('3');
			$node1->addChild($node1_1);
			$node1->addChild($node1_2);
			$node1_1_1 = new TreeNode('4');
			$node1_1->addChild($node1_1_1);
			
			$parents =$node1_1->getParents();
			$this->assertReference($node1, $parents['1']);
			$parents =$node1_2->getParents();
			$this->assertReference($node1, $parents['1']);
			$parents =$node1_1_1->getParents();
			$this->assertReference($node1_1, $parents['2']);
			
			$this->assertIdentical($node1_1->getId(), '2');
			$this->assertIdentical($node1_2->getId(), '3');
			$this->assertIdentical($node1_1_1->getId(), '4');
			
			$this->assertTrue($node1->hasChildren());
			$this->assertTrue($node1_1->hasChildren());
			$this->assertFalse($node1_2->hasChildren());

			$this->assertIdentical($node1->getChildrenCount(), 2);
			
			$children =$node1->getChildren();
			$this->assertReference($children['2'], $node1_1);
			$this->assertReference($children['3'], $node1_2);
			$children =$node1_1->getChildren();
			$this->assertReference($children['4'], $node1_1_1);
			
			// create a new root
			$node = new TreeNode('100');
			$node->addChild($node1);
			
			$children =$node->getChildren();
			$this->assertReference($children['1'], $node1);
			$parents =$node1->getParents();
			$this->assertReference($node, $parents['100']);
			
			// try detaching a node now
			$node1->detachChild($node1_1);
			$this->assertFalse($node1_1->hasParents());
			$this->assertFalse($node1->isChild($node1_1));
			$this->assertTrue($node1->isChild($node1_2));
		}
		
	}

?>