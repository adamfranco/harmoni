<?php
/**
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DateAndTime.class.php,v 1.3 2005/05/05 00:09:59 adamfranco Exp $
 */ 

require_once("ChronologyConstants.class.php");
require_once("Magnitude.class.php");
require_once("Month.class.php");
require_once("TimeZone.class.php");
require_once("Week.class.php");
require_once("Year.class.php");

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
 * @version $Id: DateAndTime.class.php,v 1.3 2005/05/05 00:09:59 adamfranco Exp $
 */
class DateAndTime 
	extends Magnitude
{

/*********************************************************
 * Class Methods
 *********************************************************/
		
	/**
	 * Answer a DateAndTime representing the Squeak epoch: 1 January 1901
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function &epoch () {
		return DateAndTime::withJulianDayNumber(ChronologyConstants::SqueakEpoch());
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
	function &withJulianDayNumber ($aJulianDayNumber) {
		$days =& Duration::withDays($aJulianDayNumber);
		
		$dateAndTime =& new DateAndTime();
		$dateAndTime->ticksOffset($days->ticks(), DateAndTime::localOffset());
		return $dateAndTime;
	}
	
	/**
	 * Create a new DateAndTime.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntDayOfYear
	 * @access public
	 * @since 5/4/05
	 */
	function &withYearDay ( $anIntYear, $anIntDayOfYear) {
		return DateAndTime::withYearDayHourMinuteSecondOffset(
				$anIntYear,
				$anIntDayOfYear, 
				0, 
				0, 
				0,
				$null = NULL
			);
	}
	
	/**
	 * Create a new DateAndTime.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntDayOfYear
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @param object Duration $aDurationOffset
	 * @return object DateAndTime
	 * @access public
	 * @since 5/4/05
	 */
	function &withYearDayHourMinuteSecondOffset ( $anIntYear, $anIntDayOfYear, 
		$anIntHour, $anIntMinute, $anIntSecond, &$aDurationOffset ) 
	{
		$year =& DateAndTime::withYearMonthDayHourMinuteSecondOffset(
				$anIntYear,
				1, 
				1, 
				0, 
				0, 
				0,
				$aDurationOffset
			);
		$day =& Duration::withDays($anIntDayOfYear - 1);
		return $year->plus($day);
	}
	
	/**
	 * Create a new DateAndTime.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @access public
	 * @since 5/4/05
	 */
	function &withYearMonthDay ( $anIntYear, 
		$anIntOrStringMonth, $anIntDay) 
	{
		return DateAndTime::withYearMonthDayHourMinuteSecondOffset(
				$anIntYear,
				$anIntOrStringMonth, 
				$anIntDay, 
				0, 
				0, 
				0,
				$null = NULL
			);
	}
	
	/**
	 * Create a new DateAndTime.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @access public
	 * @since 5/4/05
	 */
	function &withYearMonthDayHourMinute ( $anIntYear, 
		$anIntOrStringMonth, $anIntDay, $anIntHour, 
		$anIntMinute) 
	{
		return DateAndTime::withYearMonthDayHourMinuteSecondOffset(
				$anIntYear,
				$anIntOrStringMonth, 
				$anIntDay, 
				$anIntHour, 
				$anIntMinute, 
				0,
				$null = NULL
			);
	}
	
	/**
	 * Create a new DateAndTime.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @return object DateAndTime
	 * @access public
	 * @since 5/4/05
	 */
	function &withYearMonthDayHourMinuteSecond ( $anIntYear, 
		$anIntOrStringMonth, $anIntDay, $anIntHour, 
		$anIntMinute, $anIntSecond) 
	{
		return DateAndTime::withYearMonthDayHourMinuteSecondOffset(
				$anIntYear,
				$anIntOrStringMonth, 
				$anIntDay, 
				$anIntHour, 
				$anIntMinute, 
				$anIntSecond,
				$null = NULL
			);
	}
	
	/**
	 * Create a new DateAndTime.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @param object Duration $aDurationOffset
	 * @return object DateAndTime
	 * @access public
	 * @since 5/4/05
	 */
	function &withYearMonthDayHourMinuteSecondOffset ( $anIntYear, 
		$anIntOrStringMonth, $anIntDay, $anIntHour, 
		$anIntMinute, $anIntSecond, &$aDurationOffset ) 
	{
		if (is_numeric($anIntOrStringMonth))
			$monthIndex = $anIntOrStringMonth;
		else
			$monthIndex = Month::indexOfMonth($anIntOrStringMonth);
		
		$p = intval(($monthIndex - 14) / 12);
		$q = $anIntYear + 4800 + $p;
		$r = $monthIndex - 2 - (12 * $p);
		$s = intval(($anIntYear + 4900 + p) / 100);
		
		$julianDayNumber = 		intval((1461 * $q) / 4)
							+ 	intval((367 * $r) / 12)
							-	intval((3 * $s) / 4)
							+	($anIntDay - 32075);		
		
		$since =& Duration::withDaysHoursMinutesSeconds($julianDayNumber,
				$anIntHour, $anIntMinute, $anIntSecond);
				
		if (is_null($aDurationOffset))
			$offset =& DateAndTime::localOffset();
		else
			$offset =& $aDurationOffset;
		
		$dateAndTime =& new DateAndTime();
		$dateAndTime->ticksOffset($since->ticks(), $offset);
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
	
	
/*********************************************************
 * 	Instance Methods
 *********************************************************/
	
	/**
	 * Initialize this DateAndTime.
	 * ticks is {julianDayNumber. secondCount. nanoSeconds}
	 * 
	 * @param array $ticks
	 * @param object Duration $utcOffset
	 * @return void
	 * @access private
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
	 * Private - answer an array with our instance variables. Assumed to be UTC
	 * 
	 * @return array
	 * @access private
	 * @since 5/4/05
	 */
	function ticks () {
		return array ($this->jdn, $this->seconds);
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
		$n = floor((4 * $l) / 146097);
		$l = $l - floor(((146097 * $n) + 3) / 4);
		$i = floor((4000 * ($l + 1)) / 1461001);
		$l = ($l - floor((1461 * $i) / 4)) + 31;
		$j = floor((80 * $l) / 2447);
		$dd = $l - (floor((2447 * $j) / 80));
		$l = floor($j / 11);
		$mm = $j + 2 - (12 * $l);
		$yyyy = (100 * ($n - 49)) + $i + $l;
		return array('dd' => $dd, 'mm' => $mm, 'yyyy' => $yyyy);
	}
	
/*********************************************************
 * Accessing
 *********************************************************/
 	
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
	
	/**
	 * Answer the day of the month
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function dayOfMonth () {
		return $this->day();
	}
	
	/**
	 * Answer the day of the week
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function dayOfWeek () {
		$x = $this->jdn + 1;
		return ($x - (intval($x / 7) * 7)) + 1;
	}
	
	/**
	 * Answer the day of the week abbreviation
	 * 
	 * @return string
	 * @access public
	 * @since 5/3/05
	 */
	function dayOfWeekAbbreviation () {
		return substr($this->dayOfWeekName(), 0, 3);
	}
	
	/**
	 * Answer the day of the week name
	 * 
	 * @return string
	 * @access public
	 * @since 5/3/05
	 */
	function dayOfWeekName () {
		return Week::nameOfDay($this->dayOfWeek());
	}
	
	/**
	 * Answer the day of the year
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function dayOfYear () {
		$thisYear =& Year::withYear($this->year());
		$start =& $thisYear->start();
		return ($this->jdn - $start->julianDayNumber() + 1);
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
		$duration =& Duration::withSeconds($this->seconds);
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
	 * Return if this year is a leap year
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/4/05
	 */
	function isLeapYear () {
		return Year::isLeapYear($this->year());
	}
	
	/**
	 * Return the JulianDayNumber of this DateAndTime
	 * 
	 * @return integer
	 * @access public
	 * @since 5/4/05
	 */
	function julianDayNumber () {
		return $this->jdn;
	}
	
	/**
	 * Answer a DateAndTime starting at midnight local time
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/3/05
	 */
	function &midnight () {
		return DateAndTime::withYearMonthDay($this->year(), $this->month(), $this->day());
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
	 * Answer the day of the week abbreviation
	 * 
	 * @return string
	 * @access public
	 * @since 5/3/05
	 */
	function monthAbbreviation () {
		return substr($this->monthName(), 0, 3);
	}
	
	/**
	 * Answer the index of the month.
	 * 
	 * @return integer
	 * @access public
	 * @since 5/3/05
	 */
	function monthIndex () {
		return $this->month();
	}
	
	/**
	 * Answer the name of the month.
	 * 
	 * @return string
	 * @access public
	 * @since 5/3/05
	 */
	function monthName () {
		return Month::nameOfMonth($this->month());
	}
	
	/**
	 * Answer the offset
	 * 
	 * @return object Duration
	 * @access public
	 * @since 5/3/05
	 */
	function &offset () {
		return $this->offset;
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
	
/*********************************************************
 * Comparing/Testing
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

		if (!method_exists($comparand, 'asDateAndTime'))
			return FALSE;
		
		$comparandAsDateAndTime =& $comparand->asDateAndTime();
		
		if ($this->offset->isEqualTo($comparandAsDateAndTime->offset())) {
			$myTicks = $this->ticks();
			$comparandTicks = $comparandAsDateAndTime->ticks();
		} else {
			$meAsUTC =& $this->asUTC();
			$myTicks = $meAsUTC->ticks();
			$comparandAsUTC =& $comparandAsDateAndTime->asUTC();
			$comparandTicks = $comparandAsUTC->ticks();
		}
		
		if ($myTicks[0] != $comparandTicks[0])
			return FALSE;
		else
			return ($myTicks[1] == $comparandTicks[1]);
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
		$comparandAsDateAndTime =& $comparand->asDateAndTime();
		
		if ($this->offset->isEqualTo($comparandAsDateAndTime->offset())) {
			$myTicks = $this->ticks();
			$comparandTicks = $comparandAsDateAndTime->ticks();
		} else {
			$meAsUTC =& $this->asUTC();
			$myTicks = $meAsUTC->ticks();
			$comparandAsUTC =& $comparandAsDateAndTime->asUTC();
			$comparandTicks = $comparandAsUTC->ticks();
		}
		
		if ($myTicks[0] < $comparandTicks[0])
			return TRUE;
		else
			return (($myTicks[0] == $comparandTicks[0]) 
				&& ($myTicks[1] < $comparandTicks[1]));
	}
	

/*********************************************************
 * Operations
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
 * Converting
 *********************************************************/
	
	/**
	 * Answer a DateAndTime that represents this object
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/4/05
	 */
	function &asDateAndTime () {
		return $this;
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
		return Duration::withSeconds($this->seconds());
	}
	
	/**
	 * Answer a DateAndTime equivalent to the reciever, but at UTC (offset = 0)
	 * 
	 * @return object DateAndTime
	 * @access public
	 * @since 5/4/05
	 */
	function &asUTC () {
		return $this->utcOffset(Duration::withHours(0));
	}
	
	/**
	 * Answer a <DateAndTime> equivalent to the receiver but offset from UTC by aDuration
	 * 
	 * @param object Duration $aDuration
	 * @return object DateAndTime
	 * @access public
	 * @since 5/4/05
	 */
	function &utcOffset ( &$aDuration ) {
		$equiv =& $this->plus($aDuration->minus($this->offset()));
		$equiv->ticksOffset($equiv->ticks(), $aDuration);
		return $equiv;
	}
}

?>