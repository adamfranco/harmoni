<?php

require_once(HARMONI.'authorizationHandler/AuthorizationAgent.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthorizationAgentTestCase.class.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
 * @copyright 2003 
 */

    class AuthorizationAgentTestCase extends UnitTestCase {
		
		var $agent;
	
		function ExampleClassTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			$this->agent =& new AuthorizationAgent(15, "dobo", "smartass");
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			// perhaps, unset $obj here
			unset($this->agent);
		}
	
		/**
		 *    Test the constructor
		 */ 
		function test_constructor() {
			$this->assertEqual($this->agent->getSystemId(), 15);	
			$this->assertEqual($this->agent->getSystemName(), "dobo");
			$this->assertEqual($this->agent->getType(), "smartass");
		}
		
    }

?>