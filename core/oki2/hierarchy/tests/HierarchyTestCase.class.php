<?php

require_once(HARMONI.'/oki/hierarchy2/HarmoniHierarchy.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: HierarchyTestCase.class.php,v 1.5 2005/01/26 23:02:17 adamfranco Exp $
 * @package harmoni.tests.metadata
 * @copyright 2003
 **/

	class HierarchyTestCase extends UnitTestCase {

		var $hierarchy;
		var $manager;

		/**
		 *	  Sets up unit test wide variables at the start
		 *	  of each test method.
		 *	  @access public
		 */
		function setUp() {
			// Set up the database connection
			$dbHandler=&Services::requireService("DBHandler");
			$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			$dbHandler->pConnect($dbIndex);
			unset($dbHandler); // done with that for now
			
			$cache =& new HierarchyCache("8", true, $dbIndex, "doboHarmoniTest");
			$this->hierarchy =& new HarmoniHierarchy(new HarmoniId('8'), "Dobo Hierarchy", "Blah", $cache);
			$this->manager =& new HarmoniSharedManager($dbIndex, "doboHarmoniTest");
		}
		
		/**
		 *	  Clears the data set in the setUp() method call.
		 *	  @access public
		 */
		function tearDown() {
			// perhaps, unset $obj here
		}

		//--------------the tests ----------------------

		function test_updates() {
			$val = md5(uniqid(rand(), true));
			$this->hierarchy->updateDescription($val);
			$this->assertIdentical($this->hierarchy->getDescription(), $val);
			$val = md5(uniqid(rand(), true));
			$this->hierarchy->updateDisplayName($val);
			$this->assertIdentical($this->hierarchy->getDisplayName(), $val);

			$this->hierarchy->updateDisplayName("test");
			$this->hierarchy->updateDescription("Test Hierarchy");
		}
		
		function test_creating_and_deleting_nodes() {
			// create a type
			$type =& new HarmoniType("This", "Type", "Does", "Not Matter Whatsoever");
			
			// create one root node
			$node1 =& $this->hierarchy->createRootNode(new HarmoniId("100"), $type, "KOKO", "FAFA");
			$this->assertIsA($node1, "HarmoniNode");
			$this->assertReference($node1, $this->hierarchy->_cache->_cache['100'][0]);
	
			// create another one and make the first one its parent
			$node2 =& $this->hierarchy->createNode(new HarmoniId("101"), new HarmoniId("100"), $type, "KOKOs child", "fandango sucks");
			$this->assertIsA($node2, "HarmoniNode");
			$this->assertReference($node2, $this->hierarchy->_cache->_cache['101'][0]);
			
			$this->assertFalse($node1->isLeaf());
			$this->assertTrue($node2->isLeaf());
			
			$this->hierarchy->deleteNode($node2->getId());
			$this->assertFalse(isset($this->hierarchy->_cache->_cache['101']));
			$this->assertFalse($this->hierarchy->_cache->_tree->nodeExists('101'));
			$treeNode =& $this->hierarchy->_cache->_tree->getNode('100');
			$this->assertFalse($treeNode->hasChildren('100'));
			$this->hierarchy->deleteNode($node1->getId());
			$this->assertFalse(isset($this->hierarchy->_cache->_cache['100']));
			$this->assertFalse($this->hierarchy->_cache->_tree->nodeExists('100'));
		}
		
		
		function test_building_a_hierarchy_from_scratch_and_traversal() {
			// build the hierarchy, one node at a time
			$idA =& $this->manager->createId();
			$nodeA =& $this->hierarchy->createRootNode($idA, new DefaultNodeType(), "A", "A");

			$idB =& $this->manager->createId();
			$nodeB =& $this->hierarchy->createRootNode($idB, new DefaultNodeType(), "B", "B");
			
			$nodeA->addParent($idB);
	
			$idC =& $this->manager->createId();
			$nodeC =& $this->hierarchy->createRootNode($idC, new DefaultNodeType(), "C", "C");

			$nodeC->addParent($idB);

			$idD =& $this->manager->createId();
			$nodeD =& $this->hierarchy->createRootNode($idD, new DefaultNodeType(), "D", "D");

			$idE =& $this->manager->createId();
			$nodeE =& $this->hierarchy->createRootNode($idE, new DefaultNodeType(), "E", "E");
			
			$nodeD->addParent($idE);
	
			$idF =& $this->manager->createId();
			$nodeF =& $this->hierarchy->createRootNode($idF, new DefaultNodeType(), "F", "F");

			$nodeF->addParent($idE);

			$nodeE->addParent($idB);
			$nodeD->addParent($idA);
			
			$idG =& $this->manager->createId();
			$nodeG =& $this->hierarchy->createRootNode($idG, new DefaultNodeType(), "G", "G");

			$nodeE->addParent($idG);
			$nodeF->addParent($idG);
			
			// this is what the final hierarchy looks like:
			//				  B	  G
			//				 /|\ /|
			//				A C E |
			//				 \ / \|
			//				  D	  F
			
			// assert that the nodes have been cached properly
			
			$this->assertReference($this->hierarchy->_cache->_cache[$idA->getIdString()][0], $nodeA);
			$this->assertReference($this->hierarchy->_cache->_cache[$idB->getIdString()][0], $nodeB);
			$this->assertReference($this->hierarchy->_cache->_cache[$idC->getIdString()][0], $nodeC);
			$this->assertReference($this->hierarchy->_cache->_cache[$idD->getIdString()][0], $nodeD);
			$this->assertReference($this->hierarchy->_cache->_cache[$idE->getIdString()][0], $nodeE);
			$this->assertReference($this->hierarchy->_cache->_cache[$idF->getIdString()][0], $nodeF);
			$this->assertReference($this->hierarchy->_cache->_cache[$idG->getIdString()][0], $nodeG);
			
			// check parents and children of all nodes
			// parents
			$nodes =& $nodeB->getParents();
			$this->assertFalse($nodes->hasNext());
			
			$nodes =& $nodeG->getParents();
			$this->assertFalse($nodes->hasNext());

			$nodes =& $nodeA->getParents();
			$node =& $nodes->next();
			$this->assertReference($node, $nodeB);
			$this->assertFalse($nodes->hasNext());
			
			$nodes =& $nodeC->getParents();
			$node =& $nodes->next();
			$this->assertReference($node, $nodeB);
			$this->assertFalse($nodes->hasNext());
			
			$nodes =& $nodeE->getParents();
			$node =& $nodes->next();
			$this->assertReference($node, $nodeB);
			$node =& $nodes->next();
			$this->assertReference($node, $nodeG);
			$this->assertFalse($nodes->hasNext());
			
			$nodes =& $nodeD->getParents();
			$node =& $nodes->next();
			$this->assertReference($node, $nodeE);
			$node =& $nodes->next();
			$this->assertReference($node, $nodeA);
			$this->assertFalse($nodes->hasNext());

			$nodes =& $nodeF->getParents();
			$node =& $nodes->next();
			$this->assertReference($node, $nodeE);
			$node =& $nodes->next();
			$this->assertReference($node, $nodeG);
			$this->assertFalse($nodes->hasNext());

			// children
			$nodes =& $nodeB->getChildren();
			$node =& $nodes->next();
			$this->assertReference($node, $nodeA);
			$node =& $nodes->next();
			$this->assertReference($node, $nodeC);
			$node =& $nodes->next();
			$this->assertReference($node, $nodeE);
			$this->assertFalse($nodes->hasNext());

			$nodes =& $nodeG->getChildren();
			$node =& $nodes->next();
			$this->assertReference($node, $nodeE);
			$node =& $nodes->next();
			$this->assertReference($node, $nodeF);
			$this->assertFalse($nodes->hasNext());

			$nodes =& $nodeA->getChildren();
			$node =& $nodes->next();
			$this->assertReference($node, $nodeD);
			$this->assertFalse($nodes->hasNext());

			$nodes =& $nodeC->getChildren();
			$this->assertFalse($nodes->hasNext());

			$nodes =& $nodeE->getChildren();
			$node =& $nodes->next();
			$this->assertReference($node, $nodeD);
			$node =& $nodes->next();
			$this->assertReference($node, $nodeF);
			$this->assertFalse($nodes->hasNext());

			$nodes =& $nodeD->getChildren();
			$this->assertFalse($nodes->hasNext());

			$nodes =& $nodeF->getChildren();
			$this->assertFalse($nodes->hasNext());
			
			// clear cache
			$this->hierarchy->clearCache();

			// test traversal now
			$this->hierarchy->_cache->_traverseDown($idA->getIdString(), 2);
			$this->hierarchy->_cache->_traverseDown($idG->getIdString(), 5);
			$nodeA->addParent($idG);

			// clear cache
			$this->hierarchy->clearCache();

			// test traversal now
			$this->hierarchy->_cache->_traverseUp($idD->getIdString(), 2);
			$this->hierarchy->_cache->_traverseUp($idC->getIdString(), 1);
			$nodeA->addParent($idC);
			$nodeD->addParent($idF);

			// clear cache
			$this->hierarchy->clearCache();

			$iterator =& $this->hierarchy->traverse($idG, 
													Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(), 
													Hierarchy::TRAVERSE_DIRECTION_DOWN(), 
													-1);
													
//			echo "<pre>\n";
//			print_r($iterator);
//			echo "</pre>\n";

			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'G');
			$this->assertIdentical($info->getLevel(), 0);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'A');
			$this->assertIdentical($info->getLevel(), 1);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'D');
			$this->assertIdentical($info->getLevel(), 2);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'E');
			$this->assertIdentical($info->getLevel(), 1);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'F');
			$this->assertIdentical($info->getLevel(), 1);
			$this->assertFalse($iterator->hasNext());
			
			// clear cache
			$this->hierarchy->clearCache();

			$iterator =& $this->hierarchy->traverse($idD, 
													Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(), 
													Hierarchy::TRAVERSE_DIRECTION_UP(), 
													-1);
