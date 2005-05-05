<?php
/**
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ChronologyConstants.class.php,v 1.3 2005/05/05 00:09:59 adamfranco Exp $
 */ 

/**
 * ChronologyConstants is a SharedPool for the constants used by the 
 * Kernel-Chronology classes.
 *
 * Due to PHP's lack of decent date/time objects, handling of dates and times in
 * Harmoni here-to-for required swapping between various timestamp and date string 
 * represtations and other simple chronological objects that were never very 
 * universal. 
 * 
 * This package is a PHP implemenation of the Squeak (Smalltalk)
 * Kernel-Chronology package. The original Smalltalk implementation is licensed
 * under the Squeak License {@link http://squeak.org/download/license.html}.
 * 
 * @since 5/2/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ChronologyConstants.class.php,v 1.3 2005/05/05 00:09:59 adamfranco Exp $
 * @static
 */
class ChronologyConstants {
		
	/**
	 * Julian day number of 1 Jan 1901
	 * 
	 * @return integer
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function SqueakEpoch () {
		return 2415386;
	}
	
	/**
	 * Number of seconds in a day
	 * 
	 * @return integer
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function SecondsInDay () {
		return 86400;
	}
	
	/**
	 * Number of seconds in an hour
	 * 
	 * @return integer
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function SecondsInHour () {
		return 3600;
	}
	
	/**
	 * Number of seconds in a minute
	 * 
	 * @return integer
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function SecondsInMinute () {
		return 60;
	}
	
	/**
	 * Nanoseconds in a second
	 * 
	 * @return integer
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function NanosInSecond () {
		return pow (10, 9);
	}
	
	/**
	 * Nanoseconds in a millisecond
	 * 
	 * @return integer
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function NanosInMillisecond () {
		return pow (10, 6);
	}
	
	/**
	 * Names of days of the week.
	 * 
	 * @return array
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function DayNames () {
		return array (1 => 'Sunday', 2 => 'Monday', 3 => 'Tuesday', 4 => 'Wednesday',
			5 => 'Thursday', 6 => 'Friday', 7 => 'Saturday');
	}
	
	/**
	 * Names of months.
	 * 
	 * @return array
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function MonthNames () {
		return array (1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
			5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 
			10 => 'October', 11 => 'November', 12 => 'December');
	}
	
	/**
	 * Names number of days in each month.
	 * 
	 * @return array
	 * @access public
	 * @since 5/2/05
	 * @static
	 */
	function DaysInMonth () {
		return array (1 => 31, 2 => 28, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 
			7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31);
	}
}

?>