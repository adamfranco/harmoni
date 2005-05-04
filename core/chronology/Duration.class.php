<?php
/**
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Duration.class.php,v 1.2 2005/05/04 20:18:31 adamfranco Exp $
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
 * @version $Id: Duration.class.php,v 1.2 2005/05/04 20:18:31 adamfranco Exp $
 */
class Duration 
	extends Magnitude
{
	
/*********************************************************
 * Class methods
 *********************************************************/
 
	/**
	 * Create a new Duration of days...
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
	 * Create a new Duration of minutes...
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
	 * Create a new Duration of seconds...
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
	 * Create a new Duration with.
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
	
	
/*********************************************************
 * 	Instance methods
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
	 * Answer the number of days the receiver represents.
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function days () {
		if (!$this->isNegative())
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
			if (!$this->isNegative())
				return floor($this->seconds % ChronologyConstants::SecondsInMinute());
			else
				return 0 - floor(
					abs($this->seconds) % ChronologyConstants::SecondsInMinute());
		}
	}
	
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
	
/*********************************************************
 * Comparing/Testing
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
 * Operations
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
		return new Duration ($this->asSeconds() + $aDuration->asSeconds());
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
		return new Duration ($this->asSeconds() - $aDuration->asSeconds());
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
	 * Format as per ANSI 5.8.2.16: [-]D:HH:MM:SS[.S]
	 * 
	 * @return string
	 * @access public
	 * @since 5/3/05
	 */
	function printableString () {
		$d = abs($this->days());
		$h = abs($this->hours());
		$m = abs($this->minutes());
		$s = abs($this->seconds());
		
		$result = '';
		
		if ($this->isNegative())
			$result .= '-';
		
		$result .= $d.':';
		
		if ($h < 10)
			$result .= '0';
		$result .= $h.':';
		
		if ($m < 10)
			$result .= '0';
		$result .= $m.':';
		
		if ($s < 10)
			$result .= '0';
		$result .= $s;
		
		return $result;
	}
	
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
	 * Answer an array {days. seconds. nanoSeconds}. Used by DateAndTime and Time
	 * 
	 * @return array
	 * @access public
	 * @since 5/2/05
	 */
	function ticks () {
		return array(
			$this->days(),
			(($this->hours() * 3600) + ($this->minutes() * 60) + floor($this->seconds()))
		);
			
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