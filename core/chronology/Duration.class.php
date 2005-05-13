<?php
/**
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Duration.class.php,v 1.8 2005/05/13 15:43:07 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once("ChronologyConstants.class.php");
require_once("Magnitude.class.php");

/**
 * I represent a duration of time. I have been tested to support durations of 
 * up to 4 billion (4,000,000,000) years with second precision and up to 
 * 50 billion (50,000,000) years with hour precision. Durations beyond 50 billion
 * years have not been tested.
 *
 * 
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Duration.class.php,v 1.8 2005/05/13 15:43:07 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class Duration 
	extends Magnitude
{
	
/*********************************************************
 * Class methods - Instance Creation
 *********************************************************/
 	
 	/**
 	 * Formatted as per ANSI 5.8.2.16: [-]D:HH:MM:SS[.S]
 	 * 
 	 * @param string $aString
 	 * @return object Duration
 	 * @access public
 	 * @since 5/13/05
 	 * @static
 	 */
 	function &fromString ( $aString ) {
 		die('Duration::fromString($aString) is not yet implented.');
 	}
 	
	/**
	 * Create a new instance of days...
	 * 
	 * @param integer $days
	 * @return object Duration
	 * @access public
	 * @static
	 * @since 5/3/05
	 */
	function &withDays ( $days ) {
		return Duration::withDaysHoursMinutesSeconds ( $days, 0, 0, 0 );
	}
	
	/**
	 * Create a new instance with.
	 * 
	 * @param integer $days
	 * @param integer $hours
	 * @param integer $minutes
	 * @param integer $seconds
	 * @return object Duration
	 * @access public
	 * @static
	 * @since 5/3/05
	 */
	function &withDaysHoursMinutesSeconds ( $days, $hours, $minutes, $seconds ) {
		return new Duration (
			  ($days * ChronologyConstants::SecondsInDay())
			+ ($hours * ChronologyConstants::SecondsInHour())
			+ ($minutes * ChronologyConstants::SecondsInMinute())
			+ $seconds);
			
	}
	
	/**
	 * Create a new Duration of hours...
	 * 
	 * @param integer $hours
	 * @return object Duration
	 * @access public
	 * @static
	 * @since 5/3/05
	 */
	function &withHours ( $hours ) {
		return Duration::withDaysHoursMinutesSeconds ( 0, $hours, 0, 0 );
	}
	
	/**
	 * Create a new instance of minutes...
	 * 
	 * @param integer $minutes
	 * @return object Duration
	 * @access public
	 * @static
	 * @since 5/3/05
	 */
	function &withMinutes ( $minutes ) {
		return Duration::withDaysHoursMinutesSeconds ( 0, 0, $minutes, 0 );
	}
	
	/**
	 * Create a new instance. aMonth is an Integer or a String
	 * 
	 * @param string $anIntOrStrMonth
	 * @return object Duration
	 * @access public
	 * @since 5/13/05
	 * @static
	 */
	function &withMonth ( $anIntOrStrMonth ) {
		$currentYear =& Year::current();
		$month =& Month::withMonthYear($anIntOrStrMonth, $currentYear->startYear());
		return $month->duration();
	}
	
	/**
	 * Create a new instance of seconds...
	 * 
	 * @param integer $seconds
	 * @return object Duration
	 * @access public
	 * @static
	 * @since 5/3/05
	 */
	function &withSeconds ( $seconds ) {
		return Duration::withDaysHoursMinutesSeconds ( 0, 0, 0, $seconds );
	}
	
	/**
	 * Create a new instance of a number of weeks
	 * 
	 * @param float $aNumber
	 * @return object Duration
	 * @access public
	 * @since 5/13/05
	 */
	function &withWeeks ( $aNumber ) {
		return Duration::withDaysHoursMinutesSeconds(($aNumber * 7), 0, 0, 0);
	}
	
	/**
 	 * Create a new Duration of zero length
 	 * 
 	 * @return object Duration
 	 * @access public
 	 * @since 5/5/05
 	 * @static
 	 */
 	function zero () {
 		return Duration::withDays(0);
 	}
	
	
