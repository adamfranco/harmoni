<?php

class DigitalRepositoryManager
	extends OsidManager
{ // begin DigitalRepositoryManager
	// public DigitalRepository & createDigitalRepository(String $description, osid.shared.Type & $digitalRepositoryType, String $displayName);
	function & createDigitalRepository($description, & $digitalRepositoryType, $displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void deleteDigitalRepository(osid.shared.Id & $digitalRepositoryId);
	function deleteDigitalRepository(& $digitalRepositoryId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public DigitalRepositoryIterator & getDigitalRepositories();
	function & getDigitalRepositories() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public DigitalRepositoryIterator & getDigitalRepositories(osid.shared.Type & $digitalRepositoryType);
	function & getDigitalRepositories(& $digitalRepositoryType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public DigitalRepository & getDigitalRepository(osid.shared.Id & $digitalRepositoryId);
	function & getDigitalRepository(& $digitalRepositoryId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Asset & getAsset(osid.shared.Id & $assetId);
	function & getAsset(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Asset & getAsset(osid.shared.Id & $assetId, java.util.Calendar & $date);
	function & getAsset(& $assetId, & $date) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.CalendarIterator & getAssetDates(osid.shared.Id & $assetId);
	function & getAssetDates(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public AssetIterator & getAssets();
	function & getAssets() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.io.Serializable & searchCriteria();
	function & searchCriteria() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & searchType();
	function & searchType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & copyAsset(osid.shared.Id & $assetId, DigitalRepository & $digitalRepository);
	function & copyAsset(& $assetId, & $digitalRepository) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.TypeIterator & getDigitalRepositoryTypes();
	function & getDigitalRepositoryTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end DigitalRepositoryManager


class DigitalRepository
	// extends java.io.Serializable
{ // begin DigitalRepository
	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDisplayName(String $displayName);
	function updateDisplayName($displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDescription();
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDescription(String $description);
	function updateDescription($description) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & getType();
	function & getType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Asset & createAsset(osid.shared.Type & $assetType, String $description, String $displayName);
	function & createAsset(& $assetType, $description, $displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void deleteAsset(osid.shared.Id & $assetId);
	function deleteAsset(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public AssetIterator & getAssets();
	function & getAssets() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public AssetIterator & getAssets(osid.shared.Type & $assetType);
	function & getAssets(& $assetType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.TypeIterator & getAssetTypes();
	function & getAssetTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoStructureIterator & getInfoStructures();
	function & getInfoStructures() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoStructureIterator & getMandatoryInfoStructures(osid.shared.Type & $assetType);
	function & getMandatoryInfoStructures(& $assetType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.TypeIterator & getSearchTypes();
	function & getSearchTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.TypeIterator & getStatusTypes();
	function & getStatusTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & getStatus(osid.shared.Id & $assetId);
	function & getStatus(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean validateAsset(osid.shared.Id & $assetId);
	function validateAsset(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void invalidateAsset(osid.shared.Id & $assetId);
	function invalidateAsset(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Asset & getAsset(osid.shared.Id & $assetId);
	function & getAsset(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Asset & getAsset(osid.shared.Id & $assetId, java.util.Calendar & $date);
	function & getAsset(& $assetId, & $date) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.CalendarIterator & getAssetDates(osid.shared.Id & $assetId);
	function & getAssetDates(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public AssetIterator & getAssets();
	function & getAssets() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.io.Serializable & searchCriteria();
	function & searchCriteria() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & searchType();
	function & searchType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & copyAsset(osid.dr.Asset & $asset);
	function & copyAsset(& $asset) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end DigitalRepository


class Asset
	// extends java.io.Serializable
{ // begin Asset
	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDisplayName(String $displayName);
	function updateDisplayName($displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDescription();
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDescription(String $description);
	function updateDescription($description) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & getDigitalRepository();
	function & getDigitalRepository() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.io.Serializable & getContent();
	function & getContent() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateContent(java.io.Serializable & $content);
	function updateContent(& $content) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void addAsset(osid.shared.Id & $assetId);
	function addAsset(& $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void removeAsset(osid.shared.Id & $assetId, boolean $includeChildren);
	function removeAsset(& $assetId, $includeChildren) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public AssetIterator & getAssets();
	function & getAssets() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public AssetIterator & getAssets(osid.shared.Type & $assetType);
	function & getAssets(& $assetType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoRecord & createInfoRecord(osid.shared.Id & $infoStructureId);
	function & createInfoRecord(& $infoStructureId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void inheritInfoStructure(osid.shared.Id & $infoStructureId, osid.shared.Id & $assetId);
	function inheritInfoStructure(& $infoStructureId, & $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void copyInfoStructure(osid.shared.Id & $infoStructureId, osid.shared.Id & $assetId);
	function copyInfoStructure(& $infoStructureId, & $assetId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void deleteInfoRecord(osid.shared.Id & $infoRecordId);
	function deleteInfoRecord(& $infoRecordId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoRecordIterator & getInfoRecords();
	function & getInfoRecords() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoRecordIterator & getInfoRecords(osid.shared.Id & $infoStructureId);
	function & getInfoRecords(& $infoStructureId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & getAssetType();
	function & getAssetType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoStructureIterator & getInfoStructures();
	function & getInfoStructures() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoStructure & getContentInfoStructure();
	function & getContentInfoStructure() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end Asset


class InfoStructure
	// extends java.io.Serializable
{ // begin InfoStructure
	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDescription();
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoPartIterator & getInfoParts();
	function & getInfoParts() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getSchema();
	function getSchema() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getFormat();
	function getFormat() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean validateInfoRecord(InfoRecord & $infoRecord);
	function validateInfoRecord(& $infoRecord) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end InfoStructure


class InfoPart
	// extends java.io.Serializable
{ // begin InfoPart
	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDescription();
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoPartIterator & getInfoParts();
	function & getInfoParts() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean getPopulatedByDR();
	function getPopulatedByDR() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean getMandatory();
	function getMandatory() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean getRepeatable();
	function getRepeatable() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoStructure & getInfoStructure();
	function & getInfoStructure() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean validateInfoField(InfoField & $infoField);
	function validateInfoField(& $infoField) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end InfoPart


class InfoRecord
	// extends java.io.Serializable
{ // begin InfoRecord
	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoField & createInfoField(java.io.Serializable & $value, osid.shared.Id & $infoPartId);
	function & createInfoField(& $value, & $infoPartId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void deleteInfoField(osid.shared.Id & $infoFieldId);
	function deleteInfoField(& $infoFieldId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoFieldIterator & getInfoFields();
	function & getInfoFields() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean getMultivalued();
	function getMultivalued() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoStructure & getInfoStructure();
	function & getInfoStructure() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end InfoRecord


class InfoField
	// extends java.io.Serializable
{ // begin InfoField
	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoField & createInfoField(java.io.Serializable & $value, osid.shared.Id & $infoPartId);
	function & createInfoField(& $value, & $infoPartId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void deleteInfoField(osid.shared.Id & $infoFieldId);
	function deleteInfoField(& $infoFieldId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoFieldIterator & getInfoFields();
	function & getInfoFields() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.io.Serializable & getValue();
	function & getValue() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateValue(java.io.Serializable & $value);
	function updateValue(& $value) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoPart & getInfoPart();
	function & getInfoPart() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end InfoField


class DigitalRepositoryIterator
{ // begin DigitalRepositoryIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public DigitalRepository & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end DigitalRepositoryIterator


class AssetIterator
{ // begin AssetIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Asset & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end AssetIterator


class InfoStructureIterator
{ // begin InfoStructureIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoStructure & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end InfoStructureIterator


class InfoPartIterator
{ // begin InfoPartIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoPart & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end InfoPartIterator


class InfoRecordIterator
{ // begin InfoRecordIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoRecord & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end InfoRecordIterator


class InfoFieldIterator
{ // begin InfoFieldIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public InfoField & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end InfoFieldIterator


// public static final String UNKNOWN_TYPE = "Unknown or unsupported Type"
define("UNKNOWN_TYPE","Unknown or unsupported Type");

// public static final String UNKNOWN_ID = "Unknown Id"
define("UNKNOWN_ID","Unknown Id");

// public static final String UNKNOWN_DR = "Unknown Digital Repository"
define("UNKNOWN_DR","Unknown Digital Repository");

// public static final String OPERATION_FAILED = "Operation failed"
define("OPERATION_FAILED","Operation failed");

// public static final String NO_OBJECT_WITH_THIS_DATE = "No object has this date"
define("NO_OBJECT_WITH_THIS_DATE","No object has this date");

// public static final String ALREADY_ADDED = "Object already added"
define("ALREADY_ADDED","Object already added");

// public static final String CANNOT_COPY_OR_INHERIT_SELF = "Cannot copy or inherit InfoStructure from itself"
define("CANNOT_COPY_OR_INHERIT_SELF","Cannot copy or inherit InfoStructure from itself");

// public static final String ALREADY_INHERITING_STRUCTURE = "Already inheriting this InfoStructure"
define("ALREADY_INHERITING_STRUCTURE","Already inheriting this InfoStructure");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements"
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements");

// public static final String PERMISSION_DENIED = "Permission denied"
define("PERMISSION_DENIED","Permission denied");

// public static final String NULL_ARGUMENT = "Null argument"
define("NULL_ARGUMENT","Null argument");

// public static final String CONFIGURATION_ERROR = "Configuration error"
define("CONFIGURATION_ERROR","Configuration error");

?>
