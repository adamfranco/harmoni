<?php
/**
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniAsset.class.php,v 1.53 2008/02/06 15:37:52 adamfranco Exp $
 */

require_once(HARMONI."oki2/repository/HarmoniAsset.interface.php");
require_once(HARMONI."oki2/repository/HarmoniRecord.class.php");
require_once(HARMONI."oki2/repository/HarmoniRecordIterator.class.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");

require_once(dirname(__FILE__)."/FromNodesAssetIterator.class.php");

/**
 * Asset manages the Asset itself.  Assets have content as well as Records
 * appropriate to the AssetType and RecordStructures for the Asset.  Assets
 * may also contain other Assets.
 * 
 * 
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: HarmoniAsset.class.php,v 1.53 2008/02/06 15:37:52 adamfranco Exp $ 
 */

class HarmoniAsset
	implements Asset, HarmoniAssetInterface
{ // begin Asset
	
	var $_configuration;
	var $_versionControlAll = FALSE;
	var $_versionControlTypes;
	var $_hierarchy;
	var $_node;
	var $_repository;
	
	var $_recordIDs;
	var $_createdRecords;
	var $_createdRecordStructures;
	
	var $_effectiveDate;
	var $_expirationDate;
	var $_datesInDB = FALSE;
	
	/**
	 * @var object RepositoryManger $manager; 
	 * @access private
	 * @since 10/9/07
	 */
	private $manager;
	
	/**
	 * Constructor
	 */
	function __construct (RepositoryManager $manager, Hierarchy $hierarchy, Repository $repository, Id $id, ConfigurationProperties $configuration) {
	 	// Get the node coresponding to our id
	 	$this->manager = $manager;
		$this->_hierarchy =$hierarchy;
		$this->_node =$this->_hierarchy->getNode($id);
		$this->_repository =$repository;
		
		$this->_recordIDs = array();
		$this->_createdRecords = array();
		$this->_createdRecordStructures = array();
		
		// Store our configuration
		$this->_configuration =$configuration;
		$this->_versionControlAll = ($configuration->getProperty('version_control_all'))?TRUE:FALSE;
		if (is_array($configuration->getProperty('version_control_types'))) {
			ArgumentValidator::validate($configuration->getProperty('version_control_types'), ArrayValidatorRuleWithRule::getRule( ExtendsValidatorRule::getRule("Type")));
			$this->_versionControlTypes =$configuration->getProperty('version_control_types');
		} else {
			$this->_versionControlTypes = array();
		}
		
		$this->_dbIndex = $configuration->getProperty('database_index');
	 }

	/**
     * Get the display name for this Asset.
     *  
     * @return string
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
    function getDisplayName () { 
		return $this->_node->getDisplayName();
	}

	 /**
     * Update the display name for this Asset.
     * 
     * @param string $displayName
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
    function updateDisplayName ( $displayName ) { 
		$this->_node->updateDisplayName($displayName);
		$this->updateModificationDate();
	}

	 /**
     * Get the description for this Asset.
     *  
     * @return string
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
    function getDescription () { 
		return $this->_node->getDescription();
	}

	/**
     * Update the description for this Asset.
     * 
     * @param string $description
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
    function updateDescription ( $description ) { 
		$this->_node->updateDescription($description);
		$this->updateModificationDate();
	}

	 /**
     * Get the unique Id for this Asset.
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
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getId () { 
		return $this->_node->getId();
	}
	
	/**
     * Get the Id of the Repository in which this Asset resides.  This is set
     * by the Repository's createAsset method.
     *  
     * WARNING::IMPLEMENTATION AND DOCUMENTATION DIFFER
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
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getRepository () { 

		return $this->_repository;
	}

	/**
     * Get an Asset's content.  This method can be a convenience if one is not
     * interested in all the structure of the Records.
     *  
     * @return object mixed (original type: java.io.Serializable)
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
    function getContent () { 
	
 		$idManager = Services::getService("Id");
 		$recordMgr = Services::getService("RecordManager");
 		
 		// Ready our type for comparisson
 		$contentType = "edu.middlebury.harmoni.repository.asset_content";
 		$myId =$this->_node->getId();
 		
 		// Get the content DataSet.
 		$myRecordSet =$recordMgr->fetchRecordSet($myId->getIdString());
 		$myRecordSet->loadRecords();
		$contentRecords =$myRecordSet->getRecordsByType($contentType);
		
		if (isset($contentRecords[0]) && $contentRecords[0])
			return $contentRecords[0]->getValue("Content");
		else
			return new Blob();
	}

	/**
     * Update an Asset's content.
     * 
     * @param object mixed $content (original type: java.io.Serializable)
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
    function updateContent ( $content ) { 
 		ArgumentValidator::validate($content, ExtendsValidatorRule::getRule("Blob"));
 		$idManager = Services::getService("Id");
 		$recordMgr = Services::getService("RecordManager");
 		
 		// Ready our type for comparisson
 		$contentType = "edu.middlebury.harmoni.repository.asset_content";
 		$myId =$this->_node->getId();
 		
 		// Get the content DataSet.
 		$myRecordSet =$recordMgr->fetchRecordSet($myId->getIdString());
 		$myRecordSet->loadRecords();
		$contentRecords =$myRecordSet->getRecordsByType($contentType);

 		if (count($contentRecords)) {
 			$contentRecord =$contentRecords[0];
 			
 			$contentRecord->setValue("Content", $content);
 		
			$contentRecord->commit(TRUE);
 		} else {
			// Set up and create our new record
			$schemaMgr = Services::getService("SchemaManager");
			$contentSchema =$schemaMgr->getSchemaByID($contentType);
			$contentSchema->load();
//			printpre($contentSchema->getAllLabels());
			
			// Decide if we want to version-control this field.
			$versionControl = $this->_versionControlAll;
			if (!$versionControl) {
				foreach ($this->_versionControlTypes as $key => $val) {
					if ($contentType == $this->_versionControlTypes[$key]) {
						$versionControl = TRUE;
						break;
					}
				}
			}
			
			$contentRecord =$recordMgr->createRecord($contentType, $versionControl);
			
			$contentRecord->setValue("Content", $content);
 		
			$contentRecord->commit(TRUE);
	
			// Add the record to our group
			$myRecordSet->add($contentRecord);
			$myRecordSet->commit(TRUE);
		}
		$this->updateModificationDate();
	}

	/**
     * Get the date at which this Asset is effective.
     *  
     * @return object DateAndTime
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
    function getEffectiveDate () { 
	
		if (!isset($this->_effectiveDate)) {
			$this->_loadDates();
		}
		
		return $this->_effectiveDate;
	}

	/**
     * Update the date at which this Asset is effective.
     * 
     * @param object DateAndTime $effectiveDate OR NULL
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
     *         org.osid.repository.RepositoryException#EFFECTIVE_PRECEDE_EXPIRATION}
     * 
     * @access public
     */
    function updateEffectiveDate ( $effectiveDate ) { 
		ArgumentValidator::validate($effectiveDate,
			OptionalRule::getRule(
				HasMethodsValidatorRule::getRule("asDateAndTime")));
		
		// Make sure that we have dates from the DB if they exist.
		$this->_loadDates();
		// Update our date in preparation for DB updating
		$this->_effectiveDate =$effectiveDate;
		// Store the dates
		$this->_storeDates();
	}

	/**
     * Get the date at which this Asset expires.
     *  
     * @return object DateAndTime
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
    function getExpirationDate () { 
		if (!$this->_expirationDate) {
			$this->_loadDates();
		}
		
		return $this->_expirationDate;
	}

	
    /**
     * Update the date at which this Asset expires.
     * 
     * @param object DateAndTime $expirationDate
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
     *         org.osid.repository.RepositoryException#EFFECTIVE_PRECEDE_EXPIRATION}
     * 
     * @access public
     */
    function updateExpirationDate ( $expirationDate ) { 
		ArgumentValidator::validate($expirationDate,
			OptionalRule::getRule(
				HasMethodsValidatorRule::getRule("asDateAndTime")));
			
		// Make sure that we have dates from the DB if they exist.
		$this->_loadDates();
		// Update our date in preparation for DB updating
		$this->_expirationDate =$expirationDate;
		// Store the dates
		$this->_storeDates();
	}

	/**
     * Add an Asset to this Asset.
     * 
     * @param object Id $assetId
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
     *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.repository.RepositoryException#ALREADY_ADDED
     *         ALREADY_ADDED}
     * 
     * @access public
     */
    function addAsset ( Id $assetId ) { 
		$node =$this->_hierarchy->getNode($assetId);
		$oldParents =$node->getParents();
		// We are assuming a single-parent hierarchy
		$oldParent =$oldParents->next();
		$node->changeParent($oldParent->getId(), $this->_node->getId());
		
		$this->save();
		$this->updateModificationDate();
	}

	/**
     * Remove an Asset from this Asset.  This method does not delete the Asset
     * from the Repository.
     * 
     * @param object Id $assetId
     * @param boolean $includeChildren
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
    function removeAsset ( Id $assetId, $includeChildren ) { 
    	if ($includeChildren !== true)
    		 $includeChildren = FALSE;
    	
		$node =$this->_hierarchy->getNode($assetId);
	
		if (!$includeChildren) {
			// Move the children to the current asset before moving
			// the asset to the repository root
			$children =$node->getChildren();
			while ($children->hasNext()) {
				$child =$children->next();
				$child->changeParent($node->getId(), $this->_node->getId());
			}
		}
		
		// Move the asset to the repository root.
		$node->changeParent($this->_node->getId(), $this->_repository->getId());
		
		$this->save();
		$this->updateModificationDate();
	}

	 /**
     * Get all the Assets in this Asset. Iterators return a set, one at a
     * time.
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
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getAssets () { 		
		// create an AssetIterator and return it
		$assetIterator = new FromNodesAssetIterator(
									$this->_node->getChildren(),
									$this->_repository);
		
		return $assetIterator;
    
    }
	
	/**
     * Get the parents of this asset, Iterators return a set one at a time.
     *
     * WARNING: NOT IN OSID 
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
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getParents () { 
    	$assets = array();
		$parents =$this->_node->getParents();
		
		$repositoryKeyType = $this->manager->repositoryKeyType;
    	
		while ($parents->hasNext()) {
			$parent =$parents->next();
			if (!$repositoryKeyType->isEqual($parent->getType()))
				$assets[] =$this->_repository->getAsset($parent->getId());
		}
		
		// create an AssetIterator and return it
		$assetIterator = new HarmoniAssetIterator($assets);
		
		return $assetIterator;
    }
    
    /**
     * Answer an iterator of the TraversalInfo of the decendent Assets 
     * (children, grandchildren, etc).
     * WARNING: NOT IN OSID
     * 
     * @return object TraversalInfoIterator
     * @access public
     * @since 12/15/05
     */
    function getDescendentInfo () {
    	$traversalInfo =$this->_hierarchy->traverse(
    		$this->getId(),
    		Hierarchy::TRAVERSE_MODE_DEPTH_FIRST,
    		Hierarchy::TRAVERSE_DIRECTION_DOWN,
    		Hierarchy::TRAVERSE_LEVELS_ALL);
    		
    	return $traversalInfo;
    }
	
	/**
     * Get the parents of this asset, Iterators return a set one at a time.
     *
     * WARNING: NOT IN OSID 
     *
     * @param object Type $assetType
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
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    function getParentsByType ( Type $assetType ) {
    	$assets = array();
		$parents =$this->_node->getParents();
		while ($parents->hasNext()) {
			$parent =$parents->next();
			if ($assetType->isEqual($parent->getType()))
				$assets[] =$this->_repository->getAsset($parent->getId());
		}
		
		// create an AssetIterator and return it
		$assetIterator = new HarmoniAssetIterator($assets);
		
		return $assetIterator;
    }
	
	 /**
     * Get all the Assets of the specified AssetType in this Repository.
     * Iterators return a set, one at a time.
     * 
     * @param object Type $assetType
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
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
	
    function getAssetsByType ( Type $assetType ) { 
    	$assets = array();
		$children =$this->_node->getChildren();
		while ($children->hasNext()) {
			$child =$children->next();
			if ($assetType->isEqual($child->getType()))
				$assets[] =$this->_repository->getAsset($child->getId());
		}
		
		$obj = new HarmoniAssetIterator($assets);
		
		return $obj;
	}

	 /**
     * Create a new Asset Record of the specified RecordStructure.   The
     * implementation of this method sets the Id for the new object.
     * 
     * @param object Id $recordStructureId
     *  
     * @return object Record
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
    function createRecord (Id $recordStructureId ) { 
		
		// If this is a schema that is hard coded into our implementation, create
		// a record for that schema.
		if (in_array($recordStructureId->getIdString(), array_keys($this->_repository->_builtInTypes))) 
		{
			// Create an Id for the record;
			$idManager = Services::getService("Id");
			$newId =$idManager->createId();
	
			// instantiate the new record.
			$recordClass = $this->_repository->_builtInTypes[$recordStructureId->getIdString()];
			$recordStructure =$this->_repository->getRecordStructure($recordStructureId);
			$record = new $recordClass($recordStructure, $newId, $this->_configuration, $this);
			
			// store a relation to the record
			$dbHandler = Services::getService("DatabaseManager");
			$query = new InsertQuery;
			$query->setTable("dr_asset_record");
			$query->setColumns(array("fk_asset", "fk_record", "structure_id"));
			$myId =$this->getId();
			$query->addRowOfValues(array(
								"'".$myId->getIdString()."'",
								"'".$newId->getIdString()."'",
								"'".$recordStructureId->getIdString()."'"));
			$result =$dbHandler->query($query, $this->_dbIndex);
		} 
		
		// Otherwise use the data manager
		else {
			// Get the DataSetGroup for this Asset
			$recordMgr = Services::getService("RecordManager");
			$myId =$this->_node->getId();
			$myGroup =$recordMgr->fetchRecordSet($myId->getIdString());
			
			// Get the recordStructure needed.
			$recordStructures =$this->_repository->getRecordStructures();
			while ($recordStructures->hasNext()) {
				$structure =$recordStructures->next();
				if ($recordStructureId->isEqual($structure->getId()))
					break;
			}
			
			// 	get the type for the new data set.
			$schemaMgr = Services::getService("SchemaManager");
			$schemaID = $recordStructureId->getIdString();
//			$type =$schemaMgr->getSchemaByID($recordStructureId->getIdString());
			
			// Set up and create our new dataset
			// Decide if we want to version-control this field.
				$versionControl = $this->_versionControlAll;
				if (!$versionControl) {
					foreach ($this->_versionControlTypes as $key => $val) {
						if ($schemaID == $this->_versionControlTypes[$key]) {
							$versionControl = TRUE;
							break;
						}
					}
				}
				
				$newRecord =$recordMgr->createRecord($schemaID, $versionControl);
			
			// The ignoreMandatory Allows this record to be created without checking for
			// values on mandatory fields. These constraints should be checked when
			// validateAsset() is called.
			$newRecord->commit(TRUE);
			
			// Add the DataSet to our group
			$myGroup->add($newRecord);
			
			// us the RecordStructure and the dataSet to create a new Record
			$record = new HarmoniRecord($this->manager, $structure, $newRecord, $this);
		}
		
		// Add the record to our createdRecords array, so we can pass out references to it.
		$recordId =$record->getId();
		$this->_createdRecords[$recordId->getIdString()] =$record;
		
		$this->save();
		$this->updateModificationDate();
		
		return $record;
	}

	 /**
     * Add the specified RecordStructure and all the related Records from the
     * specified asset.  The current and future content of the specified
     * Record is synchronized automatically.
     * 
     * @param object Id $assetId
     * @param object Id $recordStructureId
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
     *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link
     *         org.osid.repository.RepositoryException#ALREADY_INHERITING_STRUCTURE
     *         ALREADY_INHERITING_STRUCTURE}
     * 
     * @access public
     */
    function inheritRecordStructure ( Id $assetId, Id $recordStructureId ) { 
	
		// If this is a schema that is hard coded into our implementation, create
		// a record for that schema.
		if (in_array($recordStructureId->getIdString(), array_keys($this->_repository->_builtInTypes))) 
		{
			// Create an Id for the record;
			$idManager = Services::getService("Id");
			$dbHandler = Services::getService("DatabaseManager");
	
			// get the record ids that we want to inherit
			$query = new SelectQuery();
			$query->addTable("dr_asset_record");
			$query->addColumn("fk_record");
			$query->addWhereEqual("fk_asset", $assetId->getIdString());
			$query->addWhereEqual("structure_id", $recordStructureId->getIdString(), _AND);
			
			$result =$dbHandler->query($query, $this->_dbIndex);
			
			// store a relation to the record
			$dbHandler = Services::getService("DatabaseManager");
			$query = new InsertQuery;
			$query->setTable("dr_asset_record");
			$query->setColumns(array("fk_asset", "fk_record", "structure_id"));
			
			$myId =$this->getId();
			
			while ($result->hasMoreRows()) {
				$query->addRowOfValues(array(
									"'".$myId->getIdString()."'",
									"'".$result->field("fk_record")."'",
									"'".$recordStructureId->getIdString()."'"));
				$dbHandler->query($query, $this->_dbIndex);
				$result->advanceRow();
			}
			
			$result->free();
		} 
		
		// Otherwise use the data manager
		else {
			// Get our managers:
			$recordMgr = Services::getService("RecordManager");
			$idMgr = Services::getService("Id");
		
			// Get the DataSetGroup for this Asset
			$myId =$this->_node->getId();
			$mySet =$recordMgr->fetchRecordSet($myId->getIdString());
			
			// Get the DataSetGroup for the source Asset
			$otherSet =$recordMgr->fetchRecordSet($assetId->getIdString());
			$otherSet->loadRecords(RECORD_FULL);
			$records =$otherSet->getRecords();
			
			// Add all of DataSets (Records) of the specified RecordStructure and Asset
			// to our RecordSet.
			foreach (array_keys($records) as $key) {
				// Get the ID of the current DataSet's TypeDefinition
				$schema =$records[$key]->getSchema();
				$schemaId =$idMgr->getId($schema->getID());
				
				// If the current DataSet's DataSetTypeDefinition's ID is the same as
				// the RecordStructure ID that we are looking for, add that dataSet to our
				// DataSetGroup.
				if ($recordStructureId->isEqual($schemaId)) {
					$mySet->add($records[$key]);
				}
			}
			
			// Save our DataSetGroup
			$mySet->commit(TRUE);
		}
		
		$this->updateModificationDate();
	}

	/**
     * Add the specified RecordStructure and all the related Records from the
     * specified asset.
     * 
     * @param object Id $assetId
     * @param object Id $recordStructureId
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
     *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link
     *         org.osid.repository.RepositoryException#CANNOT_COPY_OR_INHERIT_SELF
     *         CANNOT_COPY_OR_INHERIT_SELF}
     * 
     * @access public
     */
    function copyRecordStructure (Id $assetId, Id $recordStructureId ) { 
	
		// Get our managers:
		$recordMgr = Services::getService("RecordManager");
		$idMgr = Services::getService("Id");
		
		// Get the RecordSet for this Asset
		$myId =$this->_node->getId();
		$set =$recordMgr->fetchRecordSet($myId->getIdString());
		
		// Get the DataSetGroup for the source Asset
		$otherSet =$recordMgr->fetchRecordSet($assetId->getIdString());
		$otherSet->loadRecords(RECORD_FULL);
		$records =$otherSet->getRecords();
		
		// Add all of Records (Records) of the specified RecordStructure and Asset
		// to our RecordSet.
		foreach (array_keys($records) as $key) {
			// Get the ID of the current DataSet's TypeDefinition
			$schema =$records[$key]->getSchema();
			$schemaId =$idMgr->getId($schema->getID());
			
			// If the current Record's Schema ID is the same as
			// the RecordStructure ID that we are looking for, add replicates of that Record
			// to our RecordSet.
			if ($recordStructureId->isEqual($schemaId)) {
				$newRecord =$records[$key]->replicate();
				$set->add($newRecord);
			}
		}
		
		// Save our RecordSet
		$set->commit(TRUE);
		
		$this->updateModificationDate();
	}

	/**
     * Delete a Record.  If the specified Record has content that is inherited
     * by other Records, those other Records will not be deleted, but they
     * will no longer have a source from which to inherit value changes.
     * 
     * @param object Id $recordId
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
    function deleteRecord (Id $recordId ) { 
		
		$record =$this->getRecord($recordId);
		$structure =$record->getRecordStructure();
		$structureId =$structure->getId();
		
		// If this is a schema that is hard coded into our implementation, create
		// a record for that schema.
		if (in_array($structureId->getIdString(), array_keys($this->_repository->_builtInTypes))) 
		{
			// Delete all of the Parts for the record
			$parts =$record->getParts();
			while ($parts->hasNext()) {
				$part =$parts->next();
				$record->deletePart($part->getId());
			}
			
			// Delete the relation for the record.
			$dbHandler = Services::getService("DatabaseManager");
			$query = new DeleteQuery;
			$query->setTable("dr_asset_record");
			$myId =$this->getId();
			$query->addWhereEqual("fk_asset", $myId->getIdString());
			$query->addWhereEqual("fk_record", $recordId->getIdString());
			
			$result =$dbHandler->query($query, $this->_dbIndex);
		}
		// Otherwise use the data manager
		else {
			$recordMgr = Services::getService("RecordManager");
			$record =$recordMgr->fetchRecord($recordId->getIdString(),RECORD_FULL);
			
			// Check if the record is part of other record sets (assets via inheretance)
			$myId =$this->getId();
			$setsContaining = $recordMgr->getRecordSetIDsContaining($record);
			$myRecordSet =$recordMgr->fetchRecordSet($myId->getIdString());
			
			// If this is the last asset referencing this record, delete it.
			$idManager = Services::getService('Id');
			if (count($setsContaining) == 1 && $myId->isEqual($idManager->getId($setsContaining[0]))) {
				$myRecordSet->removeRecord($record);
				$myRecordSet->commit(TRUE);
				$record->delete();
				$record->commit(TRUE);
			}
			// If this record is used by other assets, remove the record from this set, 
			// but leave it in the rest.
			else {
				$myRecordSet =$recordMgr->fetchRecordSet($myId->getIdString());
				$myRecordSet->removeRecord($record);
				$myRecordSet->commit(TRUE);
			}
		}
		
		$this->updateModificationDate();
	}

	 /**
     * Get the Record for this Asset that matches this Record's unique Id.
     * 
     * @param object Id $recordId
     *  
     * @return object Record
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
    function getRecord ( Id $recordId ) { 
		
		// Check to see if the record is in our cache.
		// If so, return it. If not, create it, then return it.
		if (!isset($this->_createdRecords[$recordId->getIdString()])) {
			// Check for the record in our non-datamanager records;
		
			$idManager = Services::getService("Id");
			$dbHandler = Services::getService("DatabaseManager");
			$myId =$this->getId();

			// get the record ids that we want to inherit
			$query = new SelectQuery();
			$query->addTable("dr_asset_record");
			$query->addColumn("structure_id");
			$query->addWhereEqual("fk_asset", $myId->getIdString());
			$query->addWhereEqual("fk_record", $recordId->getIdString(), _AND);
			
			$result =$dbHandler->query($query, $this->_dbIndex);
			
			if ($result->getNumberOfRows()) {
				$structureIdString = $result->field("structure_id");
				
				$recordClass = $this->_repository->_builtInTypes[$structureIdString];
				$recordStructureId =$idManager->getId($structureIdString);
				$recordStructure =$this->_repository->getRecordStructure($recordStructureId);
				
				$this->_createdRecords[$recordId->getIdString()] = new $recordClass(
												$recordStructure,
												$recordId,
												$this->_configuration,
												$this
											);
			} 
			
			// Otherwise use the data manager
			else {
				
				// Get the DataSet.
				$recordMgr = Services::getService("RecordManager");
				// Specifying TRUE for editable because it is unknown whether or not editing will
				// be needed. @todo Change this if we wish to re-fetch the $dataSet when doing 
				// editing functions.
				$record =$recordMgr->fetchRecord($recordId->getIdString());
	
				// Make sure that we have a valid dataSet
				$rule = ExtendsValidatorRule::getRule("DMRecord");
				if (!$rule->check($record))
					throwError(new HarmoniError(RepositoryException::UNKNOWN_ID(), "Repository :: Asset", TRUE));
				
				// Get the record structure.
				$schema =$record->getSchema();
				if (!isset($this->_createdRecordStructures[$schema->getID()])) {
					$repository =$this->getRepository();
					$this->_createdRecordStructures[$schema->getID()] = new HarmoniRecordStructure($this->manager, $schema, $repository->getId());
				}
				
				// Create the Record in our cache.
				$this->_createdRecords[$recordId->getIdString()] = new HarmoniRecord ($this->manager,
								$this->_createdRecordStructures[$schema->getID()], $record, $this);
			}
			$result->free();
		}
						
		return $this->_createdRecords[$recordId->getIdString()];
	}

	
    /**
     * Get all the Records for this Asset.  Iterators return a set, one at a
     * time.
     *  
     * @return object RecordIterator
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
    function getRecords () { 
		
		$id =$this->getId();
		$recordMgr = Services::getService("RecordManager");
		$idManager = Services::getService("Id");		
		$records = array();
		
		// Get the records from the data manager.
		if ($recordSet =$recordMgr->fetchRecordSet($id->getIdString())) {
			// fetching as editable since we don't know if it will be edited.
			$recordSet->loadRecords();
			$dmRecords =$recordSet->getRecords();
	
			// create  records for each dataSet as needed.
			foreach (array_keys($dmRecords) as $key) {
				$recordIdString = $dmRecords[$key]->getID();
				$recordId =$idManager->getId($recordIdString);
				$record =$this->getRecord($recordId);
				$structure =$record->getRecordStructure();
				
				// Add the record to our array
				$records[] =$record;
			}
		}
		
		// get the record ids that we want to inherit
		$dbHandler = Services::getService("DatabaseManager");
		$myId =$this->getId();
		
		$query = new SelectQuery();
		$query->addTable("dr_asset_record");
		$query->addColumn("fk_record");
		$query->addWhereEqual("fk_asset", $myId->getIdString());
		
		$result =$dbHandler->query($query, $this->_dbIndex);
		
		while ($result->hasMoreRows()) {
			$recordId =$idManager->getId($result->field("fk_record"));
			
			$records[] =$this->getRecord($recordId);
			
			$result->advanceRow();
		}
		$result->free();
		// Create an iterator and return it.
		$recordIterator = new HarmoniRecordIterator($records);
		
		return $recordIterator;
	}
	
    /**
     * Get all the Records of the specified RecordStructure for this Asset.
     * Iterators return a set, one at a time.
     * 
     * @param object Id $recordStructureId
     *  
     * @return object RecordIterator
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
    function getRecordsByRecordStructure (Id $recordStructureId ) { 
		
		$id =$this->getId();
		$recordMgr = Services::getService("RecordManager");
		$idManager = Services::getService("Id");		
		$records = array();
		
		// Get our non-datamanager records
		if (in_array($recordStructureId->getIdString(), array_keys($this->_repository->_builtInTypes))) 
		{
			// get the record ids that we want to inherit
			$dbHandler = Services::getService("DatabaseManager");
			$myId =$this->getId();
			
			$query = new SelectQuery();
			$query->addTable("dr_asset_record");
			$query->addColumn("fk_record");
			$query->addWhereEqual("fk_asset", $myId->getIdString());
			$query->addWhereEqual("structure_id", $recordStructureId->getIdString(), _AND);
			
			$result =$dbHandler->query($query, $this->_dbIndex);
			
			while ($result->hasMoreRows()) {
				$recordId =$idManager->getId($result->field("fk_record"));
				
				$records[] =$this->getRecord($recordId);
				
				$result->advanceRow();
			}
			
			$result->free();
		}
		// Get the records from the data manager.
		else if ($recordSet =$recordMgr->fetchRecordSet($id->getIdString())) {
			// fetching as editable since we don't know if it will be edited.
			$recordSet->loadRecords();
			$dmRecords =$recordSet->getRecords();
	
			// create  records for each dataSet as needed.
			foreach (array_keys($dmRecords) as $key) {
				$recordIdString = $dmRecords[$key]->getID();
				$recordId =$idManager->getId($recordIdString);
				$record =$this->getRecord($recordId);
				$structure =$record->getRecordStructure();
				
				// Add the record to our array
				if ($recordStructureId->isEqual($structure->getId()))
					$records[] =$record;
			}
		}
		
		// Create an iterator and return it.
		$recordIterator = new HarmoniRecordIterator($records);
		
		return $recordIterator;
	}
	
    /**
     * Get all the Records of the specified RecordStructureType for this Asset.
     * Iterators return a set, one at a time.
     * 
     * @param object Type $recordStructureType
     *  
     * @return object RecordIterator
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
    function getRecordsByRecordStructureType (Type $recordStructureType ) { 
		throw new UnimplementedException();
    } 
 	
 	/**
     * Get the AssetType of this Asset.  AssetTypes are used to categorize
     * Assets.
     *  
     * @return object Type
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
    function getAssetType () { 
		return $this->_node->getType();
	}

	/**
     * Get all the RecordStructures for this Asset.  RecordStructures are used
     * to categorize information about Assets.  Iterators return a set, one at
     * a time.
     *  
     * @return object RecordStructureIterator
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
    function getRecordStructures () { 
		// cycle through all our DataSets, get their type and make a RecordStructure for each. 
		$recordStructures = array();
		
		$records =$this->getRecords();
		
		while ($records->hasNext()) {
			$record =$records->next();
			$structure =$record->getRecordStructure();
			$structureId =$structure->getId();
			if (!isset($recordStructures[$structureId->getIdString()]))
				$recordStructures[$structureId->getIdString()] =$structure;
		}
		
		$obj = new HarmoniIterator($recordStructures);
		
		return $obj;
	}

	/**
     * Get the RecordStructure associated with this Asset's content.
     *  
     * @return object RecordStructure
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
    function getContentRecordStructure () { 
		$idManager = Services::getService("Id");
		$schemaMgr = Services::getService("SchemaManager");
		
		$recordStructures =$this->_repository->getRecordStructures();

		// Get the id of the Content DataSetTypeDef
		$contentType = "edu.middlebury.harmoni.repository.asset_content";
		$contentTypeId =$idManager->getId($contentType);
		
		while ($recordStructures->hasNext()) {
			$structure =$recordStructures->next();
			if ($contentTypeId->isEqual($structure->getId()))
				return $structure;
		}
		throwError(new HarmoniError(RepositoryException::OPERATION_FAILED(), "Repository :: Asset", TRUE));
	}
	
	
    /**
     * Get the Part for a Record for this Asset that matches this Part's unique
     * Id.
     * 
     * @param object Id $partId
     *  
     * @return object Part
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
    function getPart ( Id $partId ) { 
	
		$records =$this->getRecords();
		while ($records->hasNext()) {
			$record =$records->next();
			$parts =$record->getParts();
			while ($parts->hasNext()) {
				$part =$parts->next();
				if ($partId->isEqual($part->getId()))
					return $part;
			}
		}
		// Throw an error if we didn't find the part.
		throwError(new HarmoniError(RepositoryException::UNKNOWN_ID(), "Repository :: Asset", TRUE));
	}
	
	/**
     * Get the Value of the Part of the Record for this Asset that matches this
     * Part's unique Id.
     * 
     * @param object Id $partId
     *  
     * @return object mixed (original type: java.io.Serializable)
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
    function getPartValue ( Id $partId ) { 
		$part =$this->getPart($partId);
		return $part->getValue();
	}
	
	/**
     * Get the Parts of the Records for this Asset that are based on this
     * RecordStructure PartStructure's unique Id.
     * 
     * @param object Id $partStructureId
     *  
     * @return object PartIterator
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
    function getPartsByPartStructure ( Id $partStructureId ) { 
		$returnParts = array();
		$records =$this->getRecords();
		while ($records->hasNext()) {
			$record =$records->next();
			$parts =$record->getParts();
			while ($parts->hasNext()) {
				$part =$parts->next();
				$partStructure =$part->getPartStructure();
				if ($partStructureId->isEqual($partStructure->getId()))
					$returnParts[] =$part;
			}
		}
    	$obj = new HarmoniIterator($returnParts);
    	return $obj;
    }
	
	/**
     * Get the Values of the Parts of the Records for this Asset that are based
     * on this RecordStructure PartStructure's unique Id.
     * 
     * @param object Id $partStructureId
     *  
     * @return object ObjectIterator
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
    function getPartValuesByPartStructure ( Id $partStructureId ) { 
    	$partIterator =$this->getPartsByPartStructure($partStructureId);
    	$partValues = array();
//		print $partStructureId->getIdString()."<br />";
    	while ($partIterator->hasNext()) {
    		$part =$partIterator->next();
    		$partValues[] =$part->getValue();
    	}
    	$obj = new HarmoniIterator($partValues);
    	return $obj;
    } 

	/**
	 * Store the effective and expiration Dates. getEffectiveDate or getExpirationDate
	 * should be called first to set the datesInDB flag.
	 * 
	 * @return void
	 * @access public
	 * @since 8/10/04
	 */
	function _storeDates () {
		$dbHandler = Services::getService("DatabaseManager");
		$id =$this->_node->getId();
		
		// If we have stored dates for this asset set them
		if ($this->_datesInDB) {
			$query = new UpdateQuery;
			$query->addWhereEqual("asset_id", $id->getIdString());
		} 
		
		// Otherwise, insert Them
		else {
			$query = new InsertQuery;
			$query->addValue("asset_id", $id->getIdString());
			$query->addRawValue("create_timestamp", "NOW()");
			
			// Add the creator
			$agentId = $this->_getCurrentAgent();
			$query->addValue("creator", $agentId->getIdString());
		}
		
		
		
		if (is_object($this->_effectiveDate))
			$query->addValue("effective_date", $dbHandler->toDBDate($this->_effectiveDate, $this->_dbIndex));
		else
			$query->addRawValue("effective_date", "NULL");
			
		if (is_object($this->_expirationDate))
			$query->addValue("expiration_date", $dbHandler->toDBDate($this->_expirationDate, $this->_dbIndex));
		else
			$query->addRawValue("expiration_date", "NULL");
			

		$query->addRawValue("modify_timestamp", "NOW()");
		
		$query->setTable("dr_asset_info");
		
		$result =$dbHandler->query($query, $this->_dbIndex);
	}
	
	/**
	 * Answer the current agent id
	 * 
	 * @return object Id
	 * @access private
	 * @since 7/9/07
	 */
	function _getCurrentAgent () {
		$authN = Services::getService("AuthN");
		$agentM = Services::getService("Agent");
		$idM = Services::getService("Id");
		$authTypes =$authN->getAuthenticationTypes();
		
		while ($authTypes->hasNext()) {
			$authType =$authTypes->next();
			$id =$authN->getUserId($authType);
			if (!$id->isEqual($idM->getId('edu.middlebury.agents.anonymous'))) {
				return $id;
			}
		}
		
		// If we didn't find an agent, return the anonymous id.
		return $idM->getId('edu.middlebury.agents.anonymous');
	}
	
	/**
	 * Loads dates from the database and sets the _datesInDB flag
	 * 
	 * @return void
	 * @access public
	 * @since 8/10/04
	 */
	function _loadDates () {
		$dbHandler = Services::getService("DatabaseManager");
		// Get the content DataSet.
		$id =$this->_node->getId();
		
		$query = new SelectQuery;
		$query->addTable("dr_asset_info");
		$query->addColumn("effective_date");
		$query->addColumn("expiration_date");
		$query->addColumn("create_timestamp");
		$query->addColumn("creator");
		$query->addColumn("modify_timestamp");
		$query->addWhereEqual("asset_id", $id->getIdString());
		
		$result =$dbHandler->query($query, $this->_dbIndex);
		
		// If we have stored dates for this asset set them
		if ($result->getNumberOfRows()) {
			$this->_effectiveDate =$dbHandler->fromDBDate($result->field("effective_date"), $this->_dbIndex);
			$this->_expirationDate =$dbHandler->fromDBDate($result->field("expiration_date"), $this->_dbIndex);
			$this->_createDate =$dbHandler->fromDBDate($result->field("create_timestamp"), $this->_dbIndex);
			$this->_creator = $result->field("creator");
			$this->_modifyDate =$dbHandler->fromDBDate($result->field("modify_timestamp"), $this->_dbIndex);
			$this->_datesInDB = TRUE;
			
			if (!$this->_createDate)
				$this->_createDate = DateAndTime::epoch();
			if (!$this->_modifyDate)
				$this->_modifyDate = DateAndTime::epoch();
		} 
		
		else {
			$this->_effectiveDate = NULL;
			$this->_expirationDate = NULL;
			$this->_createDate = DateAndTime::epoch();
			$this->_modifyDate = DateAndTime::epoch();
			$this->_creator = NULL;
			$this->_datesInDB = FALSE;
		}
		
		$result->free();
	}
	
	/**
	 * Update the modification date and set the creation date if needed.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @return void
	 * @access public
	 * @since 5/4/06
	 */
	function updateModificationDate () {
		// Only update our modification time if we will be adding more than a
		// minute (to save on many repeated updates while changing lots of values
		// at once).
		if (isset($this->_modifyDate) && is_object($this->_modifyDate)) {
			$now = DateAndTime::now();
			$minute = Duration::withSeconds(60);
			if ($minute->isGreaterThan($now->minus($this->_modifyDate)))
				return;			
		}
		
		$this->_loadDates();
		$this->_storeDates();
	}
	
	/**
	 * Answer the Id of the agent that created the asset
	 * 
	 * WARNING: NOT IN OSID
	 * 
	 * @return object Id
	 * @access public
	 * @since 7/9/07
	 */
	function getCreator () {
		if (!isset($this->_creator)) {
			$this->_loadDates();
		}
		
		if (is_null($this->_creator)) {
			$null = null;
			return $null;
		} else {
			$idManager = Services::getService("Id");
			return $idManager->getId($this->_creator);
		}
	}
	
	/**
     * Get the date at which this Asset was created.
     *  
     * WARNING: NOT IN OSID
     *
     * @return object DateAndTime
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
    function getCreationDate () { 
		if (!isset($this->_createDate) || $this->_createDate->isEqualTo(DateAndTime::epoch())) {
			$this->_loadDates();
		}
		
		return $this->_createDate;
	}
	
	/**
     * Get the date at which this Asset was created.
     *  
     * WARNING: NOT IN OSID
     *
     * @return object DateAndTime
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
    function getModificationDate () { 
		if (!isset($this->_modifyDate) || $this->_modifyDate->isEqualTo(DateAndTime::epoch())) {
			$this->_loadDates();
		}
		
		return $this->_modifyDate;
	}
	
	/**
	 * Forcibly set the creator of this Asset. This is meant to be used when importing
	 * from backups.
     *  
     * WARNING: NOT IN OSID
     *
	 * @param object Id $agentId
	 * @return void
	 * @access public
	 * @since 1/25/08
	 */
	public function forceSetCreator (Id $agentId) {
		$dbHandler = Services::getService("DatabaseManager");
		$query = new UpdateQuery;
		$query->setTable("dr_asset_info");
		$query->addValue("creator", $agentId->getIdString());
		$query->addWhereEqual("asset_id", $this->getId()->getIdString());
		$dbHandler->query($query, $this->_dbIndex);
		
		$this->_creator = $agentId->getIdString();
	}
	
	/**
	 * Forcibly set the creation date of this Asset. This is meant to be used when importing
	 * from backups.
     *  
     * WARNING: NOT IN OSID
     *
	 * @param object DateAndTime $date
	 * @return void
	 * @access public
	 * @since 1/25/08
	 */
	public function forceSetCreationDate (DateAndTime $date) {
		$dbHandler = Services::getService("DatabaseManager");
		$query = new UpdateQuery;
		$query->setTable("dr_asset_info");
		$query->addValue("create_timestamp", $date->asString());
		$query->addWhereEqual("asset_id", $this->getId()->getIdString());
		$dbHandler->query($query, $this->_dbIndex);
		
		$this->_createDate = $date;
	}
	
	/**
	 * Forcibly set the creation date of this Asset. This is meant to be used when importing
	 * from backups.
     *  
     * WARNING: NOT IN OSID
     *
	 * @param object DateAndTime $date
	 * @return void
	 * @access public
	 * @since 1/25/08
	 */
	public function forceSetModificationDate (DateAndTime $date) {
		$dbHandler = Services::getService("DatabaseManager");
		$query = new UpdateQuery;
		$query->setTable("dr_asset_info");
		$query->addValue("modify_timestamp", $date->asString());
		$query->addWhereEqual("asset_id", $this->getId()->getIdString());
		$dbHandler->query($query, $this->_dbIndex);
		
		$this->_modifyDate = $date;
	}
	
	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {		
		// Save the dataManager
		$recordMgr = Services::getService("RecordManager");
		$nodeId =$this->_node->getId();
		$group =$recordMgr->fetchRecordSet($nodeId->getIdString(), true);
		
		// The ignoreMandatory Allows this record to be created without checking for
		// values on mandatory fields. These constraints should be checked when
		// validateAsset() is called.
		if ($group) $group->commit(TRUE);
	}

} // end Asset