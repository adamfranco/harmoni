<?php
/**
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Year.class.php,v 1.2 2005/05/05 23:09:48 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once("Timespan.class.php");

/**
 * I represent a Year.
 * 
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Year.class.php,v 1.2 2005/05/05 23:09:48 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class Year 
	extends Timespan
{

/*********************************************************
 * Class Methods
 *********************************************************/
	
	/**
	 * Return TRUE if the year passed is a leap year
	 * 
	 * @param integer $anInteger
	 * @return boolean
	 * @access public
	 * @since 5/4/05
	 * @static
	 */
	function isLeapYear ( $anInteger ) {
		if($anInteger > 0)
			$adjustedYear = $anInteger;
		else
			$adjustedYear = 0 - ($anInteger + 1);
	}

/*********************************************************
 * Class Methods - Instance Creation
 *********************************************************/
	
	/**
	 * Answer a new object that represents now.
	 * 
	 * @return object Month
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &current () {
		return Year::starting(DateAndTime::now());
	}
	
	/**
	 * Create a new object starting now, with zero duration
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @return object Month
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &starting ( &$aDateAndTime ) {
		return Year::startingDuration($aDateAndTime, Duration::zero());
	}
	
	/**
	 * Create a new Year, start from midnight
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @param object Duration $aDuration
	 * @return object Year
	 * @access public
	 * @static
	 * @since 5/4/05
	 */
	function &startingDuration ( &$aDateAndTime, &$aDuration) {
		$midnight =& $aDateAndTime->midnight();
		$year =& new Year;
		$year->setStart($midnight); 
		$year->setDuration(Duration::withDays(Year::daysInYear($midnight->year())));
		
		return $year;
	}

	/**
	 * Create a new Year
	 * 
	 * @param integer $anInteger
	 * @return object Year
	 * @access public
	 * @since 5/4/05
	 * @static
	 */
	function &withYear ( $anInteger ) {
		return Year::startingDuration(
			DateAndTime::withYearMonthDay($anInteger, 1, 1), $null = NULL);
	}

/*********************************************************
 * Hybrid Class/Instance Methods
 *********************************************************/
	
	/**
	 * Return the number of days in a year.
	 *
	 * This method can be either called as a class method (with a parameter)
	 * or as an instance method (without a parameter).
	 * 
	 * @param optional integer $anInteger
	 * @return integer
	 * @access public
	 * @since 5/4/05
	 */
	function daysInYear ( $anInteger = NULL ) {
		if (is_null($anInteger) && is_object ($this))
			return $this->duration->days();
		else {
			if (is_null($anInteger)) {
				$errorString = "Cannot execute daysInYear for NULL.";
				if (function_exists('throwError'))
					throwError(new Error($errorString));
				else
					die ($errorString);
			}
				
			if (Year::isLeapYear($anInteger))
				return 365 +1;
			else
				return 365;
		}
	}

/*********************************************************
 * Instance Methods
 *********************************************************/
 	
}

?>