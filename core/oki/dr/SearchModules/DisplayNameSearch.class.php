<?php

require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Return assets of the specified type
 *
 * @package harmoni.osid.dr.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DisplayNameSearch.class.php,v 1.2 2005/01/19 21:10:07 adamfranco Exp $
 */

class DisplayNameSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @date 11/2/04
	 */
	function DisplayNameSearch ( $dr ) {
		$this->_dr =& $dr;
	}
	
	
		
	/**
	 * Get the ids of the assets that match the search criteria
	 * 
	 * @param mixed $searchCriteria
	 * @return array
	 * @access public
	 * @date 11/2/04
	 */
	function searchAssets ( $searchCriteria ) {
		$matchingIds = array();
		
		// Get All the assets
		$assets =& $this->_dr->getAssets();
		
		// Add their id to the array if the displayName matches
		while ($assets->hasNext()) {
			$asset =& $assets->next();
			if (ereg($searchCriteria, $asset->getDisplayName()))
				$matchingIds[] =& $asset->getId();
		}
		
		// Return the array
		return $matchingIds;
	}
	
}

?>