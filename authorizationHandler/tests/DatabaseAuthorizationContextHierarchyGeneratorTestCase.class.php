<?php

require_once(HARMONI.'authorizationHandler/generator/DatabaseAuthorizationContextHierarchyGenerator.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DatabaseAuthorizationContextHierarchyGeneratorTestCase.class.php,v 1.4 2003/07/07 02:27:48 dobomode Exp $
 * @copyright 2003 
 */

    class DatabaseAuthorizationContextHierarchyGeneratorTestCase extends UnitTestCase {
		
		var $generator;
		var $dbHandler;
	
		function DatabaseAuthorizationContextHierarchyGeneratorTestCase() {
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
				DatabaseAuthorizationContextHierarchyGenerator($dbIndex);
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
			// no hierarchy
			$depth = $this->generator->addContextHierarchyLevel("site", "site_id");
			$this->assertIdentical($depth, 0);

			$resultFromGenerator = $this->generator->generateSubtree(0, 71);
			$resultFromDobo = array();
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

		}
		
		/**
		 *    Test simple hierarchy - only 2 levels.
		 */ 
		function test_Hierarchy_2_Levels() {
			$this->test_No_Hierarchy();
		
			$depth = $this->generator->addContextHierarchyLevel("section", "section_id", "FK_site");
			$this->assertIdentical($depth, 1);

			$resultFromGenerator = $this->generator->generateSubtree(0, 71);
			$resultFromDobo = array();
			$resultFromDobo[1] = array(251, 252);
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);
		}
		
		/**
		 *    Test complex hierarchy - many levels.
		 */ 
		function test_Hierarchy_Many_Levels() {
			$this->test_Hierarchy_2_Levels();	
		
			$depth = $this->generator->addContextHierarchyLevel("page", "page_id", "FK_section");
			$this->assertIdentical($depth, 2);

			$resultFromGenerator = $this->generator->generateSubtree(0, 71);
			$resultFromDobo = array();
			$resultFromDobo[1] = array(251, 252);
			$resultFromDobo[2] = array(811, 812, 813, 814);
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			$depth = $this->generator->addContextHierarchyLevel("story", "story_id", "FK_page");
			$this->assertIdentical($depth, 3);

			$resultFromGenerator = $this->generator->generateSubtree(0, 71);
			$resultFromDobo = array();
			$resultFromDobo[1] = array(251, 252);
			$resultFromDobo[2] = array(811, 812, 813, 814);
			$resultFromDobo[3] = array(675, 679, 676, 677, 678);
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			$resultFromGenerator = $this->generator->generateSubtree(1, 251);
			$resultFromDobo = array();
			$resultFromDobo[2] = array(811, 812, 813);
			$resultFromDobo[3] = array(675, 679, 676, 677);
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			$resultFromGenerator = $this->generator->generateSubtree(2, 811);
			$resultFromDobo = array();
			$resultFromDobo[3] = array(675, 679);
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			$resultFromGenerator = $this->generator->generateSubtree(3, 675);
			$resultFromDobo = array();
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);
		}
		
		/**
		 *    Test getAncestors().
		 */ 
		function test_getAncestors() {
			$this->generator->addContextHierarchyLevel("site", "site_id");
			$this->generator->addContextHierarchyLevel("section", "section_id", "FK_site");
			$this->generator->addContextHierarchyLevel("page", "page_id", "FK_section");
			$this->generator->addContextHierarchyLevel("story", "story_id", "FK_page");
			
			$resultFromGenerator = $this->generator->getAncestors(0, 71);
			$resultFromDobo = array();
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			$resultFromGenerator = $this->generator->getAncestors(1, 252);
			$resultFromDobo = array();
			$resultFromDobo[0] = 71;
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			$resultFromGenerator = $this->generator->getAncestors(2, 813);
			$resultFromDobo = array();
			$resultFromDobo[0] = 71;
			$resultFromDobo[1] = 251;
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			$resultFromGenerator = $this->generator->getAncestors(3, 678);
			$resultFromDobo = array();
			$resultFromDobo[0] = 71;
			$resultFromDobo[1] = 252;
			$resultFromDobo[2] = 814;
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);
		}
		
		/**
		 *    Test caching.
		 */ 
		function test_caching() {
			$this->generator->addContextHierarchyLevel("site", "site_id");
			$this->generator->addContextHierarchyLevel("section", "section_id", "FK_site");
			$this->generator->addContextHierarchyLevel("page", "page_id", "FK_section");
			$this->generator->addContextHierarchyLevel("story", "story_id", "FK_page");
		
			$resultFromDobo = array();
			$resultFromGenerator = $this->generator->generateSubtree(1, 251);
			$resultFromDobo[2] = array(811, 812, 813);
			$resultFromDobo[3] = array(675, 679, 676, 677);

			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			$resultFromGenerator = $this->generator->generateSubtree(0, 71);
			$resultFromDobo = array();
			$resultFromDobo[1] = array(251, 252);
			$resultFromDobo[2] = array(811, 812, 813, 814);
			$resultFromDobo[3] = array(675, 679, 676, 677, 678);
			
			$this->assertEqual($resultFromGenerator, $resultFromDobo);

			// this should come from the cache
			$resultFromGenerator = $this->generator->generateSubtree(0, 71);
			$this->assertEqual($resultFromGenerator, $resultFromDobo);
			
			// this should come from the cache
			$this->assertEqual($resultFromGenerator, $resultFromDobo);
			
			$resultFromDobo = array();
			$resultFromGenerator = $this->generator->generateSubtree(1, 252);
			$resultFromDobo[2] = array(814);
			$resultFromDobo[3] = array(678);

			// this should come from the cache
			$this->assertEqual($resultFromGenerator, $resultFromDobo);
		}



    }

?>