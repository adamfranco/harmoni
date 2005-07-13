<?php
/**
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Year.class.php,v 1.10 2005/07/13 17:41:11 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once(dirname(__FILE__)."/Timespan.class.php");

/**
 * I am a Timespan that represents a Year.
 *
 * To create new Year instances, <b>use one of the static instance-creation 
 * methods</b>, NOT 'new Year':
 *		- {@link current Year::current()}
 *		- {@link current Year::current()}
 *		- {@link epoch Year::epoch()}
 *		- {@link starting Year::starting($aDateAndTime)}
 *		- {@link startingDuration Year::startingDuration($aDateAndTime, $aDuration)}
 *		- {@link startingEnding Year::startingEnding($startDateAndTime, $endDateAndTime)}
 *		- {@link withYear Year::withYear($anInteger)}
 * 
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Year.class.php,v 1.10 2005/07/13 17:41:11 adamfranco Exp $
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
	 * @return object Year
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &current ( $class = 'Year' ) {
		return parent::current($class);
	}
	
	/**
	 * Answer a Year starting on the Squeak epoch: 1 January 1901
	 * 
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Year
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &epoch ( $class = 'Year' ) {
		return parent::epoch($class);
	}
	
	/**
	 * Create a new object starting now
	 * 
	 * @param object DateAndTime $aDateAndTime
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Year
	 * @access public
	 * @since 5/5/05
	 * @static
	 */
	function &starting ( &$aDateAndTime, $class = 'Year' ) {
		return parent::starting($aDateAndTime, $class);
	}
	
	/**
	 * Create a new object with given start and end DateAndTimes
	 * 
	 * @param object DateAndTime $startDateAndTime
	 * @param object DateAndTime $endDateAndTime
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Year
	 * @access public
	 * @since 5/11/05
	 */
	function &startingEnding ( &$startDateAndTime, &$endDateAndTime, 
		$class = 'Year' ) 
	{
		return parent::startingEnding ( $startDateAndTime, $endDateAndTime, $class);
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
	function &startingDuration ( &$aDateAndTime, &$aDuration, $class = 'Year' ) {
		
		// Validate our passed class name.
		if (!(strtolower($class) == strtolower('Year')
			|| is_subclass_of(new $class, 'Year')))
		{
			die("Class, '$class', is not a subclass of 'Year'.");
		}
		
		$asDateAndTime =& $aDateAndTime->asDateAndTime();
		$midnight =& $asDateAndTime->atMidnight();
		$year =& new $class;
		$year->setStart($midnight); 
		$year->setDuration(Duration::withDays(Year::daysInYear($midnight->year())));
		
		return $year;
	}

	/**
	 * Create a new Year
	 * 
	 * @param integer $anInteger
	 * @param optional string $class DO NOT USE OUTSIDE OF PACKAGE.
	 *		This parameter is used to get around the limitations of not being
	 *		able to find the class of the object that recieved the initial 
	 *		method call.
	 * @return object Year
	 * @access public
	 * @since 5/4/05
	 * @static
	 */
	function &withYear ( $anInteger, $class = 'Year' ) {
		$start =& DateAndTime::withYearMonthDay($anInteger, 1, 1);
		eval('$result =& '.$class.'::startingDuration(
				$start, 
				$null = NULL,
				$class
			);');
		return $result;
	}

/*********************************************************
 * Hybrid Class/Instance Methods
 *********************************************************/
 
 	/**
	 * Return TRUE if the year passed is a leap year
	 *
	 * This method can be either called as a class method (with a parameter)
	 * or as an instance method (without a parameter).
	 * 
	 * @param optional integer $anInteger
	 * @return boolean
	 * @access public
	 * @since 5/4/05
	 * @static
	 */
	function isLeapYear ( $anInteger = NULL ) {
		if (is_null($anInteger) && is_object ($this))
			return $this->isLeapYear($this->startYear());
		else {
			if($anInteger > 0)
				$adjustedYear = $anInteger;
			else
				$adjustedYear = 0 - ($anInteger + 1);
			
			if (($adjustedYear % 4 != 0) 
				|| (($adjustedYear % 100 == 0) && ($adjustedYear % 400 != 0)))
			{
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}
	
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
 * Instance Methods - Accessing
 *********************************************************/
 
	/**
	 * Answer a printable string
	 * 
	 * @return string
	 * @access public
	 * @since 5/23/05
	 */
	function printableString () {
		return $this->startYear();
	}

/*********************************************************
 * Instance Methods - Converting
 *********************************************************/
 	
 	/**
 	 * Answer the receiver as a Year
 	 * 
 	 * @return object Year
 	 * @access public
 	 * @since 5/23/05
 	 */
 	function &asYear () {
 		return $this;
 	}
}

?>