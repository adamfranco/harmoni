<?php
/**
 * @package harmoni.osid_v2.hierarchy.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HierarchyManagerTestCase.class.php,v 1.10 2005/04/13 21:59:57 adamfranco Exp $
 */
 
require_once(dirname(__FILE__).'/../HarmoniHierarchyManager.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.osid_v2.hierarchy.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HierarchyManagerTestCase.class.php,v 1.10 2005/04/13 21:59:57 adamfranco Exp $
 */

	class HierarchyManagerTestCase extends UnitTestCase {

		var $manager;

		/**
		 *	  Sets up unit test wide variables at the start
		 *	  of each test method.
		 *	  @access public
		 */
		function setUp() {
			// Set up the database connection
			$dbHandler=&Services::getService("DatabaseManager");
			$dbIndex = $dbHandler->addDatabase( new MySQLDatabase("devo","doboHarmoniTest","test","test") );
			$dbHandler->pConnect($dbIndex);
			unset($dbHandler); // done with that for now

			$context =& new OsidContext;
			$configuration =& new ConfigurationProperties;
			$configuration->addProperty('database_index', $dbIndex);
			$configuration->addProperty('database_name', $arg0 = "doboHarmoniTest");
			unset($arg0);
			$this->manager =& new HarmoniHierarchyManager;
			$this->manager->assignConfiguration($configuration);
		}
		
		/**
		 *	  Clears the data set in the setUp() method call.
		 *	  @access public
		 */
		function tearDown() {
			// perhaps, unset $obj here
		}

		//--------------the tests ----------------------

		function test_get_hierarchy() {
			$hierarchy =& $this->manager->getHierarchy(new HarmoniId("8"));
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
			$this->assertIdentical($hierarchy->getId(), new HarmoniId("8"));
			$this->assertTrue(is_string($hierarchy->getDisplayName()));
			$this->assertTrue(is_String($hierarchy->getDescription()));
			$this->assertIdentical($hierarchy->allowsMultipleParents(), true);
			$this->assertIdentical($hierarchy->allowsRecursion(), false);
			
			// second time should be from cache
			$hierarchy =& $this->manager->getHierarchy(new HarmoniId("8"));
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
			$this->assertIdentical($hierarchy->getId(), new HarmoniId("8"));
			$this->assertTrue(is_string($hierarchy->getDisplayName()));
			$this->assertTrue(is_String($hierarchy->getDescription()));
			$this->assertIdentical($hierarchy->allowsMultipleParents(), true);
			$this->assertIdentical($hierarchy->allowsRecursion(), false);
		}

		function test_get_hierarchies() {
			$hierarchies =& $this->manager->getHierarchies();
			while ($hierarchies->hasNext()) {
				$hierarchy =& $hierarchies->next();
				$this->assertIsA($hierarchy, "HarmoniHierarchy");
			}
		}
		
		function test_create_and_delete_hierarchy() {
			$hierarchy =& $this->manager->createHierarchy("H5", $arg0 = null, "Hierarchy Five", true, false);
			unset($arg0);
			$this->assertIsA($hierarchy, "HarmoniHierarchy");
			$this->assertIdentical($hierarchy->getDisplayName(), "H5");
			$this->assertIdentical($hierarchy->getDescription(), "Hierarchy Five");
			$this->assertIdentical($hierarchy->allowsMultipleParents(), true);
			$this->assertIdentical($hierarchy->allowsRecursion(), false);

			$this->manager->deleteHierarchy($hierarchy->getId());
		}
		
		function test_node() {
			$node =& $this->manager->getNode(new HarmoniId("3"));
			$this->assertIsA($node, "Node");
			$this->assertIdentical($node->getDisplayName(), "C");
			$this->assertIdentical($node->getDescription(), "");
			$deftype =& new DefaultNodeType();
			$type =& $node->getType();
			$this->assertIdentical($type->getAuthority(), $deftype->getAuthority());
			$this->assertIdentical($type->getDomain(), $deftype->getDomain());
			$this->assertIdentical($type->getKeyword(), $deftype->getKeyword());
			$this->assertIdentical($type->getDescription(), $deftype->getDescription());
			
			$this->assertIdentical($node->_cache->_allowsMultipleParents, true);
			
			$hierarchy =& $this->manager->getHierarchy(new HarmoniId("8"));
			$this->assertReference($hierarchy->_cache, $node->_cache);		
		}

	}