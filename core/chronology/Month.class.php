<?php
/**
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Month.class.php,v 1.7 2005/05/23 15:38:44 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once("Timespan.class.php");

/**
 * I represent a month.
 * 
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Month.class.php,v 1.7 2005/05/23 15:38:44 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class Month 
	extends Timespan
{

/*********************************************************
 * Class Methods
 *********************************************************/
		
	/**
	 * Return the index of a string Month.
	 * 
	 * @param string $aNameString
	 * @return integer
	 * @access public
	 * @since 5/4/05
	 * @static
	 */
	function indexOfMonth ( $aNameString ) {
		foreach (ChronologyConstants::MonthNames() as $i => $name) {
			if (preg_match("/$aNameString.*/i", $name))
				return $i;
		}
		
		$errorString = $aNameString ." is not a recognized month name.";
		if (function_exists('throwError'))
			throwError(new Error($errorString));
		else
			die ($errorString);
	}
	
	/**
	 * Return the name of the month at index.
	 * 
	 * @param integer $anInteger
	 * @return string
	 * @access public
	 * @since 5/4/05
	 * @static
	 */
	function nameOfMonth ( $anInteger ) {
		$names = ChronologyConstants::MonthNames();
		if ($names[$anInteger])
			return $names[$anInteger];
		
		$errorString = $anInteger ." is not a valid month index.";
		if (function_exists('throwError'))
			throwError(new Error($errorString));
		else
			die ($errorString);
	}
	
	/**
	 * Answer the days in this month on a given year.
	 * 
	 * @param string $indexOrNameString
	 * @param ingteger $yearInteger
	 * @return integer
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function daysInMonthForYear ( $indexOrNameString, $yearInteger ) {
		if (is_numeric($indexOrNameString))
			$index = $indexOrNameString;
		else
			$index = Month::indexOfMonth($indexOrNameString);
		
		if ($index < 1 | $index > 12) {
			$errorString = $index ." is not a valid month index.";
			if (function_exists('throwError'))
				throwError(new Error($errorString));
			else
				die ($errorString);
		}
		
		$monthDays = ChronologyConstants::DaysInMonth();
		$days = $monthDays[$index];
		
		if ($index == 2 && Year::isLeapYear($yearInteger))
			return $days + 1;
		else
			return $days;
	}
	
/*********************************************************
 * Class Methods - Instance Creation
 *
 * All static instance creation methods have an optional
 * $class parameter which is used to get around the limitations 
 * of not being	able to find the class of the object that 
 * recieved the initial method call rather than the one in
 * which it is implemented. These parameters SHOULD NOT BE
 * USED OUTSIDE OF THIS PACKAGE.
 *********************************************************/
 
 	/**
	 * Answer a new object that represents now.
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Month
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &current ( $class = 'Month' ) {
		return parent::current($class);
	}
	
	/**
	 * Answer a Month starting on the Squeak epoch: 1 January 1901
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Month
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &epoch ( $class = 'Month' ) {
		return parent::epoch($class);
	}
	
	/**
	 * Create a new object starting now, with zero duration
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Month
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &starting ( &$aDateAndTime, $class = 'Month' ) {
		return parent::starting($aDateAndTime, $class);
	}
	
	/**
	 * Create a new object with given start and end DateAndTimes
	 * 
	 * @param object DateAndTime $startDateAndTime
	 * @param object DateAndTime $endDateAndTime
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Month
	 * @access public
	 * @since 5/11/05
	 */
	function &startingEnding ( &$startDateAndTime, &$endDateAndTime, 
		$class = 'Month' ) 
	{
		return parent::startingEnding ( $startDateAndTime, $endDateAndTime, $class);
	}
	
		
	/**
	 * Create a new object starting now, with a given duration. 
	 * Override - as each month has a defined duration
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @param object Duration $aDuration
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Month
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &startingDuration ( &$aDateAndTime, &$aDuration, $class = 'Month' ) {
		
		// Validate our passed class name.
		if (!(strtolower($class) == strtolower('Month')
			|| is_subclass_of(new $class, 'Month')))
		{
			die("Class, '$class', is not a subclass of 'Month'.");
		}
		
		$start =& $aDateAndTime->asDateAndTime();
		$adjusted =& DateAndTime::withYearMonthDay($start->year(), $start->month(), 1);
		$days = Month::daysInMonthForYear($adjusted->month(), $adjusted->year());
		
		$month =& new $class;
		$month->setStart($adjusted);
		$month->setDuration(Duration::withDays($days));
		
		return $month;
	}
	
	/**
	 * Create a Month for the given <year> and <month>.
	 * <month> may be a number or a String with the
	 * name of the month. <year> should be with 4 digits.
	 * 
	 * @param string $anIntegerOrStringMonth
	 * @param integer $anIntegerYear Four-digit year.
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Month
	 * @access public
	 * @since 5/11/05
	 */
	function &withMonthYear ( $anIntegerOrStringMonth, $anIntegerYear, 
		$class = 'Month' ) 
	{
		eval('$result =& '.$class.'::starting(DateAndTime::withYearMonthDay(
			$anIntegerYear, $anIntegerOrStringMonth, 1), $class);');
		return $result;
	}

	
/*********************************************************
 * Instance methods - Accessing
 *********************************************************/
	
	/**
	 * Answer the number of days
	 * 
	 * @return integer
	 * @access public
	 * @since 5/5/05
	 */
	function daysInMonth () {
		return $this->duration->days();
	}

/*********************************************************
 * Instance methods - Operations
 *********************************************************/

	/**
	 * Answer the previous object of our duration.
	 * 
	 * @return object Timespan
	 * @access public
	 * @since 5/10/05
	 */
	function &previous () {
		eval('$result =& '.get_class($this).'::startingDuration(
 			$this->start->minus(Duration::withDays(1)),
 			$this->duration,
 			'.get_class($this).');');
 		return $result;
	}

}

?>