<?php

require_once(HARMONI."oki/hierarchy2/tree/Tree.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: TreeTestCase.class.php,v 1.3 2004/06/09 19:26:27 dobomode Exp $
 * @copyright 2003 
 */

    class TreeTestCase extends UnitTestCase {
		
		function TreeTestCase() {
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
			$tree =& new Tree();
			
			$this->assertNotNull($tree);
			
			$this->assertIdentical($tree->getSize(), 0);
			
			// create two root nodes
			$node1 =& new TreeNode('1');
			$node2 =& new TreeNode('2');
			$tree->addNode($node1);
			$tree->addNode($node2);
			
			$this->assertTrue(is_a($node1, "TreeNodeInterface"));
			$this->assertTrue(is_a($node2, "TreeNodeInterface"));
			$this->assertIdentical($tree->getSize(), 2);
			$this->assertReference($tree->getNode('1'), $node1);
			$this->assertReference($tree->getNode('2'), $node2);
			
			// insert some children
			$node3 =& new TreeNode('3');
			$node4 =& new TreeNode('4');
			$node5 =& new TreeNode('5');
			$tree->addNode($node3, $node2);
			$tree->addNode($node4, $node2);
			$tree->addNode($node5, $node3);
			$this->assertIdentical($tree->getSize(), 5);

			$nodes =& $tree->getNodes();

			$this->assertReference($nodes['1'], $node1);
			$this->assertReference($nodes['2'], $node2);
			$this->assertReference($nodes['3'], $node3);
			$this->assertReference($nodes['4'], $node4);
			$this->assertReference($nodes['5'], $node5);
			
			$node =& $tree->getNode('5');
			$parents =& $node->getParents();
			$node =& $parents['3'];
			$parents =& $node->getParents();
			$node =& $parents['2'];
			$this->assertReference($node, $node2);
		}
		
	
		/**
		 *    Simple traversal in a single parent hierarchy
		 */ 
		function test_traversal1() {
			// initialize
			$tree =& new Tree();
		
			// create a tree
			$node1 =& new TreeNode('1');
			$node1_1 =& new TreeNode('1_1');
			$node1_2 =& new TreeNode('1_2');
			$node1_2_1 =& new TreeNode('1_2_1');
			$node1_2_2 =& new TreeNode('1_2_2');
			$node1_2_2_1 =& new TreeNode('1_2_2_1');
			$node1_2_2_2 =& new TreeNode('1_2_2_2');
			$node2 =& new TreeNode('2');
			$node2_3 =& new TreeNode('2_3');
			$node2_3_3 =& new TreeNode('2_3_3');
			$node2_3_4 =& new TreeNode('2_3_4');
			$node3 =& new TreeNode('3');
			$node3_1 =& new TreeNode('3_1');
			$node3_1_1 =& new TreeNode('3_1_1');
			
			$tree->addNode($node1);
			$tree->addNode($node1_1, $node1);
			$tree->addNode($node1_2, $node1);
			$tree->addNode($node1_2_1, $node1_2);
			$tree->addNode($node1_2_2, $node1_2);
			$tree->addNode($node1_2_2_1, $node1_2_2);
			$tree->addNode($node1_2_2_2, $node1_2_2);
			$tree->addNode($node2);
			$tree->addNode($node2_3, $node2);
			$tree->addNode($node2_3_3, $node2_3);
			$tree->addNode($node2_3_4, $node2_3);
			$tree->addNode($node3);
			$tree->addNode($node3_1, $node3);
			$tree->addNode($node3_1_1, $node3_1);
			
			$this->assertIdentical($tree->getSize(), 14);

			$resultFromObject =& $tree->traverse($node1, true, -1);
			
			$this->assertIdentical(count($resultFromObject), 7);
			$this->assertReference($resultFromObject['1'][0], $node1);
			$this->assertReference($resultFromObject['1_1'][0], $node1_1);
			$this->assertReference($resultFromObject['1_2'][0], $node1_2);
			$this->assertReference($resultFromObject['1_2_1'][0], $node1_2_1);
			$this->assertReference($resultFromObject['1_2_2'][0], $node1_2_2);
			$this->assertReference($resultFromObject['1_2_2_1'][0], $node1_2_2_1);
			$this->assertReference($resultFromObject['1_2_2_2'][0], $node1_2_2_2);

			$resultFromObject =& $tree->traverse($node2_3, true, -1);
			
			$this->assertIdentical(count($resultFromObject), 3);
			$this->assertReference($resultFromObject['2_3'][0], $node2_3);
			$this->assertReference($resultFromObject['2_3_3'][0], $node2_3_3);
			$this->assertReference($resultFromObject['2_3_4'][0], $node2_3_4);

			$resultFromObject =& $tree->traverse($node1, true, -1);
}


		/**
		 *    Simple traversal in a single parent hierarchy
		 */ 
		function test_traversal2() {
			// initialize
			$tree =& new Tree();

			// here is a sketch of the tree being tested
			//			 A B C
			//			  \|/
			//			D  E
			//			 \/ \
			//			 F   G
			//			 /\ /
			//			H  I
				
			$nodeA =& new TreeNode('A');
			$nodeB =& new TreeNode('B');
			$nodeC =& new TreeNode('C');
			$nodeD =& new TreeNode('D');
			$nodeE =& new TreeNode('E');
			$nodeF =& new TreeNode('F');
			$nodeG =& new TreeNode('G');
			$nodeH =& new TreeNode('H');
			$nodeI =& new TreeNode('I');
			
			$tree->addNode($nodeA);
			$tree->addNode($nodeB);
			$tree->addNode($nodeC);
			$tree->addNode($nodeD);
			$tree->addNode($nodeE, $nodeA);
			$tree->addNode($nodeE, $nodeB);
			$tree->addNode($nodeE, $nodeC);
			$tree->addNode($nodeF, $nodeD);
			$tree->addNode($nodeF, $nodeE);
			$tree->addNode($nodeG, $nodeE);
			$tree->addNode($nodeH, $nodeF);
			$tree->addNode($nodeI, $nodeF);
			$tree->addNode($nodeI, $nodeG);
			
			$this->assertIdentical($tree->getSize(), 9);

			$resultFromObject =& $tree->traverse($nodeA, true, -1);
			
			$this->assertIdentical(count($resultFromObject), 6);
			$this->assertReference($resultFromObject['A'][0], $nodeA);
			$this->assertReference($resultFromObject['E'][0], $nodeE);
			$this->assertReference($resultFromObject['F'][0], $nodeF);
			$this->assertReference($resultFromObject['G'][0], $nodeG);
			$this->assertReference($resultFromObject['H'][0], $nodeH);
			$this->assertReference($resultFromObject['I'][0], $nodeI);
			$this->assertIdentical($resultFromObject['A'][1], 0);
			$this->assertIdentical($resultFromObject['E'][1], 1);
			$this->assertIdentical($resultFromObject['F'][1], 2);
			$this->assertIdentical($resultFromObject['G'][1], 2);
			$this->assertIdentical($resultFromObject['H'][1], 3);
			$this->assertIdentical($resultFromObject['I'][1], 3);

			$resultFromObject =& $tree->traverse($nodeA, true, 10);
			
			$this->assertIdentical(count($resultFromObject), 6);
			$this->assertReference($resultFromObject['A'][0], $nodeA);
			$this->assertReference($resultFromObject['E'][0], $nodeE);
			$this->assertReference($resultFromObject['F'][0], $nodeF);
			$this->assertReference($resultFromObject['G'][0], $nodeG);
			$this->assertReference($resultFromObject['H'][0], $nodeH);
			$this->assertReference($resultFromObject['I'][0], $nodeI);

			$resultFromObject =& $tree->traverse($nodeF, false, -1);
			
			$this->assertIdentical(count($resultFromObject), 6);
			$this->assertReference($resultFromObject['A'][0], $nodeA);
			$this->assertReference($resultFromObject['B'][0], $nodeB);
			$this->assertReference($resultFromObject['C'][0], $nodeC);
			$this->assertReference($resultFromObject['D'][0], $nodeD);
			$this->assertReference($resultFromObject['E'][0], $nodeE);
			$this->assertReference($resultFromObject['F'][0], $nodeF);
			$this->assertIdentical($resultFromObject['A'][1], -2);
			$this->assertIdentical($resultFromObject['B'][1], -2);
			$this->assertIdentical($resultFromObject['C'][1], -2);
			$this->assertIdentical($resultFromObject['D'][1], -1);
			$this->assertIdentical($resultFromObject['E'][1], -1);
			$this->assertIdentical($resultFromObject['F'][1], 0);
			
			$resultFromObject =& $tree->traverse($nodeG, true, 0);
			$this->assertIdentical(count($resultFromObject), 1);
			$this->assertReference($resultFromObject['G'][0], $nodeG);
			$this->assertIdentical($resultFromObject['G'][1], 0);

			$resultFromObject =& $tree->traverse($nodeB, true, 1);
			$this->assertIdentical(count($resultFromObject), 2);
			$this->assertReference($resultFromObject['B'][0], $nodeB);
			$this->assertReference($resultFromObject['E'][0], $nodeE);
			$this->assertIdentical($resultFromObject['B'][1], 0);
			$this->assertIdentical($resultFromObject['E'][1], 1);

			$resultFromObject =& $tree->traverse($nodeI, false, 2);
			
			$this->assertIdentical(count($resultFromObject), 5);
			$this->assertReference($resultFromObject['I'][0], $nodeI);
			$this->assertReference($resultFromObject['F'][0], $nodeF);
			$this->assertReference($resultFromObject['G'][0], $nodeG);
			$this->assertReference($resultFromObject['D'][0], $nodeD);
			$this->assertReference($resultFromObject['E'][0], $nodeE);
			$this->assertIdentical($resultFromObject['I'][1], 0);
			$this->assertIdentical($resultFromObject['F'][1], -1);
			$this->assertIdentical($resultFromObject['G'][1], -1);
			$this->assertIdentical($resultFromObject['D'][1], -2);
			$this->assertIdentical($resultFromObject['E'][1], -2);
			
			// now make A and C non-roots
			// the new tree will be
			//
			//               J
			//               |
			//			 A B C
			//			/ \|/
			//			D  E
			//			 \/ \
			//			 F   G
			//			 /\ /
			//			H  I
			
			$nodeJ =& new TreeNode('J');
			$tree->addNode($nodeD, $nodeA);
			$tree->addNode($nodeJ);
			$tree->addNode($nodeC, $nodeJ);
			
		}
		
		
		/**
		 *    Test addNode
		 */ 
		function test_addNode() {
			// initialize
			$tree =& new Tree();
		
			// create a tree
			$node1 =& new TreeNode('1');
			$node2 =& new TreeNode('2');
			$node3 =& new TreeNode('3');
			
			$tree->addNode($node1);
			$tree->addNode($node2, $node1);
			$tree->addNode($node3, $node1);
			
			$this->assertIdentical($tree->getSize(), 3);
			
//			$tree->addNode($node1, $node3); // this should give a cycle error
		}

		
    }

?>