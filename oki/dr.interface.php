<?php

require_once(OKI."/osid.interface.php");

	/**
	 * The DigitalRepositoryManager supports creating and deleting Digital Repositories
	 * and Assets as well as getting the various Types used.  
	 * <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * <p>SID Version: 1.0 rc6<p>Licensed under the 
	 * {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class DigitalRepositoryManager // :: API interface
	extends OsidManager
{

	/**
	 * Create a new DigitalRepository of the specified Type.  The implementation 
	 * of this method sets the Id for the new object.
	 * @param string displayName
	 * @param string description
	 * @param object digitalRepositoryType
	 * @return object DigitalRepository
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 * 		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * 		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * 		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * 		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * 		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * 		{@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 */
	function &createDigitalRepository($displayName, $description, & $digitalRepositoryType) { /* :: interface :: */ }

	/**
	 * Delete a DigitalRepository.
	 * @param object digitalRepositoryId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 * 		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * 		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * 		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * 		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * 		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * 		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function deleteDigitalRepository(& $digitalRepositoryId) { /* :: interface :: */ }

	/**
	 * Get all the DigitalRepositories.  Iterators return a group of items, one 
	 * item at a time.  The Iterator's hasNext method returns <code>true</code> 
	 * if there are additional objects available; <code>false</code> otherwise.  
	 * The Iterator's next method returns the next object.
	 * @return object DigitalRepositoryIterator  The order of the objects returned 
	 * 		by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getDigitalRepositories() { /* :: interface :: */ }

	/**
	 * Get all the DigitalRepositories of the specified Type.  Iterators return
	 *  a group of items, one item at a time.  The Iterator's hasNext method 
	 * returns <code>true</code> if there are additional objects available; 
	 * <code>false</code> otherwise.  The Iterator's next method returns the 
	 * next object.
	 *  digitalRepositoryType
	 * @return object DigitalRepositoryIterator  The order of the objects returned 
	 * by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 */
	function &getDigitalRepositoriesByType(& $digitalRepositoryType) { /* :: interface :: */ }

	/**
	 * Get a specific DigitalRepository by Unique Id.
	 *  digitalRepositoryId
	 * @return object DigitalRepository
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getDigitalRepository(& $digitalRepositoryId) { /* :: interface :: */ }

	/**
	 * Get the Asset with the specified Unique Id.
	 *  assetId
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getAsset(& $assetId) { /* :: interface :: */ }

	/**
	 * Get the Asset with the specified Unique Id and appropriate for the date 
	 * specified.  The date permits
	 * @param object assetId
	 * @param object date
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#NO_OBJECT_WITH_THIS_DATE NO_OBJECT_WITH_THIS_DATE}
	 */
	function &getAssetByDate(& $assetId, & $date) { /* :: interface :: */ }

	/**
	 * Get all the dates for the Asset with the specified Unique Id.  These 
	 * dates could be for a form of versioning.
	 * @return object osid.shared.CalendarIterator
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function &getAssetDates(& $assetId) { /* :: interface :: */ }

	/**
	 * Perform a search of the specified Type and get all the Assets that satisfy
	 * the SearchCriteria.  The search is performed for all specified 
	 * DigitalRepositories.  Iterators return a group of items, one item at a time.  
	 * The Iterator's hasNext method returns <code>true</code> if there are 
	 * additional objects available; <code>false</code> otherwise.  The Iterator's 
	 * next method returns the next object.
	 * @param object digitalRepositories
	 * @param object searchCriteria
	 * @param object searchType
	 * @return object AssetIterator  The order of the objects returned by the 
	 * Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_DR UNKNOWN_DR}
	 */
	function &getAssets(& $digitalRepositories, & $searchCriteria, & $searchType) { /* :: interface :: */ }
	
	/**
	 * Create in a DigitalRepository a copy of an Asset.  The Id, AssetType, and 
	 * DigitalRepository for the new Asset is set by the implementation.  All 
	 * InfoRecords are similarly copied.
	 * @param object digitalRepository
	 * @param object assetId
	 * @return object osid.shared.Id
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &copyAsset(& $digitalRepository, & $assetId) { /* :: interface :: */ }

	/**
	 * Get all the DigitalRepositoryTypes in this DigitalRepositoryManager.  
	 * DigitalRepositoryTypes are used to categorize DigitalRepositories.  
	 * Iterators return a group of items, one item at a time.  The Iterator's 
	 * hasNext method returns <code>true</code> if there are additional objects 
	 * available; <code>false</code> otherwise.  The Iterator's next method 
	 * returns the next object.
	 * @return object osid.shared.TypeIterator  The order of the objects returned 
	 * by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getDigitalRepositoryTypes() { /* :: interface :: */ }
}


