<?php
/**
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthoritativeValuesSearch.class.php,v 1.1 2006/04/27 18:14:52 adamfranco Exp $
 */

require_once(dirname(__FILE__)."/RegexSearch.abstract.php");

/**
 * Return assets of the specified type
 * 
 *
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthoritativeValuesSearch.class.php,v 1.1 2006/04/27 18:14:52 adamfranco Exp $
 */

class AuthoritativeValuesSearch
	extends SearchModuleInterface
{
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @since 11/2/04
	 */
	function AuthoritativeValuesSearch ( $repository ) {
		$this->_repository =& $repository;
	}
	
	
		
	/**
	 * Get the ids of the assets that match the search criteria
	 * 
	 * @param mixed $searchCriteria
	 * @return array
	 * @access public
	 * @since 11/2/04
	 */
	function &searchAssets ( $searchCriteria ) {		
		$matchingIds = array();
		
		
		
		// Return the array
		return $matchingIds;
	}
	
}

?>