<?

//require_once(HARMONI."utilities/DateTime.interface.php");

/** 
 * Declares the functionallity for all Date classes.
 * @access public
 * @version $Id: DateTime.class.php,v 1.11 2004/01/14 20:09:42 gabeschine Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 7/20/2003
 * @package harmoni.utilities
 */
class DateTime {

	/**
	 * Year. 4-digit.
	 * @attribute private integer _year
	 */
	var $_year;
	
	/**
	 * Month. 1-12.
	 * @attribute private integer _month
	 */
	var $_month;
	
	/**
	 * Day. 1-31.
	 * @attribute private integer _day
	 */
	var $_day;
	
	/**
	 * Hours. 0-23.
	 * @attribute private integer _hours
	 */
	var $_hours;
	
	/**
	 * Minutes. 0-59.
	 * @attribute private integer _minutes
	 */
	var $_minutes;
	
	/**
	 * Seconds. 0-59.
	 * @attribute private integer _seconds
	 */
	var $_seconds;
	

	/**
	 * Get accessor for _year property.
	 *
	 * @access public
	 */
	function getYear() {
		return $this->_year;
	}
	
	/**
	 * Creates a new date.
	 * @access public
	 */
	function DateTime($year = 1970, $month = 1, $day = 1, 
					  $hours = 0, $minutes = 0, $seconds = 0) {
		// ** parameter validation
		$integerRule =& new NumericValidatorRule();
		ArgumentValidator::validate($year, $integerRule, true);

		$rangeRule =& new IntegerRangeValidatorRule(1, 12);
		ArgumentValidator::validate(intval($month), $rangeRule, true);

		$rangeRule =& new IntegerRangeValidatorRule(1, 31);
		ArgumentValidator::validate(intval($day), $rangeRule, true);
		
		$rangeRule =& new IntegerRangeValidatorRule(0, 23);
		ArgumentValidator::validate(intval($hours), $rangeRule, true);
		
		$rangeRule =& new IntegerRangeValidatorRule(0, 59);
		ArgumentValidator::validate(intval($minutes), $rangeRule, true);
		ArgumentValidator::validate(intval($seconds), $rangeRule, true);
		// ** end of parameter validation

		// make the year 1900+
		$year += ($year<1900)?1900:0;
		$year += ($year<1970)?100:0; // 2000+
		$this->_year = $year;
		$this->_month = $month;
		$this->_day = $day;
		$this->_hours = $hours;
		$this->_minutes = $minutes;
		$this->_seconds = $seconds;
	}
	
	/**
	 * Set accessor for _year property.
	 *
	 * @access public
	 */
	function setYear($year) {
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($year, $integerRule, true);

		$this->_year = $year;
	}
	
	
	/**
	 * Get accessor for _month property.
	 *
	 * @access public
	 */
	function getMonth() {
		return $this->_month;
	}
	
	
	/**
	 * Set accessor for _month property.
	 *
	 * @access public
	 */
	function setMonth($month) {
		$rangeRule =& new IntegerRangeValidatorRule(1, 12);
		ArgumentValidator::validate($month, $rangeRule, true);

		$this->_month = $month;
	}
	
	
	/**
	 * Get accessor for _day property.
	 *
	 * @access public
	 */
	function getDay() {
		return $this->_day;
	}
	
	
	/**
	 * Set accessor for _day property.
	 *
	 * @access public
	 */
	function setDay($day) {
		$rangeRule =& new IntegerRangeValidatorRule(1, 31);
		ArgumentValidator::validate($day, $rangeRule, true);

		$this->_day = $day;
	}
	
	
	/**
	 * Get accessor for _hours property.
	 *
	 * @access public
	 */
	function getHours() {
		return $this->_hours;
	}
	
	
	/**
	 * Set accessor for _hours property.
	 *
	 * @access public
	 */
	function setHours($hours) {
		$rangeRule =& new IntegerRangeValidatorRule(0, 23);
		ArgumentValidator::validate($hours, $rangeRule, true);

		$this->_hours = $hours;
	}
	
	
	/**
	 * Get accessor for _minutes property.
	 *
	 * @access public
	 */
	function getMinutes() {
		return $this->_minutes;
	}
	
	
	/**
	 * Set accessor for _minutes property.
	 *
	 * @access public
	 */
	function setMinutes($minutes) {
		$rangeRule =& new IntegerRangeValidatorRule(0, 59);
		ArgumentValidator::validate($minutes, $rangeRule, true);

		$this->_minutes = $minutes;
	}
	
	
	/**
	 * Get accessor for _seconds property.
	 *
	 * @access public
	 */
	function getSeconds() {
		return $this->_seconds;
	}
	
	
	/**
	 * Set accessor for _seconds property.
	 *
	 * @access public
	 */
	function setSeconds($seconds) {
		$rangeRule =& new IntegerRangeValidatorRule(0, 59);
		ArgumentValidator::validate($seconds, $rangeRule, true);

		$this->_seconds = $seconds;
	}
	
	/**
	 * Returns a string in the form of MM/DD/YY
	 * @return string
	 */
	function toMDY() {
		return $this->getMonth()."/".$this->getDay()."/".substr($this->getYear(),2,2);
	}
	
	/**
	 * Returns a string in the form of April 20, 2002 10:14 AM
	 * @return string
	 */
	function toString() {
		$months = array("January","February","March","April","May","June","July","August","September","October","November","December");
		$hours = $this->getHours();
		if ($hours > 12) $hours -= 12;
		if ($hours == 0) $hours = 12;
		return $months[$this->getMonth() - 1] . " " .
			sprintf("%d",$this->getDay()) . ", " .
			$this->getYear() . " " .
			$hours . ":" . sprintf("%02d",($this->getMinutes())) . " " . $this->getHoursAMPM();
	}
	
	/** 
	 * Returns either "AM" or "PM" based on the hours value.
	 * @return string
	 */
	function getHoursAMPM() {
		$hour = $this->getHours();
		if (($hour >= 0 && $hour < 12)) return "AM";
		return "PM";
	}
	
	/**
	 * Returns a unix timestamp from this date/time
	 * @return int
	 */
	function toTimestamp() {
		return mktime($this->_hours, $this->_minutes, $this->_seconds,
				$this->_month, $this->_day, $this->_year);
	}
	
	/**
	 * Returns a DateTime object corresponding to the current date and time.
	 * @method public now
	 * @static
	 * @return ref object A DateTime object corresponding to the current date and time.
	 */
	function & now() {
		$year = intval(date('Y'));
		$month = intval(date('m'));
		$day = intval(date('d'));
		$hours = intval(date('H'));
		$minutes = intval(date('i'));
		$seconds = intval(date('s'));
		return new DateTime($year, $month, $day, $hours, $minutes, $seconds);
	}
	
	/**
	 * Returns the difference in seconds between $date1 and $date2, positive if $date2 is more recent.
	 * @method public compare
	 * @static
	 * @param ref object $date1
	 * @param ref object $date2
	 * @return int
	 */
	function compare(&$date1, &$date2) {
		$time1 = $date1->toTimestamp();
		$time2 = $date2->toTimestamp();
		
		return $time2 - $time1;
	}


}




?>