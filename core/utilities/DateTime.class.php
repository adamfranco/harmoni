<?

require_once(HARMONI."dataManager/Primitive.interface.php");

/** 
 * Declares the functionallity for all Date classes.
 *
 * @package harmoni.utilities
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DateTime.class.php,v 1.23 2005/03/29 19:44:47 adamfranco Exp $
 * @since Created: 7/20/2003
 */
class DateTime 
	extends Primitive // This extention is put here because lots of this require 
					  // the Time primitive, which gets its functionality from 
					  // DateTime. Because PHP doesn't allow implementation of
					  // multiple interfaces, and many packages validate for 
					  // primitives, the "Time" class needed to extend primitive,
					  // but couldn't its self.
					  // This extension is improper and should be move to the Time
					  // class in PHP5.
{

	/**
	 * Year. 4-digit.
	 * @var integer _year 
	 * @access private
	 */
	var $_year;
	
	/**
	 * Month. 1-12.
	 * @var integer _month 
	 * @access private
	 */
	var $_month;
	
	/**
	 * Day. 1-31.
	 * @var integer _day 
	 * @access private
	 */
	var $_day;
	
	/**
	 * Hours. 0-23.
	 * @var integer _hours 
	 * @access private
	 */
	var $_hours;
	
	/**
	 * Minutes. 0-59.
	 * @var integer _minutes 
	 * @access private
	 */
	var $_minutes;
	
	/**
	 * Seconds. 0-59.
	 * @var integer _seconds 
	 * @access private
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
/*		$integerRule =& NumericValidatorRule::getRule();
		ArgumentValidator::validate($year, $integerRule, true);

		$rangeRule =& IntegerRangeValidatorRule::getRule(1, 12);
		ArgumentValidator::validate(intval($month), $rangeRule, true);

		$rangeRule =& IntegerRangeValidatorRule::getRule(1, 31);
		ArgumentValidator::validate(intval($day), $rangeRule, true);
		
		$rangeRule =& IntegerRangeValidatorRule::getRule(0, 23);
		ArgumentValidator::validate(intval($hours), $rangeRule, true);
		
		$rangeRule =& IntegerRangeValidatorRule::getRule(0, 59);
		ArgumentValidator::validate(intval($minutes), $rangeRule, true);
		ArgumentValidator::validate(intval($seconds), $rangeRule, true);*/
		// ** end of parameter validation

		// do not assume a range for year
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
		$integerRule =& IntegerValidatorRule::getRule();
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
		$rangeRule =& IntegerRangeValidatorRule::getRule(1, 12);
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
		$rangeRule =& IntegerRangeValidatorRule::getRule(1, 31);
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
		$rangeRule =& IntegerRangeValidatorRule::getRule(0, 23);
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
		$rangeRule =& IntegerRangeValidatorRule::getRule(0, 59);
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
		$rangeRule =& IntegerRangeValidatorRule::getRule(0, 59);
		ArgumentValidator::validate($seconds, $rangeRule, true);

		$this->_seconds = $seconds;
	}
	
	/**
	 * Set the date from a timestamp
	 *
	 * @access public
	 */
	function setDate($timestamp) {
		$year = date('Y', $timestamp);
		$this->setYear(intval($year));
		
		$month = date('n', $timestamp);
		$this->setMonth(intval($month));
		
		$day = date('j', $timestamp);
		$this->setDay(intval($day));
		
		$hour = date('G', $timestamp);
		$this->setHours(intval($hour));
		
		$min = date('i', $timestamp);
		$this->setMinutes(intval($min));
		
		$sec = date('s', $timestamp);
		$this->setSeconds(intval($sec));
	}
	
	/**
	 * Returns a string in the form of MM/DD/YY
	 * @return string
	 */
	function toMDY() {
		return intval($this->getMonth())."/".intval($this->getDay())."/".substr($this->getYear(),2,2);
	}
	
	/**
	 * Returns a string in the form of April 20, 2002 10:14 AM
	 * @param optional boolean $short If specified, will print out a M/D/Y date instead of the full string.
	 * @return string
	 */
	function toString($short=false) {

		return ($short?$this->toMDY():$this->toDateString()) . " " . $this->toTimeString();
	}

	/**
	 * Returns a time string in the form of 11:14 AM.
	 * @access public
	 * @return string
	 */
	function toTimeString()
	{
		$hours = $this->getHours();
		if ($hours > 12) $hours -= 12;
		if ($hours == 0) $hours = 12;
		return $hours . ":" . sprintf("%02d",($this->getMinutes())) . " " . $this->getHoursAMPM();
	}
	
	/**
	 * Returns a date string in the form of April 20, 2002.
	 * @access public
	 * @return string
	 */
	function toDateString()
	{
		$months = array("January","February","March","April","May","June","July","August","September","October","November","December");
		return $months[$this->getMonth() - 1] . " " .
			sprintf("%d",$this->getDay()) . ", " .
			$this->getYear();
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
	 * Modifies the stored date/time based on a string you pass.
	 * @param string $string A string of the form "+2 days" or "-3 months", etc.
	 * @access public
	 * @return void
	 */
	function modify($string)
	{
		$newTime = strtotime($string, $this->toTimestamp());
		if ($newTime) $this->setDate($newTime);
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
	 * @access public
	 * @static
	 * @return ref object A DateTime object corresponding to the current date and time.
	 */
	function &now() {
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
	 * @access public
	 * @static
	 * @param ref object $date1
	 * @param ref object $date2
	 * @return int
	 */
	function compare(&$date1, &$date2) {
		// ** parameter validation
		$extendsRule =& ExtendsValidatorRule::getRule("DateTime");
		ArgumentValidator::validate($date1, $extendsRule, true);
		ArgumentValidator::validate($date2, $extendsRule, true);
		// ** end of parameter validation

		$time1 = $date1->toTimestamp();
		$time2 = $date2->toTimestamp();
		
		return $time2 - $time1;
	}
	
	/**
	 * Returns an array indexed 0-11 of the months.
	 * @return array
	 * @static
	 */
	function getMonthsArray() {
		return array(
			"January",
			"February",
			"March",
			"April",
			"May",
			"June",
			"July",
			"August",
			"September",
			"October",
			"November",
			"December"
		);
	}

	/**
	 * Returns an array indexed 0-11 of the months shortened to three letters.
	 * @return array
	 * @static
	 */
	function getShortMonthsArray() {
		return array(
			"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
	}

}




?>
