<?php

require_once(HARMONI.'/oki/hierarchy2/HarmoniNode.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: NodeTestCase.class.php,v 1.10 2005/01/19 22:28:10 adamfranco Exp $
 * @package harmoni.tests.metadata
 * @copyright 2003
 **/

    class NodeTestCase extends UnitTestCase {
	
		var $nodeA;
		var $nodeF;
		var $cache;
		
        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @access public
         */
        function setUp() {
			// Set up the database connection
			$dbHandler=&Services::requireService("DBHandler");
			$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			$dbHandler->pConnect($dbIndex);
			unset($dbHandler); // done with that for now
			
			$this->cache =& new HierarchyCache("8", true, $dbIndex, "doboHarmoniTest");
			$this->nodeA =& $this->cache->getNode("1");
			$this->nodeF =& $this->cache->getNode("6");

			// all tests assume the following tree in the database
			//			 A B C
			//			  \|/
			//			D  E
			//			 \/ \
			//			 F   G
			//			 /\ /
			//			H  I
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @access public
         */
        function tearDown() {
			// perhaps, unset $obj here
        }

		//--------------the tests ----------------------

		function test_get_node() {
			$nodeF =& $this->cache->getNode('6');
			
			$this->assertEqual($nodeF->_id, $this->nodeF->_id);
			$this->assertEqual($nodeF->_type, $this->nodeF->_type);
			$this->assertEqual($nodeF->_displayName, $this->nodeF->_displayName);
			$this->assertEqual($nodeF->_description, $this->nodeF->_description);
		}

		function test_get_parents() {
			// test fetching parents of node F
			$parents =& $this->nodeF->getParents();
			
			$this->assertIsA($parents, "HarmoniNodeIterator");
			$parent =& $parents->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$parent1 =& new HarmoniNode(new HarmoniId('4'), $type, "D", "", $parent->_cache);
									   
			$this->assertEqual($parent->_id, $parent1->_id);
			$this->assertEqual($parent->_type, $parent1->_type);
			$this->assertEqual($parent->_displayName, $parent1->_displayName);
			$this->assertEqual($parent->_description, $parent1->_description);
			
			$parent =& $parents->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$parent1 =& new HarmoniNode(new HarmoniId('5'), $type, "E", "", $parent->_cache);
									   
			$this->assertEqual($parent->_id, $parent1->_id);
			$this->assertEqual($parent->_type, $parent1->_type);
			$this->assertEqual($parent->_displayName, $parent1->_displayName);
			$this->assertEqual($parent->_description, $parent1->_description);
			
			$this->assertFalse($parents->hasNext());

			// do it again, should get from cache this time
			$parents =& $this->nodeF->getParents();
			
			$this->assertIsA($parents, "HarmoniNodeIterator");
			$parent =& $parents->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$parent1 =& new HarmoniNode(new HarmoniId('4'), $type, "D", "", $parent->_cache);
									   
			$this->assertEqual($parent->_id, $parent1->_id);
			$this->assertEqual($parent->_type, $parent1->_type);
			$this->assertEqual($parent->_displayName, $parent1->_displayName);
			$this->assertEqual($parent->_description, $parent1->_description);
			
			$parent =& $parents->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$parent1 =& new HarmoniNode(new HarmoniId('5'), $type, "E", "", $parent->_cache);
									   
			$this->assertEqual($parent->_id, $parent1->_id);
			$this->assertEqual($parent->_type, $parent1->_type);
			$this->assertEqual($parent->_displayName, $parent1->_displayName);
			$this->assertEqual($parent->_description, $parent1->_description);
			
			$this->assertFalse($parents->hasNext());

			// fetch parents of node E
			
			$nodeE =& $parent;
			$parents =& $nodeE->getParents();
			
			$this->assertIsA($parents, "HarmoniNodeIterator");
			$parent =& $parents->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$parent1 =& new HarmoniNode(new HarmoniId('1'), $type, "A", "", $parent->_cache);
									   
			$this->assertEqual($parent->_id, $parent1->_id);
			$this->assertEqual($parent->_type, $parent1->_type);
			
			$parent =& $parents->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$parent1 =& new HarmoniNode(new HarmoniId('2'), $type, "B", "", $parent->_cache);
									   
			$this->assertEqual($parent->_id, $parent1->_id);
			$this->assertEqual($parent->_type, $parent1->_type);
			$this->assertEqual($parent->_displayName, $parent1->_displayName);
			$this->assertEqual($parent->_description, $parent1->_description);

			$parent =& $parents->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$parent1 =& new HarmoniNode(new HarmoniId('3'), $type, "C", "", $parent->_cache);
									   
			$this->assertEqual($parent->_id, $parent1->_id);
			$this->assertEqual($parent->_type, $parent1->_type);
			$this->assertEqual($parent->_displayName, $parent1->_displayName);
			$this->assertEqual($parent->_description, $parent1->_description);
			
			$this->assertFalse($parents->hasNext());
			
			// try getting parents of root
			
			$parents =& $this->nodeA->getParents();
			$this->assertFalse($parents->hasNext());
		}

		function test_get_children() {
			// test fetching children of child A
			$children =& $this->nodeA->getChildren();
		
			$this->assertIsA($children, "HarmoniNodeIterator");
			$child =& $children->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$child1 =& new HarmoniNode(new HarmoniId('5'), $type, "E", "", $child->_cache);
									   
			$this->assertEqual($child->_id, $child1->_id);
			$this->assertEqual($child->_type, $child1->_type);
			$this->assertEqual($child->_displayName, $child1->_displayName);
			$this->assertEqual($child->_description, $child1->_description);
			$this->assertFalse($children->hasNext());
			
			// do the same thing again - should not read from the database!
			// test fetching children of child A
			$children =& $this->nodeA->getChildren();
		
			$this->assertIsA($children, "HarmoniNodeIterator");
			$child =& $children->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$child1 =& new HarmoniNode(new HarmoniId('5'), $type, "E", "", $child->_cache);
									   
			$this->assertEqual($child->_id, $child1->_id);
			$this->assertEqual($child->_type, $child1->_type);
			$this->assertEqual($child->_displayName, $child1->_displayName);
			$this->assertEqual($child->_description, $child1->_description);
			$this->assertFalse($children->hasNext());

			$nodeF =& $child;
			// test fetching children of child F
			$children =& $nodeF->getChildren();
		
			$this->assertIsA($children, "HarmoniNodeIterator");
			$child =& $children->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$child1 =& new HarmoniNode(new HarmoniId('6'), $type, "F", "", $child->_cache);
									   
			$this->assertEqual($child->_id, $child1->_id);
			$this->assertEqual($child->_type, $child1->_type);
			$this->assertEqual($child->_displayName, $child1->_displayName);
			$this->assertEqual($child->_description, $child1->_description);

			$child =& $children->next();
			$type =& new HarmoniType("harmoni", "hierarchy", "node");
			$child1 =& new HarmoniNode(new HarmoniId('7'), $type, "G", "", $child->_cache);
									   
			$this->assertEqual($child->_id, $child1->_id);
			$this->assertEqual($child->_type, $child1->_type);
			$this->assertEqual($child->_displayName, $child1->_displayName);
			$this->assertEqual($child->_description, $child1->_description);

			$this->assertFalse($children->hasNext());
		}
		
		
		function test_updates() {
			$val = md5(uniqid(rand(), true));
			$this->nodeA->updateDescription($val);
			$this->assertIdentical($this->nodeA->getDescription(), $val);
			$val = md5(uniqid(rand(), true));
			$this->nodeA->updateDisplayName($val);
			$this->assertIdentical($this->nodeA->getDisplayName(), $val);

			$this->nodeA->updateDisplayName("A");
			$this->nodeA->updateDescription("");
		}
		
		function test_is_leaf() {
			$this->assertFalse($this->nodeA->isLeaf());
			$this->assertFalse($this->nodeF->isLeaf());
			$children =& $this->nodeF->getChildren();
			$child =& $children->next();
			$this->assertTrue($child->isLeaf());
		}
		
		function test_is_root() {
			$this->assertTrue($this->nodeA->isRoot());
			$this->assertFalse($this->nodeF->isRoot());
		}
		
		function test_add_remove_change_parent() {
			// let's make B a parent of F
			// get B (B is the parent of E, which is the child of A

			$this->nodeF->addParent(new HarmoniId('2'));
			$this->nodeF->changeParent(new HarmoniId('2'), new  HarmoniId('7'));
			$this->nodeF->removeParent(new HarmoniId('7'));
		}
		
	}