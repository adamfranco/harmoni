<?php

require_once(HARMONI.'authenticationHandler/AuthenticationMethod.abstract.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthenticationMethodTestCase.class.php,v 1.1 2003/08/14 19:26:29 gabeschine Exp $
 * @copyright 2003 
 **/

    class AuthenticationMethodTestCase extends UnitTestCase {
	
		function AuthenticationMethodTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @public
		*/
		function setUp() {
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @public
		 */
		function tearDown() {
			// perhaps, unset $obj here
		}
	
		/**
		 *    First test Description
		 */ 
		function test_first_thing() {
			$this->assertEqual(false,"We need to delete this and write some real tests.");	
		}
		
    }

?>