<?

require_once(HARMONI."/oki/dr/HarmoniAsset.interface.php");
require_once(HARMONI."/oki/dr/HarmoniInfoRecord.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoRecordIterator.class.php");
require_once(HARMONI."/oki/shared/HarmoniIterator.class.php");

/**
 * Asset manages the Asset itself.  Assets have content as well as InfoRecords
 * appropriate to the AssetType and InfoStructures for the Asset.  Assets may
 * also contain other Assets.
 *
 * @package harmoni.osid.dr
 * @author Adam Franco
 * @copyright 2004 Middlebury College
 * @access public
 */

class HarmoniAsset
	extends HarmoniAssetInterface
{ // begin Asset
	
	var $_configuration;
	var $_versionControlAll = FALSE;
	var $_versionControlTypes;
	var $_hierarchy;
	var $_node;
	var $_dr;
	
	var $_recordIDs;
	var $_createdInfoRecords;
	var $_createdInfoStructures;
	
	/**
	 * Constructor
	 */
	function HarmoniAsset (& $hierarchy, & $dr, & $id, & $configuration) {
	 	// Get the node coresponding to our id
		$this->_hierarchy =& $hierarchy;
		$this->_node =& $this->_hierarchy->getNode($id);
		$this->_dr =& $dr;
		
		$this->_recordIDs = array();
		$this->_createdInfoRecords = array();
		$this->_createdInfoStructures = array();
		
		// Store our configuration
		$this->_configuration =& $configuration;
		$this->_versionControlAll = ($configuration['versionControlAll'])?TRUE:FALSE;
		if (is_array($configuration['versionControlTypes'])) {
			ArgumentValidator::validate($configuration['versionControlTypes'], new ArrayValidatorRuleWithRule( new ExtendsValidatorRule("TypeInterface")));
			$this->_versionControlTypes =& $configuration['versionControlTypes'];
		} else {
			$this->_versionControlTypes = array();
		}
		
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
	 * @return object osid.shared.Id A unique Id that is usually set by a create
	 *		 method's implementation
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getId() {
		return $this->_node->getId();
	}

	/**
	 * Get the DigitalRepository in which this Asset resides.  This is set by
	 * the DigitalRepository's createAsset method.
	 *
	 * @return object osid.shared.Id A unique Id that is usually set by a create
	 *		 method's implementation digitalRepositoryId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getDigitalRepository() {
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
	function &getContent() {
 		$sharedManager =& Services::getService("Shared");
 		$recordMgr =& Services::getService("RecordManager");
 		
 		// Ready our type for comparisson
 		$contentType =& new HarmoniType("DR", "Harmoni",  "AssetContent");
 		$myId =& $this->_node->getId();
 		
 		// Get the content DataSet.
 		$myRecordSet =& $recordMgr->fetchRecordSet($myId->getIdString());
 		$myRecordSet->loadRecords();
		$contentRecords =& $myRecordSet->getRecordsByType($contentType);
		
		$contentRecord =& $contentRecords[0];
		
 		if (!$contentRecord) {
 			return new Blob;
 		} else {
 			$recordFieldData =& $contentRecord->getCurrentValue("Content");
 			return $recordFieldData->getPrimitive();
 		}
	}

	/**
	 * Update an Asset's content.
	 *
	 * @param mixed java.io.Serializable
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateContent(& $content) {
 		ArgumentValidator::validate($content, new ExtendsValidatorRule("Blob"));
 		$sharedManager =& Services::getService("Shared");
 		$recordMgr =& Services::getService("RecordManager");
 		
 		// Ready our type for comparisson
 		$contentType =& new HarmoniType("DR", "Harmoni",  "AssetContent");
 		$myId =& $this->_node->getId();
 		
 		// Get the content DataSet.
 		$myRecordSet =& $recordMgr->fetchRecordSet($myId->getIdString());
 		$myRecordSet->loadRecords();
		$contentRecords =& $myRecordSet->getRecordsByType($contentType);

 		if (count($contentRecords)) {
 			$contentRecord =& $contentRecords[0];
 			
 			$contentRecord->setValue("Content", $content);
 		
			$contentRecord->commit(TRUE);
 		} else {
			// Set up and create our new record
			$schemaMgr =& Services::getService("SchemaManager");
			$contentSchema =& $schemaMgr->getSchemaByType($contentType);
			$contentSchema->load();
			
			// Decide if we want to version-control this field.
			$versionControl = $this->_versionControlAll;
			if (!$versionControl) {
				foreach ($this->_versionControlTypes as $key => $val) {
					if ($contentType->isEqual($this->_versionControlTypes[$key])) {
						$versionControl = TRUE;
						break;
					}
				}
			}
			
			$contentRecord =& $recordMgr->createRecord($contentType, $versionControl);
			
			$contentRecord->setValue("Content", $content);
 		
			$contentRecord->commit(TRUE);
	
			// Add the record to our group
			$myRecordSet->add($contentRecord);
			$myRecordSet->commit(TRUE);
		}
	}

	/**
	 * Get an Asset's EffectiveDate
	 *
	 * @return java.util.Calendar
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getEffectiveDate() {
		if (!$this->_effectiveDate) {
			$this->_loadDates();
		}
		
		return $this->_effectiveDate;
	}

	/**
	 * Update an Asset's EffectiveDate.
	 *
	 * @param object java.util.Calendar
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateEffectiveDate(& $effectiveDate) {
		ArgumentValidator::validate($effectiveDate, new ExtendsValidatorRule("Time"));
		
		// Make sure that we have dates from the DB if they exist.
		$this->_loadDates();
		// Update our date in preparation for DB updating
		$this->_effectiveDate->adoptValue($effectiveDate);
		// Store the dates
		$this->_storeDates();
	}

	/**
	 * Get an Asset's EffectiveDate
	 *
	 * @return java.util.Calendar
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getExpirationDate() {
		if (!$this->_expirationDate) {
			$this->_loadDates();
		}
		
		return $this->_expirationDate;
	}

	/**
	 * Update an Asset's ExpirationDate.
	 *
	 * @param object java.util.Calendar
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function updateExpirationDate(& $expirationDate) {
		ArgumentValidator::validate($expirationDate, new ExtendsValidatorRule("Time"));
		
		// Make sure that we have dates from the DB if they exist.
		$this->_loadDates();
		// Update our date in preparation for DB updating
		$this->_expirationDate->adoptValue($expirationDate);
		// Store the dates
		$this->_storeDates();
	}

	/**
	 * Add an Asset to this Asset.
	 *
	 * @param object osid.shared.Id assetId
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
		
		$this->save();
	}

	/**
	 * Remove an Asset to this Asset.  This method does not delete the Asset
	 * from the DigitalRepository.
	 *
	 * @param object osid.shared.Id assetId
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
		
		$this->save();
	}

	/**
	 * Get all the Assets in this Asset.  Iterators return a set, one at a
	 * time.  The Iterator's hasNext method returns true if there are
	 * additional objects available; false otherwise.  The Iterator's next
	 * method returns the next object.
	 *
	 * @return object osid.dr.AssetIterator  The order of the objects returned by the
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
	 * @return object osid.dr.AssetIterator  The order of the objects returned by the
	 *		 Iterator is not guaranteed.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, UNKNOWN_TYPE
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getAssets() {
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
	 * Get all the Assets of the specified AssetType in this Asset.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object AssetIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.dr
	 */
	function &getAssetsByType(& $assetType) {
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
	 * Create a new Asset InfoRecord of the specified InfoStructure.   The
	 * implementation of this method sets the Id for the new object.
	 *
	 * @param object osid.shared.Id infoStructureId
	 *
	 * @return object osid.dr.InfoRecord
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, UNKNOWN_ID
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &createInfoRecord(& $infoStructureId) {
		ArgumentValidator::validate($infoStructureId, new ExtendsValidatorRule("Id"));
		
		// If this is a schema that is hard coded into our implementation, create
		// a record for that schema.
		if (in_array($infoStructureId->getIdString(), array_keys($this->_dr->_builtInTypes))) 
		{
			// Create an Id for the record;
			$sharedManager =& Services::getService("Shared");
			$newId =& $sharedManager->createId();
	
			// instantiate the new record.
			$recordClass = $this->_dr->_builtInTypes[$infoStructureId->getIdString()];
			$infoStructure =& $this->_dr->getInfoStructure($infoStructureId);
			$record =& new $recordClass($infoStructure, $newId, $this->_configuration);
			
			// store a relation to the record
			$dbHandler =& Services::getService("DBHandler");
			$query =& new InsertQuery;
			$query->setTable("dr_asset_record");
			$query->setColumns(array("FK_asset", "FK_record", "structure_id"));
			$myId =& $this->getId();
			$query->addRowOfValues(array(
								"'".$myId->getIdString()."'",
								"'".$newId->getIdString()."'",
								"'".$infoStructureId->getIdString()."'"));
			$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
		} 
		
		// Otherwise use the data manager
		else {
			// Get the DataSetGroup for this Asset
			$recordMgr =& Services::getService("RecordManager");
			$myId = $this->_node->getId();
			$myGroup =& $recordMgr->fetchRecordSet($myId->getIdString());
			
			// Get the info Structure needed.
			$infoStructures =& $this->_dr->getInfoStructures();
			while ($infoStructures->hasNext()) {
				$structure =& $infoStructures->next();
				if ($infoStructureId->isEqual($structure->getId()))
					break;
			}
			
			// 	get the type for the new data set.
			$schemaMgr =& Services::getService("SchemaManager");
			$type =& $schemaMgr->getSchemaTypeByID($infoStructureId->getIdString());
			
			// Set up and create our new dataset
			// Decide if we want to version-control this field.
				$versionControl = $this->_versionControlAll;
				if (!$versionControl) {
					foreach ($this->_versionControlTypes as $key => $val) {
						if ($type->isEqual($this->_versionControlTypes[$key])) {
							$versionControl = TRUE;
							break;
						}
					}
				}
				
				$newRecord =& $recordMgr->createRecord($type, $versionControl);
			
			// The ignoreMandatory Allows this record to be created without checking for
			// values on mandatory fields. These constraints should be checked when
			// validateAsset() is called.
			$newRecord->commit(TRUE);
			
			// Add the DataSet to our group
			$myGroup->add($newRecord);
			
			// us the InfoStructure and the dataSet to create a new InfoRecord
			$record =& new HarmoniInfoRecord($structure, $newRecord);
		}
		
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
	 * @param object osid.shared.Id assetId
	 * @param object osid.shared.Id infoStructureId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, ALREADY_INHERITING_STRUCTURE
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function inheritInfoStructure(& $infoStructureId, & $assetId) {	
	
		// Check the arguments
		ArgumentValidator::validate($infoStructureId, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($assetId, new ExtendsValidatorRule("Id"));
		
		// If this is a schema that is hard coded into our implementation, create
		// a record for that schema.
		if (in_array($infoStructureId->getIdString(), array_keys($this->_dr->_builtInTypes))) 
		{
			// Create an Id for the record;
			$sharedManager =& Services::getService("Shared");
			$dbHandler =& Services::getService("DBHandler");
	
			// get the record ids that we want to inherit
			$query =& new SelectQuery();
			$query->addTable("dr_asset_record");
			$query->addColumn("FK_record");
			$query->addWhere("FK_asset = '".$assetId->getIdString()."'");
			$query->addWhere("structure_id = '".$infoStructureId->getIdString()."'", _AND);
			
			$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
			
			// store a relation to the record
			$dbHandler =& Services::getService("DBHandler");
			$query =& new InsertQuery;
			$query->setTable("dr_asset_record");
			$query->setColumns(array("FK_asset", "FK_record", "structure_id"));
			
			$myId =& $this->getId();
			
			while ($result->hasMoreRows()) {
				$query->addRowOfValues(array(
									"'".$myId->getIdString()."'",
									"'".$result->field("FK_record")."'",
									"'".$infoStructureId->getIdString()."'"));
				$dbHandler->query($query, $this->_configuration["dbId"]);
				$result->advanceRow();
			}
		} 
		
		// Otherwise use the data manager
		else {
			// Get our managers:
			$recordMgr =& Services::getService("RecordManager");
			$sharedMgr =& Services::getService("Shared");
		
			// Get the DataSetGroup for this Asset
			$myId = $this->_node->getId();
			$mySet =& $recordMgr->fetchRecordSet($myId->getIdString());
			
			// Get the DataSetGroup for the source Asset
			$otherSet =& $recordMgr->fetchRecordSet($assetId->getIdString());
			$otherSet->loadRecords(RECORD_FULL);
			$records =& $otherSet->getRecords();
			
			// Add all of DataSets (InfoRecords) of the specified InfoStructure and Asset
			// to our DataSetGroup.
			foreach (array_keys($records) as $key) {
				// Get the ID of the current DataSet's TypeDefinition
				$schema =& $records[$key]->getSchema();
				$schemaId =& $sharedMgr->getId($schema->getID());
				
				// If the current DataSet's DataSetTypeDefinition's ID is the same as
				// the InfoStructure ID that we are looking for, add that dataSet to our
				// DataSetGroup.
				if ($infoStructureId->isEqual($schemaId)) {
					$mySet->add($records[$key]);
				}
			}
			
			// Save our DataSetGroup
			$mySet->commit(TRUE);
		}
	}

	/**
	 * Add the specified InfoStructure and all the related InfoRecords from the
	 * specified asset.
	 *
	 * @param object osid.shared.Id assetId
	 * @param object osid.shared.Id infoStructureId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function copyInfoStructure(& $infoStructureId, & $assetId) {
	
		// Check the arguments	
		ArgumentValidator::validate($infoStructureId, new ExtendsValidatorRule("Id"));
		ArgumentValidator::validate($assetId, new ExtendsValidatorRule("Id"));
		
		// Get our managers:
		$recordMgr =& Services::getService("RecordManager");
		$sharedMgr =& Services::getService("Shared");
		
		// Get the RecordSet for this Asset
		$myId = $this->_node->getId();
		$set =& $recordMgr->fetchRecordSet($myId->getIdString());
		
		// Get the DataSetGroup for the source Asset
		$otherSet =& $recordMgr->fetchRecordSet($assetId->getIdString());
		$otherSet->loadRecords(RECORD_FULL);
		$records =& $otherSet->getRecords();
		
		// Add all of Records (InfoRecords) of the specified InfoStructure and Asset
		// to our RecordSet.
		foreach (array_keys($records) as $key) {
			// Get the ID of the current DataSet's TypeDefinition
			$schema =& $records[$key]->getSchema();
			$schemaId =& $sharedMgr->getId($schema->getID());
			
			// If the current Record's Schema ID is the same as
			// the InfoStructure ID that we are looking for, add clones of that Record
			// to our RecordSet.
			if ($infoStructureId->isEqual($schemaId)) {
				$newRecord =& $records[$key]->clone();
				$set->add($newRecord);
			}
		}
		
		// Save our RecordSet
		$set->commit(TRUE);
	}

	/**
	 * Delete an InfoRecord.  If the specified InfoRecord has content that is
	 * inherited by other InfoRecords, those
	 *
	 * @param object osid.shared.Id infoRecordId
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, UNKNOWN_ID
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function deleteInfoRecord(& $infoRecordId) {
		ArgumentValidator::validate($infoRecordId, new ExtendsValidatorRule("Id"));
		
		$record =& $this->getInfoRecord($infoRecordId);
		$structure =& $record->getInfoStructure();
		$structureId =& $structure->getId();
		
		// If this is a schema that is hard coded into our implementation, create
		// a record for that schema.
		if (in_array($structureId->getIdString(), array_keys($this->_dr->_builtInTypes))) 
		{
			// Delete all of the InfoFields for the record
			$fields =& $record->getInfoFields();
			while ($fields->hasNext()) {
				$field =& $fields->next();
				$record->deleteInfoField($field->getId());
			}
			
			// Delete the relation for the record.
			$dbHandler =& Services::getService("DBHandler");
			$query =& new DeleteQuery;
			$query->setTable("dr_asset_record");
			$myId =& $this->getId();
			$query->addWhere("FK_asset = '".$myId->getIdString()."'");
			$query->addWhere("FK_record = '".$infoRecordId->getIdString()."'");
			
			$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
		}
		// Otherwise use the data manager
		else {
			$recordMgr =& Services::getService("RecordManager");
			$record =& $recordMgr->fetchRecord($infoRecordId->getIdString(),RECORD_FULL);
			
			// Check if the record is part of other record sets (assets via inheretance)
			$myId =& $this->getId();
			$setsContaining = $recordMgr->getRecordSetIDsContaining($record);
			$myRecordSet =& $recordMgr->fetchRecordSet($myId->getIdString());
			
			// If this is the last asset referencing this record, delete it.
			if (count($setsContaining) == 1 && $setsContaining[0] == $myId->getIdString()) {
				$myRecordSet->removeRecord($record);
				$myRecordSet->commit(TRUE);
				$record->delete(TRUE);
				$record->commit(TRUE);
			}
			// If this record is used by other assets, remove the record from this set, 
			// but leave it in the rest.
			else {
				$myRecordSet =& $recordMgr->fetchRecordSet($myId->getIdString());
				$myRecordSet->removeRecord($record);
				$myRecordSet->commit(TRUE);
			}
		}
	}

	/**
	 * Get the InfoRecord of the specified ID for this Asset.
	 *
	 * @param object osid.shared.Id infoRecordId
	 *
	 * @return object osid.dr.InfoRecord 
	 *
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getInfoRecord(& $infoRecordId ) {
		ArgumentValidator::validate($infoRecordId, new ExtendsValidatorRule("Id"));
		
		// Check to see if the info record is in our cache.
		// If so, return it. If not, create it, then return it.
		if (!$this->_createdInfoRecords[$infoRecordId->getIdString()]) {
			
			// Check for the record in our non-datamanager records;
		
			$sharedManager =& Services::getService("Shared");
			$dbHandler =& Services::getService("DBHandler");
			$myId =& $this->getId();
			
			// get the record ids that we want to inherit
			$query =& new SelectQuery();
			$query->addTable("dr_asset_record");
			$query->addColumn("structure_id");
			$query->addWhere("FK_asset = '".$myId->getIdString()."'");
			$query->addWhere("FK_record = '".$infoRecordId->getIdString()."'", _AND);
			
			$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
			
			if ($result->getNumberOfRows()) {
				$structureIdString =& $result->field("structure_id");
				
				$recordClass = $this->_dr->_builtInTypes[$structureIdString];
				$infoStructureId =& $sharedManager->getId($structureIdString);
				$infoStructure =& $this->_dr->getInfoStructure($infoStructureId);
				
				$this->_createdInfoRecords[$infoRecordId->getIdString()] =& new $recordClass(
												$infoStructure,
												$infoRecordId,
												$this->_configuration
											);
			} 
			
			// Otherwise use the data manager
			else {
				
				// Get the DataSet.
				$recordMgr =& Services::getService("RecordManager");
				// Specifying TRUE for editable because it is unknown whether or not editing will
				// be needed. @todo Change this if we wish to re-fetch the $dataSet when doing 
				// editing functions.
				$record =& $recordMgr->fetchRecord($infoRecordId->getIdString());
	
				// Make sure that we have a valid dataSet
				$rule =& new ExtendsValidatorRule("Record");
				if (!$rule->check($record))
					throwError(new Error(UNKNOWN_ID, "Digital Repository :: Asset", TRUE));
				
				// Get the info structure.
				$schema =& $record->getSchema();
				if (!$this->_createdInfoStructures[$schema->getID()]) {
					$this->_createdInfoStructures[$schema->getID()] =& new HarmoniInfoStructure($schema);
				}
				
				// Create the InfoRecord in our cache.
				$this->_createdInfoRecords[$infoRecordId->getIdString()] =& new HarmoniInfoRecord (
								$this->_createdInfoStructures[$schema->getID()], $record);
			}
		}
		
		return $this->_createdInfoRecords[$infoRecordId->getIdString()];
	}

	/**
	 * Get all the InfoRecords for this Asset.  Iterators return a set, one at
	 * a time.  The Iterator's hasNext method returns true if there are
	 * additional objects available; false otherwise.  The Iterator's next
	 * method returns the next object.
	 *
	 * @return object osid.dr.InfoRecordIterator  The order of the objects returned by
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
	 * @param object osid.shared.Id infoStructureId
	 *
	 * @return object osid.dr.InfoRecordIterator  The order of the objects returned by
	 *		 the Iterator is not guaranteed.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED, NULL_ARGUMENT, CANNOT_COPY_OR_INHERIT_SELF
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getInfoRecords( $infoStructureId = null ) {
		if ($infoStructureId)
			ArgumentValidator::validate($infoStructureId, new ExtendsValidatorRule("Id"));
		
		$id =& $this->getId();
		$recordMgr =& Services::getService("RecordManager");
		$sharedManager =& Services::getService("Shared");		
		$infoRecords = array();
		
		// Get the records from the data manager.
		if ($recordSet =& $recordMgr->fetchRecordSet($id->getIdString())) {
			// fetching as editable since we don't know if it will be edited.
			$recordSet->loadRecords();
			$records =& $recordSet->getRecords();
	
			// create info records for each dataSet as needed.
			foreach (array_keys($records) as $key) {
				$recordIdString = $records[$key]->getID();
				$recordId =& $sharedManager->getId($recordIdString);
				$infoRecord =& $this->getInfoRecord($recordId);
				$structure =& $infoRecord->getInfoStructure();
				
				// Add the record to our array
				if (!$infoStructureId || $infoStructureId->isEqual($structure->getId()))
					$infoRecords[] =& $infoRecord;
			}
		}
		
		// Get our non-datamanager records
		if (!$infoStructureId || in_array($infoStructureId->getIdString(), array_keys($this->_dr->_builtInTypes))) 
		{
			// get the record ids that we want to inherit
			$dbHandler =& Services::getService("DBHandler");
			$myId =& $this->getId();
			
			$query =& new SelectQuery();
			$query->addTable("dr_asset_record");
			$query->addColumn("FK_record");
			$query->addWhere("FK_asset = '".$myId->getIdString()."'");
			if ($infoStructureId)
				$query->addWhere("structure_id = '".$infoStructureId->getIdString()."'", _AND);
			
			$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
			
			while ($result->hasMoreRows()) {
				$recordId =& $sharedManager->getId($result->field("FK_record"));
				
				$infoRecords[] =& $this->getInfoRecord($recordId);
				
				$result->advanceRow();
			}
		}
		
		// Create an iterator and return it.
		$recordIterator =& new HarmoniInfoRecordIterator($infoRecords);
		
		return $recordIterator;
	}

	/**
	 * Description_getAssetTypes=Get the AssetType of this Asset.  AssetTypes
	 * are used to categorize Assets.
	 *
	 * @return object osid.shared.Type
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getAssetType() {
		return $this->_node->getType();
	}

	/**
	 * Get all the InfoStructures for this Asset.  InfoStructures are used to
	 * categorize information about Assets.  Iterators return a set, one at a
	 * time.  The Iterator's hasNext method returns true if there are
	 * additional objects available; false otherwise.  The Iterator's next
	 * method returns the next object.
	 *
	 * @return object osid.shared.TypeIterator The order of the objects returned by
	 *		 the Iterator is not guaranteed.
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getInfoStructures() {
		// cycle through all our DataSets, get their type and make an InfoStructure for each. 
		$infoStructures = array();
		
		$infoRecords =& $this->getInfoRecords();
		
		while ($infoRecords->hasNext()) {
			$record =& $infoRecords->next();
			$structure =& $record->getInfoStructure();
			$structureId =& $structure->getId();
			if (!$infoStructures[$structureId->getIdString()])
				$infoStructures[$structureId->getIdString()] =& $structure;
		}
		
		return new HarmoniIterator($infoStructures);
	}

	/**
	 * Get the InfoStructure associated with this Asset's content.
	 *
	 * @return object osid.dr.InfoStructure
	 *
	 * @throws An exception with one of the following messages defined in
	 *		 osid.dr.DigitalRepositoryException may be thrown:
	 *		 OPERATION_FAILED
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getContentInfoStructure() {
		$sharedManager =& Services::getService("Shared");
		$schemaMgr =& Services::getService("SchemaManager");
		
		$infoStructures =& $this->_dr->getInfoStructures();

		// Get the id of the Content DataSetTypeDef
		$contentType =& new HarmoniType("DR", "Harmoni", "AssetContent");
		$contentTypeId =& $sharedManager->getId($schemaMgr->getIDByType($contentType));
		
		while ($infoStructures->hasNext()) {
			$structure =& $infoStructures->next();
			if ($contentTypeId->isEqual($structure->getId()))
				return $structure;
		}
		throwError(new Error(OPERATION_FAILED, "Digital Repository :: Asset", TRUE));
	}
	
	/**
	 * Get the InfoField for an InfoRecord for this Asset that matches this 
	 * InfoField Unique Id.
	 *
	 * @param object osid.shared.Id infoFieldId
	 *
	 * @return object osid.dr.InfoField
	 *
	 * @throws An exception with one of the following messages defined in 
	 * 		osid.dr.DigitalRepositoryException may be thrown: 
	 * 		OPERATION_FAILED, PERMISSION_DENIED, CONFIGURATION_ERROR, 
	 *		UNIMPLEMENTED, NULL_ARGUMENT, UNKNOWN_ID
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getInfoField(& $infoFieldId) {
	
		$infoRecords =& $this->getInfoRecords();
		while ($infoRecords->hasNext()) {
			$record =& $infoRecords->next();
			$fields =& $record->getInfoFields();
			while ($fields->hasNext()) {
				$field =& $fields->next();
				if ($infoFieldId->isEqual($field->getId()))
					return $field;
			}
		}
		// Throw an error if we didn't find the field.
		throwError(new Error(UNKNOWN_ID, "Digital Repository :: Asset", TRUE));
	}
	
	/**
	 * Get the Value of the InfoField of the InfoRecord for this Asset that 
	 * matches this InfoField Unique Id.
	 *
	 * @param object osid.shared.Id infoFieldId
	 *
	 * @return java.io.Serializable
	 *
	 * @throws An exception with one of the following messages defined in 
	 * 		osid.dr.DigitalRepositoryException may be thrown: 
	 * 		OPERATION_FAILED, PERMISSION_DENIED, CONFIGURATION_ERROR, 
	 *		UNIMPLEMENTED, NULL_ARGUMENT, UNKNOWN_ID
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getInfoFieldValue(& $infoFieldId) {
		throwError(new Error(UNIMPLEMENTED, "Digital Repository :: Asset", TRUE));
	}
	
	/**
	 * Get the InfoFields of the InfoRecords for this Asset that are based 
	 * on this InfoStructure InfoPart Unique Id.
	 *
	 * @param object osid.shared.Id infoPartId
	 *
	 * @return object osid.dr.InfoFieldIterator
	 *
	 * @throws An exception with one of the following messages defined in 
	 * 		osid.dr.DigitalRepositoryException may be thrown: 
	 * 		OPERATION_FAILED, PERMISSION_DENIED, CONFIGURATION_ERROR, 
	 *		UNIMPLEMENTED, NULL_ARGUMENT, UNKNOWN_ID
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getInfoFieldsByPart(& $infoPartId) {
		throwError(new Error(UNIMPLEMENTED, "Digital Repository :: Asset", TRUE));
	}
	
	/**
	 * Get the Values of the InfoFields of the InfoRecords for this Asset
	 * that are based on this InfoStructure InfoPart Unique Id.
	 *
	 * @param object osid.shared.Id infoPartId
	 *
	 * @return object osid.shared.SerializableObjectIterator
	 *
	 * @throws An exception with one of the following messages defined in 
	 * 		osid.dr.DigitalRepositoryException may be thrown: 
	 * 		OPERATION_FAILED, PERMISSION_DENIED, CONFIGURATION_ERROR, 
	 *		UNIMPLEMENTED, NULL_ARGUMENT, UNKNOWN_ID
 	 *
	 * @todo Replace JavaDoc with PHPDoc
	 */
	function &getInfoFieldValueByPart(& $infoPartId) {
		throwError(new Error(UNIMPLEMENTED, "Digital Repository :: Asset", TRUE));
	}

	/**
	 * Store the effective and expiration Dates. getEffectiveDate or getExpirationDate
	 * should be called first to set the datesInDB flag.
	 * 
	 * @return void
	 * @access public
	 * @date 8/10/04
	 */
	function _storeDates () {
		$dbHandler =& Services::getService("DBHandler");
		$id =& $this->_node->getId();
		
		// If we have stored dates for this asset set them
		if ($this->_datesInDB) {
			$query =& new UpdateQuery;
			$query->setWhere("asset_id='".$id->getIdString()."'");
		} 
		
		// Otherwise, insert Them
		else {
			$query =& new InsertQuery;
		}
		
		$columns = array("asset_id", "effective_date", "expiration_date");
		$values = array($id->getIdString(), 
						$dbHandler->toDBDate($this->_effectiveDate, $this->_configuration["dbId"]), 
						$dbHandler->toDBDate($this->_expirationDate, $this->_configuration["dbId"]));
		$query->setColumns($columns);
		$query->setValues($values);
		$query->setTable("dr_asset_info");
		
		$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
	}
	
	/**
	 * Loads dates from the database and sets the _datesInDB flag
	 * 
	 * @return void
	 * @access public
	 * @date 8/10/04
	 */
	function _loadDates () {
		$dbHandler =& Services::getService("DBHandler");
		// Get the content DataSet.
		$id =& $this->_node->getId();
		
		$query =& new SelectQuery;
		$query->addTable("dr_asset_info");
		$query->addColumn("effective_date");
		$query->addColumn("expiration_date");
		$query->addWhere("asset_id='".$id->getIdString()."'");
		
		$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
		
		// If we have stored dates for this asset set them
		if ($result->getNumberOfRows()) {
			$this->_effectiveDate =& new Time($dbHandler->fromDBDate($result->field("effective_date"), $this->_configuration["dbId"]));
			$this->_expirationDate =& new Time($dbHandler->fromDBDate($result->field("expiration_date"), $this->_configuration["dbId"]));
			$this->_datesInDB = TRUE;
		} 
		
		// Otherwise, just create some zeroed objects to return
		else {
			$this->_effectiveDate =& new Time;
			$this->_expirationDate =& new Time;
			$this->_datesInDB = FALSE;
		}
	}
	
	
	
	/**
	 * Saves this object to persistable storage.
	 * @access protected
	 */
	function save () {		
		// Save the dataManager
		$recordMgr =& Services::getService("RecordManager");
		$nodeId =& $this->_node->getId();
		$group =& $recordMgr->fetchRecordSet($nodeId->getIdString(), true);
		
		// The ignoreMandatory Allows this record to be created without checking for
		// values on mandatory fields. These constraints should be checked when
		// validateAsset() is called.
		if ($group) $group->commit(TRUE);
	}

} // end Asset
?>