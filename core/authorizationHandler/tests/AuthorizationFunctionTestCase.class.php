<?php

require_once(HARMONI.'authorizationHandler/AuthorizationFunction.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthorizationFunctionTestCase.class.php,v 1.1 2003/08/14 19:26:30 gabeschine Exp $
 * @copyright 2003 
 */

    class AuthorizationFunctionTestCase extends UnitTestCase {
		
		var $function;
	
		function ExampleClassTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			$this->function =& new AuthorizationFunction(20, "view");
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			// perhaps, unset $obj here
			unset($this->function);
		}
	
		/**
		 *    Test the constructor
		 */ 
		function test_constructor() {
			$this->assertEqual($this->function->getSystemId(), 20);
			$this->assertEqual($this->function->getSystemName(), "view");
		}
		
    }

?>