//			echo "<pre>\n";
//			print_r($iterator);
//			echo "</pre>\n";
	
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'D');
			$this->assertIdentical($info->getLevel(), 0);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'A');
			$this->assertIdentical($info->getLevel(), -1);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'B');
			$this->assertIdentical($info->getLevel(), -2);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'C');
			$this->assertIdentical($info->getLevel(), -2);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'G');
			$this->assertIdentical($info->getLevel(), -2);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'E');
			$this->assertIdentical($info->getLevel(), -1);
			$info =& $iterator->next();
			$this->assertIdentical($info->getDisplayName(), 'F');
			$this->assertIdentical($info->getLevel(), -1);
			$this->assertFalse($iterator->hasNext());


			// delete nodes
			$this->hierarchy->deleteNode($idD);
			$this->hierarchy->deleteNode($idF);

			$this->hierarchy->deleteNode($idA);
			$this->hierarchy->deleteNode($idC);
			$this->hierarchy->deleteNode($idE);

			$this->hierarchy->deleteNode($idB);
			$this->hierarchy->deleteNode($idG);
		}
		
		function test_traverse() {
//			$this->hierarchy->_cache->_traverseDown("1", 7);

//			$this->hierarchy->_cache->_traverseUp("9", 7);
		}
		

		/**
		 * Testing getAgentTypes
		 **/
		function test_get_group_types() {
			$types =& $this->hierarchy->getNodeTypes();
			$this->assertIsA($types, "HarmoniTypeIterator");
			while ($types->hasNext()) {
				$type =& $types->next();
				$this->assertIsA($type, "TypeInterface");
			}
		}
		
		
		function test_get_stuff() {
			// test getNode
			$node =& $this->hierarchy->getNode(new HarmoniId("2"));
			$this->assertIdentical($node->getId(), new HarmoniId("2"));
			$this->assertIdentical($node->getDisplayName(), "B");

			// clear cache
			$this->hierarchy->clearCache();
			
			// test getAllNodes
			$iterator =& $this->hierarchy->getAllNodes();
			$this->assertIdentical(count($this->hierarchy->_cache->_cache), 9);
			while ($iterator->hasNext()) {
				$node =& $iterator->next();
				$this->assertIsA($node, "HarmoniNode");
			}
			
			// test getRootNodes
			$iterator =& $this->hierarchy->getRootNodes();
			while ($iterator->hasNext()) {
				$node =& $iterator->next();
				$this->assertIsA($node, "HarmoniNode");
			}
			
		}
	
	
	}