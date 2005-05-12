<?php
/** 
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: YearTestCase.class.php,v 1.1 2005/05/12 17:46:54 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 * @since 5/3/05
 */

require_once(dirname(__FILE__)."/../Month.class.php");

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
 * @version $Id: YearTestCase.class.php,v 1.1 2005/05/12 17:46:54 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */

class YearTestCase extends UnitTestCase {
	
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
		$epochYear =& Year::epoch();
		
		$this->assertEqual(strtolower(get_class($epochYear)), 'year');
		$this->assertEqual($epochYear->dayOfYear(), 1);
		$this->assertEqual($epochYear->daysInYear(), 365);
		
		$duration =& $epochYear->duration();
		$this->assertTrue($duration->isEqualTo(Duration::withDays(365)));
		$this->assertEqual($epochYear->startYear(), 1901);
		
		$current =& Year::current();
		$this->assertEqual($current->startYear(), $this->currentYear);
		
		$aYear =& Year::withYear(1999);
		$this->assertEqual($aYear->startYear(), 1999);
		$aYear =& Year::withYear(2005);
		$this->assertEqual($aYear->startYear(), 2005);
		
		$aYear =& Year::starting(DateAndTime::withYearDay(1982, 25));
		$this->assertEqual($aYear->startYear(), 1982);
		$this->assertEqual($aYear->dayOfYear(), 25);
		$this->assertEqual($aYear->daysInYear(), 365);
	}
	
	/**
	 * Test some leap years.
	 * 
	 */
	function test_leap_years() {
		// recent leap years
		$this->assertTrue(Year::isLeapYear(1980));
		$this->assertTrue(Year::isLeapYear(1984));
		$this->assertTrue(Year::isLeapYear(1988));
		$this->assertTrue(Year::isLeapYear(1992));
		$this->assertTrue(Year::isLeapYear(1996));
		$this->assertTrue(Year::isLeapYear(2000));
		$this->assertTrue(Year::isLeapYear(2004));
		$this->assertTrue(Year::isLeapYear(2008));
		
		// divisible-by 100 years
		$this->assertTrue(Year::isLeapYear(1600));
		$this->assertFalse(Year::isLeapYear(1700));
		$this->assertFalse(Year::isLeapYear(1800));
		$this->assertFalse(Year::isLeapYear(1900));
		$this->assertTrue(Year::isLeapYear(2000));
		$this->assertFalse(Year::isLeapYear(2100));
		$this->assertFalse(Year::isLeapYear(2200));
		$this->assertFalse(Year::isLeapYear(2300));
		$this->assertTrue(Year::isLeapYear(2400));
		
		// Non-leap years
		$this->assertFalse(Year::isLeapYear(1981));
		$this->assertFalse(Year::isLeapYear(1979));
		$this->assertFalse(Year::isLeapYear(1999));
		$this->assertFalse(Year::isLeapYear(2003));
		$this->assertFalse(Year::isLeapYear(2001));
		$this->assertFalse(Year::isLeapYear(1789));
		$this->assertFalse(Year::isLeapYear(2002));
		$this->assertFalse(Year::isLeapYear(1998));
		$this->assertFalse(Year::isLeapYear(2005));
	
		$aYear =& Year::starting(DateAndTime::withYearDay(1980, 55));
		$this->assertEqual($aYear->startYear(), 1980);
		$this->assertEqual($aYear->dayOfYear(), 55);
		$this->assertEqual($aYear->daysInYear(), 366);
		
		$aYear =& Year::withYear(1980);
		$this->assertEqual($aYear->startYear(), 1980);
		$this->assertEqual($aYear->dayOfYear(), 1);
		$this->assertEqual($aYear->daysInYear(), 366);
		
		$aYear =& Year::withYear(2000);
		$this->assertEqual($aYear->startYear(), 2000);
		$this->assertEqual($aYear->dayOfYear(), 1);
		$this->assertEqual($aYear->daysInYear(), 366);
	}	
	
}
?>