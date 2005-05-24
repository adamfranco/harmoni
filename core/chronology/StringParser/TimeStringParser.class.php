<?php
/**
 * @since 5/24/05
 * @package harmoni.chronology.string_parsers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TimeStringParser.class.php,v 1.1 2005/05/24 23:09:18 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once(dirname(__FILE__)."/StringParser.class.php");
//require_once(dirname(__FILE__)."/RegexStringParser.class.php");

/**
 * This StringParser can handle ISO 8601 dates. {@link http://www.cl.cam.ac.uk/~mgk25/iso-time.html}
 * Examples:
 * 		- 4/5/82
 * 		- 04/05/82
 *		- 04/05/1982
 *		- 4-5-82
 * 
 * @since 5/24/05
 * @package harmoni.chronology.string_parsers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: TimeStringParser.class.php,v 1.1 2005/05/24 23:09:18 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class TimeStringParser 
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
^										# Start of the line

#-----------------------------------------------------------------------------			
	(									# One or Two-digit hour
		(?: [1-9])
		|
		(?: 1[0-9])
		|
		(?: 2[0-4])
	)
	
	(?:									# Optional :Minute:Seconds component
		:								# Colon
		([0-5][0-9])?					# Two-digit minute
		
		(?:								# Optional :Seconds component
			:							# Colon				
			(							# Two-digit second 
				[0-5][0-9]
				(?: \.[0-9]+)?			# followed by an optional decimal.
			)
		)?
	)?
	
	\s?									# Optional space
	
	(am|pm)?							# Optional AM or PM
	
$
/xi";
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
		preg_match($this->getRegex(), $this->input, $matches);
		
		// Matches:
		// [0] => 3:25:10 pm
		// [1] => 3
		// [2] => 25
		// [3] => 10
		// [4] => pm
		
		if (strtolower($matches[4]) == 'pm' && $matches[1] < 13)
			$this->setHour($matches[1] + 12);
		else
			$this->setHour($matches[1]);
			
		$this->setMinute($matches[2]);
		$this->setSecond($matches[3]);
	}
}

?>