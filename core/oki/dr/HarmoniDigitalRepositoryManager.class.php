<?
require_once(OKI."dr.interface.php");
require_once(HARMONI."/oki/dr/HarmoniDigitalRepository.class.php");

/**
 * The DigitalRepositoryManager supports creating and deleting Digital 
 * Repositories and Assets as well as getting the various Types used.  
 * <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition 
 * License}.
 *
 * @package harmoni.osid_v1.dr
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniDigitalRepositoryManager.class.php,v 1.26 2005/03/29 19:44:17 adamfranco Exp $ */

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
		
		// Record what parent to store newly created DRs under
		if ($configuration['defaultParentId']) {
			$this->_defaultParentId =& $sharedManager->getId($configuration['defaultParentId']);
		} else {
			$this->_defaultParentId = NULL;
		}
		
		// Define the type to use as a key for Identifying DRs
		$this->_repositoryKeyType =& new HarmoniType("Repository", "Harmoni", 
							"Repository", "Nodes with this type are by definition Repositories.");
		
		// Cache any created DRs so that we can pass out references to them.
		$this->_createdDRs = array();
		
		// Store the configuration
		$this->_configuration =& $configuration;
		
		
		// Make sure that we have a 'harmoni.dr.assetcontent' type InfoStructure for
		// assets to put their generic content into.
