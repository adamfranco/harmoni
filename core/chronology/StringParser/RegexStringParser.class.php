<?php
/**
 * @since 5/24/05
 * @package harmoni.chronology.string_parsers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RegexStringParser.class.php,v 1.2 2005/05/24 23:09:17 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */ 
 
require_once(dirname(__FILE__)."/StringParser.class.php");

/**
 * RegexStringParser is an abstract class that implements a common canHandle()
 * method for decendents as well as defines a 'getRegex()' class method which must
 * be set by decendent classes.
 * 
 * @since 5/24/05
 * @package harmoni.chronology.string_parsers
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RegexStringParser.class.php,v 1.2 2005/05/24 23:09:17 adamfranco Exp $
 *
 * @link http://harmoni.sourceforge.net/
 * @author Adam Franco <adam AT adamfranco DOT com> <afranco AT middlebury DOT edu>
 */
class RegexStringParser
	extends StringParser
{

/*********************************************************
 * Instance Methods
 *********************************************************/
	
	/**
	 * Answer True if this parser can handle the format of the string passed.
	 * 
	 * @return boolean
	 * @access public
	 * @since 5/24/05
	 */
	function canHandle () {
		return preg_match($this->getRegex(), $this->input);
	}
	
	/**
	 * Return the regular expression used by this parser
	 * 
	 * @return string
	 * @access protected
	 * @since 5/24/05
	 */
	function getRegex () {
		die(__CLASS__.'::'.__FUNCTION__.'() was not overridden by a child class.');
	}
	
}

?>