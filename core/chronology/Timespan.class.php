<?php
/**
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Timespan.class.php,v 1.6 2005/05/12 00:03:15 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 

require_once("Magnitude.class.php");

/**
 * Timespan represents a duration starting at a specific DateAndTime.
 *
 * Due to PHP's lack of decent date/time objects, handling of dates and times in
 * Harmoni here-to-for required swapping between various timestamp and date string 
 * represtations and other simple chronological objects that were never very 
 * universal. 
 * 
 * This package is a PHP implemenation of the Squeak (Smalltalk)
 * Kernel-Chronology package. The original Smalltalk implementation is licensed
 * under the Squeak License {@link http://squeak.org/download/license.html}.
 * 
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Timespan.class.php,v 1.6 2005/05/12 00:03:15 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class Timespan 
	extends Magnitude
{

	/**
	 * @var object DateAndTime $start; The starting point of this time-span 
	 * @access private
	 * @since 5/11/05
	 */
	var $start;
	
	/**
	 * @var object Duration $duration; The duration of this time-span. 
	 * @access private
	 * @since 5/11/05
	 */
	var $duration;

/*********************************************************
 * Class Methods - Instance Creation
 *********************************************************/
	/**
	 * Answer a new object that represents now.
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Timespan
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &current ( $class = 'Timespan' ) {
		eval('$result =& '.$class.'::starting(DateAndTime::now(), $class);');
		
		return $result;
	}
	
	/**
	 * Answer a Timespan starting on the Squeak epoch: 1 January 1901
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Timespan
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &epoch ( $class = 'Timespan' ) {
		eval('$result =& '.$class.'::starting(DateAndTime::epoch(), $class);');
		
		return $result;
	}
	
	/**
	 * Create a new object starting now, with zero duration
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Timespan
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &starting ( &$aDateAndTime, $class = 'Timespan' ) {
		eval('$result =& '.$class.'::startingDuration(
				$aDateAndTime, Duration::zero(), $class);');
		
		return $result;
	}
	
	/**
	 * Create a new object
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @param object Duration $aDuration
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Timespan
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &startingDuration ( &$aDateAndTime, &$aDuration, $class = 'Timespan' ) {
		
		// Validate our passed class name.
		if (!(strtolower($class) == strtolower('Timespan')
			|| is_subclass_of(new $class, 'Timespan')))
		{
			die("Class, '$class', is not a subclass of 'Timespan'.");
		}
		
		$timeSpan =& new $class;
		$timeSpan->setStart($aDateAndTime);
		$timeSpan->setDuration($aDuration);
		
		return $timeSpan;
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
	 * @return object Timespan
	 * @access public
	 * @since 5/11/05
	 */
	function &startingEnding ( &$startDateAndTime, &$endDateAndTime, $class = 'Timespan' ) 
	{
		$end =& $endDateAndTime->asDateAndTime();
		eval('$result =& '.$class.'::startingDuration(
			$startDateAndTime,
			$end->minus($startDateAndTime),
			$class);');
		
		return $result;
	}
	
/*********************************************************
 * Instance Methods - Private
 *********************************************************/
 
	/**
	 * Do not use this constructor for building objects, please use the 
	 * class-methods Timespan::new(), Timespan::starting(), etcetera, instead.
	 * 
	 * @return object Timespan
	 * @access private
	 * @since 5/2/05
	 */
	function Timespan () {
		
	}

	/**
	 * Store the start DateAndTime of this timespan
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @return void
	 * @access private
	 * @since 5/4/05
	 */
	function setStart ( &$aDateAndTime ) {
		$this->start =& $aDateAndTime;
	}
	
	/**
	 * Set the Duration of this timespan
	 * 
	 * @param object Duration $aDuration
	 * @return void
	 * @access private
	 * @since 5/4/05
	 */
	function setDuration ( &$aDuration ) {
		$this->duration =& $aDuration;
	}

