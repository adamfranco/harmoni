<?php
/**
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Date.class.php,v 1.2 2005/05/12 17:45:08 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once("Timespan.class.php");
require_once("DateAndTime.class.php");

/**
 * Instances of Date are Timespans with duration of 1 day.
 * Their default creation assumes a start of midnight in the local time zone.
 * 
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Date.class.php,v 1.2 2005/05/12 17:45:08 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class Date 
	extends Timespan
{

/*********************************************************
 * Class Methods
 *********************************************************/
		
	
	
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
	 * Answer a new object that represents now.
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Date
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &current ( $class = 'Date' ) {
		return parent::current($class);
	}
	
	/**
	 * Answer a Date starting on the Squeak epoch: 1 January 1901
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Date
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &epoch ( $class = 'Date' ) {
		return parent::epoch($class);
	}
	
	/**
	 * Read a Date from the stream in any of the forms:  
	
*		<day> <monthName> <year>		(5 April 1982; 5-APR-82)  
	
*		<monthName> <day> <year>		(April 5, 1982)  
	
*		<monthNumber> <day> <year>		(4/5/82) 
	 *		<day><monthName><year>			(5APR82)
	 *		<four-digit year><two-digit monthNumber><two-digit day>	(19820405; 1982-04-05)
	 * 
	 * @param string $aString
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Date
	 * @access public
	 * @since 5/10/05
	 */
	function &fromString ( $aString, $class = 'Date' ) {
		$day = NULL;
		$month = NULL;
		$year = NULL;
		
		// <day> <monthName> <year>		(5 April 1982; 5-APR-82)  
		// and
		// <day><monthName><year>			(5APR82)
		if (preg_match("/^([0-9]{1,2})[^0-9a-zA-Z]*([a-zA-Z]+)[^0-9a-zA-Z]*([0-9]+))$/",
			$aString, $matches))
		{
			$day = $matches[1];
			$month = $matches[2];
			$year = $matches[3];
		}
		
		// <monthName> <day> <year>		(April 5, 1982; Apr 5, 1982)  
		else if (preg_match("/^([a-zA-Z]+)[^0-9a-zA-Z]*([0-9]{1,2})[^0-9a-zA-Z]*([0-9]+))$/",
			$aString, $matches))
		{
			$day = $matches[2];
			$month = $matches[1];
			$year = $matches[3];
		}
		
		// <monthNumber> <day> <year>		(4/5/82) 
		else if (preg_match("/^([0-9]{1,2})[^0-9a-zA-Z]*([0-9]{1,2})[^0-9a-zA-Z]*([0-9]{2}))$/",
			$aString, $matches))
		{
			$day = $matches[2];
			$month = $matches[1];
			$year = $matches[3];
		}
		
		// <four-digit year><two-digit monthNumber><two-digit day>	(19820405; 1982-04-05)
		else if (preg_match("/^(-?[0-9]{4})[^0-9a-zA-Z]*([0-9]{2})[^0-9a-zA-Z]*([0-9]{2}))$/",
			$aString, $matches))
		{
			$day = $matches[3];
			$month = $matches[2];
			$year = $matches[1];
		}
		
		// Otherwise we have an invalid date format
		else {
			die("'".$aString."' is not in a valid format.");
		}
		
		eval('$result =& '.$class.'::starting(DateAndTime::withYearMonthDay($year, $month, $day));');
		return $result;
	}
	
	/**
	 * Create a new object starting now, with our default one day duration
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @return object Date
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &starting ( &$aDateAndTime, $class = 'Date' ) {
		return parent::startingDuration($aDateAndTime->midnight(), Duration::withDays(1), $class);
	}
	
	/**
	 * Create a new object starting from midnight
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @param object Duration $aDuration
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Year
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &startingDuration ( &$aDateAndTime, &$aDuration, $class = 'Date' ) {
		return parent::startingDuration ( $aDateAndTime, $aDuration, $class );
	}
	
	/**
	 * Answer today's date
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Date
	 * @access public
	 * @since 5/10/05
	 */
	function &today ( $class = 'Date' ) {
		eval('$today =& '.$class.'::current($class);');
		return $today;
	}
	
	/**
	 * Answer yesterday's date
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Date
	 * @access public
	 * @since 5/10/05
	 */
	function &yesterday ( $class = 'Date' ) {
		eval('$today =& '.$class.'::today($class);');
		return $today->previous();
	}
	
	/**
	 * Answer tommorow's date
	 * 
	 * @return object Date
	 * @access public
	 * @since 5/10/05
	 */
	function &tomorrow ( $class = 'Date' ) {
		eval('$today =& '.$class.'::today($class);');
		return $today->next();
	}
	
	/**
	 * Create a new object starting on the julian day number specified.
	 * 
	 * @param integer $anInteger
	 * @return object Date
	 * @access public
	 * @since 5/10/05
	 */
	function &withJulianDayNumber ( $anInteger, $class = 'Date' ) {
		eval('$result =& '.$class.'::starting(DateAndTime::withJulianDayNumber($anInteger));');
		return $result;
	}
	
	/**
	 * Create a new object starting on the year, month, and day of month specified.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntOrStringMonth
	 * @param integer $anIntDay
	 * @return object Date
	 * @access public
	 * @since 5/10/05
	 */
	function &withYearMonthDay ( $anIntYear, $anIntOrStringMonth, $anIntDay, $class = 'Date' ) {
		eval('$result =& '.$class.'::starting(DateAndTime::withYearMonthDay($anIntYear, 
			$anIntOrStringMonth, $anIntDay));');
		return $result;
	}
	
	/**
	 * Create a new object starting on the year and day of year specified.
	 * 
	 * @param integer $anIntYear
	 * @param integer $anIntDay
	 * @return object Date
	 * @access public
	 * @since 5/10/05
	 */
	function &withYearDay ( $anIntYear, $anIntDay, $class = 'Date' ) {
		eval('$result =& '.$class.'::starting(DateAndTime::withYearDay($anIntYear,  $anIntDay));');
		return $result;
	}
	
/*********************************************************
 * Instance methods - Accessing
 *********************************************************/
	
	
}

?>