/**
 * DigitialRepository manages Assets of various Types and information about 
 * the Assets.  Assets are created, persisted, and validated by the Digital 
 * Repository.  When initially created, an Asset has an immutable Type and 
 * Unique Id and its validation status is false.  In this state, all methods 
 * can be called, but integrity checks are not enforced.  When the Asset and 
 * its InfoRecords are ready to be validated, the validateAsset method checks 
 * the Asset and sets the validation status.  When working with a valid Asset, 
 * all methods include integrity checks and an exception is thrown if the 
 * activity would result in an inappropriate state.  Optionally, the invalidateAsset 
 * method can be called to release the requirement for integrity checks, but 
 * the Asset will not become valid again, until validateAsset is called and 
 * the entire Asset is checked.    <p>Licensed under the 
 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
 *		<p>SID Version: 1.0 rc6<p>Licensed under the 
 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package osid.dr
 */
class DigitalRepository // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this DigitalRepository.
	 * @return string the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Update the name for this DigitalRepository.
	 * @param string displayName
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDisplayName($displayName) { /* :: interface :: */ }

	/**
	 * Get the description for this DigitalRepository.
	 * @return string the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this DigitalRepository.
	 * @param string description
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this DigitalRepository.
	 * @return object osid.shared.Id Unique Id this is usually set by a create 
	 * 		method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the the DigitalRepositoryType of this DigitalRepository.
	 * @return object osid.shared.Type
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getType() { /* :: interface :: */ }

	/**
	 * Create a new Asset of this AssetType to this DigitalRepository.  The 
	 * implementation of this method sets the Id for the new object.
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 */
	function &createAsset($displayName, $description, & $assetType) { /* :: interface :: */ }

	/**
	 * Delete an Asset from this DigitalRepository.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function deleteAsset(& $assetId) { /* :: interface :: */ }

	/**
	 * Get all the Assets in this DigitalRepository.  Iterators return a group 
	 * of items, one item at a time.  The Iterator's hasNext method returns 
	 * <code>true</code> if there are additional objects available; 
	 * <code>false</code> otherwise.  The Iterator's next method returns the
	 *  next object.
	 * @return object AssetIterator  The order of the objects returned by the
	 * 	 Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getAssets() { /* :: interface :: */ }

	/**
	 * Get all the Assets of the specified AssetType in this Asset.  Iterators 
	 * return a group of items, one item at a time.  The Iterator's hasNext method 
	 * returns <code>true</code> if there are additional objects available; 
	 * <code>false</code> otherwise.  The Iterator's next method returns the 
	 * next object.
	 * @return object AssetIterator  The order of the objects returned by the 
	 * Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 */
	function &getAssetsByType(& $assetType) { /* :: interface :: */ }

	/**
	 * Get all the AssetTypes in this DigitalRepository.  AssetTypes are used 
	 * to categorize Assets.  Iterators return a group of items, one item at a 
	 * time.  The Iterator's hasNext method returns <code>true</code> if there 
	 * are additional objects available; <code>false</code> otherwise.  The 
	 * Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator  The order of the objects returned 
	 * by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getAssetTypes() { /* :: interface :: */ }

	/**
	 * Get all the InfoStructures in this DigitalRepository.  InfoStructures are 
	 * used to categorize information about Assets.  Iterators return a group of 
	 * items, one item at a time.  The Iterator's hasNext method returns <code>true</code> 
	 * if there are additional objects available; <code>false</code> otherwise.  
	 * The Iterator's next method returns the next object.
	 * @return object InfoStructureIterator  The order of the objects returned 
	 * by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoStructures() { /* :: interface :: */ }

	/**
	 * Get the InfoStructures that this AssetType must support.  InfoStructures 
	 * are used to categorize information about Assets.  Iterators return a group 
	 * of items, one item at a time.  The Iterator's hasNext method returns 
	 * <code>true</code> if there are additional objects available; 
	 * <code>false</code> otherwise.  The Iterator's next method returns the next 
	 * object.
	 * @return object InfoStructureIterator  The order of the objects returned by 
	 * the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 */
	function &getMandatoryInfoStructures(& $assetType) { /* :: interface :: */ }

	/**
	 * Get all the SearchTypes supported by this DigitalRepository.  Iterators 
	 * return a group of items, one item at a time.  The Iterator's hasNext 
	 * method returns <code>true</code> if there are additional objects available; 
	 * <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object osid.shared.TypeIterator  The order of the objects returned 
	 * by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getSearchTypes() { /* :: interface :: */ }

	/**
	 * Get all the StatusTypes supported by this DigitalRepository.  Iterators 
	 * return a group of items, one item at a time.  The Iterator's hasNext method 
	 * returns <code>true</code> if there are additional objects available; 
	 * <code>false</code> otherwise.  The Iterator's next method returns the 
	 * next object.
	 * @return object osid.shared.TypeIterator  The order of the objects 
	 * returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getStatusTypes() { /* :: interface :: */ }

	/**
	 * Get the the StatusType of this Asset.
	 * @return object osid.shared.Type
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getStatus(& $assetId) { /* :: interface :: */ }

	/**
	 * Validate all the InfoRecords for an Asset and set its status Type 
	 * accordingly.  If the Asset is valid, return true; otherwise return false.  
	 * The implementation may throw an Exception for any validation failures and 
	 * use the Exception's message to identify specific causes.
	 * null
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function validateAsset(& $assetId) { /* :: interface :: */ }

	/**
	 * Set the Asset's status Type accordingly and relax validation checking 
	 * when creating InfoRecords and InfoFields or updating InfoField's values.
	 * null
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function invalidateAsset(& $assetId) { /* :: interface :: */ }

	/**
	 * Get the Asset with the specified Unique Id.
	 *  assetId
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getAsset(& $assetId) { /* :: interface :: */ }

	/**
	 * Get the Asset with the specified Unique Id and appropriate for the date 
	 * specified.  The date permits
	 * @param object assetId
	 * @param object date
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#NO_OBJECT_WITH_THIS_DATE NO_OBJECT_WITH_THIS_DATE}
	 */
	function &getAssetByDate(& $assetId, & $date) { /* :: interface :: */ }
	
	/**
	 * Get all the dates for the Asset with the specified Unique Id.  These dates 
	 * could be for a form of versioning.
	 * @return object osid.shared.CalendarIterator
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function &getAssetDates(& $assetId) { /* :: interface :: */ }

	/**
	 * Perform a search of the specified Type and get all the Assets that satisfy 
	 * the SearchCriteria.  Iterators return a group of items, one item at a time.  
	 * The Iterator's hasNext method returns <code>true</code> if there are 
	 * additional objects available; <code>false</code> otherwise.  The Iterator's 
	 * next method returns the next object.
	 * @param object searchCriteria
	 * @param object searchType
	 * @return object AssetIterator  The order of the objects returned by the 
	 * Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 */
	function &getAssetsBySearch(& $searchCriteria, & $searchType) { /* :: interface :: */ }
	
	/**
	 * Create in a copy of an Asset.  The Id, AssetType, and DigitalRepository 
	 * for the new Asset is set by the implementation.  All InfoRecords are similarly 
	 * copied.
	 * @param object asset
	 * @return object osid.shared.Id
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the 
	 * following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &copyAsset(& $asset) { /* :: interface :: */ }
}


