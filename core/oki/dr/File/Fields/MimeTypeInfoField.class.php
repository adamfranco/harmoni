<?

	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package harmoni.osid.dr
	 */
class MimeTypeInfoField extends InfoField
//	extends java.io.Serializable
{

	var $_recordId;
	var $_infoPart;
	var $_type;
	
	function MimeTypeInfoField( &$infoPart, &$recordId, $configuration ) {
		$this->_recordId =& $recordId;
		$this->_infoPart =& $infoPart;
		$this->_configuration = $configuration;
		
		// Set our name to NULL, so that we can know if it has not been checked
		// for yet. If we search for name, but don't have any, or the name is
		// an empty string, it will have value "" instead of NULL
		$this->_type = NULL;
	}
	
	/**
	 * Get the Unique Id for this InfoStructure.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getId() {
		$sharedManager =& Services::getService("Shared");
		return $sharedManager->getId($this->_recordId->getIdString()."-MIME_TYPE");
	}

	/**
	 * Create an InfoField.  InfoRecords are composed of InfoFields. InfoFields can also contain other InfoFields.  Each InfoRecord is associated with a specific InfoStructure and each InfoField is associated with a specific InfoPart.
	 *  infoPartId
	 *  value
	 * @return object InfoField
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function &createInfoField(& $infoPartId, & $value) {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniInfoField", true));
	}

	/**
	 * Delete an InfoField and all its InfoFields.
	 *  infoFieldId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function deleteInfoField(& $infoFieldId) {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniInfoField", true));
	}

	/**
	 * Get all the InfoFields in the InfoField.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoFieldIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getInfoFields() {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniInfoField", true));
	}

	/**
	 * Get the for this InfoField.
	 * @return java.io.Serializable
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function getValue() {
		// If we don't have the type, load it from the database.
		if ($this->_type === NULL) {
			$dbHandler =& Services::getService("DBHandler");
			
			// Get the type from the database,
			$query =& new SelectQuery;
			$query->addColumn("type");
			$query->addTable("dr_file");
			$query->addTable("dr_mime_type", INNER_JOIN, "fk_mime_type = dr_mime_type.id");
			$query->addWhere("dr_file.id = '".$this->_recordId->getIdString()."'");
			
			$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
			
			// If no name was found, return an empty string.
			if ($result->getNumberOfRows() == 0)
				$this->_type = 0;
			else
				$this->_type = $result->field("type");
		}
		
		return $this->_type;
	}

	/**
	 * Update the for this InfoField.
	 * null
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package harmoni.osid.dr
	 */
	function updateValue($value) {
		ArgumentValidator::validate($value, new StringValidatorRule);
		
		// Store the name in the object in case its asked for again.
		$this->_type = $value;
		
	// then write it to the database.
		$dbHandler =& Services::getService("DBHandler");
	
		// Check to see if the type is in the database
		$query =& new SelectQuery;
		$query->addTable("dr_mime_type");
		$query->addColumn("id");
		$query->addWhere("type = '".$this->_type."'");
		$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
		
		// If it doesn't exist, insert it.
		if (!$result->getNumberOfRows()) {
			$query =& new InsertQuery;
			$query->setTable("dr_mime_type");
			$query->setColumns(array("type"));
			$query->setValues(array("'".addslashes($this->_type)."'"));
			
			$result2 =& $dbHandler->query($query, $this->_configuration["dbId"]);
			$mimeId = $result->getLastAutoIncrementValue();
		} else {
			$mimeId = $result->field("id");
		}
			
		// add its id to the file.
		$query =& new UpdateQuery;
		$query->setTable("dr_file");
		$query->setColumns(array("FK_mime_type"));
		$query->setValues(array("'".$mimeId."'"));
		$query->addWhere("id = '".$this->_recordId->getIdString()."'");
		
		// run the query
		$dbHandler->query($query, $this->_configuration["dbId"]);
	}

	/**
	 * Get the InfoPart associated with this InfoField.
	 * @return object InfoPart
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getInfoPart() {
		return $this->_infoPart;
	}
}
