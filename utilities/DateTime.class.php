<?

require_once(HARMONI."DateTime.interface.php");

/** 
 * Declares the functionallity for all Date classes.
 * @access public
 * @version $Id: DateTime.class.php,v 1.1 2003/07/20 17:43:26 dobomode Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @date Created: 7/20/2003
 * @package harmoni.utilities;
 */
class DateTime implements DateTimeInterface {


	/**
	 * Year. Any.
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
	 * @attribute private itneger _seconds
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
	function DateTime($year = 1981, $month = 10, $day = 24, 
					  $hours = 8, $minutes = 30, $seconds = 0) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($year, $integerRule, true);

		$rangeRule =& new IntegerRangeValidatorRule(1, 12);
		ArgumentValidator::validate($month, $rangeRule, true);

		$rangeRule =& new IntegerRangeValidatorRule(1, 31);
		ArgumentValidator::validate($day, $rangeRule, true);
		
		$rangeRule =& new IntegerRangeValidatorRule(0, 23);
		ArgumentValidator::validate($hours, $rangeRule, true);
		
		$rangeRule =& new IntegerRangeValidatorRule(0, 59);
		ArgumentValidator::validate($minutes, $rangeRule, true);
		ArgumentValidator::validate($seconds, $rangeRule, true);
		// ** end of parameter validation

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
		$this->_seconds = $seconds;
	}
	
		
}




?>