<?php

require_once(HARMONI.'authenticationHandler/AuthenticationResult.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: AuthenticationResultTestCase.class.php,v 1.1 2003/06/26 20:47:26 adamfranco Exp $
 * @copyright 2003 
 **/

    class AuthenticationResultTestCase extends UnitTestCase {
	
		function AuthenticationResultTestCase() {
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