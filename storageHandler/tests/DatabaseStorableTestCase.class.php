<?php

require_once(HARMONI.'storageHandler/Storables/DatabaseStorable.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: DatabaseStorableTestCase.class.php,v 1.1 2003/07/03 01:34:14 dobomode Exp $
 * @copyright 2003 
 **/

    class DatabaseStorableTestCase extends UnitTestCase {
	
		function FileStorableTestCase() {
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
		 *    First test Description.
		 */ 
		function test_name_Path() {
			$dataContainer =& new DatabaseStorableDataContainer();
			$storable =& new DatabaseStorable($dataContainer);
			
			$this->assertFalse(true);
			
		}
		
    }

?>