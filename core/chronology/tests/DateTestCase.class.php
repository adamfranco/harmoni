<?php
/** 
 * @package harmoni.chronology.tests
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DateTestCase.class.php,v 1.1 2005/05/13 13:50:10 adamfranco Exp $
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
 * @version $Id: DateTestCase.class.php,v 1.1 2005/05/13 13:50:10 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */

class DateTestCase extends UnitTestCase {
	
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
		$epoch =& Date::epoch();
		
		$this->assertEqual(strtolower(get_class($epoch)), 'date');
		$this->assertEqual($epoch->dayOfMonth(), 1);
		$this->assertEqual($epoch->dayOfYear(), 1);
		$this->assertEqual($epoch->startMonthIndex(), 1);
		$this->assertEqual($epoch->startMonthName(), 'January');
		$this->assertEqual($epoch->startMonthAbbreviation(), 'Jan');
		
		$duration =& $epoch->duration();
		$this->assertTrue($duration->isEqualTo(Duration::withDays(1)));
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