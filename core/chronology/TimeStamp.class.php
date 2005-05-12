<?php
/**
 * @since 5/11/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TimeStamp.class.php,v 1.1 2005/05/12 00:03:15 adamfranco Exp $
 */ 
 
require_once("DateAndTime.class.php");

/**
 * This represents a duration of 0 length that marks a particular point in time.
 * 
 * @since 5/11/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TimeStamp.class.php,v 1.1 2005/05/12 00:03:15 adamfranco Exp $
 */
class TimeStamp
	extends DateAndTime 
{
		
/*********************************************************
 * Class Methods - Instance Creation
 *********************************************************/
	
	/**
	 * Answer a TimeStamp representing the Squeak epoch: 1 January 1901
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function &epoch ( $class = 'TimeStamp' ) {
		return parent::epoch($class);
	}
	
	/**
	 * Create a new TimeStamp for a given Julian Day Number.
	 * 
	 * @param integer $aJulianDayNumber
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function &withJulianDayNumber ( $aJulianDayNumber, $class = 'TimeStamp' ) {
		return parent::withJulianDayNumber($aJulianDayNumber, $class);
	}
	
	/**
	 * Create a new TimeStamp.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntDayOfYear
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	function &withYearDay ( $anIntYear, $anIntDayOfYear, $class = 'TimeStamp') {
		return parent::withYearDay ( $anIntYear, $anIntDayOfYear, $class );
	}
	
	/**
	 * Create a new TimeStamp.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntDayOfYear
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @param object Duration $aDurationOffset
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	function &withYearDayHourMinuteSecondOffset ( $anIntYear, $anIntDayOfYear, 
		$anIntHour, $anIntMinute, $anIntSecond, &$aDurationOffset, $class = 'TimeStamp' ) 
	{
		return parent::withYearDayHourMinuteSecondOffset ( $anIntYear, $anIntDayOfYear, 
			$anIntHour, $anIntMinute, $anIntSecond, $aDurationOffset, $class);
	}
	
	/**
	 * Create a new TimeStamp.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @access public
	 * @return object TimeStamp
 	 * @static
	 * @since 5/4/05
	 */
	function &withYearMonthDay ( $anIntYear, $anIntOrStringMonth, $anIntDay, 
		$class = 'DateAndTime' ) 
	{
		return parent::withYearMonthDay ( $anIntYear, $anIntOrStringMonth, $anIntDay, 
			$class);
	}
	
	/**
	 * Create a new TimeStamp.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	function &withYearMonthDayHourMinute ( $anIntYear, $anIntOrStringMonth, 
		$anIntDay, $anIntHour, $anIntMinute, $class = 'TimeStamp' ) 
	{
		return parent::withYearMonthDayHourMinute ( $anIntYear, $anIntOrStringMonth, 
			$anIntDay, $anIntHour, $anIntMinute, $class);
	}
	
	/**
	 * Create a new TimeStamp.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	function &withYearMonthDayHourMinuteSecond ( $anIntYear, $anIntOrStringMonth, 
		$anIntDay, $anIntHour, $anIntMinute, $anIntSecond, $class = 'TimeStamp' ) 
	{
		return parent::withYearMonthDayHourMinuteSecond ( $anIntYear, $anIntOrStringMonth, 
			$anIntDay, $anIntHour, $anIntMinute, $anIntSecond, $class);
	}
	
	/**
	 * Create a new TimeStamp.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @param integer $anIntHour
	 * @param integer $anIntMinute
	 * @param integer $anIntSecond
	 * @param object Duration $aDurationOffset
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
 	 * @static
	 * @since 5/4/05
	 */
	function &withYearMonthDayHourMinuteSecondOffset ( $anIntYear, 
		$anIntOrStringMonth, $anIntDay, $anIntHour, $anIntMinute, 
		$anIntSecond, &$aDurationOffset, $class = 'TimeStamp'  ) 
	{
		return parent::withYearMonthDayHourMinuteSecondOffset ( $anIntYear, 
			$anIntOrStringMonth, $anIntDay, $anIntHour, $anIntMinute, 
			$anIntSecond, $aDurationOffset, $class);
	}
	
/*********************************************************
 * Instance methods - Converting
 *********************************************************/
 	
 	/**
	 * Answer a Timestamp that represents this DateAndTime
	 * 
	 * @return object TimeStamp
	 * @access public
	 * @since 5/5/05
	 */
	function &asTimeStamp () {
		return $this;
	}
}

?>