<?php

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: test.php,v 1.2 2005/01/19 16:33:27 adamfranco Exp $
 * @copyright 2003 
 **/

    require_once('testedclass.php');

    class TestSomething extends UnitTestCase {
	
		var $obj;
	
		function TestOfLogging() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
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
		 *    Tests something. 
		 */ 
        function testSomething1() {
        }

		/**
		 *    Tests something. 
		 */ 
        function testSomething2() {
        }

		/**
		 *    Tests something. 
		 */ 
        function testSomething3() {
        }
		
    }

?>