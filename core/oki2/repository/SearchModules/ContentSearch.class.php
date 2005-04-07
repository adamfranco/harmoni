<?php
/**
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ContentSearch.class.php,v 1.5 2005/04/07 16:33:30 adamfranco Exp $
 */

require_once(dirname(__FILE__)."/SearchModule.interface.php");

/**
 * Return assets of the specified type
 *
 * @package harmoni.osid_v2.repository.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ContentSearch.class.php,v 1.5 2005/04/07 16:33:30 adamfranco Exp $
 */

class ContentSearch
	extends SearchModuleInterface {
	
	/**
	 * Constructor
	 * 
	 * @param object $dr
	 * @return object
	 * @access public
	 * @since 11/2/04
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
	 * @since 11/2/04
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
				
		$idManager =& Services::getService("Id");
		
		foreach ($groupIds as $id) {
			$matchingIds[] =& $idManager->getId($id);
		}
				
		// Return the array
		return $matchingIds;
	}
	
}

?>