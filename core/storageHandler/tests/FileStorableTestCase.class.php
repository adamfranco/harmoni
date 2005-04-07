<?php

require_once(HARMONI.'storageHandler/Storables/FileStorable.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 *
 * @package harmoni.storage.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: FileStorableTestCase.class.php,v 1.4 2005/04/07 16:33:30 adamfranco Exp $
 **/

    class FileStorableTestCase extends UnitTestCase {
	
		function FileStorableTestCase() {
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
		function test_name_Path() {
			$storable = new FileStorable(HARMONI.'storageHandler/tests/mtests',"","max1.txt");

			$this->assertEqual("max1.txt",$storable->getName());	
			$this->assertEqual("",$storable->getPath());
			$storable->setName("max2.ttx");
			$this->assertEqual($storable->getSize(),20);
			
		}
		
    }

?>