<?php
/**
 * @since 5/5/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Time.class.php,v 1.4 2005/05/20 23:03:19 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 

require_once("ChronologyConstants.class.php");
require_once("Magnitude.class.php");
require_once("Month.class.php");
require_once("TimeZone.class.php");
require_once("Week.class.php");
require_once("Year.class.php");

/**
 * This represents a period of time.
 *
 * My implementation uses one SmallIntegers:
 * seconds	- number of seconds since midnight.
 * 
 * @since 5/5/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Time.class.php,v 1.4 2005/05/20 23:03:19 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class Time 
	extends Magnitude
{

	/**
	 * @var integer $seconds; The seconds from midnight of this time 
	 * @access private
	 * @since 5/11/05
	 */
	var $seconds;

/*********************************************************
 * Class Methods - Instance Creation
 *********************************************************/
	
	/**
	 * Create a new Time.
	 * 
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @return object Time
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	function &withHourMinuteSecond ($anIntHour, $anIntMinute, $anIntSecond ) 
	{
		return Time::withSeconds(
							  ($anIntHour * ChronologyConstants::SecondsInHour())
							+ ($anIntMinute * ChronologyConstants::SecondsInMinute())
							+ $anIntSecond);
	}
	
	/**
	 * Create a new Time
	 * 
	 * @param integer $anIntSeconds
	 * @return object Time
	 * @access public
	 * @since 5/5/05
	 */
	function withSeconds ( $anIntSeconds ) {
		$time = new Time;
		$time->setSeconds($anIntSeconds);
		return $time;
	}
	
	
/*********************************************************
 * 	Instance Methods - Private
 *********************************************************/
	
	/**
	 * Set our seconds
	 * 
	 * @param ingteger $anIntSeconds
	 * @return void
	 * @access private
	 * @since 5/5/05
	 */
	function setSeconds ( $anIntSeconds ) {
		$this->seconds = $anIntSeconds;
	}
	
	/**
	 * Private - answer an array with our instance variables. Assumed to be UTC
	 * 
	 * @return array
	 * @access private
	 * @since 5/4/05
	 */
	function ticks () {
		return array ($this->seconds);
	}
	
/*********************************************************
 * Instance Methods - Accessing
 *********************************************************/
	
	/**
	 * Answer the duration of this object (always zero)
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/5/05
	 */
	function &duration () {
		return Duration::zero();
	}
	
	/**
	 * Answer the hours (0-23)
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function hour () {
		return $this->hour24();
	}
	
	/**
	 * Answer the hours (0-23)
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function hour24 () {
		$duration =& $this->asDuration();
		return $duration->hours();
	}
	
	/**
	 * Answer an <integer> between 1 and 12, inclusive, representing the hour 
	 * of the day in the 12-hour clock of the local time of the receiver.
	 * 
	 * @return integer
	 * @access public
	 * @since 5/4/05
	 */
	function hour12 () {
		$x = ($this->hour24() - 1) % 12;
		if ($x < 0)
			$x = $x + 12;
		return $x + 1;
	}
	
	/**
	 * Return the Meridian Abbreviation ('AM'/'PM')
	 * 
	 * @return string
	 * @access public
	 * @since 5/5/05
	 */
	function meridianAbbreviation () {
		if ($this->hour() < 12)
			return 'AM';
		else
			return 'PM';
	}
	
	/**
	 * Answer a DateAndTime starting at midnight local time
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/3/05
	 */
	function &midnight () {
		$dAndT =& DateAndTime::withYearMonthDay($this->year(), $this->month(), $this->dayOfMonth());
		return $dAndT;
	}
	
	/**
	 * Answer the miniute (0-59)
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function minute () {
		$duration =& Duration::withSeconds($this->seconds);
		return $duration->minutes();
	}
	
	/**
	 * Format is 'h:mm:ss am'  or, if showSeconds is false, 'h:mm am'
	 * 
	 * @param optional boolean $showSeconds
	 * @return string
	 * @access public
	 * @since 5/20/05
	 */
	function string12 ( $showSeconds = TRUE ) {
		if ($this->hour() > 12)
			$result .= $this->hour() - 12;
		else
			$result .= $this->hour();
		
		$result .= ':';
		$result .= str_pad(abs($this->minute()), 2, '0', STR_PAD_LEFT);
		
		if ($showSeconds) {
			$result .= ':';
			$result .= str_pad(abs($this->second()), 2, '0', STR_PAD_LEFT);
		}
		
		if ($this->hour() > 12)
			$result .= ' pm';
		else
			$result .= ' am';
		
		return $result;
	}
	
	/**
	 * Format is 'hh:mm:ss' or, if showSeconds is false, 'hh:mm'
	 * 
	 * @param optional boolean $showSeconds
	 * @return string
	 * @access public
	 * @since 5/20/05
	 */
	function string24 ( $showSeconds = TRUE ) {
		$result .= str_pad(abs($this->hour()), 2, '0', STR_PAD_LEFT);
		$result .= ':';
		$result .= str_pad(abs($this->minute()), 2, '0', STR_PAD_LEFT);
		
		if ($showSeconds) {
			$result .= ':';
			$result .= str_pad(abs($this->second()), 2, '0', STR_PAD_LEFT);
		}
		
		return $result;
	}
	
	/**
	 * Format is 'h:mm<:ss> am'
	 * 
	 * @return string
	 * @access public
	 * @since 5/20/05
	 */
	function printableString () {
		return $this->string12(($this->second() != 0));
	}
	
	/**
	 * Answer the second (0-59)
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function second () {
		$duration =& Duration::withSeconds($this->seconds);
		return $duration->seconds();
	}
	
/*********************************************************
 * Instance methods - Comparing/Testing
 *********************************************************/
	/**
	 * comparand conforms to protocol DateAndTime,
	 * or can be converted into something that conforms.
	 * 
	 * @param object $comparand
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isEqualTo ( &$comparand ) {
		if ($this === $comparand)
			return TRUE;

		if (!strtolower(get_class($comparand)) == 'time' 
			&& !is_subclass_of($comparand, 'Time'))
			return FALSE;
				
		$myTicks = $this->ticks();
		$comparandTicks = $comparand->ticks();
		
		return ($myTicks[0] == $comparandTicks[0]);
	}
	
	/**
	 * comparand conforms to protocol DateAndTime,
	 * or can be converted into something that conforms.
	 * 
	 * @param object $comparand
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isLessThan ( &$comparand ) {
		$myDuration =& $this->asDuration();
		return $myDuration->isLessThan($comparand->asDuration());
	}
	

/*********************************************************
 * Instance methods - Operations
 *********************************************************/
 
	/**
	 * Answer a new Duration whose our date + operand. The operand must implement
	 * asDuration().
	 * 
	 * @param object $operand
	 * @return object DateAndTime
	 * @access public
	 * @since 5/4/05
	 */
	function &plus ( &$operand ) {
		die("need to implement Time::plus()");
		$ticks = array();
		$duration =& $operand->asDuration();
		$durationTicks = $duration->ticks();
		
		foreach ($this->ticks() as $key => $value) {
			$ticks[$key] = $value + $durationTicks[$key];
		}
		
		$result =& new DateAndTime();
		$result->ticksOffset($ticks, $this->offset());
		return $result;
	}
	

