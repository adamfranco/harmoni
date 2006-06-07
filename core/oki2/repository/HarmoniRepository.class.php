<?

require_once(HARMONI."/oki2/repository/HarmoniRepository.interface.php");
require_once(HARMONI."/oki2/repository/HarmoniAsset.class.php");
require_once(HARMONI."/oki2/repository/HarmoniAssetIterator.class.php");
require_once(HARMONI."/oki2/repository/HarmoniRepositoryIterator.class.php");
require_once(HARMONI."/oki2/repository/HarmoniRecordStructure.class.php");

require_once(HARMONI."/oki2/repository/File/FileRecord.class.php");
require_once(HARMONI."/oki2/repository/File/FileSystemFileRecord.class.php");
require_once(HARMONI."/oki2/repository/File/FileRecordStructure.class.php");

require_once(HARMONI."/oki2/repository/HarmoniRecordStructureIterator.class.php");//where is this now?
require_once(HARMONI."/oki2/shared/HarmoniTypeIterator.class.php");
//require_once(HARMONI."/oki2/shared/HarmoniCalendarIterator.class.php");

// Search Modules
require_once(dirname(__FILE__)."/SearchModules/KeywordSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/AssetTypeSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/ContentSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/DescriptionSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/DisplayNameSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/RootAssetSearch.class.php");
require_once(dirname(__FILE__)."/SearchModules/AuthoritativeValuesSearch.class.php");

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
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: HarmoniRepository.class.php,v 1.51 2006/06/07 19:24:13 adamfranco Exp $ 
 */

