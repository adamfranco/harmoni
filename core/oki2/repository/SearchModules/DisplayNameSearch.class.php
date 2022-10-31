<?php
/**
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DisplayNameSearch.class.php,v 1.8 2007/09/04 20:25:47 adamfranco Exp $
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
 * @version $Id: DisplayNameSearch.class.php,v 1.8 2007/09/04 20:25:47 adamfranco Exp $
 */

class DisplayNameSearch
	extends RegexSearch
{
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @since 11/2/04
	 */
	function __construct ( $dr ) {
		$this->_dr =$dr;
	}
	
	
		
	/**
	 * Get the ids of the assets that match the search criteria
	 * 
	 * @param mixed $searchCriteria
	 * @return array
	 * @access public
	 * @since 11/2/04
	 */
	function searchAssets ( $searchCriteria ) {
		$searchCriteria = $this->translateToRegex($searchCriteria);
		
		$matchingIds = array();
		
		// Get All the assets
		$assets =$this->_dr->getAssets();
		
		// Add their id to the array if the displayName matches
		while ($assets->hasNext()) {
			$asset =$assets->next();
			if (preg_match($searchCriteria, $asset->getDisplayName()))
				$matchingIds[] =$asset->getId();
		}
		
		// Return the array
		return $matchingIds;
	}
	
	
	
}

?>