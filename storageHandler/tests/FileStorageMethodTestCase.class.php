<?php

require_once(HARMONI.'storageHandler/StorageMethods/FileStorageMethod.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @version $Id: FileStorageMethodTestCase.class.php,v 1.3 2003/06/30 21:05:46 movsjani Exp $
 * @copyright 2003 
 **/

    class FileStorageMethodTestCase extends UnitTestCase {
	
		function FileStorageMethodTestCase() {
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
		function test_store_retrieve() {
			
			$method = new FileStorageMethod(HARMONI.'storageHandler/tests/stests');
			
			$storable = new FileStorable(HARMONI.'storageHandler/tests/mtests',"","max1.txt");

			$method->store($storable,"","maxnew.txt");

			$method->copy("","maxnew.txt","","maxultranew.txt");

			$storable2 = $method->retrieve("","maxultranew.txt");

			$this->assertEqual($storable->getData(),"as;dlfkjasasdf Adin.");
			
			$method->move("","maxnew.txt","","maxold.txt");

			$storables = $method->listInPath("",true);
			foreach ($storables as $storable){
				print "<br>";
				print $storable->getPath()." "; 
				print $storable->getName()." "; 
				print "<br>";
			}

			print $method->getSizeOf("");
			print "<br>";
			print $method->getSizeOf("","maxold.txt");
		}
		
    }

?>