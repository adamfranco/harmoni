<?

require_once(HARMONI."/oki/dr/HarmoniDigitalRepository.interface.php");
require_once(HARMONI."/oki/dr/HarmoniAsset.class.php");
require_once(HARMONI."/oki/dr/HarmoniAssetIterator.class.php");
require_once(HARMONI."/oki/dr/HarmoniDigitalRepositoryIterator.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoStructure.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoStructureIterator.class.php");
require_once(HARMONI."/oki/shared/HarmoniTypeIterator.class.php");
require_once(HARMONI."/oki/shared/HarmoniCalendarIterator.class.php");

/**
 * DigitialRepository manages Assets of various Types and information about the Assets.  Assets are created, persisted, and validated by the Digital Repository.  When initially created, an Asset has an immutable Type and Unique Id and its validation status is false.  In this state, all methods can be called, but integrity checks are not enforced.  When the Asset and its InfoRecords are ready to be validated, the validateAsset method checks the Asset and sets the validation status.  When working with a valid Asset, all methods include integrity checks and an exception is thrown if the activity would result in an inappropriate state.  Optionally, the invalidateAsset method can be called to release the requirement for integrity checks, but the Asset will not become valid again, until validateAsset is called and the entire Asset is checked.    <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package harmoni.osid.dr
 */