/*********************************************************
 * 	Instance methods - Private
 *********************************************************/
	
	/**
	 * Initialize this Duration.
	 * 
	 * @param integer seconds
	 * @return object Duration
	 * @access private
	 * @since 5/3/05
	 */
	function Duration ($seconds = 0) {
		$this->seconds = $seconds;
	}
	
	/**
	 * Answer an array {days. seconds. nanoSeconds}. Used by DateAndTime and Time
	 * 
	 * @return array
	 * @access private
	 * @since 5/2/05
	 */
	function ticks () {
		return array(
			$this->days(),
			(($this->hours() * 3600) + ($this->minutes() * 60) + floor($this->seconds()))
		);
			
	}
	
/*********************************************************
 * Instance methods - Accessing
 *********************************************************/
	
	/**
	 * Answer the number of days the receiver represents.
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function days () {
		if ($this->isPositive())
			return floor($this->seconds/ChronologyConstants::SecondsInDay());
		else {
			return 0 - floor(abs($this->seconds)/ChronologyConstants::SecondsInDay());
		}
	}
	
	/**
	 * Answer the number of hours the receiver represents.
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function hours () {		
		// Above 2^31 seconds, (amost exactly 100 years), PHP converts the
		// variable from an integer to a float to allow it to grow larger.
		// While addition and subraction work fine with floats, float modulos 
		// and divisions loose precision. This precision loss does not affect
		// the proper value of days up to the maximum duration tested, 50billion
		// years.
		if (abs($this->seconds) > pow(2, 31)) {
			$remainderDuration =& $this->minus(Duration::withDays($this->days()));
			return $remainderDuration->hours();
		} else {
			if (!$this->isNegative())
				return floor(
					($this->seconds % ChronologyConstants::SecondsInDay()) 
					/ ChronologyConstants::SecondsInHour());
			else
				return 0 - floor(
					(abs($this->seconds) % ChronologyConstants::SecondsInDay()) 
					/ ChronologyConstants::SecondsInHour());
		}
	}
	
	/**
	 * Answer the number of minutes the receiver represents.
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function minutes () {
		// Above 2^31 seconds, (amost exactly 100 years), PHP converts the
		// variable from an integer to a float to allow it to grow larger.
		// While addition and subraction work fine with floats, float modulos 
		// and divisions loose precision. This precision loss does not affect
		// the proper value of days up to the maximum duration tested, 50billion
		// years.
		if (abs($this->seconds) > pow(2, 31)) {
			$remainderDuration =& $this->minus(Duration::withDays($this->days()));
			return $remainderDuration->minutes();
		} else {
			if (!$this->isNegative())
				return floor(
					($this->seconds % ChronologyConstants::SecondsInHour()) 
					/ ChronologyConstants::SecondsInMinute());
			else
				return 0 - floor(
					(abs($this->seconds) % ChronologyConstants::SecondsInHour()) 
					/ ChronologyConstants::SecondsInMinute());
		}
	}
	
	/**
	 * Format as per ANSI 5.8.2.16: [-]D:HH:MM:SS[.S]
	 * 
	 * @return string
	 * @access public
	 * @since 5/3/05
	 */
	function printableString () {		
		$result = '';
		
		if ($this->isNegative())
			$result .= '-';
		
		$result .= abs($this->days()).':';
		$result .= str_pad(abs($this->hours()), 2, '0', STR_PAD_LEFT).':';
		$result .= str_pad(abs($this->minutes()), 2, '0', STR_PAD_LEFT).':';
		$result .= str_pad(abs($this->seconds()), 2, '0', STR_PAD_LEFT);
		
		return $result;
	}
	
	/**
	 * Answer the number of seconds the receiver represents.
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function seconds () {
		// Above 2^31 seconds, (amost exactly 100 years), PHP converts the
		// variable from an integer to a float to allow it to grow larger.
		// While addition and subraction work fine with floats, float modulos 
		// and divisions loose precision. This precision loss does not affect
		// the proper value of days up to the maximum duration tested, 50billion
		// years.
		if (abs($this->seconds) > pow(2, 31)) {
			$remainderDuration =& $this->minus(Duration::withDays($this->days()));
			return $remainderDuration->seconds();
		} else {
			if ($this->isPositive())
				return floor($this->seconds % ChronologyConstants::SecondsInMinute());
			else
				return 0 - floor(
					abs($this->seconds) % ChronologyConstants::SecondsInMinute());
		}
	}
	
/*********************************************************
 * Instance methods - Comparing/Testing
 *********************************************************/
	
	/**
	 * Return true if this Duration is negative.
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isNegative () {
		return ($this->asSeconds() < 0);
	}
	
	/**
	 * Return true if this Duration is positive.
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isPositive () {
		return !($this->isNegative());
	}
	
	/**
	 * Test if this Duration is equal to aDuration.
	 * 
	 * @param object Duration $aDuration
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isEqualTo ( &$aDuration ) {
		return ($this->asSeconds() == $aDuration->asSeconds());
	}
	
	/**
	 * Test if this Duration is less than aDuration.
	 * 
	 * @param object Duration $aDuration
	 * @return boolean
	 * @access public
	 * @since 5/3/05
	 */
	function isLessThan ( &$aDuration ) {
		return ($this->asSeconds() < $aDuration->asSeconds());
	}
	
