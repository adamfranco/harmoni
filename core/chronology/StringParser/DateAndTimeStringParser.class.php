<?php
/**
 * @since 5/24/05
 * @package harmoni.chronology.string_parsers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DateAndTimeStringParser.class.php,v 1.1 2005/05/24 23:09:17 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once(dirname(__FILE__)."/StringParser.class.php");


/**
 * DateAndTimeStringParser breaks up strings into a date component and a time
 * component and attempts to match each individually.
 * 
 * @since 5/24/05
 * @package harmoni.chronology.string_parsers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DateAndTimeStringParser.class.php,v 1.1 2005/05/24 23:09:17 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class DateAndTimeStringParser
	extends RegexStringParser
{

/*********************************************************
 * Instance Methods
 *********************************************************/
	
	/**
	 * Return the regular expression used by this parser.
	 * If the input has a time component, then this parser can handle it.
	 * 
	 * @return string
	 * @access protected
	 * @since 5/24/05
	 */
	function getRegex () {	
		$timeRegex = TimeStringParser::getRegex();
		
		// Remove a line-beginning anchor from the time expression
		return preg_replace('/\/[\s\r]*\^/', '/', $timeRegex);
	}
	
	/**
	 * Parse the input string and set our elements based on the contents of the
	 * input string. Elements not found in the string will be null.
	 * 
	 * @return void
	 * @access private
	 * @since 5/24/05
	 */
	function parse () {
		preg_match($this->getRegex(), $this->input, $timeMatches);
		$timeComponent = $timeMatches[0];
		
		// The date is anything before the time
		$dateComponent = trim(str_replace($timeComponent, '', $this->input));
		
		$timeParser =& new TimeStringParser($timeComponent);
		$dateParser =& StringParser::getParserFor($dateComponent);
		
		// Merge the two results into our fields
		if ($dateParser) {
			$this->setYear($dateParser->year());
			$this->setMonth($dateParser->month());
			$this->setDay($dateParser->day());
		}
		
		$this->setHour($timeParser->hour());
		$this->setMinute($timeParser->minute());
		$this->setSecond($timeParser->second());
		
		if (!is_null($timeParser->offsetHour()))
	 		$this->setOffsetHour($timeParser->offsetHour());
	 	if (!is_null($timeParser->offsetMinute()))
	 		$this->setOffsetMinute($timeParser->offsetMinute());
	 	if (!is_null($timeParser->offsetSecond()))
 			$this->setOffsetSecond($timeParser->offsetSecond());
	}
}

?>