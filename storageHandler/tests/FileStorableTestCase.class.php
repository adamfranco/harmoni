<?php

require_once(HARMONI.'storageHandler/Storables/FileStorable.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: FileStorableTestCase.class.php,v 1.2 2003/06/30 21:05:46 movsjani Exp $
 * @copyright 2003 
 **/

    class FileStorableTestCase extends UnitTestCase {
	
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
			$storable = new FileStorable(HARMONI.'storageHandler/tests/mtests',"","max1.txt");

			$this->assertEqual("max1.txt",$storable->getName());	
			$this->assertEqual("",$storable->getPath());
			$storable->setName("max2.ttx");
			$this->assertEqual($storable->getSize(),20);
			
		}
		
    }

?>