<?

require_once(HARMONI."/oki/dr/HarmoniAsset.interface.php");
require_once(HARMONI."/oki/dr/HarmoniInfoRecord.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoRecordIterator.class.php");

/**
 * Asset manages the Asset itself.  Assets have content as well as InfoRecords
 * appropriate to the AssetType and InfoStructures for the Asset.  Assets may
 * also contain other Assets.
 */

class HarmoniAsset
	extends HarmoniAssetInterface
{ // begin Asset

	var $_hierarchy;
	var $_node;
	var $_dr;
	
	var $_dataSetsIDs;
	var $_createdInfoRecords;
	var $_createdInfoStructures;
	
	/**
	 * Constructor
	 * 
	 *
	 *
	 */
	function HarmoniAsset (& $hierarchy, & $dr, & $id) {
	 	// Get the node coresponding to our id
		$this->_hierarchy =& $hierarchy;
		$this->_node =& $this->_hierarchy->getNode($id);
		$this->_dr =& $dr;
		
		$this->_dataSetsIDs = array();
		$this->_createdInfoRecords = array();
		$this->_createdInfoStructures = array();
	 }

	/**
	 * Get the display name for this Asset.
	 *
	 * @return String the display name
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function getDisplayName() {
		return $this->_node->getDisplayName();
	}

	/**
	 * Update the display name for this Asset.
	 *
	 * @param String displayName
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateDisplayName($displayName) {
		$this->_node->updateDisplayName($displayName);
	}

	/**
	 * Get the description for this Asset.
	 *
	 * @return String the description
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function getDescription() {
		return $this->_node->getDescription();
	}

	/**
	 * Update the description for this Asset.
	 *
	 * @param String description
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateDescription($description) {
		$this->_node->updateDescription($description);
	}

	/**
	 * Get the unique Id for this Asset.
	 *
	 * @return osid.shared.Id A unique Id that is usually set by a create
	 *		 method's implementation
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getId() {
		return $this->_node->getId();
	}

	/**
	 * Get the DigitalRepository in which this Asset resides.  This is set by
	 * the DigitalRepository's createAsset method.
	 *
	 * @return osid.shared.Id A unique Id that is usually set by a create
	 *		 method's implementation digitalRepositoryId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getDigitalRepository() {
		return $this->_dr;
	}

	/**
	 * Get an Asset's content.  This method can be a convenience if one is not
	 * interested in all the structure of the InfoRecords.
	 *
	 * @return java.io.Serializable
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getContent() {
		$dataSetMgr =& Services::getService("DataSetManager");
		$myId = $this->_node->getId();
		$myGroup =& $dataSetMgr->fetchDataSetGroup($myId->getIdString());
		
		$valid = $this->_dr->isAssetValid($myId);
		
		/*$sets =& */$myGroup->fetchDataSets(!$valid);
		
		// return the group, but have the above line pre-load the DataSets in the group.
		return $myGroup;
//		return $sets;
	}

	/**
	 * Update an Asset's content.
	 *
	 * @param java.io.Serializable
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateContent(& $content) {
		// let's update what we've got stored with the new IDs & DataSets
		
		throwError( new Error(
			OPERATION_FAILED.": The method updateContent() has not been implemented. Use getContent() and modify that directly.","HarmoniAsset",true));
	}

	/**
	 * Add an Asset to this Asset.
	 *
	 * @param osid.shared.Id assetId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, UNKNOWN_ID, ALREADY_ADDED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function addAsset(& $assetId) {
		$node =& $this->_hierarchy->getNode($assetId);
		$oldParents =& $node->getParents();
		// We are assuming a single-parent hierarchy
		$oldParent =& $oldParents->next();
		$node->changeParent($oldParent->getId(), $this->_node->getId());
	}

	/**
	 * Remove an Asset to this Asset.  This method does not delete the Asset
	 * from the DigitalRepository.
	 *
	 * @param osid.shared.Id assetId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, UNKNOWN_ID
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function removeAsset(& $assetId, $includeChildren) {
		$node =& $this->_hierarchy->getNode($assetId);
	
		if (!$includeChildren) {
			// Move the children to the current asset before moving
			// the asset to the dr root
			$children =& $node->getChildren();
			while ($children->hasNext()) {
				$child =& $children->next();
				$child->changeParent($node->getId(), $this->_node->getId());
			}
		}
		
		// Move the asset to the dr root.
		$node->changeParent($this->_node->getId(), $this->_dr->getId());
	}

	/**
	 * Get all the Assets in this Asset.  Iterators return a set, one at a
	 * time.  The Iterator's hasNext method returns true if there are
	 * additional objects available; false otherwise.  The Iterator's next
	 * method returns the next object.
	 *
	 * @return osid.dr.AssetIterator  The order of the objects returned by the
	 *		 Iterator is not guaranteed.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	/**
	 * Get all the Assets of the specified AssetType in this DigitalRepository.
	 * Iterators return a set, one at a time.  The Iterator's hasNext method
	 * returns true if there are additional objects available; false
	 * otherwise.  The Iterator's next method returns the next object.
	 *
	 * @return osid.dr.AssetIterator  The order of the objects returned by the
	 *		 Iterator is not guaranteed.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, UNKNOWN_TYPE
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getAssets() {
		$assets = array();
		$children =& $this->_node->getChildren();
		while ($children->hasNext()) {
			$child =& $children->next();
			$assets[] =& $this->_dr->getAsset($child->getId());
		}
		
		// create an AssetIterator and return it
		$assetIterator =& new HarmoniAssetIterator($assets);
		
		return $assetIterator;
	}

	/**
	 * Create a new Asset InfoRecord of the specified InfoStructure.   The
	 * implementation of this method sets the Id for the new object.
	 *
	 * @param osid.shared.Id infoStructureId
	 *
	 * @return osid.dr.InfoRecord
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, UNKNOWN_ID
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & createInfoRecord(& $infoStructureId) {
		ArgumentValidator::validate($infoStructureId, new ExtendsValidatorRule("Id"));
		
		// Get the DataSetGroup for this Asset
		$dataSetMgr =& Services::getService("DataSetManager");
		$myId = $this->_node->getId();
		$myGroup =& $dataSetMgr->fetchDataSetGroup($myId->getIdString());
		
		// Get the info Structure needed.
		$infoStructures =& $this->_dr->getInfoStructures();
		while ($infoStructures->hasNext()) {
			$structure =& $infoStructures->next();
			if ($infoStructureId->isEqual($structure->getId()))
				break;
		}
		
		// 	get the type for the new data set.
		$dataSetTypeMgr =& Services::getService("DataSetTypeManager");
		$type =& $dataSetTypeMgr->getDataSetTypeByID($infoStructureId->getIdString());
		
		// Set up and create our new dataset
		$versionControl = FALSE;
		$newDataSet =& $dataSetMgr->newDataSet($type, $versionControl);
		
		printpre($myGroup->_dataSetIDs);
		// Add the DataSet to our group
		$myGroup->addDataSet($newDataSet);
		printpre($myGroup->_dataSetIDs);
		
		// us the InfoStructure and the dataSet to create a new InfoRecord
		$record =& new HarmoniInfoRecord($structure, $newDataSet);
		
		// Add the record to our createdRecords array, so we can pass out references to it.
		$recordId =& $record->getId();
		$this->_createdInfoRecords[$recordId->getIdString()] =& $record;
		
		$this->save();
		
		return $record;
	}

	/**
	 * Add the specified InfoStructure and all the related InfoRecords from the
	 * specified asset.  The current and future content of the specified
	 * InfoRecord is synchronized automatically.
	 *
	 * @param osid.shared.Id assetId
	 * @param osid.shared.Id infoStructureId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, ALREADY_INHERITING_STRUCTURE
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function inheritInfoStructure(& $infoStructureId, & $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Add the specified InfoStructure and all the related InfoRecords from the
	 * specified asset.
	 *
	 * @param osid.shared.Id assetId
	 * @param osid.shared.Id infoStructureId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function copyInfoStructure(& $infoStructureId, & $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Delete an InfoRecord.  If the specified InfoRecord has content that is
	 * inherited by other InfoRecords, those
	 *
	 * @param osid.shared.Id infoRecordId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, UNKNOWN_ID
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function deleteInfoRecord(& $infoRecordId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Get the InfoRecord of the specified ID for this Asset.
	 *
	 * @param osid.shared.Id infoRecordId
	 *
	 * @return osid.dr.InfoRecord 
	 *
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getInfoRecord(& $infoRecordId ) {
		ArgumentValidator::validate($infoRecordId, new ExtendsValidatorRule("Id"));
		
		// Check to see if the info record is in our cache.
		// If so, return it. If not, create it, then return it.
		if (!$this->_createdInfoRecords[$infoRecordId->getIdString()]) {
			
			// Get the DataSet.
			$dataSetMgr =& Services::getService("DataSetManager");
			// Specifying TRUE for editable because it is unknown whether or not editing will
			// be needed. @todo Change this if we wish to re-fetch the $dataSet when doing 
			// editing functions.
			$dataSet =& $dataSetMgr->fetchDataSet($infoRecordId->getIdString(), TRUE);

			// Make sure that we have a valid dataSet
			$rule =& new ExtendsValidatorRule("CompactDataSet");
			if (!$rule->check($dataSet))
				throwError(new Error(UNKNOWN_ID, "Digital Repository :: Asset", TRUE));
			
			// Get the info structure.
			$dataSetTypeDef =& $dataSet->getDataSetTypeDefinition();
			if (!$this->_createdInfoStructures[$dataSetTypeDef->getID()]) {
				$this->_createdInfoStructures[$dataSetTypeDef->getID()] =& new HarmoniInfoStructure($dataSetTypeDef);
			}
			
			// Create the InfoRecord in our cache.
			$this->_createdInfoRecords[$infoRecordId->getIdString()] =& new HarmoniInfoRecord (
							$this->_createdInfoStructures[$dataSetTypeDef->getID()], $dataSet);
		}
		
		return $this->_createdInfoRecords[$infoRecordId->getIdString()];
	}

	/**
	 * Get all the InfoRecords for this Asset.  Iterators return a set, one at
	 * a time.  The Iterator's hasNext method returns true if there are
	 * additional objects available; false otherwise.  The Iterator's next
	 * method returns the next object.
	 *
	 * @return osid.dr.InfoRecordIterator  The order of the objects returned by
	 *		 the Iterator is not guaranteed.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */	 
	/**
	 * Get all the InfoRecords of the specified InfoStructure for this Asset.
	 * Iterators return a set, one at a time.  The Iterator's hasNext method
	 * returns true if there are additional objects available; false
	 * otherwise.  The Iterator's next method returns the next object.
	 *
	 * @param osid.shared.Id infoStructureId
	 *
	 * @return osid.dr.InfoRecordIterator  The order of the objects returned by
	 *		 the Iterator is not guaranteed.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, CANNOT_COPY_OR_INHERIT_SELF
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getInfoRecords( $infoStructureId = null ) {
		if ($infoStructureId)
			ArgumentValidator::validate($infoStructureId, new ExtendsValidatorRule("Id"));
		
		$id =& $this->getId();
		$dataSetMgr =& Services::getService("DataSetManager");
		$sharedManager =& Services::getService("Shared");		
		
		$dataSetGroup =& $dataSetMgr->fetchDataSetGroup($id->getIdString());
		// fetching as editable since we don't know if it will be edited.
		$dataSets =& $dataSetGroup->fetchDataSets(TRUE);

		// create info records for each dataSet as needed.
		$infoRecords = array();
		foreach ($dataSets as $key => $dataSet) {
			$dataSetId =& $sharedManager->getId($key);
			$infoRecord =& $this->getInfoRecord($dataSetId);
			$structure =& $infoRecord->getInfoStructure();
			
			// Add the record to our array
			if (!$infoStructureId || $infoStructureId->isEqual($structure->getId()))
				$infoRecords[] =& $infoRecord;
		}
		
		// Create an iterator and return it.
		$recordIterator =& new HarmoniInfoRecordIterator($infoRecords);
		
		return $recordIterator;
	}

	/**
	 * Description_getAssetTypes=Get the AssetType of this Asset.  AssetTypes
	 * are used to categorize Assets.
	 *
	 * @return osid.shared.Type
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getAssetType() {
		return $this->_node->getType();
	}

	/**
	 * Get all the InfoStructures for this Asset.  InfoStructures are used to
	 * categorize information about Assets.  Iterators return a set, one at a
	 * time.  The Iterator's hasNext method returns true if there are
	 * additional objects available; false otherwise.  The Iterator's next
	 * method returns the next object.
	 *
	 * @return osid.shared.TypeIterator The order of the objects returned by
	 *		 the Iterator is not guaranteed.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getInfoStructures() {
		// cycle through all our DataSets, get their type and make an InfoStructure for each. 
		$infoStructures = array();
		
		$sets =& $this->getContent();
		
		foreach (array_keys($sets) as $id) {
			$typeDef =& $sets[$id]->getDataSetTypeDefinition();
			$infoStructures[] =& new HarmoniInfoStructure($typeDef);
		}
		
		return new HarmoniIterator($infoStructures);
	}

	/**
	 * Get the InfoStructure associated with this Asset's content.
	 *
	 * @return osid.dr.InfoStructure
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function & getContentInfoStructure() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {
		// Save the Hierarchy
		$this->_node->save();
		
		// Save the dataManager
		$dataSetMgr =& Services::getService("DataSetManager");
		$nodeId =& $this->_node->getId();
		$group =& $dataSetMgr->fetchDataSetGroup($nodeId->getIdString(), true);
		
		if ($group) $group->commit();
	}
	 
	/**
	 * Loads this object from persistable storage.
	 * @access protected
	 */
	function load () {
		// Load the Hierarchy
		$this->_node->load();
		
		// Load the dataManager
		// nothing needed.
	}

} // end Asset

?>