class HarmoniRepository
	extends HarmoniRepositoryInterface
{
	
	var $_configuration;
	var $_searchTypes;
	var $_node;
	var $_type;
	var $_hierarchy;
	var $_createdAssets;
	
	var $_createdRecordStructures;
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
		$this->_repositoryKeyType =& new HarmoniType("Repository", "edu.middlebury.harmoni", 
							"Repository", "Nodes with this type are by definition Repositories.");
		
		// Set up an array of created RecordStructures so we can pass out references to them.
		$this->_createdRecordStructures = array();
		
		// Add the file RecordStructure to the DR
		$this->_createdRecordStructures['FILE'] =& new HarmoniFileRecordStructure;
		
		// Built-in Types
		// Keys of the array are the RecordStructure Ids,
		// Vals of the array are the record class-names to instantiate.
		$this->_builtInTypes = array();
		
		if ($configuration['use_filesystem_for_files'])
			$this->_builtInTypes['FILE'] = 'FileSystemFileRecord';
		else
			$this->_builtInTypes['FILE'] = 'FileRecord';
		
		// Store our configuration
		$this->_configuration =& $configuration;
	}
	 
	/**
	 * Returns if this Asset is valid or not. 
	 * 
	 * WARNING: NOT IN OSID - Method no longer in OSID
	 *
	 * @param object assetId
	 * @return bool
	 */
	function isAssetValid(&$assetId) {
		throw(new Error("Method gone from OSID","Repository",TRUE));
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
   * @access public
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
   * @access public
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
   * @access public
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
	 * @access public
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
			
			$dbc =& Services::getService("DatabaseManager");
			$result =& $dbc->query($query, $this->_configuration->getProperty('database_index'));
			
			// Return our type
			if ($result->getNumberOfRows()) {
				$this->_type =& new HarmoniType($result->field("type_domain"),
												$result->field("type_authority"),
												$result->field("type_keyword"),
												$result->field("type_description"));
				$result->free();
			} 
			// Otherwise, throw an error
			else {
				$result->free();
				throwError(new Error(RepositoryException::OPERATION_FAILED(), "Repository", 1));
			}
		}
		
		return $this->_type;
	}

	/** NOT IN OSID???
	 * Get the description for this Repository.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() {
		return $this->_node->getDescription();
	}

	/**
	 * Update the description for this Repository.
	 * 
	 * @param string $description
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDescription ( $description ) { 
		$this->_node->updateDescription($description);
	}

	/**
	 * Create a new Asset of this AssetType in this Repository.	 The
	 * implementation of this method sets the Id for the new object.
	 * 
	 * @param string $displayName
	 * @param string $description
	 * @param object Type $assetType
	 *	
	 * @return object Asset
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &createAsset ( $displayName, $description, &$assetType, $id = NULL ) { 
		// Get our id for the parent id
		$repositoryId =& $this->_node->getId();
		
		// Create an Id for the new Asset
		if (!is_object($id)) {
			$IDManager =& Services::getService("Id");
			$id =& $IDManager->createId();
		}
		
		// verify that this type exists or add it if needed.
		if (isset($this->_assetTypes)) {
			$typeExists = false;
			foreach(array_keys($this->_assetTypes) as $key) {
				if ($assetType->isEqual($this->_assetTypes[$key])) {
					$typeExists = true;
					break;
				}
			}
			if (!$typeExists)
				$this->_assetTypes[] =& $assetType;
		}
		
		// Add this DR's root node to the hierarchy.
		$node =& $this->_hierarchy->createNode($id, $repositoryId, $assetType, $displayName, $description);
		
		// Create the asset with its new ID and cache it.
		$this->_createdAssets[$id->getIdString()] =& new HarmoniAsset($this->_hierarchy, $this, $id, $this->_configuration);
		
		return $this->_createdAssets[$id->getIdString()];
	}

	 /**
	 * Delete an Asset from this Repository.
	 * 
	 * @param object Id $assetId
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteAsset ( &$assetId , $parentId = null) { 
		ArgumentValidator::validate($assetId, ExtendsValidatorRule::getRule("Id"));
				
		// Get the asset
		$asset =& $this->getAsset($assetId);
		$assetIdString = $assetId->getIdString();
		$children =& $asset->getAssets();
		
		// deeper and deeper
		while ($children->hasNext()) {
			$child =& $children->next();
			$this->deleteAsset($child->getId(), $assetIdString);
		}
		
		// climbing out if multiparent unlink parent
		$parents =& $asset->_node->getParents();
		if ($parents->count() > 1) {
			$idManager =& Services::getService("Id");
			$asset->_node->removeParent($idManager->getId($parentId));
			return;
		}
		// not multiparent delete asset itself

		// Delete the Records for the Asset
		$records =& $asset->getRecords();
		while ($records->hasNext()) {
			$record =& $records->next();
			$recordId =& $record->getId();
			$asset->deleteRecord($recordId);
		}
		
		// Delete the Record Set
		$recordMgr =& Services::getService("RecordManager");
		$assetId =& $asset->getId();
		$recordMgr->deleteRecordSet($assetId->getIdString());
		
		// Delete the Asset info
		$query =& new DeleteQuery;
		$query->setTable("dr_asset_info");
		$query->setWhere("asset_id='".addslashes($assetId->getIdString())."'");
		$dbc =& Services::getService("DatabaseManager");
		$dbc->query($query, $this->_configuration->getProperty('database_index'));
		
		// Delete the Node for this Asset
		$this->_hierarchy->deleteNode($assetId);
		
		// Delete this asset from the createdAssets cache
		unset($this->_createdAssets[$assetId->getIdString()]);
		
		// unset our asset types as the list may have now changed.
		unset($this->_assetTypes);
	}

	/**
	 * Get all the Assets in this Repository.  Iterators return a set, one at a
	 * time.
	 *	
	 * @return object AssetIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getAssets () { 
		// get a list for all the nodes under this hierarchy.
		$traversalInfoIterator =& $this->_hierarchy->traverse($this->_node->getId(), 
										Hierarchy::TRAVERSE_MODE_DEPTH_FIRST(), Hierarchy::TRAVERSE_DIRECTION_DOWN(), 
										Hierarchy::TRAVERSE_LEVELS_ALL());
		
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
					$this->getAsset($assetId, FALSE);
			}
		}
		
		// create an AssetIterator with all fo the Assets in the createdAssets array
		$assetIterator =& new HarmoniAssetIterator($this->_createdAssets);
		
		return $assetIterator;
	}

	 /**
	 * Get all the Assets of the specified AssetType in this Asset.	 Iterators
	 * return a set, one at a time.
	 * 
	 * @param object Type $assetType
	 *	
	 * @return object AssetIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getAssetsByType ( &$assetType ) { 
		ArgumentValidator::validate($assetType, ExtendsValidatorRule::getRule("Type"));
		$assets = array();
		$allAssets =& $this->getAssets();
		while ($allAssets->hasNext()) {
			$asset =& $allAssets->next();
			if ($assetType->isEqual($asset->getAssetType()))
				$assets[] =& $asset;
		}
		
		$obj =& new HarmoniAssetIterator($assets);
		
		return $obj;
	}

	/**
	 * Get all the AssetTypes in this Repository.  AssetTypes are used to
	 * categorize Assets.  Iterators return a set, one at a time.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getAssetTypes () { 
		if (!isset($this->_assetTypes)) {
			$assets =& $this->getAssets();
			$this->_assetTypes = array();
			while ($assets->hasNext()) {
				$asset =& $assets->next();
				
				// Make sure we haven't added the type yet.
				$added = FALSE;
				if (count($this->_assetTypes)) {
					foreach ($this->_assetTypes as $key=>$type) {
						if ($this->_assetTypes[$key]->isEqual($asset->getAssetType()))
							$added = TRUE;
					}
				}
				// if we haven't, add the type
				if (!$added)
					$this->_assetTypes[] =& $asset->getAssetType();
			}
		}
		
		// create the iterator and return it
		$typeIterator =& new HarmoniTypeIterator($this->_assetTypes);
		
		return $typeIterator;
	}
	
	 /**
	 * Get the Properties of this Type associated with this Repository.
	 * 
	 * @param object Type $propertiesType
	 *	
	 * @return object Properties
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getPropertiesByType ( &$propertiesType ) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	} 

	 /**
	 * Get all the Property Types for  Repository.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getPropertyTypes () { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	} 
	
	 /**
	 * Get the Properties associated with this Repository.
	 *	
	 * @return object PropertiesIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getProperties () { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	} 
	

	
	/**
	 * Get all the RecordStructures with the specified RecordStructureType in
	 * this Repository.	 RecordStructures are used to categorize information
	 * about Assets.  Iterators return a set, one at a time.
	 * 
	 * @param object Type $recordStructureType
	 *	
	 * @return object RecordStructure
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getRecordStructuresByType ( &$recordStructureType ) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	} 
	
	/**
	 * Get all the SearchTypes supported by this Repository.  Iterators return
	 * a set, one at a time.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getSearchTypes () { 
		$obj =& new HarmoniTypeIterator($this->_searchTypes);
		return $obj;
	}
	
	/**
	 * Get all the StatusTypes supported by this Repository.  Iterators return
	 * a set, one at a time.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getStatusTypes () { 
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}
	
	/**
	 * Get the RecordStructure in this DigitalRepository with the specified Id.  RecordStructures are used to categorize information about Assets.
	 * Note: This method is a Harmoni addition to the OSID and at the time of this writing,
	 * was not a part of the DR OSID.
	 * @param object $infoStructureId
	 * @return object RecordStructure	 The RecordStructure of the requested Id.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getRecordStructure( & $infoStructureId ) {
		// Check that we have created an infoStructure with the ID
		if (!isset($this->_createdRecordStructures[$infoStructureId->getIdString()])) {
			// If not, create the infoStructure
			$schemaMgr =& Services::getService("SchemaManager");
			$schema =& $schemaMgr->getSchemaByID($infoStructureId->getIdString());
			$this->_createdRecordStructures[$infoStructureId->getIdString()] =& new HarmoniRecordStructure(
															$schema);
		}
		
		return $this->_createdRecordStructures[$infoStructureId->getIdString()];
		
	}
	
	 /**
	 * Get all the RecordStructures in this Repository.	 RecordStructures are
	 * used to categorize information about Assets.	 Iterators return a set,
	 * one at a time.
	 *	
	 * @return object RecordStructureIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getRecordStructures () { 
		$schemaMgr =& Services::getService("SchemaManager");
		$schemaIDs = $schemaMgr->getAllSchemaIDs();
		foreach ($schemaIDs as $id) {
			// Make sure that this record structure is either a global one
			// or particular to this repository
			$repositoryId =& $this->getId();
			$repositoryIdString = str_replace('.', '\.', $repositoryId->getIdString());
			if ((preg_match("/^Repository::".$repositoryIdString."::.+/", $id)
				|| !preg_match("/^Repository::.+::.+/", $id))
				// Check that we have created an RecordStructure with the ID
				&& !isset($this->_createdRecordStructures[$id]))
			{
					// If not, create the RecordStructure
					$schema =& $schemaMgr->getSchemaByID($id);
					$this->_createdRecordStructures[$id] =& new HarmoniRecordStructure(
																$schema);
			}
		}
		
		// create an Iterator and return it
		$iterator =& new HarmoniRecordStructureIterator($this->_createdRecordStructures);
		
		return $iterator;
		
	}

	/**
	 * Get the StatusType of the Asset with the specified unique Id.
	 * 
	 * @param object Id $assetId
	 *	
	 * @return object Type
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getStatus ( &$assetId ) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
	}

	/**
	 * Validate all the Records for an Asset and set its status Type
	 * accordingly.	 If the Asset is valid, return true; otherwise return
	 * false.  The implementation may throw an Exception for any validation
	 * failures and use the Exception's message to identify specific causes.
	 * 
	 * @param object Id $assetId
	 *	
	 * @return boolean
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function validateAsset ( &$assetId ) { 
		$string = $assetId->getIdString();
		
		$this->_assetValidFlags[$string] = true;
	}

	/**
	 * Set the Asset's status Type accordingly and relax validation checking
	 * when creating Records and Parts or updating Parts' values.
	 * 
	 * @param object Id $assetId
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function invalidateAsset ( &$assetId ) { 
		$string = $assetId->getIdString();
		
		$this->_assetValidFlags[$string] = false;
	}

	/**
	 * Get the Asset with the specified unique Id.
	 * 
	 * @param object Id $assetId
	 * @param option boolean $verifyExistance WARNING: not in OSID.
	 *				This parameter is used to allow calls to getAsset() from 
	 *				inside this implementation to avoid re-checking the existance
	 *				of the asset as by their nature, that existance is ensured.
	 *	
	 * @return object Asset
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getAsset ( &$assetId, $verifyExistance = TRUE) { 
		ArgumentValidator::validate($assetId, ExtendsValidatorRule::getRule("Id"));
		
		if (!isset($this->_createdAssets[$assetId->getIdString()])) {
			
			if ($verifyExistance) {
				// Get the node for this asset to make sure its availible
				if (!$this->_hierarchy->getNode($assetId))
					throwError(new Error(RepositoryException::UNKNOWN_ID(), "Repository", 1));
				
				// Verify that the requested Asset is in this DR.
				$repositoryMan =& Services::getService("Repository");
				$repositoryId = $repositoryMan->_getAssetRepository($assetId);
				if (!$repositoryId
					|| !$repositoryId->isEqual($this->getId()))
				{
					throwError(new Error(RepositoryException::UNKNOWN_ID()." for an Asset: ".$assetId->getIdString(), "Repository", 1));
				}
			}
			
			// create the asset and add it to the cache
			$this->_createdAssets[$assetId->getIdString()] =& new HarmoniAsset($this->_hierarchy, $this, $assetId, $this->_configuration);
			$this->_assetValidFlags[$assetId->getIdString()] = true;
		}
		
		// Dish out the asset.
		return $this->_createdAssets[$assetId->getIdString()];
	}

	/**
	 * Get the Asset with the specified unique Id that is appropriate for the
	 * date specified.	The specified date allows a Repository implementation
	 * to support Asset versioning.
	 * 
	 * @param object Id $assetId
	 * @param object DateAndTime $date
	 *	
	 * @return object Asset
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#NO_OBJECT_WITH_THIS_DATE
	 *		   NO_OBJECT_WITH_THIS_DATE}
	 * 
	 * @access public
	 */
	function &getAssetByDate ( &$assetId, $date ) { 
		ArgumentValidator::validate($assetId, ExtendsValidatorRule::getRule("Id"));
		ArgumentValidator::validate($date, HasMethodsValidatorRule::getRule("asDateAndTime"));
		
		die ("Method <b>".__FUNCTION__."()</b> declared in class <b> ".__CLASS__."</b> has not been implimented.");
		
		// Return an Asset where all Records have the values that they
		// would have on the specified date.
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
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function &getAssetDates ( &$assetId ) { 
		ArgumentValidator::validate($assetId, ExtendsValidatorRule::getRule("Id"));
		
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
	 * Perform a search of the specified Type and get all the Assets that
	 * satisfy the SearchCriteria.	Iterators return a set, one at a time.
	 * 
	 * @param object mixed $searchCriteria (original type: java.io.Serializable)
	 * @param object Type $searchType
	 * @param object Properties $searchProperties
	 *	
	 * @return object AssetIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getAssetsBySearch ( &$searchCriteria, &$searchType, &$searchProperties ) {
		ArgumentValidator::validate($searchType, ExtendsValidatorRule::getRule("Type"));
		ArgumentValidator::validate($searchProperties, OptionalRule::getRule(
			ExtendsValidatorRule::getRule("Properties")));
		
		// Check that we support the searchType
		$supported = FALSE;
		foreach (array_keys($this->_searchTypes) as $key) {
			if ($searchType->isEqual($this->_searchTypes[$key])) {
				$supported = TRUE;
				$searchName = $key;
				break;
			}
		}
		
		if ($supported) {
			$search =& new $searchName($this);
			$assetIds =& $search->searchAssets($searchCriteria, $searchProperties);
			
			// get the assets for the resuting ids
			$assets = array();
			
			// Order
			if (is_object($searchProperties) 
				&& $searchProperties->getProperty("order") == ("DisplayName")) 
			{
				foreach ($assetIds as $key => $id) {
					$asset =& $this->getAsset($assetIds[$key], FALSE);
					$assets[$asset->getDisplayName().$id->getIdString()] =& $asset;
				}
			} else if (is_object($searchProperties) 
				&& $searchProperties->getProperty("order") == ("Id")) 
			{
				foreach ($assetIds as $key => $id)
					$assets[$assetIds[$key]->getIdString()] =& $this->getAsset($assetIds[$key], FALSE);
			} else if (is_object($searchProperties) 
				&& $searchProperties->getProperty("order") == ("ModificationDate")) 
			{
				foreach ($assetIds as $key => $id) {
					$asset =& $this->getAsset($assetIds[$key], FALSE);
					$date =& $asset->getModificationDate();
					$assets[$date->asString().$id->getIdString()] =& $asset;
				}
			} else if (is_object($searchProperties) 
				&& $searchProperties->getProperty("order") == ("CreationDate")) 
			{
				foreach ($assetIds as $key => $id) {
					$asset =& $this->getAsset($assetIds[$key], FALSE);
					$date =& $asset->getCreationDate();
					$assets[$date->asString().$id->getIdString()] =& $asset;
				}
			} else {
				foreach ($assetIds as $key => $id)
					$assets[] =& $this->getAsset($assetIds[$key], FALSE);
			}
			
			// Filter based on type
			// This can probably be moved to the search modules to improve
			// performance by eliminating these assets before they are otherwise
			// operated on.
			if (is_object($searchProperties) 
				&& is_array($searchProperties->getProperty("allowed_types"))
				&& count($searchProperties->getProperty("allowed_types")))
			{
				$allowedTypes =& $searchProperties->getProperty("allowed_types");
				foreach (array_keys($assets) as $key) {
					$type =& $assets[$key]->getAssetType();
					$allowed = FALSE;
					foreach (array_keys($allowedTypes) as $typeKey) {
						if ($type->isEqual($allowedTypes[$typeKey])) {
							$allowed = TRUE;
							break;
						}
					}
					if (!$allowed)
						unset($assets[$key]);
				}
			}
			
			// Order Direction
			if (is_object($searchProperties) 
				&& $searchProperties->getProperty("direction") == "DESC")
			{
				krsort($assets);
			} else {
				ksort($assets);
			}
			
			
			
			// create an AssetIterator and return it
			$assetIterator =& new HarmoniAssetIterator($assets);
			
			return $assetIterator;
			
		} else {
			throwError(new Error(RepositoryException::UNKNOWN_TYPE()." ".$searchType->getDomain()."::".$searchType->getAuthority()."::".$searchType->getKeyword(), "Repository", 1));
		}
	}

	/**
	 * Create a copy of an Asset.  The Id, AssetType, and Repository for the
	 * new Asset is set by the implementation.	All Records are similarly
	 * copied.
	 * 
	 * @param object Asset $asset
	 *	
	 * @return object Id
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &copyAsset ( &$asset ) { 
		// Copy the asset to the dr root (recursivley for children)
		$id =& $this->_copyAsset($asset, $this->getId());
		
		return $id;
	}
	
	/**
	 * Create an RecordStructure in this DR. This is not part of the DR OSID at 
	 * the time of this writing, but is needed for dynamically created 
	 * RecordStructures.
	 *
	 * @param string $displayName	The DisplayName of the new RecordStructure.
	 * @param string $description	The Description of the new RecordStructure.
	 * @param string $format		The Format of the new RecordStructure.
	 * @param string $schema		The schema of the new RecordStructure.
	 *
	 * @return object RecordStructure The newly created RecordStructure.
	 */
	 
	/**
	 * This method indicates whether this implementation supports Repository
	 * methods getAssetsDates() and getAssetByDate()
	 *	
	 * @return boolean
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function supportsVersioning () { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	} 
	
	/**
	 * This method indicates whether this implementation supports Repository
	 * methods: copyAsset, deleteAsset, invalidateAsset, updateDescription,
	 * updateDisplayName. Asset methods: addAsset, copyRecordStructure,
	 * createRecord, deleteRecord, inheritRecordStructure, removeAsset,
	 * updateContent, updateDescription, updateDisplayName,
	 * updateEffectiveDate, updateExpirationDate. Part methods: createPart,
	 * deletePart, updateDisplayName, updateValue. PartStructure methods:
	 * updateDisplayName, validatePart. Record methods: createPart,
	 * deletePart, updateDisplayName. RecordStructure methods:
	 * updateDisplayName, validateRecord.
	 *	
	 * @return boolean
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function supportsUpdate () { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	 
	/**
	 * Create a new RecordStructure
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param string $displayName
	 * @param string $description
	 * @param string $format
	 * @param string $schema
	 * @param optional object $theID
	 * @param boolean $isGlobal
	 * @return object RecordStructure
	 * @access public
	 * @since 2/17/05
	 */
	function &createRecordStructure($displayName, $description, $format, $schema,
		$theID=null, $isGlobal = FALSE) 
	{
		$schemaMgr =& Services::getService("SchemaManager");
		
		if ($theID == null) {
			$idMgr =& Services::getService("Id");
			$id =& $idMgr->createId();
		} else {
			$id =& $theID;
		}
		
		// Limit the Record Struture just to this repository if it is not
		// specified as global.
		if ($isGlobal)
			$idString = $id->getIdString();
		else {
			$repositoryId =& $this->getId();
			$idString = "Repository::".$repositoryId->getIdString()."::".$id->getIdString();
		}

		// Create the Schema
		$tempSchema =& new Schema($idString, $displayName, 1, $description, 
			array("format"=>$format, "schema"=>$schema));
		$schemaMgr->synchronize($tempSchema);
		
		// The SchemaManager only allows you to use Schemas created by it for use with Records.
		$schema =& $schemaMgr->getSchemaByID($idString);
		//debug::output("RecordStructure is being created from Schema with Id: '".$schema->getID()."'");
		$this->_createdRecordStructures[$schema->getID()] =& new HarmoniRecordStructure(
																$schema);
		return $this->_createdRecordStructures[$schema->getID()];
	}
	
	/**
	 * Delete a RecordStructure all Records in the repository that use it.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param object Id $recordStructureId
	 * @return void
	 * @access public
	 * @since 6/6/06
	 */
	function deleteRecordStructure ( &$recordStructureId ) {
		// Delete the Records that use this RecordStructure
		$assets =& $this->getAssets();
		while ($assets->hasNext()) {
			$asset =& $assets->next();
			$records =& $asset->getRecordsByRecordStructure($recordStructureId);
			while ($records->hasNext()) {
				$record =& $records->next();
				$asset->deleteRecord($record->getId());
			}
		}
		
		
		// Delete the Structure
		$schemaMgr =& Services::getService("SchemaManager");
		$recordMgr =& Services::getService("RecordManager");
		
		$recordIdsForSchema = $recordMgr->getRecordIDsByType($recordStructureId->getIdString());
		
		if (count($recordIdsForSchema)) {
			throwError(new Error(
				RepositoryException::OPERATION_FAILED()
					." when deleting RecordStructure: '"
					.$recordStructureId->getIdString()
					."', Records exist for this RecordStructure.", 
				"Repository", 1));
		}
		
		$schema =& $schemaMgr->deleteSchema($recordStructureId->getIdString());
	}
	
	/**
	 * Duplicate a RecordStructure, optionally duplicating the records as well,
	 * also optionally deleting the records in the original RecordStructure.
	 *
	 * Use this method to convert from data stored in a 'global' RecordStructure
	 * such as DublinCore into a 'local' version of the RecordStructure Core in which the
	 * user has the option of customizing fields.
	 *
	 * As well, this method can be used to convert a RecordStructure and associated
	 * Records to a local version if the RecordStructure was accidentally created
	 * as a 'global' one.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param object Id $recordStructureId The id of the RecordStructure to duplicate
	 * @param boolean $copyRecords 	If true, existing records will be duplicated
	 *								under the new RecordStructure.
	 * @param optional object $id An optional id for the new RecordStructure
	 * @param boolean $isGlobal If true the new RecordStructure will be made a global one.
	 * @return void
	 * @access public
	 * @since 6/7/06
	 */
	function duplicateRecordStructure ( &$recordStructureId, $copyRecords = FALSE, 
		$id = null, $isGlobal = FALSE ) 
	{
		ArgumentValidator::validate($recordStructureId, ExtendsValidatorRule::getRule("Id"));
		ArgumentValidator::validate($copyRecords, BooleanValidatorRule::getRule());
		ArgumentValidator::validate($id, OptionalRule::getRule(
			ExtendsValidatorRule::getRule("Id")));
		ArgumentValidator::validate($isGlobal, BooleanValidatorRule::getRule());
		
		$oldRecStruct =& $this->getRecordStructure($recordStructureId);
		$newRecStruct =& $this->createRecordStructure(
							$oldRecStruct->getDisplayName()._(" Copy"),
							$oldRecStruct->getDescription(),
							$oldRecStruct->getFormat(),
							$oldRecStruct->getSchema(),
							$id,
							$isGlobal);
		
		$mapping = array();
		$oldPartStructs =& $oldRecStruct->getPartStructures();
		while ($oldPartStructs->hasNext()) {
			$oldPartStruct =& $oldPartStructs->next();
			$newPartStruct =& $newRecStruct->createPartStructure(
							$oldRecStruct->getDisplayName(),
							$oldRecStruct->getDescription(),
							$oldRecStruct->getType(),
							$oldRecStruct->isMandatory(),
							$oldRecStruct->isRepeatable(),
							$oldRecStruct->isPopulatedByRepository());
			
			// Mapping
			$oldPartStructId =& $oldPartStruct->getId();
			$mapping[$oldPartStructId->getIdString()] =& $newPartStruct->getId();
		}
		unset($oldPartStruct, $newPartStruct);
		
		if ($copyRecords) {
			$assets =& $this->getAssets();
			while ($assets->hasNext()) {
				$asset =& $assets->next();
				$oldRecords =& $asset->getRecordsByRecordStructure($oldRecStruct->getId());
				while ($oldRecords->hasNext()) {
					$oldRecord =& $oldRecords->next();
					
					// Create the new Record
					$newRecord =& $asset->createRecord($newRecStruct->getId());
					
					$oldParts =& $oldRecord->getParts();
					while ($oldParts->hasNext()) {
						$oldPart =& $oldParts->next();
						$oldPartStruct =& $oldPart->getPartStructure();
						$oldPartStructId =& $oldPartStruct->getId();
						
						$newPart =& $newRecord->createPart(
										$mapping[$oldPartStructId->getIdString()],
										$oldPart->getValue());
					}
				}
			}
		}
	}

	/**
	 * Recursively copies an asset and its children to a new parent.
	 * 
	 * @access private
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
	
// 	/**
// 	 * Convert Records from one storage method (Class) to another.
// 	 * 
// 	 * @param object Id $recordStructureId The Id of the RecordStructure of both
// 	 *		Record classes. They must share the same RecordStructure
// 	 * @param string $destinationClass
// 	 * @return void
// 	 * @access public
// 	 * @since 2/17/05
// 	 */
// 	function convertRecords ( &$recordStructureId, $destinationClass ) {
// 		$recordStructure =& $this->getRecordStructure($recordStructureId);
// 		
// 		$allAssets =& $this->getAssets();
// 		while ($allAssets->hasNextAsset()) {
// 			$asset =& $allAssets->nextAsset();
// 			
// 			$assetId =& $asset->getId();
// 			print "\n<br/>\t - Converting Asset: ".$assetId->getIdString();
// 			
// 			$origRecords =& $asset->getRecordsByRecordStructure($recordStructureId);
// 			while ($origRecords->hasNextRecord()) {
// 				$origRecord =& $origRecords->nextRecord();
// 				
// 				$recordId =& $origRecord->getId();
// 				print "\n<br/>\t - \t - Converting Record: ".$recordId->getIdString();
// 				
// 				$newRecord =& new $destinationClass (
// 									$recordStructure,
// 									$origRecord->getId(),
// 									$this->_configuration()
// 								);
// 				$newRecord->copyFromRecord($origRecord);
// 			}
// 		}
// 	}
	
	
	
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
		$this->_searchTypes["KeywordSearch"] =& new Type(
			"Repository",
			"edu.middlebury.harmoni",
			"Keyword", 
			"Search with a string for keywords.");
		
		$this->_searchTypes["AuthoritativeValuesSearch"] =& new Type(
			"Repository",
			"edu.middlebury.harmoni",
			"Authoritative Values", 
			"Select from the authoritative values on a particular field.");
		
		$this->_searchTypes["AssetTypeSearch"] =& new Type(
			"Repository",
			"edu.middlebury.harmoni",
			"AssetType", 
			"Select all asset's of the specified Type.");
		
		$this->_searchTypes["RootAssetSearch"] =& new Type(
			"Repository",
			"edu.middlebury.harmoni",
			"RootAssets", 
			"Search for just the 'root' or 'top level' assets which are not assets of other assets.");
		
		$this->_searchTypes["DisplayNameSearch"] =& new Type(
			"Repository",
			"edu.middlebury.harmoni",
			"DisplayName", 
			"Search with a regular expression string in the Asset DisplayName.");

		$this->_searchTypes["DescriptionSearch"] =& new Type(
			"Repository",
			"edu.middlebury.harmoni",
			"Description", 
			"Search with a regular expression string in the Asset Description.");

		$this->_searchTypes["ContentSearch"] =& new Type(
			"Repository",
			"edu.middlebury.harmoni",
			"Content", 
			"Search with a regular expression string in the Asset Content.");

	}

}

?>
