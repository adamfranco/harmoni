<?
require_once(OKI."/dr/drAPI.interface.php");
require_once(HARMONI."/oki/dr/HarmoniDigitalRepository.class.php");

/**
 * The DigitalRepositoryManager supports creating and deleting Digital Repositories and Assets as well as getting the various Types used.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package osid.dr
 */

class HarmoniDigitalRepositoryManager // :: API interface
	extends DigitalRepositoryManager
{

	/**
	 * Constructor
	 * @param array $configuration	An array of the configuration options nessisary to load
	 * 								this manager. To use the a specific manager store, a
	 *								store data source must be configured as noted in the class
	 * 								of said manager store.
	 * manager.
	 * @access public
	 */
	function HarmoniDigitalRepositoryManager ($configuration = NULL) {
		// Set up our hierarchy
		$hierarchyManager =& Services::getService("Hierarchy");
		$sharedManager =& Services::getService("Shared");
		$hierarchyId =& $sharedManager->getId($configuration['hierarchyId']);
		$this->_hierarchy =& $hierarchyManager->getHierarchy($hierarchyId);
	}

	/**
	 * Create a new DigitalRepository of the specified Type.  The implementation of this method sets the Id for the new object.
	 * @param displayName
	 * @param description
	 *  digitalRepositoryType
	 * @return DigitalRepository
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.dr
	 */
	function & createDigitalRepository ($displayName, $description, & $digitalRepositoryType) {
		// Create an Id for the digital Repository Node
		$sharedManager =& Services::getService("Shared");
		$newId =& $sharedManager->createId();
		
		// Add this DR's root node to the hierarchy.
		$node =& $this->_hierarchy->createRootNode($newId, $digitalRepositoryType, $displayName, $description);
		
		$dr =& new HarmoniDigitalRepository ($this->_hierarchy, $node->getId());
		return $dr;
	}

	/**
	 * Delete a DigitalRepository.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function deleteDigitalRepository(& $digitalRepositoryId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteDigitalRepository(osid.shared.Id digitalRepositoryId)

	/**
	 * Get all the DigitalRepositories.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return DigitalRepositoryIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getDigitalRepositories() { /* :: interface :: */ }
	// :: full java declaration :: DigitalRepositoryIterator getDigitalRepositories()

	/**
	 * Get all the DigitalRepositories of the specified Type.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 *  digitalRepositoryType
	 * @return DigitalRepositoryIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.dr
	 */
	function & getDigitalRepositoriesByType(& $digitalRepositoryType) { /* :: interface :: */ }
	// :: full java declaration :: DigitalRepositoryIterator getDigitalRepositoriesByType(osid.shared.Type digitalRepositoryType)

	/**
	 * Get a specific DigitalRepository by Unique Id.
	 *  digitalRepositoryId
	 * @return DigitalRepository
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function & getDigitalRepository(& $digitalRepositoryId) { /* :: interface :: */ }
	// :: full java declaration :: DigitalRepository getDigitalRepository(osid.shared.Id digitalRepositoryId)

	/**
	 * Get the Asset with the specified Unique Id.
	 *  assetId
	 * @return Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function & getAsset(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: public Asset getAsset(osid.shared.Id assetId)

	/**
	 * Get the Asset with the specified Unique Id and appropriate for the date specified.  The date permits
	 * @param assetId
	 * @param date
	 * @return Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#NO_OBJECT_WITH_THIS_DATE NO_OBJECT_WITH_THIS_DATE}
	 * @package osid.dr
	 */
	function & getAssetByDate(& $assetId, & $date) { /* :: interface :: */ }
	// :: full java declaration :: public Asset getAssetByDate(osid.shared.Id assetId, java.util.Calendar date)

	/**
	 * Get all the dates for the Asset with the specified Unique Id.  These dates could be for a form of versioning.
	 * @return osid.shared.CalendarIterator
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.dr
	 */
	function & getAssetDates(& $assetId) { /* :: interface :: */ }
	// :: full java declaration :: public osid.shared.CalendarIterator getAssetDates(osid.shared.Id assetId)

	/**
	 * Perform a search of the specified Type and get all the Assets that satisfy the SearchCriteria.  The search is performed for all specified DigitalRepositories.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param digitalRepositories
	 * @param searchCriteria
	 * @param searchType
	 * @return AssetIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link DigitalRepositoryException#UNKNOWN_DR UNKNOWN_DR}
	 * @package osid.dr
	 */
	function & getAssets(& $digitalRepositories, & $searchCriteria, & $searchType) { /* :: interface :: */ }
	// :: full java declaration :: public AssetIterator getAssets
	
	/**
	 * Create in a DigitalRepository a copy of an Asset.  The Id, AssetType, and DigitalRepository for the new Asset is set by the implementation.  All InfoRecords are similarly copied.
	 * @param digitalRepository
	 * @param assetId
	 * @return osid.shared.Id
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function & copyAsset(& $digitalRepository, & $assetId) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id copyAsset(DigitalRepository digitalRepository, osid.shared.Id assetId)

	/**
	 * Get all the DigitalRepositoryTypes in this DigitalRepositoryManager.  DigitalRepositoryTypes are used to categorize DigitalRepositories.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return osid.shared.TypeIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getDigitalRepositoryTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getDigitalRepositoryTypes()
}

?>