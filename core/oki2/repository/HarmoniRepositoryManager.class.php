<?
require_once(OKI2."osid/repository/RepositoryManager.php");
require_once(HARMONI."oki2/repository/HarmoniRepository.class.php");

/**
 * <p>
 * The RepositoryManager supports creating and deleting Repositories and Assets
 * as well as getting the various Types used.
 * </p>
 * 
 * <p>
 * All implementations of OsidManager (manager) provide methods for accessing
 * and manipulating the various objects defined in the OSID package. A manager
 * defines an implementation of an OSID. All other OSID objects come either
 * directly or indirectly from the manager. New instances of the OSID objects
 * are created either directly or indirectly by the manager.  Because the OSID
 * objects are defined using interfaces, create methods must be used instead
 * of the new operator to create instances of the OSID objects. Create methods
 * are used both to instantiate and persist OSID objects.  Using the
 * OsidManager class to define an OSID's implementation allows the application
 * to change OSID implementations by changing the OsidManager package name
 * used to load an implementation. Applications developed using managers
 * permit OSID implementation substitution without changing the application
 * source code. As with all managers, use the OsidLoader to load an
 * implementation of this interface.
 * </p>
 * 
 * <p></p>
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package harmoni.XXXX.YYYYYY
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: HarmoniRepositoryManager.class.php,v 1.4 2005/01/19 21:39:18 thebravecowboy Exp $ 
 */

