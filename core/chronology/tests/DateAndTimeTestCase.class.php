<?php
/** 
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DateAndTimeTestCase.class.php,v 1.9 2005/05/12 17:46:45 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 * @since 5/3/05
 */

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
 * @version $Id: DateAndTimeTestCase.class.php,v 1.9 2005/05/12 17:46:45 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 * @since 5/3/05
 */

class DateAndTimeTestCase extends UnitTestCase {

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
		$this->assertEqual($dateAndTime->dayOfMonth(), 4);
		$this->assertEqual($dateAndTime->hour(), 15);
		$this->assertEqual($dateAndTime->hour12(), 3);
		$this->assertEqual($dateAndTime->minute(), 25);
		$this->assertEqual($dateAndTime->second(), 10);
		
		$dateAndTime =& DateAndTime::withYearMonthDayHourMinute(2005, 5, 4, 15, 25);
		$this->assertEqual($dateAndTime->year(), 2005);
		$this->assertEqual($dateAndTime->month(), 5);
		$this->assertEqual($dateAndTime->dayOfMonth(), 4);
		$this->assertEqual($dateAndTime->hour(), 15);
		$this->assertEqual($dateAndTime->hour12(), 3);
		$this->assertEqual($dateAndTime->minute(), 25);
		$this->assertEqual($dateAndTime->second(), 0);
	
		$dateAndTime =& DateAndTime::withYearDay(1950, 1);
		$this->assertEqual($dateAndTime->year(), 1950);
		$this->assertEqual($dateAndTime->month(), 1);
		$this->assertEqual($dateAndTime->dayOfMonth(), 1);
		$this->assertEqual($dateAndTime->hour(), 0);
		$this->assertEqual($dateAndTime->hour12(), 12);
		$this->assertEqual($dateAndTime->minute(), 0);
		$this->assertEqual($dateAndTime->second(), 0);
		
