<?php

    require_once('Group.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @author Dobo Radichkov
 * @version $Id: GroupTestCase.class.php,v 1.1 2003/06/16 20:12:39 dobomode Exp $
 * @copyright 2003 
 **/

    class GroupTestCase extends UnitTestCase {
	

		function TypedUserTestCase() {
			$this->UnitTestCase();
		}

        /**
         *    Sets up unit test wide variables at the start
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
		 *    Tests getNumberOfUsers() function.
		 */ 
        function testNumberOfUsers() {
			$this->assertEqual($this->group->getNumberOfUsers(), 4);
		}
		
    }

?>