/*********************************************************
 * Instance methods - Converting
 *********************************************************/
	
	/**
	 * Answer a Date that represents this object
	 * 
	 * @return object Date
	 * @access public
	 * @since 5/5/05
	 */
	function &asDate () {
		return Date::today();
	}
	
	/**
	 * Answer a DateAndTime that represents this object
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/4/05
	 */
	function &asDateAndTime () {
		$dateAndTime =& DateAndTime::today();
		return $dateAndTime->plus($this);
	}
	
	/**
	 * Answer a Duration that represents this object, the duration since
	 * midnight.
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/4/05
	 */
	function &asDuration () {
		return Duration::withSeconds($this->seconds);
	}
	
	/**
	 * Answer the month that represents this date's month
	 * 
	 * @return object Month
	 * @access public
	 * @since 5/5/05
	 */
	function &asMonth () {
		$asDateAndTime =& $this->asDateAndTime();
		return $asDateAndTime->asMonth();
	}
	
	/**
	 * Answer the number of seconds since midnight of the receiver.
	 * 
	 * @return integer
	 * @access public
	 * @since 5/5/05
	 */
	function asSeconds () {
		return $this->seconds;
	}
	
	/**
	 * Answer a Time that represents our time component
	 * 
	 * @return object Time
	 * @access public
	 * @since 5/5/05
	 */
	function &asTime () {
		return $this;
	}
	
	/**
	 * Answer a Timestamp that represents this DateAndTime
	 * 
	 * @return object TimeStamp
	 * @access public
	 * @since 5/5/05
	 */
	function &asTimeStamp () {
		$asDateAndTime =& $this->asDateAndTime();
		return $asDateAndTime->asTimeStamp();
	}
	
	/**
	 * Answer this time as a Week
	 * 
	 * @return object Year
	 * @access public
	 * @since 5/5/05
	 */
	function &asWeek () {
		$asDateAndTime =& $this->asDateAndTime();
		return $asDateAndTime->asWeek();
	}
	
	/**
	 * Answer this time as a Year
	 * 
	 * @return object Year
	 * @access public
	 * @since 5/5/05
	 */
	function &asYear () {
		$asDateAndTime =& $this->asDateAndTime();
		return $asDateAndTime->asYear();
	}
}

?>