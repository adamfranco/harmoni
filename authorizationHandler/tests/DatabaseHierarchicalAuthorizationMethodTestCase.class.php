<?php

require_once(HARMONI.'authorizationHandler/DatabaseHierarchicalAuthorizationMethod.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DatabaseHierarchicalAuthorizationMethodTestCase.class.php,v 1.1 2003/07/04 03:32:35 dobomode Exp $
 * @copyright 2003 
 */

    class DatabaseHierarchicalAuthorizationMethodTestCase extends UnitTestCase {
		
		var $method;
	
		function DatabaseHierarchicalAuthorizationMethodTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			// get DBHandler
			Services::requireService("DBHandler", true);
			$dbHandler =& Services::getService("DBHandler");
			$dbIndex = $dbHandler->createDatabase(MYSQL, "devo.middlebury.edu", "harmoniTest", "test", "test");
			$dbHandler->connect($dbIndex);

			// setup generator
			$generator =& new
				DatabaseAuthorizationContextHierarchyGenerator($dbIndex);
			$generator->addContextHierarchyLevel("site", "site_id");
			$generator->addContextHierarchyLevel("section", "section_id", "FK_site");
			$generator->addContextHierarchyLevel("page", "page_id", "FK_section");
			$generator->addContextHierarchyLevel("story", "story_id", "FK_page");

			// setup data container
			$dataContainer =& new DatabaseHierarchicalAuthorizationMethodDataContainer();
			$dataContainer->set("dbIndex", $dbIndex);
			$dataContainer->set("agentIdColumn", "agent_id");
			$dataContainer->set("agentTypeColumn", "agent_type");
			$dataContainer->set("functionIdColumn", "function_id");
			$dataContainer->set("contextIdColumn", "context_id");
			$dataContainer->set("contextDepthColumn", "context_depth");
			$dataContainer->set("authorizedColumn", "authorized");
			
			$this->method =& new DatabaseHierarchicalAuthorizationMethod($dataContainer, 
																		 $generator);
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
		function test_constructor() {
			// can't think of any tests here
		}
		
		
	
		/**
		 *    Test no hierarchy.
		 */ 
		function test_No_Hierarchy() {
		}
		
    }

?>