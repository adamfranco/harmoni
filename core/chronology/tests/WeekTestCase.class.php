<?php
/** 
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: WeekTestCase.class.php,v 1.2 2005/05/20 23:04:28 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 * @since 5/3/05
 */

require_once(dirname(__FILE__)."/../Date.class.php");

/**
 * A single unit test case. This class is intended to test one particular
 * class. Replace 'testedclass.php' below with the class you would like to
 * test.
 *
 * @since 5/3/05
 *
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: WeekTestCase.class.php,v 1.2 2005/05/20 23:04:28 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */

class WeekTestCase extends UnitTestCase {
	
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
	 * Test the creation methods.
	 */ 
	function test_creation() {
		$epoch =& Week::epoch();
		
		$this->assertEqual(strtolower(get_class($epoch)), 'week');
		$this->assertEqual($epoch->startYear(), 1900);
		$this->assertEqual($epoch->startMonth(), 12);
		$this->assertEqual($epoch->dayOfMonth(), 30);
		$this->assertEqual($epoch->startMonthName(), 'December');
		$start =& $epoch->start();
		$this->assertEqual($start->hour(), 0);
		$this->assertEqual($start->minute(), 0);
		$this->assertEqual($start->second(), 0);
		
		$duration =& $epoch->duration();
		$this->assertTrue($duration->isEqualTo(Duration::withDays(7)));
		
		
		$week =& Week::starting(DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 5, 4, 15, 25, 10, Duration::withHours(-4)));
		
		$this->assertEqual(strtolower(get_class($week)), 'week');
		$this->assertEqual($week->startYear(), 2005);
		$this->assertEqual($week->startMonth(), 5);
		$this->assertEqual($week->dayOfMonth(), 1);
		$start =& $week->start();
		$this->assertEqual($start->hour(), 0);
		$this->assertEqual($start->minute(), 0);
		$this->assertEqual($start->second(), 0);
		$this->assertEqual($week->startMonthName(), 'May');
		$duration =& $week->duration();
		$this->assertEqual($duration->days(), 7);
		$this->assertTrue($week->isEqualTo(
			Week::starting(DateAndTime::withYearMonthDayHourMinuteSecondOffset(
							2005, 5, 3, 15, 25, 10, Duration::withHours(-4)))));
	}
	
	/**
	 * Test instance creation from a string.
	 * 
	 */
	function test_from_string () {
		$this->assertEqual('fromString() is tested', 'Yes');
	}
	
}
?>