<?

	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class HarmoniInfoField extends InfoField
//	extends java.io.Serializable
{

	var $_valueVersions;
	var $_infoPart;
	
	function HarmoniInfoField( &$infoPart, &$valueVersions ) {
		$this->_valueVersions =& $valueVersions;
		$this->_infoPart =& $infoPart;
	}
	
	/**
	 * Get the Unique Id for this InfoStructure.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getId() {
		$activeVersion =& $this->_valueVersions->getActiveVersion();
		return new HarmoniId($activeVersion->getID());
	}

	/**
	 * Create an InfoField.  InfoRecords are composed of InfoFields. InfoFields can also contain other InfoFields.  Each InfoRecord is associated with a specific InfoStructure and each InfoField is associated with a specific InfoPart.
	 *  infoPartId
	 *  value
	 * @return InfoField
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function & createInfoField(& $infoPartId, & $value) {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniInfoField", true));
	}
	// :: full java declaration :: public InfoField createInfoField(osid.shared.Id infoPartId, java.io.Serializable value)

	/**
	 * Delete an InfoField and all its InfoFields.
	 *  infoFieldId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.dr
	 */
	function deleteInfoField(& $infoFieldId) {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniInfoField", true));
	}
	// :: full java declaration :: public void deleteInfoField(osid.shared.Id infoFieldId)

	/**
	 * Get all the InfoFields in the InfoField.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return InfoFieldIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getInfoFields() {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniInfoField", true));
	}
	// :: full java declaration :: public InfoFieldIterator getInfoFields()

	/**
	 * Get the for this InfoField.
	 * @return java.io.Serializable
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getValue() {
		// NOTE: if no active versions exist, false will be returned here.
		$actValue =& $this->_valueVersions->getActiveVersion();
		
		if ($actValue) return $actValue->getValue();
		
		return null;
	}
	// :: full java declaration :: public java.io.Serializable getValue()

	/**
	 * Update the for this InfoField.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.dr
	 */
	function updateValue(& $value) {
		// Get the type for the field.
		$fieldValuesObj =& $this->_valueVersions->getFieldValues();
		$fieldDef =& $fieldValuesObj->getFieldDefinition();
		$fieldType =& $fieldDef->getType();
		
		// Create a valueObj for this value
		$class = $fieldType."DataType";
		$valueObj =& new $class($value);
	
		$this->_valueVersions->setValue($value);
	}
	// :: full java declaration :: public void updateValue(java.io.Serializable value)

	/**
	 * Get the InfoPart associated with this InfoField.
	 * @return InfoPart
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getInfoPart() {
		return $this->_infoPart;
	}
}