/**
 * Asset manages the Asset itself.  Assets have content as well as InfoRecords appropriate to the AssetType and InfoStructures for the Asset.  Assets may also contain other Assets.
<p>SID Version: 1.0 rc6<p>Licensed under the 
 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package osid.dr
 */
class Asset // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this Asset.
	 * @return string the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Update the name for this Asset.
	 * @param string displayName
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDisplayName($displayName) { /* :: interface :: */ }

	/**
	 * Get the description for this Asset.
	 * @return string the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this Asset.
	 * @param string description
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDescription($description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this Asset.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the Id of the DigitalRepository in which this Asset resides.  This is set by the DigitalRepository's createAsset method.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation digitalRepositoryId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getDigitalRepository() { /* :: interface :: */ }

	/**
	 * Get an Asset's content.  This method can be a convenience if one is not interested in all the structure of the InfoRecords.
	 * @return object java.io.Serializable
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getContent() { /* :: interface :: */ }

	/**
	 * Update an Asset's content.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateContent(& $content) { /* :: interface :: */ }

	/**
	 * Add an Asset to this Asset.
	 *  assetId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}, 
	 *		{@link DigitalRepositoryException#ALREADY_ADDED ALREADY_ADDED}
	 */
	function addAsset(& $assetId) { /* :: interface :: */ }

	/**
	 * Remove an Asset to this Asset.  This method does not delete the Asset from the DigitalRepository.
	 *  assetId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function removeAsset(& $assetId, $includeChildren) { /* :: interface :: */ }

	/**
	 * Get all the Assets in this Asset.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object AssetIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getAssets() { /* :: interface :: */ }

	/**
	 * Get all the Assets of the specified AssetType in this DigitalRepository.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object AssetIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 */
	function &getAssetsByType(& $assetType) { /* :: interface :: */ }

	/**
	 * Create a new Asset InfoRecord of the specified InfoStructure.   The implementation of this method sets the Id for the new object.
	 *  infoStructureId
	 * @return object InfoRecord
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &createInfoRecord(& $infoStructureId) { /* :: interface :: */ }

	/**
	 * Add the specified InfoStructure and all the related InfoRecords from the specified asset.  The current and future content of the specified InfoRecord is synchronized automatically.
	 *  assetId
	 *  infoStructureId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}, ALREADY_INHERITING_STRUCTURE
	 */
	function inheritInfoStructure(& $assetId, & $infoStructureId) { /* :: interface :: */ }

	/**
	 * Add the specified InfoStructure and all the related InfoRecords from the specified asset.
	 *  assetId
	 *  infoStructureId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}, 
	 *		{@link DigitalRepositoryException#CANNOT_COPY_OR_INHERIT_SELF CANNOT_COPY_OR_INHERIT_SELF}
	 */
	function copyInfoStructure(& $assetId, & $infoStructureId) { /* :: interface :: */ }

	/**
	 * Delete an InfoRecord.  If the specified InfoRecord has content that is inherited by other InfoRecords, those
	 *  infoRecordId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function deleteInfoRecord(& $infoRecordId) { /* :: interface :: */ }

	/**
	 * Get all the InfoRecords for this Asset.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoRecordIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoRecords() { /* :: interface :: */ }

	/**
	 * Get all the InfoRecords of the specified InfoStructure for this Asset.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 *  infoStructureId
	 * @return object InfoRecordIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getInfoRecordsByInfoStructure(& $infoStructureId) { /* :: interface :: */ }

	/**
	 * Description_getAssetTypes=Get the AssetType of this Asset.  AssetTypes are used to categorize Assets.
	 * @return object osid.shared.Type
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getAssetType() { /* :: interface :: */ }

	/**
	 * Get all the InfoStructures for this Asset.  InfoStructures are used to categorize information about Assets.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoStructureIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &InfoStructureIterator() { /* :: interface :: */ }
	
	/**
	 * Get the InfoStructure associated with this Asset's content.
	 * @return object InfoStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &InfoStructure() { /* :: interface :: */ }
	
	/**
	 * Get the InfoRecord for this Asset that matches this InfoRecord Unique Id.
	 * @param object infoRecordId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getInfoRecord(& $infoRecordId) { /* :: interface :: */ }

	/**
	 * Get the InfoField for an InfoRecord for this Asset that matches this InfoField Unique Id.
	 * @return object infoFieldId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getInfoField(& $infoFieldId) { /* :: interface :: */ }

	/**
	 * Get the Value of the InfoField of the InfoRecord for this Asset that matches this InfoField Unique Id.
	 * @return object infoFieldId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getInfoFieldValue(& $infoFieldId) { /* :: interface :: */ }

	/**
	 * Get the InfoFields of the InfoRecords for this Asset that are based on this InfoStructure InfoPart Unique Id.
	 * @return object infoPartId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getInfoFieldByPart(& $infoPartId) { /* :: interface :: */ }

	/**
	 * Get the Values of the InfoFields of the InfoRecords for this Asset that are based on this InfoStructure InfoPart Unique Id.
	 * @return object infoPartId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &getInfoFieldValueByPart(& $infoPartId) { /* :: interface :: */ }

	/**
	 * Get the date at which this Asset is effective.  Note that this is separate for any authorization to get or update the Asset.
	 * @return object java.util.Calendar
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getEffectiveDate() { /* :: interface :: */ }

	/**
	 * Update the date at which this Asset is effective.  Note that this is separate for any authorization to get or update the Asset.
	 * @param object effectiveDate
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#EFFECTIVE_PRECEDE_EXPIRATION}
	 */
	function updateEffectiveDate(& $EffectiveDate) { /* :: interface :: */ }

	/**
	 * Get the date at which this Asset expires.  Note that this is separate for any authorization to get or update the Asset.
	 * @return object java.util.Calendar
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getExpirationDate() { /* :: interface :: */ }

	/**
	 * Update the date at which this Asset expires.  Note that this is separate for any authorization to get or update the Asset.
	 * @param object expirationDate
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#EFFECTIVE_PRECEDE_EXPIRATION}
	 */
	function updateExpirationDate(& $ExpirationDate) { /* :: interface :: */ }
}


	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class InfoStructure // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this InfoStructure.
	 * @return string the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Get the description for this InfoStructure.
	 * @return string the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this InfoStructure.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get all the InfoParts in the InfoStructure.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoPartIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoParts() { /* :: interface :: */ }

	/**
	 * Get the schema for this InfoStructure.  The schema is defined by the implementation, e.g. Dublin Core.
	 * @return object String
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getSchema() { /* :: interface :: */ }

	/**
	 * Get the format for this InfoStructure.  The format is defined by the implementation, e.g. XML.
	 * @return object String
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getFormat() { /* :: interface :: */ }

	/**
	 * Validate an InfoRecord against its InfoStructure.  Return true if valid; false otherwise.  The status of the Asset holding this InfoRecord is not changed through this method.  The implementation may throw an Exception for any validation failures and use the Exception's message to identify specific causes.
	 * @param object infoRecord
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function validateInfoRecord(& $infoRecord) { /* :: interface :: */ }
}


	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class InfoPart // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this InfoPart.
	 * @return string the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Get the description for this InfoPart.
	 * @return string the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this InfoPart.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get all the InfoParts in the InfoPart.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoPartIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoParts() { /* :: interface :: */ }

	/**
	 * Return true if this InfoPart is automatically populated by the DigitalRepository; false otherwise.  Examples of the kind of InfoParts that might be populated are a time-stamp or the Agent setting the data.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getPopulatedByDR() { /* :: interface :: */ }

	/**
	 * Return true if this InfoPart is mandatory; false otherwise.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getMandatory() { /* :: interface :: */ }

	/**
	 * Return true if this InfoPart is repeatable; false otherwise.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getRepeatable() { /* :: interface :: */ }

	/**
	 * Get the InfoPart associated with this InfoStructure.
	 * @return object InfoStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoStructure() { /* :: interface :: */ }

	/**
	 * Validate an InfoField against its InfoPart.  Return true if valid; false otherwise.  The status of the Asset holding this InfoRecord is not changed through this method.  The implementation may throw an Exception for any validation failures and use the Exception's message to identify specific causes.
	 * @param object infoField
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function validateInfoField(& $infoField) { /* :: interface :: */ }
}


	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class InfoRecord // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this InfoRecord.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Create an InfoField.  InfoRecords are composed of InfoFields. InfoFields can also contain other InfoFields.  Each InfoRecord is associated with a specific InfoStructure and each InfoField is associated with a specific InfoPart.
	 * @param object infoPartId
	 * @param object value
	 * @return object InfoField
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &createInfoField(& $infoPartId, & $value) { /* :: interface :: */ }

	/**
	 * Delete an InfoField and all its InfoFields.
	 * @param object infoFieldId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function deleteInfoField(& $infoFieldId) { /* :: interface :: */ }

	/**
	 * Get all the InfoFields in the InfoRecord.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoFieldIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoFields() { /* :: interface :: */ }

	/**
	 * Return true if this InfoRecord is multi-valued; false otherwise.  This is determined by the implementation.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getMultivalued() { /* :: interface :: */ }

	/**
	 * Get the InfoStructure associated with this InfoRecord.
	 * @return object InfoStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
}


	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class InfoField // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the Unique Id for this InfoStructure.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Create an InfoField.  InfoRecords are composed of InfoFields. InfoFields can also contain other InfoFields.  Each InfoRecord is associated with a specific InfoStructure and each InfoField is associated with a specific InfoPart.
	 *  infoPartId
	 *  value
	 * @return object InfoField
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function &createInfoField(& $infoPartId, & $value) { /* :: interface :: */ }

	/**
	 * Delete an InfoField and all its InfoFields.
	 *  infoFieldId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 *		{@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 */
	function deleteInfoField(& $infoFieldId) { /* :: interface :: */ }

	/**
	 * Get all the InfoFields in the InfoField.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoFieldIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoFields() { /* :: interface :: */ }

	/**
	 * Get the for this InfoField.
	 * @return object java.io.Serializable
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getValue() { /* :: interface :: */ }

	/**
	 * Update the for this InfoField.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateValue(& $value) { /* :: interface :: */ }

	/**
	 * Get the InfoPart associated with this InfoField.
	 * @return object InfoPart
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoPart() { /* :: interface :: */ }
}


	/**
	 * DigitalRepositoryIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class DigitalRepositoryIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  DigitalRepositories ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }

	/**
	 * Return the next DigitalRepositories.
	 * @return object DigitalRepository
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
}


	/**
	 * AssetIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class AssetIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Assets ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }

	/**
	 * Return the next Assets.
	 * @return object Asset
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
}


	/**
	 * InfoStructureIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class InfoStructureIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Assets ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }

	/**
	 * Return the next InfoStructures.
	 * @return object InfoStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
}


	/**
	 * InfoPartIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class InfoPartIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  InfoParts ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }

	/**
	 * Return the next InfoParts.
	 * @return object InfoPart
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
}


	/**
	 * InfoRecordIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class InfoRecordIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  InfoRecords ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }

	/**
	 * Return the next InfoRecords.
	 * @return object InfoRecord
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
}


	/**
	 * InfoFieldIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class InfoFieldIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  InfoFields ; <code>false</code> otherwise.
	 * @return object boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function hasNext() { /* :: interface :: */ }

	/**
	 * Return the next InfoFields.
	 * @return object InfoField
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 *		{@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 *		{@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 *		{@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 *		{@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 *		{@link DigitalRepositoryException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 */
	function &next() { /* :: interface :: */ }
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself.
	<p>SID Version: 1.0 rc6<p>Licensed under the 
	 *		{@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class DigitalRepositoryException // :: normal class
	extends OsidException
{

	/**
	 * Unknown or unsupported Type
	 * @package osid.dr
	 */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown Type ");

	/**
	 * Unknown Id
	 * @package osid.dr
	 */
	// :: defined globally :: define("UNKNOWN_ID","Unknown Id ");

	/**
	 * Unknown Digital Repository
	 * @package osid.dr
	 */
	// :: defined globally :: define("UNKNOWN_DR","Unknown Digital Repository ");

	/**
	 * Operation failed
	 * @package osid.dr
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * No object has this date
	 * @package osid.dr
	 */
	// :: defined globally :: define("NO_OBJECT_WITH_THIS_DATE","No object has this date ");

	/**
	 * Object already added
	 * @package osid.dr
	 */
	// :: defined globally :: define("ALREADY_ADDED","Object already added ");

	/**
	 * Cannot copy or inherit InfoStructure from itself
	 * @package osid.dr
	 */
	// :: defined globally :: define("CANNOT_COPY_OR_INHERIT_SELF","Cannot copy or inherit InfoStructure from itself ");

	/**
	 * Already inheriting this InfoStructure
	 * @package osid.dr
	 */
	// :: defined globally :: define("ALREADY_INHERITING_STRUCTURE","Already inheriting this InfoStructure ");

	/**
	 * Iterator has no more elements
	 * @package osid.dr
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	/**
	 * Permission denied
	 * @package osid.dr
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Null argument
	 * @package osid.dr
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument ");

	/**
	 * Configuration error
	 * @package osid.dr
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Effective date must precede expiration date
	 * @package osid.dr
	 */
	// :: defined globally :: define("EFFECTIVE_PRECEDE_EXPIRATION","Effective date must precede expiration date ");
}

// :: post-declaration code ::
/**
 * @const string UNKNOWN_TYPE public static final String UNKNOWN_TYPE = "Unknown Type "
 * @package osid.dr
 */
define("UNKNOWN_TYPE", "Unknown Type ");

/**
 * @const string UNKNOWN_ID public static final String UNKNOWN_ID = "Unknown Id "
 * @package osid.dr
 */
define("UNKNOWN_ID", "Unknown Id ");

/**
 * @const string UNKNOWN_DR public static final String UNKNOWN_DR = "Unknown Digital Repository "
 * @package osid.dr
 */
define("UNKNOWN_DR", "Unknown Digital Repository ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid.dr
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string NO_OBJECT_WITH_THIS_DATE public static final String NO_OBJECT_WITH_THIS_DATE = "No object has this date "
 * @package osid.dr
 */
define("NO_OBJECT_WITH_THIS_DATE", "No object has this date ");

/**
 * @const string ALREADY_ADDED public static final String ALREADY_ADDED = "Object already added "
 * @package osid.dr
 */
define("ALREADY_ADDED", "Object already added ");

/**
 * @const string CANNOT_COPY_OR_INHERIT_SELF public static final String CANNOT_COPY_OR_INHERIT_SELF = "Cannot copy or inherit InfoStructure from itself "
 * @package osid.dr
 */
define("CANNOT_COPY_OR_INHERIT_SELF", "Cannot copy or inherit InfoStructure from itself ");

/**
 * @const string ALREADY_INHERITING_STRUCTURE public static final String ALREADY_INHERITING_STRUCTURE = "Already inheriting this InfoStructure "
 * @package osid.dr
 */
define("ALREADY_INHERITING_STRUCTURE", "Already inheriting this InfoStructure ");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
 * @package osid.dr
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied "
 * @package osid.dr
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument "
 * @package osid.dr
 */
define("NULL_ARGUMENT", "Null argument ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error "
 * @package osid.dr
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * @const string EFFECTIVE_PRECEDE_EXPIRATION public static final String EFFECTIVE_PRECEDE_EXPIRATION = "Effective date must precede expiration date "
 * @package osid.dr
 */
define("EFFECTIVE_PRECEDE_EXPIRATION", "Effective date must precede expiration date ");

?>
