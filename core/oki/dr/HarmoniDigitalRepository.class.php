<?require_once(HARMONI."/oki/dr/HarmoniDigitalRepository.interface.php");require_once(HARMONI."/oki/dr/HarmoniAsset.class.php");require_once(HARMONI."/oki/dr/HarmoniAssetIterator.class.php");require_once(HARMONI."/oki/shared/HarmoniTypeIterator.class.php");/** * DigitialRepository manages Assets of various Types and information about the Assets.  Assets are created, persisted, and validated by the Digital Repository.  When initially created, an Asset has an immutable Type and Unique Id and its validation status is false.  In this state, all methods can be called, but integrity checks are not enforced.  When the Asset and its InfoRecords are ready to be validated, the validateAsset method checks the Asset and sets the validation status.  When working with a valid Asset, all methods include integrity checks and an exception is thrown if the activity would result in an inappropriate state.  Optionally, the invalidateAsset method can be called to release the requirement for integrity checks, but the Asset will not become valid again, until validateAsset is called and the entire Asset is checked.    <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}. * @package osid.dr */class HarmoniDigitalRepository	extends HarmoniDigitalRepositoryInterface{		/**	 * Constructor	 * 	 *	 *	 */	function HarmoniDigitalRepository (& $hierarchy, & $id) {		// Get the node coresponding to our id		$this->_hierarchy =& $hierarchy;		$this->_node =& $this->_hierarchy->getNode($id);				// Cache any created Assets so that we can pass out references to them.		$this->_createdAssets = array();	 }	/**	 * Get the name for this DigitalRepository.	 * @return String the name	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}	 * @package osid.dr	 */	function getDisplayName() { 		return $this->_node->getDisplayName();	}	/**	 * Update the name for this DigitalRepository.	 * @param displayName	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}	 * @package osid.dr	 */	function updateDisplayName($displayName) { 		$this->_node->updateDisplayName($displayName);	}	/**	 * Get the description for this DigitalRepository.	 * @return String the name	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}	 * @package osid.dr	 */	function getDescription() {		return $this->_node->getDescription();	}	/**	 * Update the description for this DigitalRepository.	 * @param description	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}	 * @package osid.dr	 */	function updateDescription($description) { 		$this->_node->updateDescription($description);	}	/**	 * Get the Unique Id for this DigitalRepository.	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}	 * @package osid.dr	 */	function & getId() {		return $this->_node->getId();	}	/**	 * Get the the DigitalRepositoryType of this DigitalRepository.	 * @return osid.shared.Type	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}	 * @package osid.dr	 */	function & getType() {		return $this->_node->getType();	}	/**	 * Create a new Asset of this AssetType to this DigitalRepository.  The implementation of this method sets the Id for the new object.	 * @return Asset	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}	 * @package osid.dr	 */	function & createAsset($displayName, $description, & $assetType) {		// Get our id for the parent id		$drId =& $this->_node->getId();				// Create an Id for the new Asset		$sharedManager =& Services::getService("Shared");		$newId =& $sharedManager->createId();				// Add this DR's root node to the hierarchy.		$node =& $this->_hierarchy->createNode($newId, $drId, $assetType, $displayName, $description);				// Create the asset with its new ID and cache it.		$this->_createdAssets[$newId->getIdString()] =& new HarmoniAsset($this->_hierarchy, $this, $newId);				return $this->_createdAssets[$newId->getIdString()];	}	/**	 * Delete an Asset from this DigitalRepository.	 * null	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}	 * @package osid.dr	 */	function deleteAsset(& $assetId) {		// Delete the Data for this Asset		//@todo				// Delete the Node for this Asset		$this->_hiearchy->deleteNode($assetId);				// Delete this asset from the createdAssets cache		unset($this->_createdAssets[$assetId->getIdString()]);	}	/**	 * Get all the Assets in this DigitalRepository.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.	 * @return AssetIterator  The order of the objects returned by the Iterator is not guaranteed.	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}	 * @package osid.dr	 */	function & getAssets() {		// get a list for all the nodes under this hierarchy.		$traversalInfoIterator =& $this->_hierarchy->traverse($this->_node->getId(), 										TRAVERSE_MODE_DEPTH_FIRST, TRAVERSE_DIRECTION_DOWN, 										TRAVERSE_LEVELS_INFINITE);		while ($traversalInfoIterator->hasNext()) {			$traversalInfo =& $traversalInfoIterator->next();						// make sure that the asset is loaded into the createdAssets array			$this->getAsset($traversalInfo->getNodeId());		}				// create an AssetIterator with all fo the Assets in the createdAssets array		$assetIterator =& new HarmoniAssetIterator($this->_createdAssets);				return $assetIterator;	}	/**	 * Get all the Assets of the specified AssetType in this Asset.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.	 * @return AssetIterator  The order of the objects returned by the Iterator is not guaranteed.	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}	 * @package osid.dr	 */	function & getAssetsByType(& $assetType) {		$allAssets =& $this->getAssets();		$assetsOfType = array();		while ($allAssets->hasNext()) {			$asset =& $allAssets->next();			if ($assetType->isEqual($asset->getType()))				$assetsOfType[] =& $asset;		}				// create an AssetIterator and return it		$assetIterator =& new HarmoniAssetIterator($assetsOfType);				return $assetIterator;	}	/**	 * Get all the AssetTypes in this DigitalRepository.  AssetTypes are used to categorize Assets.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.	 * @return osid.shared.TypeIterator  The order of the objects returned by the Iterator is not guaranteed.	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}	 * @package osid.dr	 */	function & getAssetTypes() {		$assets =& $this->getAssets();		$types = array();		while ($assets->hasNext()) {			$asset =& $assets->next();						// Make sure we haven't added the type yet.			$added = FALSE;			if (count($types)) {				foreach ($types as $key=>$type) {					if ($types[$key]->isEqual($asset->getType()))						$added = TRUE;				}			}			// if we haven't, add the type			if (!$added)				$types[] =& $asset->getType();		}				// create the iterator and return it		$typeIterator =& new HarmoniTypeIterator($types);				return $typeIterator;	}	/**	 * Get all the InfoStructures in this DigitalRepository.  InfoStructures are used to categorize information about Assets.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.	 * @return InfoStructureIterator  The order of the objects returned by the Iterator is not guaranteed.	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}	 * @package osid.dr	 */	function & getInfoStructures() { /* :: interface :: */ }	// :: full java declaration :: InfoStructureIterator getInfoStructures()	/**	 * Get the InfoStructures that this AssetType must support.  InfoStructures are used to categorize information about Assets.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.	 * @return InfoStructureIterator  The order of the objects returned by the Iterator is not guaranteed.	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}	 * @package osid.dr	 */	function & getMandatoryInfoStructures(& $assetType) { /* :: interface :: */ }	// :: full java declaration :: InfoStructureIterator getMandatoryInfoStructures(osid.shared.Type assetType)	/**	 * Get all the SearchTypes supported by this DigitalRepository.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.	 * @return osid.shared.TypeIterator  The order of the objects returned by the Iterator is not guaranteed.	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}	 * @package osid.dr	 */	function & getSearchTypes() { /* :: interface :: */ }	// :: full java declaration :: osid.shared.TypeIterator getSearchTypes()	/**	 * Get all the StatusTypes supported by this DigitalRepository.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.	 * @return osid.shared.TypeIterator  The order of the objects returned by the Iterator is not guaranteed.	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}	 * @package osid.dr	 */	function & getStatusTypes() { /* :: interface :: */ }	// :: full java declaration :: osid.shared.TypeIterator getStatusTypes()	/**	 * Get the the StatusType of this Asset.	 * @return osid.shared.Type	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}	 * @package osid.dr	 */	function & getStatus(& $assetId) { /* :: interface :: */ }	// :: full java declaration :: osid.shared.Type getStatus(osid.shared.Id assetId)	/**	 * Validate all the InfoRecords for an Asset and set its status Type accordingly.  If the Asset is valid, return true; otherwise return false.  The implementation may throw an Exception for any validation failures and use the Exception's message to identify specific causes.	 * null	 * @return boolean	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}	 * @package osid.dr	 */	function validateAsset(& $assetId) { /* :: interface :: */ }	// :: full java declaration :: public boolean validateAsset(osid.shared.Id assetId)	/**	 * Set the Asset's status Type accordingly and relax validation checking when creating InfoRecords and InfoFields or updating InfoField's values.	 * null	 * @return boolean	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}	 * @package osid.dr	 */	function invalidateAsset(& $assetId) { /* :: interface :: */ }	// :: full java declaration :: public void invalidateAsset(osid.shared.Id assetId)	/**	 * Get the Asset with the specified Unique Id.	 *  assetId	 * @return Asset	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}	 * @package osid.dr	 */	function & getAsset(& $assetId) {		if (!$this->_createdAssets[$assetId->getIdString()]) {			// Get the node for this asset to make sure its availible			if (!$this->_hierarchy->getNode($assetId))				throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));						// create the asset and add it to the cache			$this->_createdAssets[$assetId->getIdString()] =& new HarmoniAsset($this->_hierarchy, $this, $assetId);		}				// Dish out the asset.		return $this->_createdAssets[$assetId->getIdString()];	}	/**	 * Get the Asset with the specified Unique Id and appropriate for the date specified.  The date permits	 * @param assetId	 * @param date	 * @return Asset	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#NO_OBJECT_WITH_THIS_DATE NO_OBJECT_WITH_THIS_DATE}	 * @package osid.dr	 */	function & getAssetByDate(& $assetId, & $date) { /* :: interface :: */ }	// :: full java declaration :: public Asset getAssetByDate(osid.shared.Id assetId, java.util.Calendar date)	/**	 * Get all the dates for the Asset with the specified Unique Id.  These dates could be for a form of versioning.	 * @return osid.shared.CalendarIterator	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}	 * @package osid.dr	 */	function & getAssetDates(& $assetId) { /* :: interface :: */ }	// :: full java declaration :: public osid.shared.CalendarIterator getAssetDates(osid.shared.Id assetId)	/**	 * Perform a search of the specified Type and get all the Assets that satisfy the SearchCriteria.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.	 * @param searchCriteria	 * @param searchType	 * @return AssetIterator  The order of the objects returned by the Iterator is not guaranteed.	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}	 * @package osid.dr	 */	function & getAssetsBySearch(& $searchCriteria, & $searchType) { /* :: interface :: */ }	// :: full java declaration :: public AssetIterator getAssetsBySearch	/**	 * Create in a copy of an Asset.  The Id, AssetType, and DigitalRepository for the new Asset is set by the implementation.  All InfoRecords are similarly copied.	 * @param asset	 * @return osid.shared.Id	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}	 * @package osid.dr	 */	function & copyAsset(& $asset) {		// Copy the asset to the dr root (recursivley for children)		$id =& $this->_copyAsset($asset, $this->getId());	}		/**	 * Saves this object to persistable storage.	 * @access protected	 */	function save () {		// Save the Hierarchy		$this->_node->save();				// Save the dataManager		//@todo	}	 	/**	 * Loads this object from persistable storage.	 * @access protected	 */	function load () {		// Load the Hierarchy		$this->_node->load();				// Load the dataManager		//@todo	}	/**	 * Recursively copies an asset and its children to a new parent.	 *	 *	 */	function & _copyAsset(& $asset, & $newParentId) {		// Create the new asset		$newAsset =& $this->createAsset($asset->getDisplayName(),$asset->getDescription(), $asset->getAssetType());				// Move the new asset to the proper parent if it 		// is not being copied to the dr root.		if (!$newParentId->isEqual($this->getId())) {			$newParent =& $this->getAsset($newParentId);			$newParent->addAsset($newAsset);		}				// Copy its data		// @todo				// Copy the children		$children =& $asset->getChildren();		while ($children->hasNext()) {			$childAsset =& $children->next();			$this->_copyAsset($childAsset, $newAsset->getId());		}				// Return its Id		return $newAsset->getId();	}}?>