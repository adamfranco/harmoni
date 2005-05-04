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
 * @version $Id: DateAndTimeTestCase.class.php,v 1.2 2005/05/04 20:18:55 adamfranco Exp $
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
		$this->assertEqual($dateAndTime->year(), 1901);
		$this->assertEqual($dateAndTime->month(), 1);
		$this->assertEqual($dateAndTime->day(), 1);
		
		$dateAndTime =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							1901, 1, 1, 0, 0, 0, $null = NULL);
		$this->assertEqual($dateAndTime->year(), 1901);
		$this->assertEqual($dateAndTime->month(), 1);
		$this->assertEqual($dateAndTime->day(), 1);
		
		$dateAndTime =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							1901, 'jan', 1, 0, 0, 0, $null = NULL);
		$this->assertEqual($dateAndTime->year(), 1901);
		$this->assertEqual($dateAndTime->month(), 1);
		$this->assertEqual($dateAndTime->day(), 1);
		
		$dateAndTime =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							1901, 'January', 1, 0, 0, 0, $null = NULL);
		$this->assertEqual($dateAndTime->year(), 1901);
		$this->assertEqual($dateAndTime->month(), 1);
		$this->assertEqual($dateAndTime->day(), 1);
		
	}
	
	/**
	 * Test alterate static creations
	 */ 
	function test_creation_methods() {
	
		$dateAndTime =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 5, 4, 15, 25, 10, $null = NULL);
		$this->assertEqual($dateAndTime->year(), 2005);
		$this->assertEqual($dateAndTime->month(), 5);
		$this->assertEqual($dateAndTime->day(), 4);
		$this->assertEqual($dateAndTime->hour(), 15);
		$this->assertEqual($dateAndTime->hour12(), 3);
		$this->assertEqual($dateAndTime->minute(), 25);
		$this->assertEqual($dateAndTime->second(), 10);
		
		$dateAndTime =& DateAndTime::withYearMonthDayHourMinute(2005, 5, 4, 15, 25);
		$this->assertEqual($dateAndTime->year(), 2005);
		$this->assertEqual($dateAndTime->month(), 5);
		$this->assertEqual($dateAndTime->day(), 4);
		$this->assertEqual($dateAndTime->hour(), 15);
		$this->assertEqual($dateAndTime->hour12(), 3);
		$this->assertEqual($dateAndTime->minute(), 25);
		$this->assertEqual($dateAndTime->second(), 0);
	
		$dateAndTime =& DateAndTime::withYearDay(1950, 1);
		$this->assertEqual($dateAndTime->year(), 1950);
		$this->assertEqual($dateAndTime->month(), 1);
		$this->assertEqual($dateAndTime->day(), 1);
		$this->assertEqual($dateAndTime->hour(), 0);
		$this->assertEqual($dateAndTime->hour12(), 12);
		$this->assertEqual($dateAndTime->minute(), 0);
		$this->assertEqual($dateAndTime->second(), 0);
	}
}

// 		print "<pre>";
// 		print_r($duration);
// 		print "</pre>";

?>