//		$type = new HarmoniType("DR", "Harmoni", "AssetContent", "An InfoStructure for the generic content of an asset.");
//		$dataSetTypeManager =& Services::getService("DataSetTypeManager");
//		if (!$dataSetTypeManager->dataSetTypeExists($type)) {
//			$definition =& $dataSetTypeManager->newDataSetType($type);
//			$definition->addNewField( new FieldDefinition("Content", "blob"));
//			$definition->addNewField( new FieldDefinition("EffectiveDate", "datetime"));
//			$definition->addNewField( new FieldDefinition("ExpirationDate", "datetime"));
//			$dataSetTypeManager->synchronize($definition);
//		}

		$schemaMgr =& Services::getService("SchemaManager");
		$recordType = new HarmoniType("DR", "Harmoni", "AssetContent", "An InfoStructure for the generic content of an asset.");
		
		if (!$schemaMgr->schemaExists($recordType)) {
			// Create the Schema
			$schema =& new Schema($recordType);
			$schemaMgr->synchronize($schema);
			
			// The SchemaManager only allows you to use Schemas created by it for use with Records.
			$schema =& $schemaMgr->getSchemaByType($recordType);
			debug::output("InfoStructure is being created from Schema with Id: '".$schema->getID()."'");
			
			$this->_createdInfoStructures[$schema->getID()] =& new HarmoniInfoStructure(
																	$schema);
			// Add the parts to the schema
			$partType = new HarmoniType("DR", "Harmoni", "Blob", "");
			$this->_createdInfoStructures[$schema->getID()]->createInfoPart(
																"Content",
																"The binary content of the Asset",
																$partType,
																FALSE,
																FALSE,
																FALSE
																);
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
	 */
	function &createDigitalRepository ($displayName, $description, & $digitalRepositoryType) {
		// Argument Validation
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule());
		ArgumentValidator::validate($description, StringValidatorRule::getRule());
		ArgumentValidator::validate($digitalRepositoryType, ExtendsValidatorRule::getRule("Type"));
		
		// Create an Id for the digital Repository Node
		$sharedManager =& Services::getService("Shared");
		$newId =& $sharedManager->createId();
		
		// Store the type passed in our own table as we will be using
		// a special type, "_repositoryKeyType", as definition of which
		// Nodes in the Hierarchy are Repositories.
		$dbc =& Services::getService("DBHandler");
		
		$query =& new SelectQuery;
		$query->addColumn("type_id");
		$query->addTable("dr_type");
		$query->addWhere("type_domain = '".addslashes($digitalRepositoryType->getDomain())."'");
		$query->addWhere("type_authority = '".addslashes($digitalRepositoryType->getAuthority())."'", _AND);
		$query->addWhere("type_keyword = '".addslashes($digitalRepositoryType->getKeyword())."'", _AND);
		
		$result =& $dbc->query($query, $this->_configuration['dbId']);
		
		if ($result->getNumberOfRows()) {
			$typeId = $result->field("type_id");
		} else {
			$query =& new InsertQuery;
			$query->setTable("dr_type");
			$query->setColumns(array(
								"type_domain",
								"type_authority",
								"type_keyword",
								"type_description",
							));
			$query->setValues(array(
								"'".addslashes($digitalRepositoryType->getDomain())."'",
								"'".addslashes($digitalRepositoryType->getAuthority())."'",
								"'".addslashes($digitalRepositoryType->getKeyword())."'",
								"'".addslashes($digitalRepositoryType->getDescription())."'",
							));
			
			$result =& $dbc->query($query, $this->_configuration['dbId']);
			$typeId = $result->getLastAutoIncrementValue();
		}
		
		$query =& new InsertQuery;
		$query->setTable("dr_repository_type");
		$query->setColumns(array(
							"repository_id",
							"fk_dr_type",
						));
		$query->setValues(array(
							"'".addslashes($newId->getIdString())."'",
							"'".addslashes($typeId)."'",
						));
		
		$result =& $dbc->query($query, $this->_configuration['dbId']);
		
		
		// Add this DR's node to the hierarchy.
		// If we don't have a default parent specified, create
		// it as a root node
		if ($this->_defaultParentId == NULL) {
			$node =& $this->_hierarchy->createRootNode($newId, 
						$this->_repositoryKeyType, $displayName, $description);
		} 
		// If we have a default parent specified, create the
		// Node as a child of that.
		else {
			$node =& $this->_hierarchy->createNode($newId, 
						$this->_defaultParentId, 
						$this->_repositoryKeyType, $displayName, $description);
		}
		
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
		
		// Delete type type for the Repository
		$query =& new DeleteQuery;
		$query->setTable("dr_repository_type");
		$query->addWhere("repository_id = '"
						.addslashes($digitalRepositoryId->getIdString())
						."' LIMIT 1");
		$dbc =& Services::getService("DBHandler");
		$dbc->query($query, $this->_configuration['dbId']);
		
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
	 */
	function &getDigitalRepositories() {
		$nodes =& $this->_hierarchy->getNodesByType($this->_repositoryKeyType);
		while ($nodes->hasNext()) {
			$node =& $nodes->next();
			
			// make sure that the dr is loaded into the createdDRs array
			$this->getDigitalRepository($node->getId());
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
	 */
	function &getDigitalRepositoriesByType(& $digitalRepositoryType) {
		ArgumentValidator::validate($digitalRepositoryType, ExtendsValidatorRule::getRule("Type"));
		
		// Select the Ids of corresponding DRs
		$query =& new SelectQuery;
		$query->addColumn("repository_id");
		$query->addTable("dr_repository_type");
		$query->addTable("dr_type", INNER_JOIN, "fk_dr_type = type_id");
		$query->addWhere("type_domain = '".addslashes($digitalRepositoryType->getDomain())."'");
		$query->addWhere("type_authority = '".addslashes($digitalRepositoryType->getAuthority())."'", _AND);
		$query->addWhere("type_keyword = '".addslashes($digitalRepositoryType->getKeyword())."'", _AND);
		
		$dbc =& Services::getService("DBHandler");
		$result =& $dbc->query($query, $this->_configuration['dbId']);
		
		$shared =& Services::getService("Shared");
		
		$drs = array();
		while ($result->hasMoreRows()) {
			$idString = $result->field("repository_id");
			$id =& $shared->getId($idString);
			
			// make sure that the dr is loaded into the createdDRs array
			$drs[] =& $this->getDigitalRepository($id);
			$result->advanceRow();
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
	 */
	function &getDigitalRepository(& $digitalRepositoryId) {
		ArgumentValidator::validate($digitalRepositoryId, ExtendsValidatorRule::getRule("Id"));
		
		if (!$this->_createdDRs[$digitalRepositoryId->getIdString()]) {
			// Get the node for this dr to make sure its availible
			if (!$node = $this->_hierarchy->getNode($digitalRepositoryId))
				throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
			if (!$this->_repositoryKeyType->isEqual($node->getType()))
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
	 */
	function &getAsset(& $assetId) {
		ArgumentValidator::validate($assetId, ExtendsValidatorRule::getRule("Id"));
		
		// Get the node for this asset to make sure its availible
		if (!$this->_hierarchy->getNode($assetId))
			throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
		
		// figure out which DR it is in.
		if (! $drId =& $this->_getAssetDR($assetId))
			throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
			
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
	 */
	function &getAssetByDate(& $assetId, & $date) {
		// figure out which DR it is in.
		if (! $drId =& $this->_getAssetDR($assetId))
			throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
			
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
	 */
	function &getAssetDates(& $assetId) {
		// figure out which DR it is in.
		if (! $drId =& $this->_getAssetDR($assetId))
			throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
			
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
	 */
	function &getAssets(& $digitalRepositories, & $searchCriteria, & $searchType) {
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
	 */
	function &copyAsset(& $digitalRepository, & $assetId) {
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
	 */
	function &getDigitalRepositoryTypes() {
		$types = array();
		
		$query =& new SelectQuery;
		$query->addColumn("type_domain");
		$query->addColumn("type_authority");
		$query->addColumn("type_keyword");
		$query->addColumn("type_description");
		$query->addTable("dr_type");
		
		$dbc =& Services::getService("DBHandler");
		$result =& $dbc->query($query, $this->_configuration['dbId']);
		
		// Return our types
		while ($result->hasMoreRows()) {
			$types[] =& new HarmoniType($result->field("type_domain"),
											$result->field("type_authority"),
											$result->field("type_keyword"),
											$result->field("type_description"));
			$result->advanceRow();
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
 	
 	// If we have reached the top of the hierarchy and don't have a parent that
 	// is of the DR type, then we aren't in a DR and are therefore unknown
 	// to the DR manager.
 	if ($node->isRoot())
 		return FALSE;
 	
 	// Get the parent and return its ID if it is a root node (drs are root nodes).
 	$parents =& $node->getParents();
 	
 	// Make sure that we have Parents
 	if (!$parents->hasNext())
 		return FALSE;
 	
 	// assume a single-parent hierarchy
 	$parent =& $parents->next();
 	
 	if ($this->_repositoryKeyType->isEqual($parent->getType()))
 		return $parent->getId();
 	else
 		return $this->_getAssetDR( $parent->getId() );
 }

}


?>