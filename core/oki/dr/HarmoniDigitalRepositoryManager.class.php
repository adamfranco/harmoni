<?
require_once(OKI."dr.interface.php");
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
		$this->_hierarchy->load();
		
		// Cache any created DRs so that we can pass out references to them.
		$this->_createdDRs = array();
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
		
		 $this->_createdDRs[$newId->getIdString()] =& new HarmoniDigitalRepository ($this->_hierarchy, $newId);
		return  $this->_createdDRs[$newId->getIdString()];
	}

	/**
	 * Delete a DigitalRepository.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following 
	 * messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function deleteDigitalRepository(& $digitalRepositoryId) {
		$dr =& $this->getDigitalRepository($digitalRepositoryId);
		
		// Check to see if this DR has any assets.
		$assets =& $dr->getAssets();
		// If so, delete them.
		while ($assets->hasNext()) {
			$asset =& $assets->next();
			$dr->deleteAsset($asset->getId());
		}
		
		// Delete the node for the DR
		$this->_hierarchy->deleteNode($digitalRepositoryId);
		
		// Save
		$this->save();
		
		unset($this->_createdDRs[$digitalRepositoryId->getIdString()]);
	}

	/**
	 * Get all the DigitalRepositories.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return DigitalRepositoryIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getDigitalRepositories() {
		$rootNodes =& $this->_hierarchy->getRootNodes();
		$drs = array();
		while ($rootNodes->hasNext()) {
			$rootNode =& $rootNodes->next();
			
			// make sure that the dr is loaded into the createdDRs array
			$this->getDigitalRepository($rootNode->getId());
		}
		
		// create a DigitalRepositoryIterator with all fo the DRs in the createdDRs array
		$drIterator =& new HarmoniDigitalRepositoryIterator($this->_createdDRs);
		
		return $drIterator;
	}

	/**
	 * Get all the DigitalRepositories of the specified Type.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 *  digitalRepositoryType
	 * @return DigitalRepositoryIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.dr
	 */
	function & getDigitalRepositoriesByType(& $digitalRepositoryType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}
	// :: full java declaration :: DigitalRepositoryIterator getDigitalRepositoriesByType(osid.shared.Type digitalRepositoryType)

	/**
	 * Get a specific DigitalRepository by Unique Id.
	 *  digitalRepositoryId
	 * @return DigitalRepository
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function & getDigitalRepository(& $digitalRepositoryId) {
		ArgumentValidator::validate($digitalRepositoryId, new ExtendsValidatorRule("Id"));
		
		if (!$this->_createdDRs[$digitalRepositoryId->getIdString()]) {
			// Get the node for this dr to make sure its availible
			if (!$this->_hierarchy->getNode($digitalRepositoryId))
				throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
			
			// create the dr and add it to the cache
			$this->_createdDRs[$digitalRepositoryId->getIdString()] =& new HarmoniDigitalRepository($this->_hierarchy, $digitalRepositoryId);
			$this->_drValidFlags[$digitalRepositoryId->getIdString()] = true;
		}
		
		// Dish out the dr.
		return $this->_createdDRs[$digitalRepositoryId->getIdString()];
	}

	/**
	 * Get the Asset with the specified Unique Id.
	 *  assetId
	 * @return Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function & getAsset(& $assetId) {
		ArgumentValidator::validate($assetId, new ExtendsValidatorRule("Id"));
		
		// Get the node for this asset to make sure its availible
		if (!$this->_hierarchy->getNode($assetId))
			throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
		
		// figure out which DR it is in.
		$drId =& $this->_getAssetDR($assetId);
		$dr =& $this->getDigitalRepository($drId);
		
		// have the dr create it.
		return $dr->getAsset($assetId);
	}

	/**
	 * Get the Asset with the specified Unique Id and appropriate for the date specified.  The date permits
	 * @param assetId
	 * @param date
	 * @return Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#NO_OBJECT_WITH_THIS_DATE NO_OBJECT_WITH_THIS_DATE}
	 * @package osid.dr
	 */
	function & getAssetByDate(& $assetId, & $date) {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}
	// :: full java declaration :: public Asset getAssetByDate(osid.shared.Id assetId, java.util.Calendar date)

	/**
	 * Get all the dates for the Asset with the specified Unique Id.  These dates could be for a form of versioning.
	 * @return osid.shared.CalendarIterator
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.dr
	 */
	function & getAssetDates(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}
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
	function & getAssets(& $digitalRepositories, & $searchCriteria, & $searchType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}
	// :: full java declaration :: public AssetIterator getAssets
	
	/**
	 * Create in a DigitalRepository a copy of an Asset.  The Id, AssetType, and DigitalRepository for the new Asset is set by the implementation.  All InfoRecords are similarly copied.
	 * @param digitalRepository
	 * @param assetId
	 * @return osid.shared.Id
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function & copyAsset(& $digitalRepository, & $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}
	// :: full java declaration :: osid.shared.Id copyAsset(DigitalRepository digitalRepository, osid.shared.Id assetId)

	/**
	 * Get all the DigitalRepositoryTypes in this DigitalRepositoryManager.  DigitalRepositoryTypes are used to categorize DigitalRepositories.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return osid.shared.TypeIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getDigitalRepositoryTypes() {
		$drs =& $this->getDigitalRepositories();
		$types = array();
		while ($drs->hasNext()) {
			$dr =& $drs->next();
			$types[] =& $dr->getType();
		}
		return new HarmoniTypeIterator($types);
	}
	// :: full java declaration :: osid.shared.TypeIterator getDigitalRepositoryTypes()
	

	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		// Save the Hierarchy
		$this->_hierarchy->save();
		
		// Save the Data
		foreach ($this->_createdDRs as $key => $dr) {
			$this->_createdDRs[$key]->save();
		}
	}
	 
	/**
	 * Loads this object from persistable storage.
	 * @access protected
	 */
	function load () {
		
	}	

	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
	}
	
/******************************************************************************
 * Private Functions:	
 ******************************************************************************/
 
 function _getAssetDR (& $assetId) {
 	$node =& $this->_hierarchy->getNode($assetId);
 	
 	// Get the parent and return its ID if it is a root node (drs are root nodes).
 	$parents =& $node->getParents();
 	// assume a single-parent hierarchy
 	$parent =& $parents->next();
 	
 	if ($parent->isRoot())
 		return $parent->getId();
 	else
 		return $this->_getAssetDR( $parent->getId() );
 }

}

?>