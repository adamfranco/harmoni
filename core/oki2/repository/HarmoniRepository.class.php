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
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: HarmoniRepository.class.php,v 1.23 2005/07/07 21:29:59 adamfranco Exp $ 
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
		$this->_repositoryKeyType =& new HarmoniType("Repository", "Harmoni", 
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
			} 
			// Otherwise, throw an error
			else {
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
	function &createAsset ( $displayName, $description, &$assetType ) { 
		// Get our id for the parent id
		$repositoryId =& $this->_node->getId();
		
		// Create an Id for the new Asset
		$IDManager =& Services::getService("Id");
		$newId =& $IDManager->createId();
		
		// Add this DR's root node to the hierarchy.
		$node =& $this->_hierarchy->createNode($newId, $repositoryId, $assetType, $displayName, $description);
		
		// Create the asset with its new ID and cache it.
		$this->_createdAssets[$newId->getIdString()] =& new HarmoniAsset($this->_hierarchy, $this, $newId, $this->_configuration);
		
		return $this->_createdAssets[$newId->getIdString()];
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
	function deleteAsset ( &$assetId ) { 
		ArgumentValidator::validate($assetId, ExtendsValidatorRule::getRule("Id"));
		
		// Get the asset
		$asset =& $this->getAsset($assetId);
		
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
		
		// Delete the Node for this Asset
		$this->_hierarchy->deleteNode($assetId);
		
		// Delete this asset from the createdAssets cache
		unset($this->_createdAssets[$assetId->getIdString()]);
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
					$this->getAsset($assetId);
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
		
		return new HarmoniAssetIterator($assets);
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
		return new HarmoniTypeIterator($this->_searchTypes);
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
		if (!$this->_createdRecordStructures[$infoStructureId->getIdString()]) {
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
		$schemaIDs =& $schemaMgr->getAllSchemaIDs();
		foreach ($schemaIDs as $id) {
			// Check that we have created an RecordStructure with the ID
			if (!isset($this->_createdRecordStructures[$id])) {
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
	function &getAsset ( &$assetId ) { 
		if (!$this->_createdAssets[$assetId->getIdString()]) {
			// Get the node for this asset to make sure its availible
			if (!$this->_hierarchy->getNode($assetId))
				throwError(new Error(UNKNOWN_ID, "Repository", 1));
			
			// Verify that the requested Asset is in this DR.
			$repositoryMan =& Services::getService("Repository");
			if (!$repositoryId = $repositoryMan->_getAssetRepository($assetId)
				|| !$repositoryId->isEqual($this->getId()))
			{
				throwError(new Error(RepositoryException::UNKNOWN_ID(), "Repository", 1));
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
	 * @param int $date
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
		ArgumentValidator::validate($date, ExtendsValidatorRule::getRule("DateTime"));
		
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
			$assetIds =& $search->searchAssets($searchCriteria, $searchProperties);
			
			// get the assets for the resuting ids
			$assets = array();
			foreach ($assetIds as $key => $id) {
				$assets[] =& $this->getAsset($assetIds[$key]);
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
	 * @return object RecordStructure
	 * @access public
	 * @since 2/17/05
	 */
	function &createRecordStructure($displayName, $description, $format, $schema) {
		$recordType = new HarmoniType($format, $schema, $displayName, $description);
		$schemaMgr =& Services::getService("SchemaManager");
		
		// Create the Schema
		$schema =& new Schema($recordType);
		$schemaMgr->synchronize($schema);
		
		// The SchemaManager only allows you to use Schemas created by it for use with Records.
		$schema =& $schemaMgr->getSchemaByType($recordType);
		//debug::output("RecordStructure is being created from Schema with Id: '".$schema->getID()."'");
		
		$this->_createdRecordStructures[$schema->getID()] =& new HarmoniRecordStructure(
																$schema);
		return $this->_createdRecordStructures[$schema->getID()];
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
		
		$this->_searchTypes["AssetTypeSearch"] =& new HarmoniType("Repository","Harmoni","AssetType", "Select all asset's of the specified Type.");
		
		$this->_searchTypes["RootAssetSearch"] =& new HarmoniType("Repository","Harmoni","RootAssets", "Search for just the 'root' 
											or 'top level' assets which are not assets of other assets.");
		
		$this->_searchTypes["DisplayNameSearch"] =& new HarmoniType("Repository","Harmoni","DisplayName", "Search with a regular expression
												string in the Asset DisplayName.");

		$this->_searchTypes["DescriptionSearch"] =& new HarmoniType("Repository","Harmoni","Description", "Search with a regular expression
												string in the Asset Description.");

		$this->_searchTypes["ContentSearch"] =& new HarmoniType("Repository","Harmoni","Content", "Search with a regular expression
												string in the Asset Content.");

		$this->_searchTypes["AllCustomFieldsSearch"] =& new HarmoniType("Repository","Harmoni","AllCustomStructures", "Search with a regular expression
								string in the custom RecordStructures for each Asset.");
	}

}

?>
