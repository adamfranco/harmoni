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
 * @version $Id: DateAndTimeTestCase.class.php,v 1.3 2005/05/05 00:11:05 adamfranco Exp $
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
		
		$dateAndTime =& DateAndTime::withYearMonthDay(2005, 1, 1);
		$this->assertEqual($dateAndTime->year(), 2005);
		$this->assertEqual($dateAndTime->month(), 1);
		$this->assertEqual($dateAndTime->day(), 1);
		$this->assertEqual($dateAndTime->hour(), 0);
		$this->assertEqual($dateAndTime->hour12(), 12);
		$this->assertEqual($dateAndTime->minute(), 0);
		$this->assertEqual($dateAndTime->second(), 0);
	}
	
	/**
	 * Test comparisons
	 */ 
	function test_comparisons() {
		$dateAndTimeA =& DateAndTime::withYearDay(1950, 1);
		$dateAndTimeB =& DateAndTime::withYearDay(1950, 2);
		
		$this->assertFalse($dateAndTimeA->isEqualTo($dateAndTimeB));
		$this->assertTrue($dateAndTimeA->isLessThan($dateAndTimeB));
		$this->assertTrue($dateAndTimeA->isLessThanOrEqualTo($dateAndTimeB));
		$this->assertFalse($dateAndTimeA->isGreaterThan($dateAndTimeB));
		$this->assertFalse($dateAndTimeA->isGreaterThanOrEqualTo($dateAndTimeB));
		
		
		$dateAndTimeA =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 5, 4, 15, 25, 10, Duration::withHours(-4));
		$dateAndTimeB =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 5, 4, 15, 25, 10, Duration::withHours(-5));
		
		$this->assertFalse($dateAndTimeA->isEqualTo($dateAndTimeB));
		$this->assertTrue($dateAndTimeA->isLessThan($dateAndTimeB));
		$this->assertTrue($dateAndTimeA->isLessThanOrEqualTo($dateAndTimeB));
		$this->assertFalse($dateAndTimeA->isGreaterThan($dateAndTimeB));
		$this->assertFalse($dateAndTimeA->isGreaterThanOrEqualTo($dateAndTimeB));
		
		$dateAndTimeA =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 5, 4, 16, 25, 10, Duration::withHours(-4));
		$dateAndTimeB =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 5, 4, 15, 25, 10, Duration::withHours(-5));
		
		$this->assertTrue($dateAndTimeA->isEqualTo($dateAndTimeB));
		$this->assertFalse($dateAndTimeA->isLessThan($dateAndTimeB));
		$this->assertTrue($dateAndTimeA->isLessThanOrEqualTo($dateAndTimeB));
		$this->assertFalse($dateAndTimeA->isGreaterThan($dateAndTimeB));
		$this->assertTrue($dateAndTimeA->isGreaterThanOrEqualTo($dateAndTimeB));
		
		$dateAndTimeA =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 5, 4, 20, 25, 10, Duration::withHours(5));
		$dateAndTimeB =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 5, 4, 10, 25, 10, Duration::withHours(-5));
		
		$this->assertTrue($dateAndTimeA->isEqualTo($dateAndTimeB));
		$this->assertFalse($dateAndTimeA->isLessThan($dateAndTimeB));
		$this->assertTrue($dateAndTimeA->isLessThanOrEqualTo($dateAndTimeB));
		$this->assertFalse($dateAndTimeA->isGreaterThan($dateAndTimeB));
		$this->assertTrue($dateAndTimeA->isGreaterThanOrEqualTo($dateAndTimeB));
	}
	
	/**
	 * Test accessing
	 */ 
	function test_accessing() {
		$dateAndTime =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 6, 4, 15, 25, 10, Duration::withHours(-5));
		
		// Methods not in the test are in comments.
		
		// asDate()
		$temp =& $dateAndTime->asDateAndTime();
		$this->assertTrue($temp->isEqualTo(
			DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 6, 4, 15, 25, 10, Duration::withHours(-5))));
		// asDuration()
		// asLocal()
		// asMonth()
		// asSeconds()
		// asTime()
		// asTimestamp()
		// asUTC()
		// asWeek()
		// asYear		
		$this->assertEqual($dateAndTime->day(), 4);
		$this->assertEqual($dateAndTime->dayOfMonth(), 4);
		$this->assertEqual($dateAndTime->dayOfWeek(), 7);
		$this->assertEqual($dateAndTime->dayOfWeekAbbreviation(), 'Sat');
		$this->assertEqual($dateAndTime->dayOfWeekName(), 'Saturday');
		$this->assertEqual($dateAndTime->dayOfYear(), 155);
// 		$this->assertEqual($dateAndTime->daysInMonth(), 30);
// 		$this->assertEqual($dateAndTime->daysInYear(), 365);
// 		$this->assertEqual($dateAndTime->daysLeftInYear(), 210);
// 		$duration =& $dateAndTime->duration();
// 		$this->assertEqual($duration->asSeconds(), 0);
// 		$this->assertEqual($dateAndTime->firstDayOfMonth(), 152);
		$this->assertEqual($dateAndTime->hour(), 15);
		$this->assertEqual($dateAndTime->hour24(), 15);
		$this->assertEqual($dateAndTime->hour12(), 3);
// 		$this->assertEqual($dateAndTime->hours(), 15);
		$this->assertEqual($dateAndTime->hour(), 15);
		// isEqualTo()
		$this->assertFalse($dateAndTime->isLeapYear());
		// isLessThan()
		$this->assertEqual($dateAndTime->julianDayNumber(), 2453526);
// 		$this->assertEqual($dateAndTime->meridianAbbreviation(), 'PM');
		// middleOf($aDuration)
		// midnight()
		// minus()
		$this->assertEqual($dateAndTime->minute(), 25);
// 		$this->assertEqual($dateAndTime->minutes(), 25);
		$this->assertEqual($dateAndTime->month(), 6);
		$this->assertEqual($dateAndTime->monthIndex(), 6);
		$this->assertEqual($dateAndTime->monthName(), 'June');
		$this->assertEqual($dateAndTime->monthAbbreviation(), 'Jun');
		// noon()
		$offset =& $dateAndTime->offset();
		$this->assertTrue($offset->isEqualTo(Duration::withHours(-5)));
		// plus()
// 		$this->assertEqual($dateAndTime->hmsString(), '15:25:10');
		// printableString()
// 		$this->assertEqual($dateAndTime->ymdString(), '2005-06-04');
		$this->assertEqual($dateAndTime->second(), 10);
// 		$this->assertEqual($dateAndTime->seconds(), 10);
		// ticks()
		// ticksOffset()
// 		$this->assertEqual($dateAndTime->timeZoneAbbreviation(), 'EST');
// 		$this->assertEqual($dateAndTime->timeZoneAbbreviation(), 'Eastern Standard Time');
		// to()
		// toBy()
		// toByDo()
		// utcOffset
		// withOffset()
		$this->assertEqual($dateAndTime->year(), 2005);
		
		$this->assertEqual("A tests have been uncommented and run?", "Yes");
	}
}

// 		print "<pre>";
// 		print_r($duration);
// 		print "</pre>";

?>