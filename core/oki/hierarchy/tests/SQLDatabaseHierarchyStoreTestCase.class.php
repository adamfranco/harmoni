<?php

require_once(HARMONI.'/oki/hierarchy/SQLDatabaseHierarchyStore.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: SQLDatabaseHierarchyStoreTestCase.class.php,v 1.2 2003/10/30 22:39:44 adamfranco Exp $
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
 			
        }
		
        /**
         *    Clears the data set in the setUp() method call.
         *    @public
         */
        function tearDown() {
			// perhaps, unset $obj here
			$this->dbc->disconnect($this->dbindex);
			
			print "</pre>";
        }

		//--------------the tests ----------------------

		function test_constructor() {
			$store =& new SQLDatabaseHierarchyStore(1, $this->dbindex, 
					"hierarchy", "id","display_name","description",
					"hierarchy_node","fk_hierarchy","id","lk_parent","fk_data","display_name",
					"description");
//			print_r($store);
				
		}
	}