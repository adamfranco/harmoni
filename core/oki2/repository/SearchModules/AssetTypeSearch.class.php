<?php

require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Return assets of the specified type
 * 
 * @package harmoni.osid_v2.repository.search
 * @version $Id: AssetTypeSearch.class.php,v 1.3 2005/01/27 15:45:40 adamfranco Exp $
 * @since $Date: 2005/01/27 15:45:40 $
 * @copyright 2004 Middlebury College
 */

class AssetTypeSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @since 11/2/04
	 */
	function AssetTypeSearch ( $dr ) {
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
		// get the root Nodes
		$assets =& $this->_dr->getAssetsByType($searchCriteria);
		
		// Add the ids of the root nodes to an array
		$ids = array();
		while ($assets->hasNext()) {
			$asset =& $assets->next();
			$ids[] =& $asset->getId();
		}
		
		// Return the array
		return $ids;
	}
	
}

?>