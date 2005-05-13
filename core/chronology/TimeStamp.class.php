<?php
/**
 * @since 5/11/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TimeStamp.class.php,v 1.6 2005/05/13 16:11:35 adamfranco Exp $
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
 * @version $Id: TimeStamp.class.php,v 1.6 2005/05/13 16:11:35 adamfranco Exp $
 */
class TimeStamp
	extends DateAndTime 
{
		
/*********************************************************
 * Class Methods - Instance Creation
 *
 * All static instance creation methods have an optional
 * $class parameter which is used to get around the limitations 
 * of not being	able to find the class of the object that 
 * recieved the initial method call rather than the one in
 * which it is implemented. These parameters SHOULD NOT BE
 * USED OUTSIDE OF THIS PACKAGE.
 *********************************************************/
 	
 	/**
 	 * Answer a TimeStamp representing now
 	 * 
 	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
 	 * @access public
 	 * @since 5/13/05
 	 */
 	function &current ( $class = 'TimeStamp' ) {
 		eval('$result =& '.$class.'::now();');
 		return $result;
 	}
	
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
	 * Answer a new instance represented by a string:
	 * 
	 *	'-1199-01-05T20:33:14.321-05:00' 
	 *	' 2002-05-16T17:20:45.00000001+01:01' 
  	 *	' 2002-05-16T17:20:45.00000001' 
 	 *	' 2002-05-16T17:20' 
	 *	' 2002-05-16T17:20:45' 
	 *	' 2002-05-16T17:20:45+01:57' 
 	 *	' 2002-05-16T17:20:45-02:34' 
 	 *	' 2002-05-16T17:20:45+00:00' 
	 *	' 1997-04-26T01:02:03+01:02:3'  
	 *
	 * @param string $aString The input string.
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	function &fromString ( $aString, $class = 'TimeStamp' ) {
		return parent::fromString( $aString, $class);
	}
	
	/**
	 * Answer a new instance starting at midnight local time.
	 * This is a hybrid class/instance method that can either return today
	 * at midnight (called statically) or midnight on a certain date (called
	 * on an instance).
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/3/05
	 * @static
	 */
	function &midnight ( $class = 'TimeStamp' ) {
		return parent::midnight( $class );
	}
	
	/**
	 * Answer the current time.
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	function &now ( $class = 'TimeStamp' ) {
		return parent::now( $class );
	}
	
	/**
	 * Answer a new instance starting at noon local time.
	 * This is a hybrid class/instance method that can either return today
	 * at noon (called statically) or noon on a certain date (called
	 * on an instance).
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/3/05
	 * @static
	 */
	function &noon ( $class = 'TimeStamp' ) {
		return parent::noon( $class );
	}
	
	/**
	 * Answer a new instance representing today
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	function &today ( $class = 'TimeStamp' ) {
		return parent::today( $class );
	}
	
	/**
	 * Answer a new instance representing tomorow
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	function &tomorrow ( $class = 'TimeStamp' ) {
		return parent::tomorrow( $class );
	}
	
	/**
	 * Create a new instance from Date and Time objects
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	function &withDateAndTime ( &$aDate, &$aTime, $class = 'TimeStamp' ) {
		return parent::withDateAndTime( $aDate, $aTime, $class );
	}
	
	/**
	 * Create a new instance for a given Julian Day Number.
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
	 * Create a new instance.
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
	 * Create a new instance.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntDayOfYear
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
	function &withYearDayHourMinuteSecond ( $anIntYear, $anIntDayOfYear, 
		$anIntHour, $anIntMinute, $anIntSecond, $class = 'TimeStamp' ) 
	{
		return parent::withYearDayHourMinuteSecond ( $anIntYear, $anIntDayOfYear, 
			$anIntHour, $anIntMinute, $anIntSecond, $class);
	}
	
	/**
	 * Create a new instance.
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
	 * Create a new instance.
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
		$class = 'Timestamp' ) 
	{
		return parent::withYearMonthDay ( $anIntYear, $anIntOrStringMonth, $anIntDay, 
			$class);
	}
	
	/**
	 * Create a new instance.
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
	 * Create a new instance.
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
	 * Create a new instance.
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
	
	/**
	 * Answer a new instance representing yesterday
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object TimeStamp
	 * @access public
	 * @since 5/12/05
	 * @static
	 */
	function &yesterday ( $class = 'TimeStamp' ) {
		return parent::yesterday($class);
	}

/*********************************************************
 * Instance methods - Accessing
 *********************************************************/
 
 	/**
 	 * Print receiver's date and time
 	 * 
 	 * @return string
 	 * @access public
 	 * @since 5/13/05
 	 */
 	function printableString () {
 		$date =& $this->date();
 		$time =& $this->time();
 		return $date->printableString().' '.$time->printableString();
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
	
	/**
	 * Answer the date of the receiver.
	 * 
	 * @return object Date
	 * @access public
	 * @since 5/13/05
	 */
	function &date () {
		return $this->asDate();
	}
	
	/**
	 * Answer a two element Array containing the receiver's date and time.
	 * 
	 * @return array
	 * @access public
	 * @since 5/13/05
	 */
	function &dateAndTimeArray () {
		return array (
			$this->date(),
			$this->time()
		);
	}
	
	/**
	 * Answer a TimeStamp which is anInteger days before the receiver.
	 * 
	 * @param integer $anInteger
	 * @return object TimeStamp
	 * @access public
	 * @since 5/13/05
	 */
	function &minusDays ( $anInteger ) {
		return $this->minus(Duration::withDays($anIntager));
	}
	
	/**
	 * Answer a TimeStamp which is anInteger seconds before the receiver.
	 * 
	 * @param integer $anInteger
	 * @return object TimeStamp
	 * @access public
	 * @since 5/13/05
	 */
	function &minusSeconds ( $anInteger ) {
		return $this->minus(Duration::withSeconds($anIntager));
	}
	
	/**
	 * Answer a TimeStamp which is anInteger days after the receiver.
	 * 
	 * @param integer $anInteger
	 * @return object TimeStamp
	 * @access public
	 * @since 5/13/05
	 */
	function &plusDays ( $anInteger ) {
		return $this->plus(Duration::withDays($anIntager));
	}
	
	/**
	 * Answer a TimeStamp which is anInteger seconds after the receiver.
	 * 
	 * @param integer $anInteger
	 * @return object TimeStamp
	 * @access public
	 * @since 5/13/05
	 */
	function &plusSeconds ( $anInteger ) {
		return $this->plus(Duration::withSeconds($anIntager));
	}
	
	/**
	 * Answer the time of the receiver.
	 * 
	 * @return object Time
	 * @access public
	 * @since 5/13/05
	 */
	function &time () {
		return $this->asTime();
	}
}

?>