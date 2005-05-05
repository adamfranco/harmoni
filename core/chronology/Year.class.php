<?php
/**
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Year.class.php,v 1.1 2005/05/05 00:09:59 adamfranco Exp $
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
 * @version $Id: Year.class.php,v 1.1 2005/05/05 00:09:59 adamfranco Exp $
 */
class Year 
	extends Timespan
{

/*********************************************************
 * Class Methods
 *********************************************************/
		
	/**
	 * Create a new Year
	 * 
	 * @param integer $anInteger
	 * @return object Year
	 * @access public
	 * @since 5/4/05
	 */
	function &withYear ( $anInteger ) {
		return Year::startingDuration(
			DateAndTime::withYearMonthDay($anInteger, 1, 1), $null = NULL);
	}
	
	/**
	 * Create a new Year, start from midnight
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @param object Duration $aDuration
	 * @return object Year
	 * @access public
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
	 * Return TRUE if the year passed is a leap year
	 * 
	 * @param integer $anInteger
	 * @return boolean
	 * @access public
	 * @since 5/4/05
	 */
	function isLeapYear ( $anInteger ) {
		if($anInteger > 0)
			$adjustedYear = $anInteger;
		else
			$adjustedYear = 0 - ($anInteger + 1);
	}

/*********************************************************
 * Instance Methods
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
}

?>