/*********************************************************
 * Instance methods - Comparing/Testing
 *********************************************************/
	
	/**
	 * Test if this Timespan is equal to a Timespan.
	 * 
	 * @param object Timespan $aTimespan
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isEqualTo ( &$aTimespan ) {
		return ($this->start->isEqualTo($aTimespan->start())
			&& $this->duration->isEqualTo($aTimespan->duration()));
	}
	
	/**
	 * Test if this Timespan is less than a comparand.
	 * 
	 * @param object $aComparand
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isLessThan ( &$aComparand ) {
		return ($this->start->isLessThan($aComparand));
	}

/*********************************************************
 * Instance methods - Operations
 *********************************************************/
	
	/**
	 * Add a Duration.
	 * 
	 * @param object Duration $aDuration
	 * @return object Duration The result.
	 * @access public
	 * @since 5/3/05
	 */
	function &plus ( &$aDuration ) {
		$classname = get_class($this);
		
		$operation = $classname.'::startingDuration($this->start, 
			$this->duration->plus($aDuration));';
		
		return eval($operation);
	}
	
	/**
	 * Subtract a Duration or DateAndTime.
	 * 
	 * @param object $operand
	 * @return object
	 * @access public
	 * @since 5/3/05
	 */
	function &minus ( &$operand ) {
		$methods = get_class_methods($operand);
		
		// If this conforms to the DateAndTimeProtocal
		if (in_array('asdateandtime', $methods) 
			| in_array('asDateAndTime', $methods)) 
		{
			return $this->start->minus($operand);
		} 
		// If this conforms to the Duration protocal
		else {
			return $this->plus($operand->negated());
		}
	}

	/**
	 * Answer the next object of our duration.
	 * 
	 * @return object Timespan
	 * @access public
	 * @since 5/10/05
	 */
	function &next () {
		$classname = get_class($this);
		
		$operation = $classname.'::startingDuration(
			$this->start->plus($this->duration), $this->duration);';
		
		return eval($operation);
	}
	
	/**
	 * Answer the previous object of our duration.
	 * 
	 * @return object Timespan
	 * @access public
	 * @since 5/10/05
	 */
	function &previous () {
		$classname = get_class($this);
		
		$operation = $classname.'::startingDuration(
			$this->start->minus($this->duration), $this->duration);';
		
		return eval($operation);
	}
	
/*********************************************************
 * Instance Methods - Accessing
 *********************************************************/
 	
 	/**
 	 * Answer the day of the month represented by the receiver.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function dayOfMonth () {
 		return $this->start->dayOfMonth();
 	}
 	
 	/**
 	 * Answer the day of the week represented by the receiver.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function dayOfWeek () {
 		return $this->start->dayOfWeek();
 	}
 	
 	/**
 	 * Answer the day of the week represented by the receiver.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function dayOfWeekName () {
 		return $this->start->dayOfWeekName();
 	}
 	
 	/**
 	 * Answer the day of the year represented by the receiver.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function dayOfYear () {
 		return $this->start->dayOfYear();
 	}
 	
 	/**
 	 * Answer the Duration of this timespan
 	 * 
 	 * @return object Duration
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function &duration () {
 		return $this->duration;
 	}
 	
 	/**
 	 * Answer the end of this timespan
 	 * 
 	 * @return object DateAndTime
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function &end () {
 		$next =& $this->next();
 		$nextStart =& $next->start();
 		return $nextStart->minus(DateAndTime::clockPrecision());
 	}
 	
 	/**
 	 * Answer TRUE if the year represented by the receiver is a leap year.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function isLeapYear () {
 		return $this->start->isLeapYear();
 	}
 	
 	/**
 	 * Answer the Julian day number represented by the reciever.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function julianDayNumber () {
 		return $this->start->julianDayNumber();
 	}
 	
 	/**
 	 * Answer the month represented by the receiver.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function startMonth () {
 		return $this->start->isLeapYear();
 	}
 	
 	/**
 	 * Answer the month represented by the receiver.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function startMonthAbbreviation () {
 		return $this->start->monthAbbreviation();
 	}
 	
 	/**
 	 * Answer the month represented by the receiver.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function startMonthIndex () {
 		return $this->start->monthIndex();
 	}
 	
 	/**
 	 * Answer the month represented by the receiver.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function startMonthName () {
 		return $this->start->monthName();
 	}
 	
 	/**
 	 * Answer the start DateAndTime of this timespan
 	 * 
 	 * @return object DateAndTime
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function &start () {
 		return $this->start;
 	}
 	
 	/**
 	 * Answer the year represented by the receiver.
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/11/05
 	 */
 	function startYear () {
 		print "<pre>";
 		var_export($this);
 		if (!is_object($this->start))
 			print_r(debug_backtrace());
 		return $this->start->year();
 	}
}

require_once("DateAndTime.class.php");

?>