<?php
/** 
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TimespanTestCase.class.php,v 1.1 2005/05/12 22:44:45 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 * @since 5/3/05
 */

require_once(dirname(__FILE__)."/../Timespan.class.php");

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
 * @version $Id: TimespanTestCase.class.php,v 1.1 2005/05/12 22:44:45 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */

class TimespanTestCase extends UnitTestCase {
	
	/**
	*  Sets up unit test wide variables at the start
	*	 of each test method.
	*	 @access public
	*/
	function setUp() {
		$this->currentYear = date('Y');
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
		
	}
	
	/**
	 * Test some leap years.
	 * 
	 */
	function test_end() {
		$datA =& DateAndTime::withYearDay(2005, 125);
		$datB =& DateAndTime::withYearDay(2006, 125);
		
		$timespan =& Timespan::startingDuration(
				DateAndTime::withYearDay(2005, 125),
				Duration::withDays(365)
			);
		
		$this->assertEqual($timespan->startYear(), 2005);
		$this->assertEqual($timespan->dayOfYear(), 125);
		$duration =& $timespan->duration();
		$this->assertTrue($duration->isEqualTo(Duration::withDays(365)));
		$end =& $timespan->end();
		$this->assertEqual($end->julianDayNumber(), 2453860);
		$this->assertEqual(($end->julianDayNumber() - $datA->julianDayNumber()), 364);
		$this->assertEqual($end->year(), 2006);
		$this->assertEqual($end->dayOfYear(), 124);
		$this->assertTrue($end->isEqualTo(DateAndTime::withYearDayHourMinuteSecond(
			2006, 124, 23, 59, 59)));
	}	
	
}
?>