/*********************************************************
 * Instance methods - Operations
 *********************************************************/
	
	/**
	 * Return the absolute value of this duration.
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/3/05
	 */
	function &abs () {
		return new Duration (abs($this->seconds));
	}
	
	/**
	 * Divide a Duration. Operand is a Duration or a Number
	 * 
	 * @param object Duration $aDuration
	 * @return object Duration The result
	 * @access public
	 * @since 5/12/05
	 */
	function &dividedBy ( $operand ) {
		if (is_numeric($operand)) {
			return new Duration (intval($this->asSeconds() / $operand));
		} else {
			$denominator =& $operand->asDuration();
			return new Duration (intval($this->asSeconds() / $denominator->asSeconds()));
		}
	}
		
	/**
	 * Subtract a Duration.
	 * 
	 * @param object Duration $aDuration
	 * @return object Duration The result
	 * @access public
	 * @since 5/3/05
	 */
	function &minus ( &$aDuration ) {
		return $this->plus($aDuration->negated());
	}
	
	/**
	 * Multiply a Duration. Operand is a Duration or a Number
	 * 
	 * @param object Duration $aDuration
	 * @return object Duration The result
	 * @access public
	 * @since 5/12/05
	 */
	function &multipliedBy ( $operand ) {
		if (is_numeric($operand)) {
			return new Duration (intval($this->asSeconds() * $operand));
		} else {
			$duration =& $operand->asDuration();
			return new Duration (intval($this->asSeconds() * $duration->asSeconds()));
		}
	}
	
	/**
	 * Return the negative of this duration
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/10/05
	 */
	function &negated () {
		return new Duration(0 - $this->seconds);
	}
	
	/**
	 * Add a Duration.
	 * 
	 * @param object Duration $aDuration
	 * @return object Duration The result.
	 * @access public
	 * @since 5/3/05
	 */
	function &plus ( &$aDuration ) {
		return new Duration ($this->asSeconds() + $aDuration->asSeconds());
	}
	
	/**
	 * Round to a Duration.
	 * 
	 * @param object Duration $aDuration
	 * @return object Duration The result.
	 * @access public
	 * @since 5/3/05
	 */
	function &roundTo ( &$aDuration ) {
		return new Duration (
			intval(
				round(
					$this->asSeconds() / $aDuration->asSeconds())) 
			* $aDuration->asSeconds());
	}
	
	/**
	 * Truncate. 
	 * e.g. if the receiver is 5 minutes, 37 seconds, and aDuration is 2 minutes, 
	 * answer 4 minutes.
	 * 
	 * @param object Duration $aDuration
	 * @return object Duration
	 * @access public
	 * @since 5/13/05
	 */
	function &truncateTo ( &$aDuration ) {
		return new Duration (
			intval($this->asSeconds() / $aDuration->asSeconds())
			* $aDuration->asSeconds());
	}
	
	
/*********************************************************
 * Instance methods - Converting
 *********************************************************/
	
	/**
	 * Answer the duration in seconds.
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function asSeconds () {
		return $this->seconds;
	}
	
	/**
	 * Answer a Duration that represents this object.
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/4/05
	 */
	function &asDuration () {
		return $this;
	}
}

?>