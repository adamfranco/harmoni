<?php

require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Return assets of the specified type
 * 
 * @package harmoni.osid.dr.search
 * @version $Id: ContentSearch.class.php,v 1.1 2004/11/02 20:12:02 adamfranco Exp $
 * @date $Date: 2004/11/02 20:12:02 $
 * @copyright 2004 Middlebury College
 */

class ContentSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @date 11/2/04
	 */
	function ContentSearch ( $dr ) {
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
		$criteria =& new AndSearch();
		$criteria->addCriteria(new ActiveRecordsSearch());
		$criteria->addCriteria(new FieldValueSearch(new HarmoniType("DR", "Harmoni", "AssetContent", ""),"Content", new Blob($searchCriteria), SEARCH_TYPE_CONTAINS));
		
		$recordMgr =& Services::getService("RecordManager");
		$recordIDs = $recordMgr->getRecordIDsBySearch($criteria);

		$groupIds = array();
		foreach  ($recordIDs as $id) {
			$recordSetIds =& $recordMgr->getRecordSetIDsContainingID($id);
			$groupIds = array_merge($groupIds, $recordSetIds);
		}
				
		$groupIds = array_unique($groupIds);
				
		$sharedManager =& Services::getService("Shared");
		
		foreach ($groupIds as $id) {
			$matchingIds[] =& $sharedManager->getId($id);
		}
				
		// Return the array
		return $matchingIds;
	}
	
}

?>