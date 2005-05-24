<?php
/** 
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TimeTestCase.class.php,v 1.3 2005/05/24 23:09:19 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 * @since 5/3/05
 */

require_once(dirname(__FILE__)."/../Time.class.php");

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
 * @version $Id: TimeTestCase.class.php,v 1.3 2005/05/24 23:09:19 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */

class TimeTestCase extends UnitTestCase {
	
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
		$sTime =& Time::withSeconds(55510);
		$hmsTime =& Time::withHourMinuteSecond(15, 25, 10);
		
		$this->assertEqual($sTime->asSeconds(), 55510);
		$this->assertEqual($hmsTime->asSeconds(), 55510);
		
		$this->assertEqual($sTime->hour(), 15);
		$this->assertEqual($hmsTime->hour(), 15);
		
		$this->assertEqual($sTime->minute(), 25);
		$this->assertEqual($hmsTime->minute(), 25);
		
		$this->assertEqual($sTime->second(), 10);
		$this->assertEqual($hmsTime->second(), 10);
	}
	
	/**
	 * Test instance creation from a string.
	 * 
	 */
	function test_from_string () {
		$time =& Time::withHourMinuteSecond(0, 0, 0);
		$this->assertTrue($time->isEqualTo(Time::fromString('2005-08-20')));
		
		$time =& Time::withHourMinuteSecond(15, 25, 10);
		$this->assertTrue($time->isEqualTo(Time::fromString('2005-08-20T15:25:10-07:00')));
		$this->assertTrue($time->isEqualTo(Time::fromString('2005-08-20T15:25:10')));
		$this->assertTrue($time->isEqualTo(Time::fromString('20050820152510')));
		$this->assertTrue($time->isEqualTo(Time::fromString('15:25:10')));
		$this->assertTrue($time->isEqualTo(Time::fromString('3:25:10 pm')));
		
		$time =& Time::withHourMinuteSecond(15, 25, 0);
		$this->assertTrue($time->isEqualTo(Time::fromString('15:25')));
		$this->assertTrue($time->isEqualTo(Time::fromString('3:25 pm')));
		$this->assertTrue($time->isEqualTo(Time::fromString('3:25 PM')));
		$this->assertTrue($time->isEqualTo(Time::fromString('3:25PM')));
		
		$time =& Time::withHourMinuteSecond(15, 0, 0);
		$this->assertTrue($time->isEqualTo(Time::fromString('3pm')));
		
		$time =& Time::withHourMinuteSecond(8, 25, 0);
		$this->assertTrue($time->isEqualTo(Time::fromString('8:25')));
		$this->assertTrue($time->isEqualTo(Time::fromString('8:25AM')));
		
	}
	
}
?>