class HarmoniRepositoryManager
	extends RepositoryManager
{
	
	var $_configuration;
	var $_repositoryValidFlags;
	var $_hierarchy;
	var $_createdRepositories;
	
	/**
	 * Constructor
	 * @param array $configuration	An array of the configuration options 
	 * nessisary to load this manager. To use the a specific manager store, a 
	 * store data source must be configured as noted in the class of said 
	 * manager store.
	 * manager.
	 * @access public
	 */
	function HarmoniRepositoryManager ($configuration = NULL) {
		// Set up our hierarchy
		$hierarchyManager =& Services::getService("Hierarchy");
		$sharedManager =& Services::getService("Shared");
		$hierarchyId =& $sharedManager->getId($configuration['hierarchyId']);
		$this->_hierarchy =& $hierarchyManager->getHierarchy($hierarchyId);
		
		// Record what parent to store newly created repositories under
		if ($configuration['defaultParentId']) {
			$this->_defaultParentId =& $sharedManager->getId($configuration['defaultParentId']);
		} else {
			$this->_defaultParentId = NULL;
		}
		
		// Define the type to use as a key for Identifying repositories
		$this->_repositoryKeyType =& new HarmoniType("Repository", "Harmoni", 
							"Repository", "Nodes with this type are by definition Repositories.");
		
		// Cache any created repositories so that we can pass out references to them.
		$this->_createdRepositories = array();
		
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
		$recordType = new HarmoniType("Repository", "Harmoni", "AssetContent", "An InfoStructure for the generic content of an asset.");
		
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
			$partType = new HarmoniType("Repository", "Harmoni", "Blob", "");
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
   * Create a new Repository of the specified Type.  The implementation of
   * this method sets the Id for the new object.
   * 
   * @param string $displayName
   * @param string $description
   * @param object Type $repositoryType
   *  
   * @return object Repository
   * 
   * @throws object RepositoryException An exception with one of
   *         the following messages defined in
   *         org.osid.repository.RepositoryException may be thrown: {@link
   *         org.osid.repository.RepositoryException#OPERATION_FAILED
   *         OPERATION_FAILED}, {@link
   *         org.osid.repository.RepositoryException#PERMISSION_DENIED
   *         PERMISSION_DENIED}, {@link
   *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
   *         CONFIGURATION_ERROR}, {@link
   *         org.osid.repository.RepositoryException#UNIMPLEMENTED
   *         UNIMPLEMENTED}, {@link
   *         org.osid.repository.RepositoryException#NULL_ARGUMENT
   *         NULL_ARGUMENT}, {@link
   *         org.osid.repository.RepositoryException#UNKNOWN_TYPE
   *         UNKNOWN_TYPE}
   * 
   * @access public
   */
  function &createRepository ( $displayName, $description, &$repositoryType ){
		// Argument Validation
		ArgumentValidator::validate($displayName, new StringValidatorRule);
		ArgumentValidator::validate($description, new StringValidatorRule);
		ArgumentValidator::validate(repositoryType, new ExtendsValidatorRule("TypeInterface"));
		
		// Create an Id for the digital Repository Node
		$sharedManager =& Services::getService("Shared");
		$newId =& $sharedManager->createId();
		
		// Store the type passed in our own table as we will be using
		// a special type, "_repositoryKeyType", as definition of which
		// Nodes in the Hierarchy are Repositories.
		$dbc =& Services::getService("DBHandler");
		
		$query =& new SelectQuery;
		$query->addColumn("type_id");
		$query->addTable("repository_type");
		$query->addWhere("type_domain = '".addslashes($repositoryType->getDomain())."'");
		$query->addWhere("type_authority = '".addslashes($repositoryType->getAuthority())."'", _AND);
		$query->addWhere("type_keyword = '".addslashes($repositoryType->getKeyword())."'", _AND);
		
		$result =& $dbc->query($query, $this->_configuration['dbId']);
		
		if ($result->getNumberOfRows()) {
			$typeId = $result->field("type_id");
		} else {
			$query =& new InsertQuery;
			$query->setTable("repository_type");
			$query->setColumns(array(
								"type_domain",
								"type_authority",
								"type_keyword",
								"type_description",
							));
			$query->setValues(array(
								"'".addslashes($repositoryType->getDomain())."'",
								"'".addslashes($repositoryType->getAuthority())."'",
								"'".addslashes($repositoryType->getKeyword())."'",
								"'".addslashes($repositoryType->getDescription())."'",
							));
			
			$result =& $dbc->query($query, $this->_configuration['dbId']);
			$typeId = $result->getLastAutoIncrementValue();
		}
		
		$query =& new InsertQuery;
		$query->setTable("repository_type");
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
		
		$this->_createdRepositories[$newId->getIdString()] =& new HarmoniRepository ($this->_hierarchy, $newId, $this->_configuration);
		return  $this->_createdRepositories[$newId->getIdString()];
	}

	  /**
     * Delete a Repository.
     * 
     * @param object Id $repositoryId
     * 
     * @throws object RepositoryException An exception with one of
     *         the following messages defined in
     *         org.osid.repository.RepositoryException may be thrown: {@link
     *         org.osid.repository.RepositoryException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.repository.RepositoryException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.repository.RepositoryException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.repository.RepositoryException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
     
	function deleteRepository(& $repositoryId) {
		$repository =& $this->getRepository($repositoryId);
		
		// Check to see if this DR has any assets.
		$assets =& $repository->getAssets();
		// If so, delete them.
		while ($assets->hasNext()) {
			$asset =& $assets->next();
			$dr->deleteAsset($asset->getId());
		}
		
		// Delete the node for the DR
		$this->_hierarchy->deleteNode($digitalRepositoryId);
		
		// Delete type type for the Repository
		$query =& new DeleteQuery;
		$query->setTable("repository_type");
		$query->addWhere("repository_id = '"
						.addslashes($repositoryId->getIdString())
						."' LIMIT 1");
		$dbc =& Services::getService("DBHandler");
		$dbc->query($query, $this->_configuration['dbId']);
		
		unset($this->_createdRepositories[$repositoryId->getIdString()]);
	}

/**
 * Get all the Repositories.  Iterators return a set, one at a time.
 *  
 * @return object RepositoryIterator
 * 
 * @throws object RepositoryException An exception with one of
 *         the following messages defined in
 *         org.osid.repository.RepositoryException may be thrown: {@link
 *         org.osid.repository.RepositoryException#OPERATION_FAILED
 *         OPERATION_FAILED}, {@link
 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
 *         PERMISSION_DENIED}, {@link
 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
 *         CONFIGURATION_ERROR}, {@link
 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
 *         UNIMPLEMENTED}, {@link
 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
 *         CONFIGURATION_ERROR}, {@link
 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
 *         UNIMPLEMENTED}
 * 
 * @access public
 */
  function &getRepositories () { 
		$nodes =& $this->_hierarchy->getNodesByType($this->_repositoryKeyType);
		while ($nodes->hasNext()) {
			$node =& $nodes->next();
			
			// make sure that the dr is loaded into the createdDRs array
			$this->getRepository($node->getId());
		}
		
		// create a DigitalRepositoryIterator with all fo the DRs in the createdDRs array
		$repositoryIterator =& new HarmoniRepositoryIterator($this->_createdRepositories);
		
		return $repositoryIterator;
	}


 /**
 * Get all the Repositories of the specified Type.  Iterators return a set,
 * one at a time.
 * 
 * @param object Type $repositoryType
 *  
 * @return object RepositoryIterator
 * 
 * @throws object RepositoryException An exception with one of
 *         the following messages defined in
 *         org.osid.repository.RepositoryException may be thrown: {@link
 *         org.osid.repository.RepositoryException#OPERATION_FAILED
 *         OPERATION_FAILED}, {@link
 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
 *         PERMISSION_DENIED}, {@link
 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
 *         CONFIGURATION_ERROR}, {@link
 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
 *         UNIMPLEMENTED}, {@link
 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
 *         NULL_ARGUMENT}, {@link
 *         org.osid.repository.RepositoryException#UNKNOWN_TYPE
 *         UNKNOWN_TYPE}
 * 
 * @access public
 */

  function &getRepositoriesByType ( &$repositoryType ) { 
		ArgumentValidator::validate($repositoryType, new ExtendsValidatorRule("TypeInterface"));
		
		// Select the Ids of corresponding repositories
		$query =& new SelectQuery;
		$query->addColumn("repository_id");
		$query->addTable("dr_repository_type");
		$query->addTable("dr_type", INNER_JOIN, "fk_dr_type = type_id");
		$query->addWhere("type_domain = '".addslashes($repositoryType->getDomain())."'");
		$query->addWhere("type_authority = '".addslashes($repositoryType->getAuthority())."'", _AND);
		$query->addWhere("type_keyword = '".addslashes($repositoryType->getKeyword())."'", _AND);
		
		$dbc =& Services::getService("DBHandler");
		$result =& $dbc->query($query, $this->_configuration['dbId']);
		
		$shared =& Services::getService("Shared");
		
		$rs = array();
		while ($result->hasMoreRows()) {
			$idString = $result->field("repository_id");
			$id =& $shared->getId($idString);
			
			// make sure that the repository is loaded into the createdRepositories array
			$rs[] =& $this->getRepository($id);
			$result->advanceRow();
		}
		
		// create a repositoryIterator with all fo the repositories in the createdRepositories array
		$repositoryIterator =& new HarmoniRepositoryIterator($rs);
		
		return $repositoryIterator;
	}

	 /**
   * Get the Repository with the specified unique Id.
   * 
   * @param object Id $repositoryId
   *  
   * @return object Repository
   * 
   * @throws object RepositoryException An exception with one of
   *         the following messages defined in
   *         org.osid.repository.RepositoryException may be thrown: {@link
   *         org.osid.repository.RepositoryException#OPERATION_FAILED
   *         OPERATION_FAILED}, {@link
   *         org.osid.repository.RepositoryException#PERMISSION_DENIED
   *         PERMISSION_DENIED}, {@link
   *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
   *         CONFIGURATION_ERROR}, {@link
   *         org.osid.repository.RepositoryException#UNIMPLEMENTED
   *         UNIMPLEMENTED}, {@link
   *         org.osid.repository.RepositoryException#NULL_ARGUMENT
   *         NULL_ARGUMENT}, {@link
   *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
   * 
   * @access public
   */
   
	function &getRepository ( &$repositoryId ) { 
		ArgumentValidator::validate($repositoryId, new ExtendsValidatorRule("Id"));
		
		if (!$this->_createdRepositories[$repositoryId->getIdString()]) {
			// Get the node for this dr to make sure its availible
			if (!$node = $this->_hierarchy->getNode($repositoryId))
				throwError(new Error(RepositoryException::UNKNOWN_ID(), "RepositoryManager", 1));
			if (!$this->_repositoryKeyType->isEqual($node->getType()))
				throwError(new Error(RepositoryException::UNKNOWN_ID(), "RepositoryManager", 1));
			
			// create the repository and add it to the cache
			$this->_createdRepositories[$repositoryId->getIdString()] =& new HarmoniRepository($this->_hierarchy, $repositoryId, $this->_configuration);
			$this->_repositoryValidFlags[$repositoryId->getIdString()] = true;
		}
		
		// Dish out the repository.
		return $this->_createdRepositories[$repositoryId->getIdString()];
	}

 /**
 * Get the Asset with the specified unique Id.
 * 
 * @param object Id $assetId
 *  
 * @return object Asset
 * 
 * @throws object RepositoryException An exception with one of
 *         the following messages defined in
 *         org.osid.repository.RepositoryException may be thrown: {@link
 *         org.osid.repository.RepositoryException#OPERATION_FAILED
 *         OPERATION_FAILED}, {@link
 *         org.osid.repository.RepositoryException#PERMISSION_DENIED
 *         PERMISSION_DENIED}, {@link
 *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
 *         CONFIGURATION_ERROR}, {@link
 *         org.osid.repository.RepositoryException#UNIMPLEMENTED
 *         UNIMPLEMENTED}, {@link
 *         org.osid.repository.RepositoryException#NULL_ARGUMENT
 *         NULL_ARGUMENT}, {@link
 *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
 * 
 * @access public
 */
	function &getAsset ( &$assetId ) { 
		ArgumentValidator::validate($assetId, new ExtendsValidatorRule("Id"));
		
		// Get the node for this asset to make sure its availible
		if (!$this->_hierarchy->getNode($assetId))
			throwError(new Error(UNKNOWN_ID, "Digital Repository", 1));
		
		// figure out which DR it is in.
		if (! $respositoryId =& $this->_getAssetRepository($assetId))
			throwError(new Error(RepositoryException::UNKNOWN_ID(), "RepositoryManager", 1));
			
		$repository =& $this->getRepository($repositoryId);
		
		// have the repostiroy create it.
		return $repository->getAsset($assetId);
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
	function &getAssetByDate(& $assetId, & $date) {
		// figure out which DR it is in.
		if (! $repositoryId =& $this->_getAssetRepository($assetId))
			throwError(new Error(RepositoryException::UNKNOWN_ID(), "RepositoryManager", 1));
			
		$repository =& $this->getRepository($repositoryId);
		
		//return the assetByDate
		return $repository->getAssetByDate($assetId, $date);
		
	}

  /**
   * Get all the dates for the Asset with the specified unique Id.  These
   * dates allows a Repository implementation to support Asset versioning.
   * 
   * @param object Id $assetId
   *  
   * @return object LongValueIterator
   * 
   * @throws object RepositoryException An exception with one of
   *         the following messages defined in
   *         org.osid.repository.RepositoryException may be thrown: {@link
   *         org.osid.repository.RepositoryException#OPERATION_FAILED
   *         OPERATION_FAILED}, {@link
   *         org.osid.repository.RepositoryException#PERMISSION_DENIED
   *         PERMISSION_DENIED}, {@link
   *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
   *         CONFIGURATION_ERROR}, {@link
   *         org.osid.repository.RepositoryException#UNIMPLEMENTED
   *         UNIMPLEMENTED}, {@link
   *         org.osid.repository.RepositoryException#NULL_ARGUMENT
   *         NULL_ARGUMENT}
   * 
   * @access public
   */

  function &getAssetDates ( &$assetId ) { 
		// figure out which Repository it is in.
		if (! $repositoryId =& $this->_getAssetRepository($assetId))
			throwError(new Error(RepositoryException::UNKNOWN_ID(), "RepositoryManager", 1));
			
		$repository =& $this->getRepository($repositoryId);
		
		//return the assetByDate
		return $repository->getAssetDates($assetId, $date);
	}

	 /**
   * Perform a search of the specified Type and get all the Assets that
   * satisfy the SearchCriteria.  The search is performed for all specified
   * Repositories.  Iterators return a set, one at a time.
   * 
   * @param object Repository[] $repositories
   * @param object mixed $searchCriteria (original type: java.io.Serializable)
   * @param object Type $searchType
   * @param object Properties $searchProperties
   *  
   * @return object AssetIterator
   * 
   * @throws object RepositoryException An exception with one of
   *         the following messages defined in
   *         org.osid.repository.RepositoryException may be thrown: {@link
   *         org.osid.repository.RepositoryException#OPERATION_FAILED
   *         OPERATION_FAILED}, {@link
   *         org.osid.repository.RepositoryException#PERMISSION_DENIED
   *         PERMISSION_DENIED}, {@link
   *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
   *         CONFIGURATION_ERROR}, {@link
   *         org.osid.repository.RepositoryException#UNIMPLEMENTED
   *         UNIMPLEMENTED}, {@link
   *         org.osid.repository.RepositoryException#NULL_ARGUMENT
   *         NULL_ARGUMENT}, {@link
   *         org.osid.repository.RepositoryException#UNKNOWN_TYPE
   *         UNKNOWN_TYPE}, {@link
   *         org.osid.repository.RepositoryException#UNKNOWN_REPOSITORY
   *         UNKNOWN_REPOSITORY}
   * 
   * @access public
   */
  function &getAssetsBySearch ( &$repositories, &$searchCriteria, &$searchType, &$searchProperties ) { 
      die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
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
   * Create in a Repository a copy of an Asset.  The Id, AssetType, and
   * Repository for the new Asset is set by the implementation.  All Records
   * are similarly copied.
   * 
   * @param object Repository $repository
   * @param object Id $assetId
   *  
   * @return object Id
   * 
   * @throws object RepositoryException An exception with one of
   *         the following messages defined in
   *         org.osid.repository.RepositoryException may be thrown: {@link
   *         org.osid.repository.RepositoryException#OPERATION_FAILED
   *         OPERATION_FAILED}, {@link
   *         org.osid.repository.RepositoryException#PERMISSION_DENIED
   *         PERMISSION_DENIED}, {@link
   *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
   *         CONFIGURATION_ERROR}, {@link
   *         org.osid.repository.RepositoryException#UNIMPLEMENTED
   *         UNIMPLEMENTED}, {@link
   *         org.osid.repository.RepositoryException#NULL_ARGUMENT
   *         NULL_ARGUMENT}, {@link
   *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
   * 
   * @access public
   */
  function &copyAsset ( &$repository, &$assetId ) { 
		$asset =& $repository->getAsset($assetId);
		return $repository->copyAsset( $asset );
	}
	// :: full java declaration :: osid.shared.Id copyAsset(DigitalRepository digitalRepository, osid.shared.Id assetId)

	/**
   * Get all the RepositoryTypes in this RepositoryManager. RepositoryTypes
   * are used to categorize Repositories.  Iterators return a set, one at a
   * time.
   *  
   * @return object TypeIterator
   * 
   * @throws object RepositoryException An exception with one of
   *         the following messages defined in
   *         org.osid.repository.RepositoryException may be thrown: {@link
   *         org.osid.repository.RepositoryException#OPERATION_FAILED
   *         OPERATION_FAILED}, {@link
   *         org.osid.repository.RepositoryException#PERMISSION_DENIED
   *         PERMISSION_DENIED}, {@link
   *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
   *         CONFIGURATION_ERROR}, {@link
   *         org.osid.repository.RepositoryException#UNIMPLEMENTED
   *         UNIMPLEMENTED}
   * 
   * @access public
   */
   
   function &getRepositoryTypes () { 
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
 
 function _getAssetRepository (& $assetId) {
 	$node =& $this->_hierarchy->getNode($assetId);
 	
 	// If we have reached the top of the hierarchy and don't have a parent that
 	// is of the Repository type, then we aren't in a Repository and are therefore unknown
 	// to the RepositoryManager.
 	
	 if ($node->isRoot())
 		return FALSE;
 	
 	// Get the parent and return its ID if it is a root node (repositories are root nodes).
 	$parents =& $node->getParents();
 	
 	// Make sure that we have Parents
 	if (!$parents->hasNext())
 		return FALSE;
 	
 	// assume a single-parent hierarchy
 	$parent =& $parents->next();
 	
 	if ($this->_repositoryKeyType->isEqual($parent->getType()))
 		return $parent->getId();
 	else
 		return $this->_getAssetRepository( $parent->getId() );
 }

}


?>