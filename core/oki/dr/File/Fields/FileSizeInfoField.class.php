<?

	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package harmoni.osid_v1.dr
	 */
class FileSizeInfoField extends InfoField
//	extends java.io.Serializable
{

	var $_recordId;
	var $_infoPart;
	var $_size;
	
	function FileSizeInfoField( &$infoPart, &$recordId, $configuration ) {
		$this->_recordId =& $recordId;
		$this->_infoPart =& $infoPart;
		$this->_configuration = $configuration;
		
		// Set our name to NULL, so that we can know if it has not been checked
		// for yet. If we search for name, but don't have any, or the name is
		// an empty string, it will have value "" instead of NULL
		$this->_size = NULL;
	}
	
	/**
	 * Get the Unique Id for this InfoStructure.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v1.dr
	 */
	function &getId() {
		$sharedManager =& Services::getService("Shared");
		return $sharedManager->getId($this->_recordId->getIdString()."-FILE_SIZE");
	}

	/**
	 * Create an InfoField.  InfoRecords are composed of InfoFields. InfoFields can also contain other InfoFields.  Each InfoRecord is associated with a specific InfoStructure and each InfoField is associated with a specific InfoPart.
	 *  infoPartId
	 *  value
	 * @return object InfoField
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid_v1.dr
	 */
	function &createInfoField(& $infoPartId, & $value) {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniInfoField", true));
	}

	/**
	 * Delete an InfoField and all its InfoFields.
	 *  infoFieldId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid_v1.dr
	 */
	function deleteInfoField(& $infoFieldId) {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniInfoField", true));
	}

	/**
	 * Get all the InfoFields in the InfoField.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoFieldIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v1.dr
	 */
	function &getInfoFields() {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniInfoField", true));
	}

	/**
	 * Get the for this InfoField.
	 * @return java.io.Serializable
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v1.dr
	 */
	function getValue() {
		// If we don't have the name, load it from the database.
		if ($this->_size === NULL) {
			$dbHandler =& Services::getService("DBHandler");
			
			// Get the name from the database,
			$query =& new SelectQuery;
			$query->addTable("dr_file");
			$query->addColumn("size");
			$query->addWhere("id = '".$this->_recordId->getIdString()."'");
			
			$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
			
			// If no name was found, return an empty string.
			if ($result->getNumberOfRows() == 0)
				$this->_size = 0;
			else
				$this->_size = $result->field("size");
		}
		
		return $this->_size;
	}

	/**
	 * Update the for this InfoField.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid_v1.dr
	 */
	function updateValue($value) {
		throwError(
			new Error(PERMISSION_DENIED, "FileSizeInfoField", true));
	}

	/**
	 * Get the InfoPart associated with this InfoField.
	 * @return object InfoPart
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v1.dr
	 */
	function &getInfoPart() {
		return $this->_infoPart;
	}
}
