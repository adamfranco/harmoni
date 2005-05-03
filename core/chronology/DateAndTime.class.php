<?php
/**
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DateAndTime.class.php,v 1.1 2005/05/03 23:55:39 adamfranco Exp $
 */ 

require_once("ChronologyConstants.class.php");
require_once("TimeZone.class.php");

/**
 * I represent a point in UTC time as defined by ISO 8601. I have zero duration.
 *
 * My implementation uses three SmallIntegers and a Duration:
 * jdn		- julian day number.
 * seconds	- number of seconds since midnight.
 * nanos	- the number of nanoseconds since the second.
 * 
 * offset	- duration from UTC.
 *
 * The nanosecond attribute is almost always zero but it defined for full ISO 
 * compliance and is suitable for timestamping.
 * 
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DateAndTime.class.php,v 1.1 2005/05/03 23:55:39 adamfranco Exp $
 */
class DateAndTime {
		
	/**
	 * Answer a DateAndTime representing the Squeak epoch: 1 January 1901
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function &epoch () {
		return DateAndTime::julianDayNumber(ChronologyConstants::SqueakEpoch());
	}
	
	/**
	 * Create a new DateAndTime for a given Julian Day Number.
	 * 
	 * @param integer $aJulianDayNumber
	 * @return object DateAndTime
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function &julianDayNumber ($aJulianDayNumber) {
		$days =& Duration::withDays($aJulianDayNumber);
		$ticks = $days->ticks();
		$dateAndTime =& new DateAndTime();
		$dateAndTime->ticksOffset($ticks, DateAndTime::localOffset());
		return $dateAndTime;
	}
	
	/**
	 * Answer the duration we are offset from UTC
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/3/05
	 */
	function &localOffset () {
		$timeZone =& DateAndTime::localTimeZone();
		return $timeZone->offset();
	}
	
	/**
	 * Answer the local TimeZone
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/3/05
	 */
	function &localTimeZone () {
		$tzAbbreviation = date('T');
		$tzOffset = date('O');
		if ($tzAbbreviation && $tzOffset)
			return TimeZone::offsetNameAbbreviation(
						Duration::withHours($tzOffset),
						$tzAbbreviation,
						$tzAbbreviation);
		else
			return TimeZone::defaultTimeZone();
	}
	
	/**
	 * Initialize this DateAndTime.
	 * ticks is {julianDayNumber. secondCount. nanoSeconds}
	 * 
	 * @param array $ticks
	 * @param object Duration $utcOffset
	 * @return void
	 * @access public
	 * @since 5/2/05
	 */
	function ticksOffset ( $ticks, $utcOffset ) {
//		$this->_normalize($ticks, 2, ChronologyConstants::NanosInSecond());
		$this->_normalize($ticks, 1, ChronologyConstants::SecondsInDay());
		
		$this->jdn = $ticks[0];
		$this->seconds = $ticks[1];
//		$this->nanos = $ticks[2];
		$this->offset =& $utcOffset;
	}
	
	/**
	 * Normalize tick values to make things like "2 days, 35 hours" into
	 * "3 days, 9 hours".
	 * 
	 * @param array $ticks
	 * @param integer $i The index of the array to normalize.
	 * @param integer $base The base to normalize to.
	 * @return void
	 * @access private
	 * @since 5/3/05
	 */
	function _normalize (&$ticks, $i, $base) {
		$tick = $ticks[$i];
		$quo = floor($tick/$base);
		$rem = $tick % $base;
		if ($rem < 0) {
			$quo = $quo-1;
			$rem = $base + $rem;
		}
		$ticks[$i-1] = $ticks[$i-1]+$quo;
		$ticks[$i] = $rem;
	}
	
	/**
	 * Return an array with the following elements:
	 *	'dd' 	=> day of the year
	 *	'mm'	=> month
	 *	'yyyy'	=> year
	 *
	 * The algorithm is from Squeak's DateAndTime>>dayMonthYearDo: method.
	 * 
	 * @return array
	 * @access public
	 * @since 5/3/05
	 */
	function dayMonthYearArray () {
		$l = $this->jdn + 68569;
		$n = 4 * floor($l / 146097);
		$l = $l - floor(((146097 * $n) + 3) / 4);
		$i = floor((4000 * ($l + 1)) / 1461001);
		$l = ($l - (1461 * floor($i / 4))) + 31;
		$j = floor((80 * $l) / 2447);
		$dd = $l - (floor((2447 * $j) / 80));
		$l = floor($j / 11);
		$mm = $j + 2 - (12 * $l);
		$yyyy = (100 * ($n - 49)) + i + $l;
		
		return array('dd' => $dd, 'mm' => $mm, 'yyyy' => $yyyy);
	}
	
	/**
	 * Answer the year
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function year () {
		$array = $this->dayMonthYearArray();
		return $array['yyyy'];
	}
	
	/**
	 * Answer the month
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function month () {
		$array = $this->dayMonthYearArray();
		return $array['mm'];
	}
	
	/**
	 * Answer the day
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function day () {
		$array = $this->dayMonthYearArray();
		return $array['dd'];
	}
}

?>