<?php
/**
 * @since 12/8/05
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RegexSearch.abstract.php,v 1.1 2005/12/08 20:12:41 adamfranco Exp $
 */ 
 
require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Abstract regular expression matching class that handles translation between
 * simple wildcard-based search strings and regular expression strings.
 * 
 * @since 12/8/05
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RegexSearch.abstract.php,v 1.1 2005/12/08 20:12:41 adamfranco Exp $
 */
class RegexSearch
	extends SearchModuleInterface 
{
		
	/**
	 * Translate a simple search string such as 'ge*ing' into a regex string such
	 * as '/\<ge.*ing\>/i'
	 * 
	 * @param string $simpleString
	 * @return string
	 * @access public
	 * @since 12/8/05
	 */
	function translateToRegex ($simpleString) {
		$simpleString = str_replace(
			chr(92), 
			'\x5C', 
			$simpleString);
			
		$searches = array(
				'/[\[\](){}\.\/|$^?]/',
				'/\*/'
			);
			
		$replacements = array(
				'\\\\\0',
				'.*'
			);
		
		return '/'.preg_replace($searches, $replacements, $simpleString).'/i';
	}
	
}

?>