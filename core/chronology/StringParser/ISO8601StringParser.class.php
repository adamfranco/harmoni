<?php
/**
 * @since 5/23/05
 * @package harmoni.chronology.string_parsers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ISO8601StringParser.class.php,v 1.1 2005/05/24 17:58:20 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once(dirname(__FILE__)."/RegexStringParser.class.php");

/**
 * This StringParser can handle ISO 8601 dates. {@link http://www.cl.cam.ac.uk/~mgk25/iso-time.html}
 * Examples:
 * 		- 4/5/82
 * 		- 04/05/82
 *		- 04/05/1982
 *		- 4-5-82
 * 
 * @since 5/23/05
 * @package harmoni.chronology.string_parsers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ISO8601StringParser.class.php,v 1.1 2005/05/24 17:58:20 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class ISO8601StringParser 
	extends RegexStringParser {
	
/*********************************************************
 * Instance Methods
 *********************************************************/
 	
 	/**
	 * Return the regular expression used by this parser
	 * 
	 * @return string
	 * @access protected
	 * @since 5/24/05
	 */
	function getRegex () {
		return
"/
^											# Start of the line

#-----------------------------------------------------------------------------
	(?:										# The date component
		([0-9]{4})							# Four-digit year
		
		-?									# Optional Hyphen
		
		(									# Two-digit month
			(?:  0[1-9])
			|
			(?:  1[0-2])
		)?
		
		-?									# Optional Hyphen
		
		(									# Two-digit day
			(?:  0[1-9])
			|
			(?:  1|2[0-9])
			|
			(?:  3[0-1])
		)?
	)?
	
	
	[\sT]?									# Optional delimiter

#-----------------------------------------------------------------------------		
	(?:										# The time component
	
		(									# Two-digit hour
			(?:  [0-1][0-9])
			|
			(?: 2[0-4])
		)
		
		:?									# Optional Colon
		
		([0-5][0-9])?						# Two-digit minute
		
		:?									# Optional Colon
		
		(									# Two-digit second 
			[0-5][0-9]
			(?: \.[0-9]+)?						# followed by an optional decimal.
		)?

#-----------------------------------------------------------------------------
		(									# Offset component
		
			Z								# Zero offset (UTC)
			|								# OR
			(?:								# Offset from UTC
				([+\-])						# Sign of the offset
			
				(							# Two-digit offset hour
					(?:  [0-1][0-9])
					|
					(?:  2[0-4])
				)			
	
				:?							# Optional Colon
				
				([0-5][0-9])?				# Two-digit offset minute
			)
		)?
	)?



$
/x";
 	}
	
	/**
	 * Parse the input string and set our elements based on the contents of the
	 * input string. Elements not found in the string will be null.
	 * 
	 * @return void
	 * @access private
	 * @since 5/23/05
	 */
	function parse () {
		preg_match($this->getRegex(), $this->input, $matches);
		
		// Matches:
		//     [0] => 2005-05-23T15:25:10-04:00
		//     [1] => 2005
		//     [2] => 05
		//     [3] => 23
		//     [4] => 15
		//     [5] => 25
		//     [6] => 10
		//     [7] => -04:00
		//     [8] => -
		//     [9] => 04
		//     [10] => 00
		
		$this->setYear($matches[1]);
		$this->setMonth($matches[2]);
		$this->setDay($matches[3]);
		$this->setHour($matches[4]);
		$this->setMinute($matches[5]);
		$this->setSecond($matches[6]);
		if ($matches[7] == 'Z') {
			$this->setOffsetHour(0);
			$this->setOffsetMinute(0);
		} else if ($matches[7]) {
			$this->setOffsetHour(intval($matches[8].$matches[9]));
			$this->setOffsetMinute(intval($matches[8].$matches[10]));
		}
	}
}

?>