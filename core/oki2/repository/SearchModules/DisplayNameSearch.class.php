<?php

require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Return assets of the specified type
 * 
 * @package harmoni.osid.dr.search
 * @version $Id: DisplayNameSearch.class.php,v 1.1 2005/01/11 17:40:25 adamfranco Exp $
 * @date $Date: 2005/01/11 17:40:25 $
 * @copyright 2004 Middlebury College
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