		$dateAndTime =& DateAndTime::withYearMonthDay(2005, 1, 1);
		$this->assertEqual($dateAndTime->year(), 2005);
		$this->assertEqual($dateAndTime->month(), 1);
		$this->assertEqual($dateAndTime->dayOfMonth(), 1);
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
		// asYear()		
		$this->assertEqual($dateAndTime->day(), 155);
		$this->assertEqual($dateAndTime->dayOfMonth(), 4);
		$this->assertEqual($dateAndTime->dayOfWeek(), 7);
		$this->assertEqual($dateAndTime->dayOfWeekAbbreviation(), 'Sat');
		$this->assertEqual($dateAndTime->dayOfWeekName(), 'Saturday');
		$this->assertEqual($dateAndTime->dayOfYear(), 155);
 		$this->assertEqual($dateAndTime->daysInMonth(), 30);
 		$this->assertEqual($dateAndTime->daysInYear(), 365);
 		$this->assertEqual($dateAndTime->daysLeftInYear(), 210);
 		$duration =& $dateAndTime->duration();
 		$this->assertEqual($duration->asSeconds(), 0);
 		$this->assertEqual($dateAndTime->firstDayOfMonth(), 152);
		$this->assertEqual($dateAndTime->hour(), 15);
		$this->assertEqual($dateAndTime->hour24(), 15);
		$this->assertEqual($dateAndTime->hour12(), 3);
		$this->assertEqual($dateAndTime->hour(), 15);
		// isEqualTo()
		$this->assertFalse($dateAndTime->isLeapYear());
		// isLessThan()
		$this->assertEqual($dateAndTime->julianDayNumber(), 2453526);
		$this->assertEqual($dateAndTime->meridianAbbreviation(), 'PM');
		// middleOf($aDuration)
		// midnight()
		// minus()
		$this->assertEqual($dateAndTime->minute(), 25);
		$this->assertEqual($dateAndTime->month(), 6);
		$this->assertEqual($dateAndTime->monthIndex(), 6);
		$this->assertEqual($dateAndTime->monthName(), 'June');
		$this->assertEqual($dateAndTime->monthAbbreviation(), 'Jun');
		// noon()
		$offset =& $dateAndTime->offset();
		$this->assertTrue($offset->isEqualTo(Duration::withHours(-5)));
		// plus()
 		$this->assertEqual($dateAndTime->hmsString(), '15:25:10');
 		$this->assertEqual($dateAndTime->ymdString(), '2005-06-04');
 		$this->assertEqual($dateAndTime->string(), '2005-06-04T15:25:10-05:00');
		$this->assertEqual($dateAndTime->second(), 10);
		// ticks()
		// ticksOffset()
 		$this->assertEqual($dateAndTime->timeZoneAbbreviation(), 'EST');
 		$this->assertEqual($dateAndTime->timeZoneName(), 'Eastern Standard Time');
		// to()
		// toBy()
		// toByDo()
		// utcOffset()
		// withOffset()
		$this->assertEqual($dateAndTime->year(), 2005);
		
// 		$this->assertEqual("All tests have been uncommented and run?", "Yes");
	}
	
	/**
	 * Test converting
	 */ 
	function test_converting() {
		$dateAndTime =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 6, 4, 15, 25, 10, Duration::withHours(-5));
		
		
		// asDate()
		$temp =& $dateAndTime->asDate();
		$this->assertTrue($temp->isEqualTo(Date::withYearMonthDay(2005, 6, 4)));
		
		// asDuration()
		$temp =& $dateAndTime->asDuration();
		$this->assertTrue($temp->isEqualTo(Duration::withSeconds(55510)));
		
		// asDateAndTime()
		$temp =& $dateAndTime->asDateAndTime();
		$this->assertTrue($temp->isEqualTo(
			DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 6, 4, 15, 25, 10, Duration::withHours(-5))));
		
		// asLocal()
		$startDuration =& Duration::withHours(-5);
		$localOffset =& DateAndTime::localOffset();
		$difference =& $localOffset->minus($startDuration);
		$temp =& $dateAndTime->asLocal();
		$local =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 6, 4, (15 + $difference->hours()), 25, 10, $localOffset);
		
		$this->assertTrue($temp->isEqualTo($local));
		
		// asMonth()
		$temp =& $dateAndTime->asMonth();
		$this->assertTrue($temp->isEqualTo(Month::withMonthYear(6, 2005)));
		
		// asSeconds()
		$localOffset =& DateAndTime::localOffset();
		$this->assertEqual($dateAndTime->asSeconds(), (3295369510 + $localOffset->asSeconds()));
		
		// asTime()
		$temp =& $dateAndTime->asTime();
		$this->assertTrue($temp->isEqualTo(Time::withHourMinuteSecond(15, 25, 10)));
		$this->assertTrue($temp->isEqualTo(Time::withSeconds(55510)));
		
		// asTimeStamp()
 		$temp =& $dateAndTime->asTimeStamp();
 		$this->assertTrue($temp->isEqualTo(
 				TimeStamp::withYearMonthDayHourMinuteSecondOffset(
							2005, 6, 4, 15, 25, 10, Duration::withHours(-5))));
		
		// asUTC()
		$temp =& $dateAndTime->asUTC();
		$this->assertTrue($temp->isEqualTo(
			DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 6, 4, 20, 25, 10, Duration::withHours(0))));
		
		// asWeek()
		$temp =& $dateAndTime->asWeek();
		$this->assertTrue($temp->isEqualTo(Week::starting($dateAndTime)));
		
		// asYear()
		$temp =& $dateAndTime->asYear();
		$this->assertTrue($temp->isEqualTo(Year::starting($dateAndTime)));		
	}
	
	/**
	 * Test utcOffset
	 * 
	 */
	function test_utcOffset() {
		$dateAndTime =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 6, 4, 15, 25, 10, Duration::withHours(-5));
		
		
		$atUTC =& $dateAndTime->utcOffset(Duration::withHours(0));
		
		$this->assertEqual($dateAndTime->julianDayNumber(), 2453526);
		$this->assertEqual($atUTC->julianDayNumber(), 2453526);
		$this->assertEqual($dateAndTime->seconds, 55510);
		$this->assertEqual($atUTC->seconds, 73510);
		$this->assertEqual($dateAndTime->offset->seconds, -18000);
		$this->assertEqual($atUTC->offset->seconds, 0);
		
		$this->assertEqual($dateAndTime->string(), '2005-06-04T15:25:10-05:00');
		$this->assertEqual($atUTC->string(), '2005-06-04T20:25:10+00:00');
	}
	
	/**
	 * Test localOffset
	 * 
	 */
	function test_localOffset() {
		$localOffset =& DateAndTime::localOffset();
		
		$this->assertTrue($localOffset->isLessThanOrEqualTo(Duration::withHours(12)));
		$this->assertTrue($localOffset->isGreaterThanOrEqualTo(Duration::withHours(-12)));
		
		$secondsOffset = date('Z');
		$this->assertTrue($localOffset->isEqualTo(Duration::withSeconds($secondsOffset)));
	}

}

// 		print "<pre>";
// 		print_r($duration);
// 		print "</pre>";

?>