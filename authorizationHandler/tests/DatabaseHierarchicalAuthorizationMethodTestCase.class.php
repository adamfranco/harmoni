<?php

require_once(HARMONI.'authorizationHandler/DatabaseHierarchicalAuthorizationMethod.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DatabaseHierarchicalAuthorizationMethodTestCase.class.php,v 1.2 2003/07/09 01:28:27 dobomode Exp $
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
			$dataContainer->set("primaryKeyColumn", "id");
			$dataContainer->set("agentIdColumn", "agent_id");
			$dataContainer->set("agentTypeColumn", "agent_type");
			$dataContainer->set("functionIdColumn", "function_id");
			$dataContainer->set("contextIdColumn", "context_id");
			$dataContainer->set("contextDepthColumn", "context_depth");
			
			$this->method =& new DatabaseHierarchicalAuthorizationMethod($dataContainer, 
																		 $generator);
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			// perhaps, unset $obj here
			unset($this->method);
		}
		
	
		/**
		 *    Test the constructor
		 */ 
		function test_constructor() {
			// can't think of any tests here
		}
		
		
	
		/**
		 *    Test simple authorize.
		 */ 
		function test_Simple_Authorize() {
			// create the agent objects
			$agent =& new AuthorizationAgent(1, "dobo", "1");
			
			// create function objects
			$function1 =& new AuthorizationFunction(1, "function name doesn't matter");
			$function2 =& new AuthorizationFunction(2, "function name doesn't matter");
			
			// create context objects
			$context1 =& new HierarchicalAuthorizationContext("harmoniTest", "permission", 0, 1);
			$context2 =& new HierarchicalAuthorizationContext("harmoniTest", "permission", 0, 300);
			$context3 =& new HierarchicalAuthorizationContext("harmoniTest", "permission", 1, 1152);
			$context4 =& new HierarchicalAuthorizationContext("harmoniTest", "permission", 2, 3532);
			$context5 =& new HierarchicalAuthorizationContext("harmoniTest", "permission", 3, 4107);
			
			$authorized = $this->method->authorize($agent, $function1, $context1);
			$this->assertTrue($authorized);
			
			$authorized = $this->method->authorize($agent, $function2, $context1);
			$this->assertFalse($authorized);
			
			$authorized = $this->method->authorize($agent, $function1, $context2);
			$this->assertTrue($authorized);
			
			$authorized = $this->method->authorize($agent, $function1, $context3);
			$this->assertTrue($authorized);
			
			$authorized = $this->method->authorize($agent, $function1, $context4);
			$this->assertTrue($authorized);
			
			$authorized = $this->method->authorize($agent, $function1, $context5);
			$this->assertTrue($authorized);
			
			// clear the cache and try the same queries in reversed order
			$this->method->clearCache();
			
			$authorized = $this->method->authorize($agent, $function1, $context5);
			$this->assertTrue($authorized);
			
			$authorized = $this->method->authorize($agent, $function1, $context4);
			$this->assertTrue($authorized);
			
			$authorized = $this->method->authorize($agent, $function1, $context3);
			$this->assertTrue($authorized);
			
			$authorized = $this->method->authorize($agent, $function1, $context2);
			$this->assertTrue($authorized);
			
			$authorized = $this->method->authorize($agent, $function2, $context1);
			$this->assertFalse($authorized);
			
			$authorized = $this->method->authorize($agent, $function1, $context1);
			$this->assertTrue($authorized);
		}
    }

?>