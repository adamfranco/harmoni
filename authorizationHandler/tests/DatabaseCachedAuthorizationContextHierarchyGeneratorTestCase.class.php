<?php

require_once(HARMONI.'authorizationHandler/generator/DatabaseCachedAuthorizationContextHierarchyGenerator.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DatabaseCachedAuthorizationContextHierarchyGeneratorTestCase.class.php,v 1.2 2003/07/02 01:14:00 dobomode Exp $
 * @copyright 2003 
 */

    class DatabaseCachedAuthorizationContextHierarchyGeneratorTestCase extends UnitTestCase {
		
		var $generator;
		var $dbHandler;
	
		function DatabaseCachedAuthorizationContextHierarchyGeneratorTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			Services::requireService("DBHandler", true);
			$this->dbHandler =& Services::getService("DBHandler");
			$dbIndex = $this->dbHandler->createDatabase(MYSQL, "devo.middlebury.edu", "harmoniTest", "test", "test");
			$this->dbHandler->connect($dbIndex);
			$this->generator =& new
				DatabaseCachedAuthorizationContextHierarchyGenerator($dbIndex);
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			// perhaps, unset $obj here
			unset($this->generator);
		}
	
		/**
		 *    Test the constructor
		 */ 
		function test_constructor() {
			// can't think of any tests here
		}
		
	
		/**
		 *    Test no hierarchy.
		 */ 
		function test_Simple_Hierarchy() {
			$depth = $this->generator->addContextHierarchyLevel("site", "site_id");
			$this->assertIdentical($depth, 0);

			$resultFromGenerator = $this->generator->generateSubtree(0, 71);
			$resultFromDobo = array();
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			$depth = $this->generator->addContextHierarchyLevel("section", "section_id", "FK_site");
			$this->assertIdentical($depth, 1);

			$resultFromGenerator = $this->generator->generateSubtree(0, 71);
			$resultFromDobo = array();
			$resultFromDobo[0] = array(251, 252);
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);
		}
		
    }

?>