<?php

require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Return assets of the specified type
 * 
 * @package harmoni.osid_v2.repository.search
 * @version $Id: DescriptionSearch.class.php,v 1.4 2005/01/27 21:47:41 adamfranco Exp $
 * @since $Date: 2005/01/27 21:47:41 $
 * @copyright 2004 Middlebury College
 */

class DescriptionSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @since 11/2/04
	 */
	function DescriptionSearch ( $dr ) {
		$this->_dr =& $dr;
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