<?php

require_once(HARMONI.'/oki/hierarchy/SQLDatabaseHierarchyStore.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: SQLDatabaseHierarchyStoreTestCase.class.php,v 1.3 2003/10/31 22:59:18 adamfranco Exp $
 * @package concerto.tests.api.metadata
 * @copyright 2003
 **/

    class SQLDatabaseHierarchyStoreTestCase extends UnitTestCase {
		
		var $store;

        /**
         *    Sets up unit test wide variables at the start
         *    of each test method.
         *    @public
         */
        function setUp() {
        	print "<pre>";
        	$this->dbc =& Services::requireService("DBHandler","DBHandler");
 			$this->dbindex = $this->dbc->createDatabase(MYSQL,"devo.middlebury.edu", "harmoniTest", "test", "test");
 			$this->dbc->connect($this->dbindex);
 			
			$this->store =& new SQLDatabaseHierarchyStore(1, $this->dbindex, 
				"hierarchy", "id","display_name","description",
				"hierarchy_node","fk_hierarchy","id","lk_parent","display_name",
				"description");
			$this->store->load();
			
			$sharedManager =& Services::getService("Shared");
			$this->newRootId =& $sharedManager->createId();
			$this->newRootIdString = $this->newRootId->getIdString();
			$this->newRoot =& new HarmoniNode($this->newRootId, $this->store, NULL, "Testing Root","The Root of my test nodes");
			$this->store->addNode($this->newRoot,0,$this->newRootIdString);
			$this->store->save();
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			$this->store->removeNode($this->newRootIdString);
			$this->store->save();
			
			$this->dbc->disconnect($this->dbindex);
			
			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_constructor() {
/* 			print "<h1>".$this->dbc->getTotalNumberOfQueries()."</h1>"; */
			
			$store =& new SQLDatabaseHierarchyStore(1, $this->dbindex, 
					"hierarchy", "id","display_name","description",
					"hierarchy_node","fk_hierarchy","id","lk_parent","display_name",
					"description");
			
/* 			print "<h1>".$this->dbc->getTotalNumberOfQueries()."</h1>"; */
/* 			 */
/* 			$store->initialize(); */
/* 			 */
/* 			print "<h1>".$this->dbc->getTotalNumberOfQueries()."</h1>"; */
/* 			 */
/* 			$store->load(5); */
/* 			 */
/* 			print_r($store->depthFirstEnumeration(0)); */
/* 			print "<h1>".$this->dbc->getTotalNumberOfQueries()."</h1>"; */
/* 			 */
/* 			$store->load(8); */
/* 			 */
/* 			print_r($store->depthFirstEnumeration(0)); */
/* 			print "<h1>".$this->dbc->getTotalNumberOfQueries()."</h1>";			 */
/* 			 */
/* 			$store->load(4); */
/* 			 */
/* 			print_r($store->depthFirstEnumeration(0)); */
/* 			print "<h1>".$this->dbc->getTotalNumberOfQueries()."</h1>"; */
/* 			 */
			$store->load();
/* 			 */
/* 			print_r($store->depthFirstEnumeration(0)); */
/* 			print "<h1>".$this->dbc->getTotalNumberOfQueries()."</h1>"; */
			
			// If the above all look right, then this works. :-)
			$this->assertTrue(TRUE);
		}
		
		function test_add_node() {
			$store =& $this->store;
			
			$this->assertEqual(count($store->_added),0);
			$this->assertEqual(count($store->_changed),0);
			$this->assertEqual(count($store->_deleted),0);
			
			$sharedManager =& Services::getService("Shared");
			$nodeId =& $sharedManager->createId();
			$nodeIdString = $nodeId->getIdString();
			$testObj =& new HarmoniNode($nodeId, $store, NULL, "Yet another node","my interesting description");
			
			$store->addNode($testObj,$this->newRootIdString,$nodeIdString);
			
			$this->assertEqual(count($store->_added),1);
			$this->assertTrue(in_array($nodeIdString,$store->_added));
			$this->assertEqual(count($store->_changed),0);
			$this->assertEqual(count($store->_deleted),0);
			$this->assertReference($testObj, $store->getData($nodeIdString));

/* 			print_r($store->depthFirstEnumeration(0)); */
			$store->save();
		}
	}