<?

require_once(dirname(__FILE__)."/Fields/FileDataInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/FileNameInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/FileSizeInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/MimeTypeInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailDataInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailMimeTypeInfoField.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoFieldIterator.class.php");

	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package harmoni.osid.dr
	 */
class FileInfoRecord extends InfoRecord
//	extends java.io.Serializable
{
	
	var $_id;
	var $_infoStructure;
	
	var $_infoFields;
	
	function FileInfoRecord( &$infoStructure, & $id, $configuration ) {
		$this->_id=& $id;
		$this->_infoStructure =& $infoStructure;
		$this->_configuration = $configuration;
		
		$sharedManager =& Services::getService("Shared");	
		$this->_infoFields = array();
		$this->_infoFields['FILE_DATA'] =& new FileDataInfoField(
									$infoStructure->getInfoPart($sharedManager->getId('FILE_DATA')),
									$this->_id,
									$this->_configuration);
		$this->_infoFields['FILE_NAME'] =& new FileNameInfoField(
									$infoStructure->getInfoPart($sharedManager->getId('FILE_NAME')),
									$this->_id,
									$this->_configuration);
		$this->_infoFields['FILE_SIZE'] =& new FileSizeInfoField(
									$infoStructure->getInfoPart($sharedManager->getId('FILE_SIZE')),
									$this->_id,
									$this->_configuration);
		$this->_infoFields['MIME_TYPE'] =& new MimeTypeInfoField(
									$infoStructure->getInfoPart($sharedManager->getId('MIME_TYPE')),
									$this->_id,
									$this->_configuration);
		$this->_infoFields['THUMBNAIL_DATA'] =& new ThumbnailDataInfoField(
									$infoStructure->getInfoPart($sharedManager->getId('THUMBNAIL_DATA')),
									$this->_id,
									$this->_configuration);
		$this->_infoFields['THUMBNAIL_MIME_TYPE'] =& new ThumbnailMimeTypeInfoField(
									$infoStructure->getInfoPart($sharedManager->getId('THUMBNAIL_MIME_TYPE')),
									$this->_id,
									$this->_configuration);
	}

	/**
	 * Get the Unique Id for this InfoRecord.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getId() {
		return $this->_id;
	}

	/**
	 * Create an InfoField.  InfoRecords are composed of InfoFields. InfoFields can also contain other InfoFields.  Each InfoRecord is associated with a specific InfoStructure and each InfoField is associated with a specific InfoPart.
	 * @param object infoPartId
	 * @param mixed value
	 * @return object InfoField
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function &createInfoField(& $infoPartId, & $value) {
		$found = FALSE;
		while ($parts->hasNext()) {
			$part =& $parts->next();
			if ($infoPartId->isEqual($part->getId())) {
				break;
				$found = TRUE;
			}
		}
		
		if (!$found)
			throwError(new Error(UNKNOWN_ID, "FileInfoRecord", true));
		
		$partIdString = $partId->getIdString();
		
// 		if (is_object($this->_infoFields[$partIdString]))
// 			throwError(new Error(PERMISSION_DENIED.": Can't add another field to a
// 			non-multi-valued part.", "FileInfoRecord", true));
// 		} else {
// 			
// 			switch ($partIdString) {
// 				case "FILE_DATA":
// 					$className = "FileDataInfoField";
// 					break;
// 				case "FILE_NAME":
// 					$className = "FileNameInfoField";
// 					break;
// 				case "FILE_SIZE":
// 					$className = "FileSizeInfoField";
// 					break;
// 				case "MIME_TYPE":
// 					$className = "MimeTypeInfoField";
// 					break;
// 				default:
// 					throwError(new Error(OPERATION_FAILED, "FileInfoRecord", true));
// 			}
// 			
// 			$this->_infoFields[$partIdString] =& new $className(
// 									$part,
// 									$this->_id,
// 									$this->configuration);
// 		}
		
		$this->_infoFields[$partIdString]->updateValue($value);
		
		return $this->_infoFields[$partIdString];
	}

	/**
	 * Delete an InfoField and all its InfoFields.
	 * @param object infoFieldId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following 
	 * messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function deleteInfoField(& $infoFieldId) {
		$string = $infoFieldId->getIdString();
		if (ereg("(.*)-(size|name|data|mime_type)",$string,$r)) {
			$recordId = $r[1];
			$field = $r[2];
			
			$this->_infoFields[$partIdString]->updateValue(NULL);
		} else {
			throwError(new Error(UNKNOWN_ID.": $string", "FileInfoRecord", true));
		}
	}

	/**
	 * Get all the InfoFields in the InfoRecord.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoFieldIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getInfoFields() {
		// Create an iterator and return it.
		$fieldIterator =& new HarmoniInfoFieldIterator($this->_infoFields);
		
		return $fieldIterator;
	}

	/**
	 * Return true if this InfoRecord is multi-valued; false otherwise.  This is determined by the implementation.
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function isMultivalued() {
		return true; // we allow as many InfoRecords of any InfoStructure as people want.
	}

	/**
	 * Get the InfoStructure associated with this InfoRecord.
	 * @return object InfoStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getInfoStructure() {
		return $this->_infoStructure;
	}
}