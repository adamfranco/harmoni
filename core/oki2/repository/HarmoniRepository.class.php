<?

require_once(HARMONI."/oki2/repository/HarmoniRepository.interface.php");
require_once(HARMONI."/oki2/repository/HarmoniAsset.class.php");
require_once(HARMONI."/oki2/repository/HarmoniAssetIterator.class.php");
require_once(HARMONI."/oki2/repository/HarmoniRepositoryIterator.class.php");
require_once(HARMONI."/oki2/repository/HarmoniInfoStructure.class.php");
require_once(HARMONI."/oki2/repository/File/FileInfoStructure.class.php");
require_once(HARMONI."/oki2/repository/File/FileInfoRecord.class.php");
require_once(HARMONI."/oki2/repository/HarmoniInfoStructureIterator.class.php");//where is this now?
require_once(HARMONI."/oki2/shared/HarmoniTypeIterator.class.php");
require_once(HARMONI."/oki2/shared/HarmoniCalendarIterator.class.php");

// Search Modules
require_once(dirname(__FILE__)."/SearchModules/AssetTypeSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/ContentSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/DescriptionSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/DisplayNameSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/RootAssetSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/AllCustomFieldsSearch.class.php");

/**
 * Repository manages Assets of various Types and information about the Assets.
 * Assets are created, persisted, and validated by the Repository.	When
 * initially created, an Asset has an immutable Type and unique Id and its
 * validation status is false.	In this state, all methods can be called, but
 * integrity checks are not enforced.  When the Asset and its Records are
 * ready to be validated, the validateAsset method checks the Asset and sets
 * the validation status.  When working with a valid Asset, all methods
 * include integrity checks and an exception is thrown if the activity would
 * result in an inappropriate state.  Optionally, the invalidateAsset method
 * can be called to release the requirement for integrity checks, but the
 * Asset will not become valid again, until validateAsset is called and the
 * entire Asset is checked.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * <p>
 * Licensed under the {@link org.osid.SidImplementationLicenseMIT MIT
 * O.K.I&#46; OSID Definition License}.
 * </p>
 * 
 * @package org.osid.repository
 */

