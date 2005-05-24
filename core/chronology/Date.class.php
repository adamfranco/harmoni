<?php
/**
 * @since 5/4/05
 * @package harmoni.chronology
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Date.class.php,v 1.6 2005/05/24 23:07:13 adamfranco Exp $
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
 * @version $Id: Date.class.php,v 1.6 2005/05/24 23:07:13 adamfranco Exp $
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
	 *
	 *		<day> <monthName> <year>		(5 April 1982; 5-APR-82)  
	 *
	 *		<monthName> <day> <year>		(April 5, 1982)  
	 *
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
		$parser =& StringParser::getParserFor($aString);
		
		if (!$parser)
			die("'".$aString."' is not in a valid format.");
		
		eval('$result =& '.$class.'::withYearMonthDay($parser->year(),
						$parser->month(), $parser->day(), $class);');
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
		return parent::startingDuration($aDateAndTime->midnight(), 
			Duration::withDays(1), $class);
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
	
/*********************************************************
 * Instance methods - Accessing/Printing
 *********************************************************/
 
 	/**
 	 * Answer the receiver rendered in standard U.S.A format mm/dd/yyyy.
 	 * 
 	 * @return string
 	 * @access public
 	 * @since 5/23/05
 	 */
 	function mmddyyyyString () {
 		return $this->printableStringWithFormat(array(2, 1, 3, '/', 1, 1, 2));
 	}
 
 	/**
 	 * Format is '4 June 2005'
 	 * 
 	 * @return string
 	 * @access public
 	 * @since 5/20/05
 	 */
 	function printableString () {
 		return $this->printableStringWithFormat(array(1, 2, 3, ' ', 3, 1));
 	}
	
	/**
	 * Print a description of the receiver on aStream using the format 
	 * denoted the argument, formatArray: 
	 *
	 *		array(item, item, item, sep, monthfmt, yearfmt, twoDigits) 
	 *
	 *		items: 1=day 2=month 3=year will appear in the order given, 
	 *
	 *		separated by sep which is eaither an ascii code or character. 
	 *
	 *		monthFmt: 1=09 2=Sep 3=September 
	 *
	 *		yearFmt: 1=1996 2=96 
	 *
	 *		digits: (missing or)1=9 2=09. 
	 *
	 *	See the examples in printOn: and mmddyy
	 * 
	 * @param array $formatArray
	 * @return string
	 * @access public
	 * @since 5/20/05
	 */
	function printableStringWithFormat ( $formatArray ) {
		$result = '';
		$twoDigits = (count($formatArray) > 6 && $formatArray[6] > 1);
		$monthFormat = $formatArray[4];
		$yearFormat = $formatArray[5];
		$separator = $formatArray[3];
		
		for ($i = 0; $i < 3; $i++) {
			$element = $formatArray[$i];
			
			switch ($element) {
				case 1:
					if ($twoDigits)
						$result .= str_pad($this->dayOfMonth(), 2, '0', STR_PAD_LEFT);
					else
						$result .= $this->dayOfMonth();
					break;
				
				case 2:
					if ($monthFormat == 1) {
						if ($twoDigits)
							$result .= str_pad($this->startMonth(), 2, '0', STR_PAD_LEFT);
						else
							$result .= $this->startMonth();
					} else if ($monthFormat == 2) {
						$result .= substr(Month::nameOfMonth($this->startMonth()), 0, 3);
					} else if ($monthFormat == 3) {
						$result .= Month::nameOfMonth($this->startMonth());
					}
					break;
				
				case 3:
					if ($yearFormat == 2) {
						$result .= str_pad(($this->startYear() % 100), 2, '0', STR_PAD_LEFT);
					} else
						$result .= $this->startYear();
			}
			
			if ($i < 2 && $separator)
				$result .= $separator;
		}
		
		return $result;
	}
	
	/**
	 * Format the date in ISO 8601 standard like '2002-10-22'.
	 * 
	 * @return string
	 * @access public
	 * @since 5/23/05
	 */
	function yyyymmddString () {
		return $this->printableStringWithFormat(array(3, 2, 1, '-', 1, 1, 2));
	}
	
/*********************************************************
 * Instance Methods - Operations
 *********************************************************/

	/**
 	 * Answer the date that occurs $anInteger days from this date
 	 * 
 	 * @param integer $anInteger
 	 * @return object Date
 	 * @access public
 	 * @since 5/20/05
 	 */
 	function &addDays ( $anInteger ) {
 		$asDateAndTime =& $this->asDateAndTime();
 		$newDateAndTime =& $asDateAndTime->plus(Duration::withDays($anInteger));
 		return $newDateAndTime->asDate();
 	}
 	
 	/**
 	 *  Answer the date that occurs $anInteger days before this date
 	 * 
 	 * @param integer $anInteger
 	 * @return object Date
 	 * @access public
 	 * @since 5/23/05
 	 */
 	function &subtractDays ( $anInteger ) {
 		return $this->addDays(0 - $anInteger);
 	}
 	
 	/**
 	 * Answer the previous date whose weekday name is dayName.
 	 * 
 	 * @param string $dayNameString
 	 * @return object Date
 	 * @access public
 	 * @since 5/23/05
 	 */
 	function &previousDayNamed ( $dayNameString ) {
 		$days = abs($this->dayOfWeek() - (Week::indexOfDay($dayNameString) % 7));
 		if ($days == 0)
 			$days = 7;
 		return $this->subtractDays($days);
 	}
 	
/*********************************************************
 * Instance Methods - Converting
 *********************************************************/
 	
 	/**
 	 * Answer the reciever as a Date
 	 * 
 	 * @return object Date
 	 * @access public
 	 * @since 5/23/05
 	 */
 	function &asDate () {
 		return $this;
 	}
 	
 	/**
 	 * Answer the seconds since the Squeak epoch: 1 January 1901 
 	 * 
 	 * @return integer
 	 * @access public
 	 * @since 5/23/05
 	 */
 	function asSeconds () {
 		return $this->start->asSeconds();
 	}
}

?>