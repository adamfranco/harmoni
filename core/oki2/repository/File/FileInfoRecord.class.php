<?

require_once(dirname(__FILE__)."/Fields/FileDataInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/FileNameInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/FileSizeInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/MimeTypeInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailDataInfoField.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailMimeTypeInfoField.class.php");
require_once(HARMONI."/oki2/repository/HarmoniInfoFieldIterator.class.php");

	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package harmoni.osid_v2.dr
	 */
class FileRecord extends Record
//	extends java.io.Serializable
{
	
	var $_id;
	var $_recordStructure;
	
	var $_parts;
	
	function FileRecord( &$recordStructure, & $id, $configuration ) {
		$this->_id=& $id;
		$this->_recordStructure =& $recordStructure;
		$this->_configuration = $configuration;
		
		$idManager =& Services::getService("Id");	
		$this->_parts = array();
		$this->_parts['FILE_DATA'] =& new FileDataInfoField(
									$recordStructure->getPartStructure($idManager->getId('FILE_DATA')),
									$this->_id,
									$this->_configuration);
		$this->_parts['FILE_NAME'] =& new FileNameInfoField(
									$recordStructure->getPartStructure($idManager->getId('FILE_NAME')),
									$this->_id,
									$this->_configuration);
		$this->_parts['FILE_SIZE'] =& new FileSizeInfoField(
									$recordStructure->getParts($idManager->getId('FILE_SIZE')),
									$this->_id,
									$this->_configuration);
		$this->_parts['MIME_TYPE'] =& new MimeTypeInfoField(
									$infoStructure->getPartStructure($idManager->getId('MIME_TYPE')),
									$this->_id,
									$this->_configuration);
		$this->_parts['THUMBNAIL_DATA'] =& new ThumbnailDataInfoField(
									$infoStructure->getInfoPart($idManager->getId('THUMBNAIL_DATA')),
									$this->_id,
									$this->_configuration);
		$this->_parts['THUMBNAIL_MIME_TYPE'] =& new ThumbnailMimeTypeInfoField(
									$recordStructure->getPartStructure($idManager->getId('THUMBNAIL_MIME_TYPE')),
									$this->_id,
									$this->_configuration);
	}

	/**
	 * Get the Unique Id for this InfoRecord.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
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
	 */
	function &createPart(& $PartStructureId, & $value) {
		$found = FALSE;
		while ($parts->hasNext()) {
			$part =& $parts->next();
			if ($PartStructureId->isEqual($part->getId())) {
				break;
				$found = TRUE;
			}
		}
		
		if (!$found)
			throwError(new Error(RepositoryException::UNKNOWN_ID(), "FileRecord", true));
		
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
		
		$this->_parts[$partIdString]->updateValue($value);
		
		return $this->_parts[$partIdString];
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
	 */
	function deletePart(& $partId) {
		$string = $partId->getIdString();
		if (ereg("(.*)-(FILE_SIZE|FILE_NAME|FILE_DATA|MIME_TYPE|THUMBNAIL_DATA|THUMBNAIL_MIME_TYPE)",$string,$r)) {
			$recordId = $r[1];
			$field = $r[2];
			
			if ($this->_isLastField($field)) {
				$dbHandler =& Services::getService("DBHandler");
				
				// Delete the data
				$query =& new DeleteQuery();
				$query->setTable("dr_file_data");
				$query->setWhere("FK_file = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration["dbId"]);
				
				// Delete the thumbnail
				$query =& new DeleteQuery();
				$query->setTable("dr_thumbnail");
				$query->setWhere("FK_file = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration["dbId"]);
				
				// delete the file row.
				$query =& new DeleteQuery();
				$query->setTable("dr_file");
				$query->setWhere("id = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration["dbId"]);
			} else if ($field != "FILE_SIZE") {
				$this->_parts[$field]->updateValue("NULL");
			}
		} else {
			throwError(new Error(RepositoryException::UNKNOWN_ID().": $string", "FileRecord", true));
		}
	}

	/**
	 * Get all the InfoFields in the InfoRecord.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoFieldIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
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
	 */
	function isMultivalued() {
		return true; // we allow as many InfoRecords of any InfoStructure as people want.
	}

	/**
	 * Get the InfoStructure associated with this InfoRecord.
	 * @return object InfoStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoStructure() {
		return $this->_infoStructure;
	}
	
	/**
	 * Return TRUE if the infoField of the passed Id is the last one, and the whole schebang should be deleted.
	 * 
	 * @param string $idString
	 * @return boolean
	 * @access public
	 * @since 10/25/04
	 */
	function _isLastField ($idString) {
		$dbHandler =& Services::getService("DBHandler");
	
		// Check to see if the data is in the database
		$query =& new SelectQuery;
		$query->addTable("dr_file");
		$query->addTable("dr_file_data", LEFT_JOIN, "dr_file.id = dr_file_data.FK_file");
		$query->addTable("dr_thumbnail", LEFT_JOIN, "dr_file.id = dr_thumbnail.FK_file");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_file.FK_mime_type = file_mime_type.id", "file_mime_type");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_thumbnail.FK_mime_type = thumbnail_mime_type.id", "thumbnail_mime_type");
		$query->addColumn("filename");
		$query->addColumn("size");
		$query->addColumn("file_mime_type.type", "file_type");
		$query->addColumn("dr_file_data.data", "file_data");
		$query->addColumn("thumbnail_mime_type.type", "thumbnail_type");
		$query->addColumn("dr_thumbnail.data", "thumbnail_data");
		$query->addWhere("dr_file.id = '".$this->_id->getIdString()."'");
		$result =& $dbHandler->query($query, $this->_configuration["dbId"]);
		
		if (!$result->getNumberOfRows()) {
			return TRUE;
		}
		
		$fields = array('filename', 'size', 'file_type', 'file_data', 'thumbnail_type', 'thumbnail_data');
		
		$countValues = 0;
		foreach ($fields as $field) {
			if ($result->field($field))
				$countValues++;
		}
		
		if ($countValues <= 1)
			return TRUE;
		else 
			return FALSE;
	}
	
	
}