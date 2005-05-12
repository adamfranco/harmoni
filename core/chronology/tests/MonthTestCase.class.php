<?php
/** 
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MonthTestCase.class.php,v 1.1 2005/05/12 00:04:03 adamfranco Exp $
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
 * @version $Id: MonthTestCase.class.php,v 1.1 2005/05/12 00:04:03 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */

class MonthTestCase extends UnitTestCase {
	
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
		$epochMonth =& Month::epoch();
		
		$this->assertEqual(strtolower(get_class($epochMonth)), 'month');
		$this->assertEqual($epochMonth->dayOfMonth(), 1);
		$this->assertEqual($epochMonth->dayOfYear(), 1);
		$this->assertEqual($epochMonth->daysInMonth(), 31);
		$this->assertEqual($epochMonth->startMonthIndex(), 1);
		$this->assertEqual($epochMonth->startMonthName(), 'January');
		$this->assertEqual($epochMonth->startMonthAbbreviation(), 'Jan');
		
		$duration =& $epochMonth->duration();
		$this->assertTrue($duration->isEqualTo(Duration::withDays(31)));
	}
	
	
	
}
?>