class HarmoniRepository
	extends HarmoniRepositoryInterface
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
	function HarmoniRepository (& $hierarchy, & $id, & $configuration) {
		// Get the node coresponding to our id
		$this->_hierarchy =& $hierarchy;
		$this->_node =& $this->_hierarchy->getNode($id);
		
		// Cache any created Assets so that we can pass out references to them.
		$this->_createdAssets = array();
		$this->_assetValidFlags = array();
//		$this->_assetDataSets = array();
		
		// Set up an array of searchTypes that this DR supports
		$this->_registerSearchTypes();
		
		// Define the type to use as a key for Identifying DRs
		$this->_repositoryKeyType =& new HarmoniType("Repository", "Harmoni", 
							"Repository", "Nodes with this type are by definition Repositories.");
		
		// Set up an array of created Info structures so we can pass out references to them.
		$this->_createdInfoStructures = array();
		
		// Add the file InfoStructure to the DR
		$this->_createdInfoStructures['FILE'] =& new HarmoniFileInfoStructure;
		
		// Built-in Types
		// Keys of the array are the infoStructure Ids,
		// Vals of the array are the record class-names to instantiate.
		$this->_builtInTypes = array();
		$this->_builtInTypes['FILE'] = 'FileInfoRecord';
		
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
   * Update the display name for this Repository.
   * 
   * @param string $displayName
   * 
   * @throws object RepositoryException An exception with one of
   *		 the following messages defined in
   *		 org.osid.repository.RepositoryException may be thrown: {@link
   *		 org.osid.repository.RepositoryException#OPERATION_FAILED
   *		 OPERATION_FAILED}, {@link
   *		 org.osid.repository.RepositoryException#PERMISSION_DENIED
   *		 PERMISSION_DENIED}, {@link
   *		 org.osid.repository.RepositoryException#CONFIGURATION_ERROR
   *		 CONFIGURATION_ERROR}, {@link
   *		 org.osid.repository.RepositoryException#UNIMPLEMENTED
   *		 UNIMPLEMENTED}, {@link
   *		 org.osid.repository.RepositoryException#NULL_ARGUMENT
   *		 NULL_ARGUMENT}
   * 
   * @public
   */
  function updateDisplayName ( $displayName ) { 
			$this->_node->updateDisplayName($displayName);
	}
	
	 /**
   * Get the display name for this Repository.
   *  
   * @return string
   * 
   * @throws object RepositoryException An exception with one of
   *		 the following messages defined in
   *		 org.osid.repository.RepositoryException may be thrown: {@link
   *		 org.osid.repository.RepositoryException#OPERATION_FAILED
   *		 OPERATION_FAILED}, {@link
   *		 org.osid.repository.RepositoryException#PERMISSION_DENIED
   *		 PERMISSION_DENIED}, {@link
   *		 org.osid.repository.RepositoryException#CONFIGURATION_ERROR
   *		 CONFIGURATION_ERROR}, {@link
   *		 org.osid.repository.RepositoryException#UNIMPLEMENTED
   *		 UNIMPLEMENTED}
   * 
   * @public
   */
  function getDisplayName () { 
		return $this->_node->getDisplayName();
	}
	/**
   * Get the unique Id for this Repository.
   *  
   * @return object Id
   * 
   * @throws object RepositoryException An exception with one of
   *		 the following messages defined in
   *		 org.osid.repository.RepositoryException may be thrown: {@link
   *		 org.osid.repository.RepositoryException#OPERATION_FAILED
   *		 OPERATION_FAILED}, {@link
   *		 org.osid.repository.RepositoryException#PERMISSION_DENIED
   *		 PERMISSION_DENIED}, {@link
   *		 org.osid.repository.RepositoryException#CONFIGURATION_ERROR
   *		 CONFIGURATION_ERROR}, {@link
   *		 org.osid.repository.RepositoryException#UNIMPLEMENTED
   *		 UNIMPLEMENTED}
   * 
   * @public
   */
  
	function &getId() {
		return $this->_node->getId();
	}

	/**
	 * Get the RepositoryType of this Repository.
	 *  
	 * @return object Type
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		 the following messages defined in
	 *		 org.osid.repository.RepositoryException may be thrown: {@link
	 *		 org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		 OPERATION_FAILED}, {@link
	 *		 org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		 PERMISSION_DENIED}, {@link
	 *		 org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		 CONFIGURATION_ERROR}, {@link
	 *		 org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		 UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function &getType () { 
		// If we don't have it cached, get our type.
		if (!$this->_type) {
			$myId =& $this->getId();
			
			$query =& new SelectQuery;
			$query->addColumn("type_domain");
			$query->addColumn("type_authority");
			$query->addColumn("type_keyword");
			$query->addColumn("type_description");
			$query->addTable("dr_repository_type");
			$query->addTable("dr_type", INNER_JOIN, "fk_dr_type = type_id");
			$query->addWhere("repository_id = '".addslashes($myId->getIdString())."'");
			
			$dbc =& Services::getService("DBHandler");
			$result =& $dbc->query($query, $this->_configuration['dbId']);
			
			// Return our type
			if ($result->getNumberOfRows()) {
				$this->_type =& new HarmoniType($result->field("type_domain"),
												$result->field("type_authority"),
												$result->field("type_keyword"),
												$result->field("type_description"));
			} 
			// Otherwise, throw an error
			else {
				throwError(new Error(RepositoryException::OPERATION_FAILED(), "Repository", 1));
			}
		}
		
		return $this->_type;
	}

//editting of this file stopped here on 01-14-2004 -- bgore

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
	 * Create a new Asset of this AssetType to this DigitalRepository.	The implementation of this method sets the Id for the new object.
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function &createAsset($displayName, $description, & $assetType) {
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
		
		// Delete the Record Set
		$recordMgr =& Services::getService("RecordManager");
		$assetId =& $asset->getId();
		$recordMgr->deleteRecordSet($assetId->getIdString());
		
		// Delete the Node for this Asset
		$this->_hierarchy->deleteNode($assetId);
		
		// Delete this asset from the createdAssets cache
		unset($this->_createdAssets[$assetId->getIdString()]);
	}

	/**
	 * Get all the Assets in this DigitalRepository.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.	The Iterator's next method returns the next object.
	 * @return object AssetIterator	 The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getAssets() {
		// get a list for all the nodes under this hierarchy.
		$traversalInfoIterator =& $this->_hierarchy->traverse($this->_node->getId(), 
										TRAVERSE_MODE_DEPTH_FIRST, TRAVERSE_DIRECTION_DOWN, 
										TRAVERSE_LEVELS_INFINITE);
		
		// These are for ignoring nodes, used when we have another repository
		// as a child.
		$ignoreNodes = FALSE;
		$childRepositoryLevel = NULL;
		
		while ($traversalInfoIterator->hasNext()) {
			$traversalInfo =& $traversalInfoIterator->next();
			$assetId =& $traversalInfo->getNodeId();
			
			// If we are skipping a child repository, break out of skipping
			// when we have reached the level of the child repository and
			// its siblings.
			if ($ignoreNodes 
				&& $traversalInfo->getLevel() <= $childRepositoryLevel)
			{
				$ignoreNodes = FALSE;
				$childRepositoryLevel = NULL;
			}
			
			// make sure that the asset is loaded into the createdAssets array
			// make sure that we don't create an asset with the id of the dr.
			if (!$assetId->isEqual($this->getId())) {
				$node =& $this->_hierarchy->getNode($assetId);
				
				// Make sure the child nod is not also a DR
				// If the node has the type which defines it as an repository
				// ignore it and its children.
				if ($this->_repositoryKeyType->isEqual($node->getType())) {
					$ignoreNodes = TRUE;
					$childRepositoryLevel = $traversalInfo->getLevel();
				}
				
				if (!$ignoreNodes)
					$this->getAsset($assetId);
			}
		}
		
		// create an AssetIterator with all fo the Assets in the createdAssets array
		$assetIterator =& new HarmoniAssetIterator($this->_createdAssets);
		
		return $assetIterator;
	}

	/**
	 * Get all the Assets of the specified AssetType in this Asset.	 Iterators return a group of items, one item at a time.	 The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object AssetIterator	 The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function &getAssetsByType(& $assetType) {
		ArgumentValidator::validate($assetType, new ExtendsValidatorRule("TypeInterface"));
		$assets = array();
		$allAssets =& $this->getAssets();
		while ($allAssets->hasNext()) {
			$asset =& $allAssets->next();
			if ($assetType->isEqual($asset->getAssetType()))
				$assets[] =& $asset;
		}
		
		return new HarmoniAssetIterator($assets);
	}

	/**
	 * Get all the AssetTypes in this DigitalRepository.  AssetTypes are used to categorize Assets.	 Iterators return a group of items, one item at a time.	 The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator	The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getAssetTypes() {
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
	 * Get the InfoStructure in this DigitalRepository with the specified Id.  InfoStructures are used to categorize information about Assets.
	 * Note: This method is a Harmoni addition to the OSID and at the time of this writing,
	 * was not a part of the DR OSID.
	 * @param object $infoStructureId
	 * @return object InfoStructure	 The InfoStructure of the requested Id.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getInfoStructure( & $infoStructureId ) {
		// Check that we have created an infoStructure with the ID
		if (!$this->_createdInfoStructures[$infoStructureId->getIdString()]) {
			// If not, create the infoStructure
			$schemaMgr =& Services::getService("SchemaManager");
			$schema =& $schemaMgr->getSchemaByID($infoStructureId->getIdString());
			$this->_createdInfoStructures[$infoStructureId->getIdString()] =& new HarmoniInfoStructure(
															$schema);
		}
		
		return $this->_createdInfoStructures[$infoStructureId->getIdString()];
		
	}
	
	/**
	 * Get all the InfoStructures in this DigitalRepository.  InfoStructures are used to categorize information about Assets.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.	 The Iterator's next method returns the next object.
	 * @return object InfoStructureIterator	 The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getInfoStructures() {
		$schemaMgr =& Services::getService("SchemaManager");
		$schemaIDs =& $schemaMgr->getAllSchemaIDs();
		foreach ($schemaIDs as $id) {
			// Check that we have created an infoStructure with the ID
			if (!$this->_createdInfoStructures[$id]) {
				// If not, create the infoStructure
				$schema =& $schemaMgr->getSchemaByID($id);
				$this->_createdInfoStructures[$id] =& new HarmoniInfoStructure(
																$schema);
			}
		}
		
		// create an Iterator and return it
		$iterator =& new HarmoniInfoStructureIterator($this->_createdInfoStructures);
		
		return $iterator;
		
	}

	/**
	 * Get the InfoStructures that this AssetType must support.	 InfoStructures are used to categorize information about Assets.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.	The Iterator's next method returns the next object.
	 * @return object InfoStructureIterator	 The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function &getMandatoryInfoStructures(& $assetType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}

	/**
	 * Get all the SearchTypes supported by this DigitalRepository.	 Iterators return a group of items, one item at a time.	 The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator	The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getSearchTypes() {
		return new HarmoniTypeIterator($this->_searchTypes);
	}

	/**
	 * Get all the StatusTypes supported by this DigitalRepository.	 Iterators return a group of items, one item at a time.	 The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator	The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getStatusTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}

	/**
	 * Get the the StatusType of this Asset.
	 * @return object osid.shared.Type
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function &getStatus(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}

	/**
	 * Validate all the InfoRecords for an Asset and set its status Type accordingly.  If the Asset is valid, return true; otherwise return false.	The implementation may throw an Exception for any validation failures and use the Exception's message to identify specific causes.
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
	 *	assetId
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function &getAsset(& $assetId) {
		if (!$this->_createdAssets[$assetId->getIdString()]) {
			// Get the node for this asset to make sure its availible
			if (!$this->_hierarchy->getNode($assetId))
				throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
			
			// Verify that the requested Asset is in this DR.
			$drMan =& Services::getService("DR");
			if (!$drId = $drMan->_getAssetDR($assetId)
				|| !$drId->isEqual($this->getId()))
			{
				throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
			}		
			
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
	function &getAssetByDate(& $assetId, & $date) {
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
	function &getAssetDates(& $assetId) {
		ArgumentValidator::validate($assetId, new ExtendsValidatorRule("Id"));
		
		$recordMgr =& Services::getService("RecordManager");
		
		// Get the DataSets in the Asset's DataSetGroup
		$recordSet =& $recordMgr->fetchRecordSet($assetId->getIdString());
//		$recordSet->loadRecords(RECORD_FULL);
//		$records =& $dataSetGroup->fetchDataSets(TRUE);
		
		$dates = $recordSet->getMergedTagDates();

		// Create and return an iterator.
		$dateIterator =& new HarmoniCalendarIterator($dates);
		return $dateIterator;
	}

	/**
	 * Perform a search of the specified Type and get all the Assets that satisfy the SearchCriteria.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.	 The Iterator's next method returns the next object.
	 * @param mixed searchCriteria
	 * @param object searchType
	 * @return object AssetIterator	 The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.dr
	 */
	function &getAssetsBySearch(& $searchCriteria, & $searchType) {
		// Check that we support the searchType
		$supported = FALSE;
		foreach ($this->_searchTypes as $key => $type) {
			if ($searchType->isEqual($type)) {
				$supported = TRUE;
				$searchName = $key;
				break;
			}
		}
		
		if ($supported) {
			$search =& new $searchName($this);
			$assetIds =& $search->searchAssets($searchCriteria);
			
			// get the assets for the resuting ids
			$assets = array();
			foreach ($assetIds as $key => $id) {
				$assets[] =& $this->getAsset($assetIds[$key]);
			}
			
			// create an AssetIterator and return it
			$assetIterator =& new HarmoniAssetIterator($assets);
			
			return $assetIterator;
			
		} else {
			throwError(new Error(UNKNOWN_TYPE." ".$searchType->getDomain()."::".$searchType->getAuthority()."::".$searchType->getKeyword(), "Digital Repository", 1));
		}
	}

	/**
	 * Create in a copy of an Asset.  The Id, AssetType, and DigitalRepository for the new Asset is set by the implementation.	All InfoRecords are similarly copied.
	 * @param object asset
	 * @return object osid.shared.Id
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function &copyAsset(& $asset) {
		// Copy the asset to the dr root (recursivley for children)
		$id =& $this->_copyAsset($asset, $this->getId());
		
		return $id;
	}
	
	/**
	 * Create an InfoStructure in this DR. This is not part of the DR OSID at 
	 * the time of this writing, but is needed for dynamically created 
	 * InfoStructures.
	 *
	 * @param string $displayName	The DisplayName of the new InfoStructure.
	 * @param string $description	The Description of the new InfoStructure.
	 * @param string $format		The Format of the new InfoStructure.
	 * @param string $schema		The schema of the new InfoStructure.
	 *
	 * @return object InfoStructure The newly created InfoStructure.
	 */
	function createInfoStructure($displayName, $description, $format, $schema) {
		$recordType = new HarmoniType($format, $schema, $displayName, $description);
		$schemaMgr =& Services::getService("SchemaManager");
		
		// Create the Schema
		$schema =& new Schema($recordType);
		$schemaMgr->synchronize($schema);
		
		// The SchemaManager only allows you to use Schemas created by it for use with Records.
		$schema =& $schemaMgr->getSchemaByType($recordType);
		//debug::output("InfoStructure is being created from Schema with Id: '".$schema->getID()."'");
		
		$this->_createdInfoStructures[$schema->getID()] =& new HarmoniInfoStructure(
																$schema);
		return $this->_createdInfoStructures[$schema->getID()];
	}

	/**
	 * Recursively copies an asset and its children to a new parent.
	 *
	 *
	 */
	function &_copyAsset(& $asset, & $newParentId) {
		// Create the new asset
		$newAsset =& $this->createAsset($asset->getDisplayName(),$asset->getDescription(), $asset->getAssetType());
		
		// Move the new asset to the proper parent if it 
		// is not being copied to the dr root.
		if (!$newParentId->isEqual($this->getId())) {
			$newParent =& $this->getAsset($newParentId);
			$newParent->addAsset($newAsset->getId());
		}
		
		// Copy its data
		// @todo
		
		// Copy the children
		$children =& $asset->getAssets();
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
		
		// classname => type obj
		
		$this->_searchTypes["AssetTypeSearch"] =& new HarmoniType("DR","Harmoni","AssetType", "Select all asset's of the specified Type.");
		
		$this->_searchTypes["RootAssetSearch"] =& new HarmoniType("DR","Harmoni","RootAssets", "Search for just the 'root' 
											or 'top level' assets which are not assets of other assets.");
		
		$this->_searchTypes["DisplayNameSearch"] =& new HarmoniType("DR","Harmoni","DisplayName", "Search with a regular expression
												string in the Asset DisplayName.");

		$this->_searchTypes["DescriptionSearch"] =& new HarmoniType("DR","Harmoni","Description", "Search with a regular expression
												string in the Asset Description.");

		$this->_searchTypes["ContentSearch"] =& new HarmoniType("DR","Harmoni","Content", "Search with a regular expression
												string in the Asset Content.");

		$this->_searchTypes["AllCustomFieldsSearch"] =& new HarmoniType("DR","Harmoni","AllCustomStructures", "Search with a regular expression
								string in the custom InfoStructures for each Asset.");
	}

}

?>