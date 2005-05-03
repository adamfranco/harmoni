<?php

require_once(dirname(__FILE__)."/../DateAndTime.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DateAndTimeTestCase.class.php,v 1.1 2005/05/03 23:55:39 adamfranco Exp $
 */

class DateAndTimeTestCase extends UnitTestCase {
	
	function TreeTestCase() {
		$this->UnitTestCase();
	}
	
	/**
	*  Sets up unit test wide variables at the start
	*	 of each test method.
	*	 @access public
	*/
	function setUp() {
		// perhaps, initialize $obj here
	}
	
	/**
	 *	  Clears the data set in the setUp() method call.
	 *	  @access public
	 */
	function tearDown() {
		// perhaps, unset $obj here
	}
	
	/**
	 * Test the DateAndTime representing the Squeak epoch: 1 January 1901.
	 */ 
	function test_epoch() {
	
		$dateAndTime =& DateAndTime::epoch();		
		print "<pre>";
		var_export($dateAndTime);
		print "</pre>";
		$this->assertEqual($dateAndTime->year(), 1901);
		$this->assertEqual($dateAndTime->month(), 1);
		$this->assertEqual($dateAndTime->day(), 1);
	}
}

// 		print "<pre>";
// 		print_r($duration);
// 		print "</pre>";

?>