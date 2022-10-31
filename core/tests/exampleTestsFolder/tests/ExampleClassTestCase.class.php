<?php

require_once(HARMONI.'examlePackageDir/ExampleClass.class.php');

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ExampleClassTestCase.class.php,v 1.4 2005/04/07 16:33:30 adamfranco Exp $
 **/

    class ExampleClassTestCase extends UnitTestCase {

		function __construct() {
			parent::__construct();
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