<?php

require_once(HARMONI.'examlePackageDir/ExampleClass.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: ExampleClassTestCase.class.php,v 1.3 2005/02/07 21:38:27 adamfranco Exp $
 * @copyright 2003 
 **/

    class ExampleClassTestCase extends UnitTestCase {
	
		function ExampleClassTestCase() {
			$this->UnitTestCase();
		}
	
		/**
		*  Sets up unit test wide variables at the start
		*    of each test method.
		*    @access public
		*/
		function setUp() {
			// perhaps, initialize $obj here
		}
		
		/**
		 *    Clears the data set in the setUp() method call.
		 *    @access public
		 */
		function tearDown() {
			// perhaps, unset $obj here
		}
	
		/**
		 *    First test Description.
		 */ 
		function test_first_thing() {
			$this->assertEqual(false,"We need to delete this and write some real tests.");	
		}
		
    }

?>