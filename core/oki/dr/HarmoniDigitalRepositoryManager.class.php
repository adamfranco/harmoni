<?
require_once(OKI."dr.interface.php");
require_once(HARMONI."/oki/dr/HarmoniDigitalRepository.class.php");

/**
 * The DigitalRepositoryManager supports creating and deleting Digital 
 * Repositories and Assets as well as getting the various Types used.  
 * <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition 
 * License}.
 *
 * <p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; 
 * SID Definition License}.
 * @package harmoni.osid.dr
 */

class HarmoniDigitalRepositoryManager
	extends DigitalRepositoryManager
{
	
	var $_configuration;
	var $_drValidFlags;
	var $_hierarchy;
	var $_createdDRs;
	
	/**
	 * Constructor
	 * @param array $configuration	An array of the configuration options 
	 * nessisary to load this manager. To use the a specific manager store, a 
	 * store data source must be configured as noted in the class of said 
	 * manager store.
	 * manager.
	 * @access public
	 */
	function HarmoniDigitalRepositoryManager ($configuration = NULL) {
		// Set up our hierarchy
		$hierarchyManager =& Services::getService("Hierarchy");
		$sharedManager =& Services::getService("Shared");
		$hierarchyId =& $sharedManager->getId($configuration['hierarchyId']);
		$this->_hierarchy =& $hierarchyManager->getHierarchy($hierarchyId);
		
		// Cache any created DRs so that we can pass out references to them.
		$this->_createdDRs = array();
		
		// Store the configuration
		$this->_configuration =& $configuration;
		
		
		// Make sure that we have a 'harmoni.dr.assetcontent' type InfoStructure for
		// assets to put their generic content into.
		$type = new HarmoniType("DR", "Harmoni", "AssetContent", "An InfoStructure for the generic content of an asset.");
		$dataSetTypeManager =& Services::getService("DataSetTypeManager");
		if (!$dataSetTypeManager->dataSetTypeExists($type)) {
			$definition =& $dataSetTypeManager->newDataSetType($type);
			$definition->addNewField( new FieldDefinition("Content", "blob"));
			$definition->addNewField( new FieldDefinition("EffectiveDate", "datetime"));
			$definition->addNewField( new FieldDefinition("ExpirationDate", "datetime"));
			$dataSetTypeManager->synchronize($definition);
		}
	}

	/**
	 * Create a new DigitalRepository of the specified Type.  The implementation
	 * of this method sets the Id for the new object.
	 * @param string displayName
	 * @param string description
	 * @param object Type digitalRepositoryType
	 * @return object digitalRepository
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function & createDigitalRepository ($displayName, $description, & $digitalRepositoryType) {
		// Argument Validation
		ArgumentValidator::validate($displayName, new StringValidatorRule);
		ArgumentValidator::validate($description, new StringValidatorRule);
		ArgumentValidator::validate($digitalRepositoryType, new ExtendsValidatorRule("Type"));
		
		// Create an Id for the digital Repository Node
		$sharedManager =& Services::getService("Shared");
		$newId =& $sharedManager->createId();
		
		// Add this DR's root node to the hierarchy.
		$node =& $this->_hierarchy->createRootNode($newId, $digitalRepositoryType, $displayName, $description);
		
		$this->_createdDRs[$newId->getIdString()] =& new HarmoniDigitalRepository ($this->_hierarchy, $newId, $this->_configuration);
		return  $this->_createdDRs[$newId->getIdString()];
	}

	/**
	 * Delete a DigitalRepository.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
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
		
		unset($this->_createdDRs[$digitalRepositoryId->getIdString()]);
	}

	/**
	 * Get all the DigitalRepositories.  Iterators return a group of items, one 
	 * item at a time.  The Iterator's hasNext method returns <code>true</code> 
	 * if there are additional objects available; <code>false</code> otherwise.  
	 * The Iterator's next method returns the next object.
	 * @return object digitalRepositoryIterator  The order of the objects 
	 * returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getDigitalRepositories() {
		$rootNodes =& $this->_hierarchy->getRootNodes();
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
	 * Get all the DigitalRepositories of the specified Type.  Iterators 
	 * return a group of items, one item at a time.  The Iterator's hasNext 
	 * method returns <code>true</code> if there are additional objects 
	 * available; 
	 * <code>false</code> otherwise.  The Iterator's next method returns the 
	 * next object.
	 * @param object Type digitalRepositoryType
	 * @return object digitalRepositoryIterator  The order of the objects returned
	 *  by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one 
	 * of the following messages defined in osid.dr.DigitalRepositoryException 
	 * may be thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function & getDigitalRepositoriesByType(& $digitalRepositoryType) {
		$rootNodes =& $this->_hierarchy->getRootNodes();
		$drs = array();
		while ($rootNodes->hasNext()) {
			$rootNode =& $rootNodes->next();
			
			// If the type is right, get the dr
			if ($digitalRepositoryType->isEqual($rootNode->getType())) {
				// make sure that the dr is loaded into the createdDRs array
				$drs[] =& $this->getDigitalRepository($rootNode->getId());
			}
		}
		
		// create a DigitalRepositoryIterator with all fo the DRs in the createdDRs array
		$drIterator =& new HarmoniDigitalRepositoryIterator($drs);
		
		return $drIterator;
	}

	/**
	 * Get a specific DigitalRepository by Unique Id.
	 *  digitalRepositoryId
	 * @return object digitalRepository
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function & getDigitalRepository(& $digitalRepositoryId) {
		ArgumentValidator::validate($digitalRepositoryId, new ExtendsValidatorRule("Id"));
		
		if (!$this->_createdDRs[$digitalRepositoryId->getIdString()]) {
			// Get the node for this dr to make sure its availible
			if (!$this->_hierarchy->getNode($digitalRepositoryId))
				throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
			
			// create the dr and add it to the cache
			$this->_createdDRs[$digitalRepositoryId->getIdString()] =& new HarmoniDigitalRepository($this->_hierarchy, $digitalRepositoryId, $this->_configuration);
			$this->_drValidFlags[$digitalRepositoryId->getIdString()] = true;
		}
		
		// Dish out the dr.
		return $this->_createdDRs[$digitalRepositoryId->getIdString()];
	}

	/**
	 * Get the Asset with the specified Unique Id.
	 *  assetId
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
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
	 * Get the Asset with the specified Unique Id and appropriate for the date 
	 * specified.  The date permits
	 * @param object assetId
	 * @param object date
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#NO_OBJECT_WITH_THIS_DATE NO_OBJECT_WITH_THIS_DATE}
	 * @package harmoni.osid.dr
	 */
	function & getAssetByDate(& $assetId, & $date) {
		// figure out which DR it is in.
		$drId =& $this->_getAssetDR($assetId);
		$dr =& $this->getDigitalRepository($drId);
		
		//return the assetByDate
		return $dr->getAssetByDate($assetId, $date);
		
	}

	/**
	 * Get all the dates for the Asset with the specified Unique Id.  These 
	 * dates could be for a form of versioning.
	 * @return object osid.shared.CalendarIterator
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.dr
	 */
	function & getAssetDates(& $assetId) {
		// figure out which DR it is in.
		$drId =& $this->_getAssetDR($assetId);
		$dr =& $this->getDigitalRepository($drId);
		
		//return the assetByDate
		return $dr->getAssetDates($assetId, $date);
	}

	/**
	 * Perform a search of the specified Type and get all the Assets that 
	 * satisfy the SearchCriteria.  The search is performed for all specified 
	 * DigitalRepositories.  Iterators return a group of items, one item at a 
	 * time.  The Iterator's hasNext method returns <code>true</code> if there 
	 * are additional objects available; <code>false</code> otherwise.  The 
	 * Iterator's next method returns the next object.
	 * @param object digitalRepositories
	 * @param mixed searchCriteria
	 * @param object searchType
	 * @return object AssetIterator  The order of the objects returned by the 
	 * Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}, 
	 * {@link DigitalRepositoryException#UNKNOWN_DR UNKNOWN_DR}
	 * @package harmoni.osid.dr
	 */
	function & getAssets(& $digitalRepositories, & $searchCriteria, & $searchType) {
		$combinedAssets = array();
		
		foreach ($digitalRepositories as $key => $val) {
			// Get the assets that match from this DR.
			$assets =& $digitalRepositories[$key]->getAssetsBySearch($searchCriteria, $searchType);
			
			// Add the assets from this dr into our combined array.
			while ($assets->hasNext()) {
				$combinedAssets[] =& $assets->next();
			}
		}
		
		// create an AssetIterator with all fo the Assets in the createdAssets array
		$assetIterator =& new HarmoniAssetIterator($combinedAssets);
		
		return $assetIterator;
	}
	
	/**
	 * Create in a DigitalRepository a copy of an Asset.  The Id, AssetType, and 
	 * DigitalRepository for the new Asset is set by the implementation.  All 
	 * InfoRecords are similarly copied.
	 * @param object digitalRepository
	 * @param object assetId
	 * @return object osid.shared.Id
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function & copyAsset(& $digitalRepository, & $assetId) {
		$asset =& $digitalRepository->getAsset($assetId);
		return $digitalRepository->copyAsset( $asset );
	}
	// :: full java declaration :: osid.shared.Id copyAsset(DigitalRepository digitalRepository, osid.shared.Id assetId)

	/**
	 * Get all the DigitalRepositoryTypes in this DigitalRepositoryManager.  
	 * DigitalRepositoryTypes are used to categorize DigitalRepositories.  
	 * Iterators return a group of items, one item at a time.  The Iterator's 
	 * hasNext method returns <code>true</code> if there are additional objects 
	 * available; <code>false</code> otherwise.  The Iterator's next method 
	 * returns the next object.
	 * @return object osid.shared.TypeIterator  The order of the objects 
	 * returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be 
	 * thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getDigitalRepositoryTypes() {
		$drs =& $this->getDigitalRepositories();
		$types = array();
		$typeStrings = array();
		while ($drs->hasNext()) {
			$dr =& $drs->next();
			$type =& $dr->getType();
			$typeString = $type->getAuthority()."::".$type->getDomain()."::".$type->getKeyword();
			if (!in_array($typeString, $typeStrings)) {
				$typeStrings[] = $typeString;
				$types[] =& $type;
			}
		}
		return new HarmoniTypeIterator($types);
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
	 * The stop function is called when a Harmoni service object is being 
	 * destroyed.
	 * Services may want to do post-processing such as content output or 
	 * committing changes to a database, etc.
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