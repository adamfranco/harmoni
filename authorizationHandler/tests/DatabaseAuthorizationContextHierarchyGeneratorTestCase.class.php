<?php

require_once(HARMONI.'authorizationHandler/generator/DatabaseCachedAuthorizationContextHierarchyGenerator.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DatabaseAuthorizationContextHierarchyGeneratorTestCase.class.php,v 1.1 2003/07/01 23:51:50 dobomode Exp $
 * @copyright 2003 
 */

    class DatabaseCachedAuthorizationContextHierarchyGeneratorTestCase extends UnitTestCase {
		
		var $generator;
		var $dbHandler;
	
		function ExampleClassTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			$this->dbHandler =& new DBHandler();
			$dbIndex = $this->dbHandler->createDatabase(MYSQL, "devo.middlebury.edu", "harmoniTest", "test", "test");
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
		function test_No_Hierarchy() {
			$depth = $this->generator->addContextHierarchyLevel("site");

			$resultFromGenerator = $this->generator->generateSubtree($depth, 71);
			$resultFromDobo = array();
			
			//$this->assertEqual($resultFromGenerator, $resultFromDobo);
		}
		
    }

?>