class HarmoniDigitalRepository
	extends HarmoniDigitalRepositoryInterface
{
	
	var $_configuration;
	var $_searchTypes;
	var $_node;
	var $_hierarchy;
	var $_createdAssets;
	
	var $_createdInfoStructures;
	var $_assetValidFlags;
	
	/**
	 * Constructor
	 */
	function HarmoniDigitalRepository (& $hierarchy, & $id, & $configuration) {
		// Get the node coresponding to our id
		$this->_hierarchy =& $hierarchy;
		$this->_node =& $this->_hierarchy->getNode($id);
		
		// Cache any created Assets so that we can pass out references to them.
		$this->_createdAssets = array();
		$this->_assetValidFlags = array();
		$this->_assetDataSets = array();
		
		// Set up an array of searchTypes that this DR supports
		$this->_registerSearchTypes();
		
		// Set up an array of created Info structures so we can pass out references to them.
		$this->_createdInfoStructures = array();
		
		// Store our configuration
		$this->_configuration =& $configuration;
	}
	 
	/**
	 * Returns if this Asset is valid or not.
	 * @param object assetId
	 * @return bool
	 */
	function isAssetValid(&$assetId) {
		throw(new Error("Method gone from OSID","DR",TRUE));
		return $this->_assetValidFlags[$assetId->getIdString()];
	}

	/**
	 * Get the name for this DigitalRepository.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function getDisplayName() { 
		return $this->_node->getDisplayName();
	}

	/**
	 * Update the name for this DigitalRepository.
	 * @param string displayName
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.dr
	 */
	function updateDisplayName($displayName) { 
		$this->_node->updateDisplayName($displayName);
	}

	/**
	 * Get the description for this DigitalRepository.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function getDescription() {
		return $this->_node->getDescription();
	}

	/**
	 * Update the description for this DigitalRepository.
	 * @param string description
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.dr
	 */
	function updateDescription($description) { 
		$this->_node->updateDescription($description);
	}

	/**
	 * Get the Unique Id for this DigitalRepository.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getId() {
		return $this->_node->getId();
	}

	/**
	 * Get the the DigitalRepositoryType of this DigitalRepository.
	 * @return object osid.shared.Type
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getType() {
		return $this->_node->getType();
	}

	/**
	 * Create a new Asset of this AssetType to this DigitalRepository.  The implementation of this method sets the Id for the new object.
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function & createAsset($displayName, $description, & $assetType) {
		// Get our id for the parent id
		$drId =& $this->_node->getId();
		
		// Create an Id for the new Asset
		$sharedManager =& Services::getService("Shared");
		$newId =& $sharedManager->createId();
		
		// Add this DR's root node to the hierarchy.
		$node =& $this->_hierarchy->createNode($newId, $drId, $assetType, $displayName, $description);
		
		// Create the asset with its new ID and cache it.
		$this->_createdAssets[$newId->getIdString()] =& new HarmoniAsset($this->_hierarchy, $this, $newId, $this->_configuration);
		
		return $this->_createdAssets[$newId->getIdString()];
	}

	/**
	 * Delete an Asset from this DigitalRepository.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function deleteAsset(& $assetId) {
		ArgumentValidator::validate($assetId, new ExtendsValidatorRule("Id"));
		
		// Get the asset
		$asset =& $this->getAsset($assetId);
		
		// Delete the InfoRecords for the Asset
		$infoRecords =& $asset->getInfoRecords();
		while ($infoRecords->hasNext()) {
			$record =& $infoRecords->next();
			$recordId =& $record->getId();
			$asset->deleteInfoRecord($recordId);
		}
		
		// Delete the Node for this Asset
		$this->_hierarchy->deleteNode($assetId);
		
		// Delete this asset from the createdAssets cache
		unset($this->_createdAssets[$assetId->getIdString()]);
		
		$this->save();
	}

	/**
	 * Get all the Assets in this DigitalRepository.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object AssetIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getAssets() {
		// get a list for all the nodes under this hierarchy.
		$traversalInfoIterator =& $this->_hierarchy->traverse($this->_node->getId(), 
										TRAVERSE_MODE_DEPTH_FIRST, TRAVERSE_DIRECTION_DOWN, 
										TRAVERSE_LEVELS_ALL);
		while ($traversalInfoIterator->hasNext()) {
			$traversalInfo =& $traversalInfoIterator->next();
			$assetId =& $traversalInfo->getNodeId();
			
			// make sure that the asset is loaded into the createdAssets array
			// make sure that we don't create an asset with the id of the dr.
			if (!$assetId->isEqual($this->getId()))
				$this->getAsset($assetId);
		}
		
		// create an AssetIterator with all fo the Assets in the createdAssets array
		$assetIterator =& new HarmoniAssetIterator($this->_createdAssets);
		
		return $assetIterator;
	}

	/**
	 * Get all the Assets of the specified AssetType in this Asset.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object AssetIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function & getAssetsByType(& $assetType) {
		ArgumentValidator::validate($assetType, new ExtendsValidatorRule("Type"));
		$assets = array();
		$children =& $this->_node->getChildren();
		while ($children->hasNext()) {
			$child =& $children->next();
			if ($assetType->isEqual($child->getType()))
				$assets[] =& $this->_dr->getAsset($child->getId());
		}
		
		return new HarmoniAssetIterator($assets);
	}

	/**
	 * Get all the AssetTypes in this DigitalRepository.  AssetTypes are used to categorize Assets.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getAssetTypes() {
		$assets =& $this->getAssets();
		$types = array();
		while ($assets->hasNext()) {
			$asset =& $assets->next();
			
			// Make sure we haven't added the type yet.
			$added = FALSE;
			if (count($types)) {
				foreach ($types as $key=>$type) {
					if ($types[$key]->isEqual($asset->getAssetType()))
						$added = TRUE;
				}
			}
			// if we haven't, add the type
			if (!$added)
				$types[] =& $asset->getAssetType();
		}
		
		// create the iterator and return it
		$typeIterator =& new HarmoniTypeIterator($types);
		
		return $typeIterator;
	}

	/**
	 * Get all the InfoStructures in this DigitalRepository.  InfoStructures are used to categorize information about Assets.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoStructureIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getInfoStructures() {
		$dataSetTypeMgr =& Services::getService("DataSetTypeManager");
		$dataSetTypeIds =& $dataSetTypeMgr->getAllDataSetTypeIDs();
		foreach ($dataSetTypeIds as $key => $id) {
			// Check that we have created an infoStructure with the ID
			if (!$this->_createdInfoStructures[$id]) {
				// If not, create the infoStructure
				$dataSetTypeDefinition =& $dataSetTypeMgr->getDataSetTypeDefinitionByID($id);
				$this->_createdInfoStructures[$id] =& new HarmoniInfoStructure(
																$dataSetTypeDefinition);
			}
		}
		
		// create an Iterator and return it
		$iterator =& new HarmoniInfoStructureIterator($this->_createdInfoStructures);
		
		return $iterator;
		
	}

	/**
	 * Get the InfoStructures that this AssetType must support.  InfoStructures are used to categorize information about Assets.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoStructureIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function & getMandatoryInfoStructures(& $assetType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}

	/**
	 * Get all the SearchTypes supported by this DigitalRepository.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getSearchTypes() {
		return new HarmoniTypeIterator($this->_searchTypes);
	}

	/**
	 * Get all the StatusTypes supported by this DigitalRepository.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getStatusTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}

	/**
	 * Get the the StatusType of this Asset.
	 * @return object osid.shared.Type
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function & getStatus(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}

	/**
	 * Validate all the InfoRecords for an Asset and set its status Type accordingly.  If the Asset is valid, return true; otherwise return false.  The implementation may throw an Exception for any validation failures and use the Exception's message to identify specific causes.
	 * null
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function validateAsset(& $assetId) {
		$string = $assetId->getIdString();
		
		$this->_assetValidFlags[$string] = true;
	}

	/**
	 * Set the Asset's status Type accordingly and relax validation checking when creating InfoRecords and InfoFields or updating InfoField's values.
	 * null
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function invalidateAsset(& $assetId) {
		$string = $assetId->getIdString();
		
		$this->_assetValidFlags[$string] = false;
	}

	/**
	 * Get the Asset with the specified Unique Id.
	 *  assetId
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function & getAsset(& $assetId) {
		if (!$this->_createdAssets[$assetId->getIdString()]) {
			// Get the node for this asset to make sure its availible
			if (!$this->_hierarchy->getNode($assetId))
				throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
			
			// create the asset and add it to the cache
			$this->_createdAssets[$assetId->getIdString()] =& new HarmoniAsset($this->_hierarchy, $this, $assetId, $this->_configuration);
			$this->_assetValidFlags[$assetId->getIdString()] = true;
		}
		
		// Dish out the asset.
		return $this->_createdAssets[$assetId->getIdString()];
	}

	/**
	 * Get the Asset with the specified Unique Id and appropriate for the date specified.  The date permits
	 * @param object assetId
	 * @param object DateTime $date The date to get.
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#NO_OBJECT_WITH_THIS_DATE NO_OBJECT_WITH_THIS_DATE}
	 * @package harmoni.osid.dr
	 */
	function & getAssetByDate(& $assetId, & $date) {
		ArgumentValidator::validate($assetId, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($date, new ExtendsValidatorRule("DateTime"));
		
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
		
		// Return an Asset where all InfoRecords have the values that they
		// would have on the specified date.
	}

	/**
	 * Get all the dates for the Asset with the specified Unique Id.  These dates could be for a form of versioning.
	 * @return object osid.shared.CalendarIterator
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.dr
	 */
	function & getAssetDates(& $assetId) {
		ArgumentValidator::validate($assetId, new ExtendsValidatorRule("Id"));
		
		$dataSetMgr =& Services::getService("DataSetManager");
		
		// Get the DataSets in the Asset's DataSetGroup
		$dataSetGroup =& $dataSetMgr->fetchDataSetGroup($assetId->getIdString());
		$dataSets =& $dataSetGroup->fetchDataSets(TRUE);
		
		// Get the dates for all Fields of all DataSets and
		// put them into an array.
		$dates = array();
		$dateStrings = array();
		foreach ($dataSets as $key => $set) {
			if ($dataSets[$key]->isVersionControlled()) {
				$typeDef =& $dataSets[$key]->getDataSetTypeDefinition();
				$labels =& $typeDef->getAllLabels(TRUE);
				foreach ($labels as $labelKey => $label) {
					$versionsObjs =& $dataSets[$key]->getAllValueVersionsObjects($label);
					foreach ($versionsObjs as $versionObjsKey => $versionObj) {
						$versionIDs =& $versionsObjs[$versionObjsKey]->getVersionList();
						foreach ($versionIDs as $id) {
							$version =& $versionsObjs[$versionObjsKey]->getVersion($id);
							$date =& $version->getDate();
				
							// Add Date to the array if it doesn't exist already.
							if (!in_array($date->toTimeStamp(), $dateStrings)) {
								$dateStrings[] = $date->toTimeStamp();
								$dates[] =& $date;
							}
						}
					}
				}
			}
		}

		// Create and return an iterator.
		$dateIterator =& new HarmoniCalendarIterator($dates);
		return $dateIterator;
	}

	/**
	 * Perform a search of the specified Type and get all the Assets that satisfy the SearchCriteria.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @param mixed searchCriteria
	 * @param object searchType
	 * @return object AssetIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function & getAssetsBySearch(& $searchCriteria, & $searchType) {
		// Check that we support the searchType
		$supported = FALSE;
		foreach ($this->_searchTypes as $key => $type) {
			if ($searchType->isEqual($type))
				$supported = TRUE;
		}
		
		if ($supported) {
			$searchFunction = "_searchBy_".$searchType->getAuthority()."_".$searchType->getDomain()."_".$searchType->getKeyword();
			$assetIds =& $this->$searchFunction($searchCriteria);
			
			// get the assets for the resuting ids
			$assets = array();
			foreach ($assetIds as $key => $id) {
				$assets[] =& $this->getAsset($assetIds[$key]);
			}
			
			// create an AssetIterator and return it
			$assetIterator =& new HarmoniAssetIterator($assets);
			
			return $assetIterator;
			
		} else {
			throwError(new Error(UNKNOWN_TYPE, "Digital Repository", 1));
		}
	}

	/**
	 * Create in a copy of an Asset.  The Id, AssetType, and DigitalRepository for the new Asset is set by the implementation.  All InfoRecords are similarly copied.
	 * @param object asset
	 * @return object osid.shared.Id
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function & copyAsset(& $asset) {
		// Copy the asset to the dr root (recursivley for children)
		$id =& $this->_copyAsset($asset, $this->getId());
		
		return $id;
	}
	
	/**
	 * Create an InfoStructure in this DR. This is not part of the DR OSID at 
	 * the time of this writing, but is needed for dynamically created 
	 * InfoStructures.
	 *
	 * @param string $displayName 	The DisplayName of the new InfoStructure.
	 * @param string $description 	The Description of the new InfoStructure.
	 * @param string $format 		The Format of the new InfoStructure.
	 * @param string $schema 		The schema of the new InfoStructure.
	 *
	 * @return object InfoStructure The newly created InfoStructure.
	 */
	function createInfoStructure($displayName, $description, $format, $schema) {
		$dataSetType = new HarmoniType($format, $schema, $displayName, $description);
		$dataSetTypeManager =& Services::getService("DataSetTypeManager");
		
		// Create the TypeDefinition
		$dataSetTypeDef =& $dataSetTypeManager->newDataSetType($dataSetType);
		
		$dataSetTypeManager->synchronize($dataSetTypeDef);
		
		$this->_createdInfoStructures[$dataSetTypeDef->getID()] =& new HarmoniInfoStructure(
																$dataSetTypeDef);
		return $this->_createdInfoStructures[$dataSetTypeDef->getID()];
	}

	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		// Save the Hierarchy
		$this->_node->save();
		
		// Save the dataManager
		//@todo
	}

	/**
	 * Recursively copies an asset and its children to a new parent.
	 *
	 *
	 */
	function & _copyAsset(& $asset, & $newParentId) {
		// Create the new asset
		$newAsset =& $this->createAsset($asset->getDisplayName(),$asset->getDescription(), $asset->getAssetType());
		
		// Move the new asset to the proper parent if it 
		// is not being copied to the dr root.
		if (!$newParentId->isEqual($this->getId())) {
			$newParent =& $this->getAsset($newParentId);
			$newParent->addAsset($newAsset);
		}
		
		// Copy its data
		// @todo
		
		// Copy the children
		$children =& $asset->getChildren();
		while ($children->hasNext()) {
			$childAsset =& $children->next();
			$this->_copyAsset($childAsset, $newAsset->getId());
		}
		
		// Return its Id
		return $newAsset->getId();
	}
	
/******************************************************************************
 * Search Types
 *
 * The private functions below contain the funtionality for searching the DR.
 * The registerSearchTypes() function sets up an array of supported searchTypes
 * for the DR. When creating a search function, be sure to add its type to 
 * registerSearchTypes().
 * Search functions are named _searchBy_TypeAuthority_TypeDomain_TypeKeyword().
 ******************************************************************************/
 	
 	/**
	 * Sets up an array of supported searchTypes for the DR.
	 *
	 * @access private
	 */
	function _registerSearchTypes () {
		$this->_searchTypes = array();
		$this->_searchTypes[] =& new HarmoniType("DR","Harmoni","AssetType", "Select all asset's of the specified Type.");
		
		$this->_searchTypes[] =& new HarmoniType("DR","Harmoni","RootAssets", "Search for just the 'root' 
											or 'top level' assets which are not assets of other assets.");
		
		$this->_searchTypes[] =& new HarmoniType("DR","Harmoni","DisplayName", "Search with a regular expression
												string in the Asset DisplayName.");

		$this->_searchTypes[] =& new HarmoniType("DR","Harmoni","Description", "Search with a regular expression
												string in the Asset Description.");

		$this->_searchTypes[] =& new HarmoniType("DR","Harmoni","Content", "Search with a regular expression
												string in the Asset Content.");

//		$this->_searchTypes[] =& new HarmoniType("DR","Harmoni","AssetInfo", "Search with a regular expression
//												string in the Asset DisplayName, Description, and Content.");
	}
	
	/**
	 * Return assets of the specified type
	 *
	 * @param mixed Search criteria. This is unused for this search and can be anything.
	 * @return array The root assets.
	 * @access private
	 */
	function & _searchBy_harmoni_dr_assettype ($searchCriteria = NULL) {
		// get the root Nodes
		$assets =& $this->getAssetsByType($searchCriteria);
		
		// Add the ids of the root nodes to an array
		$ids = array();
		while ($assets->hasNext()) {
			$asset =& $assets->next();
			$ids[] =& $asset->getId();
		}
		
		// Return the array
		return $ids;
	}
	
	/**
	 * Search for just the 'root' or 'top level' assets which are not assets of other assets.
	 *
	 * @param mixed Search criteria. This is unused for this search and can be anything.
	 * @return array The root assets.
	 * @access private
	 */
	function & _searchBy_harmoni_dr_rootassets ($searchCriteria = NULL) {
		// get the root Nodes
		$rootNodes =& $this->_node->getChildren();
		
		// Add the ids of the root nodes to an array
		$rootIds = array();
		while ($rootNodes->hasNext()) {
			$rootNode =& $rootNodes->next();
			$rootIds[] =& $rootNode->getId();
		}
		
		// Return the array
		return $rootIds;
	}
	
	/**
	 * Search for assets with DisplayNames that match with the searchCriteria as the
	 * search string.
	 *
	 * @param mixed Search criteria. A regular expression search string.
	 * @return array The matching assets.
	 * @access private
	 */
	function & _searchBy_harmoni_dr_displayname ($searchCriteria = NULL) {
		$matchingIds = array();
		
		// Get All the assets
		$assets =& $this->getAssets();
		
		// Add their id to the array if the displayName matches
		while ($assets->hasNext()) {
			$asset =& $assets->next();
			if (ereg($searchCriteria, $asset->getDisplayName()))
				$matchingIds[] =& $asset->getId();
		}
		
		// Return the array
		return $matchingIds;
	}

	/**
	 * Search for assets with Description that match with the searchCriteria as the
	 * search string.
	 *
	 * @param mixed Search criteria. A regular expression search string.
	 * @return array The matching assets.
	 * @access private
	 */
	function & _searchBy_harmoni_dr_description ($searchCriteria = NULL) {
		$matchingIds = array();
		
		// Get All the assets
		$assets =& $this->getAssets();
		
		// Add their id to the array if the displayName matches
		while ($assets->hasNext()) {
			$asset =& $assets->next();
			if (ereg($searchCriteria, $asset->getDescription()))
				$matchingIds[] =& $asset->getId();
		}
		
		// Return the array
		return $matchingIds;
	}
	
	/**
	 * Search for assets with Content that match with the searchCriteria as the
	 * search string.
	 *
	 * @param mixed Search criteria. A regular expression search string.
	 * @return array The matching assets.
	 * @access private
	 */
	function & _searchBy_harmoni_dr_content ($searchCriteria = NULL) {
		$matchingIds = array();
		
		// Get All the assets
		$criteria =& new AndSearch();
		$criteria->addCriteria(new ActiveDataSetsSearch);
		$criteria->addCriteria(new FieldValueSearch(new HarmoniType("DR", "Harmoni", "AssetContent", ""),"Content", new BlobDataType($searchCriteria)));
		
		$dataSetMgr =& Services::getService("DataSetManager");
		$dataSetIds = $dataSetMgr->selectIDsBySearch($criteria);
		
		$groupIds = array();
		foreach  ($dataSetIds as $key => $id) {
			$dataSetGroupIds =& $dataSetMgr->getGroupIdsForDataSet($id);
			$groupIds = array_merge($groupIds, $dataSetGroupIds);
		}
				
		array_unique($groupIds);
				
		$sharedManager =& Services::getService("Shared");
		
		foreach ($groupIds as $id) {
			$matchingIds[] =& $sharedManager->getId($id);
		}
				
		// Return the array
		return $matchingIds;
	}

}
?>