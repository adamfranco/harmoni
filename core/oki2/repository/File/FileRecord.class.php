<?

require_once(dirname(__FILE__)."/Fields/FileDataPart.class.php");
require_once(dirname(__FILE__)."/Fields/FileNamePart.class.php");
require_once(dirname(__FILE__)."/Fields/FileSizePart.class.php");
require_once(dirname(__FILE__)."/Fields/MimeTypePart.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailDataPart.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailMimeTypePart.class.php");
require_once(HARMONI."/oki2/repository/HarmoniPartIterator.class.php");

/**
 * Each Asset has one of the AssetType supported by the Repository.	 There are
 * also zero or more RecordStructures required by the Repository for each
 * AssetType. RecordStructures provide structural information.	The values for
 * a given Asset's RecordStructure are stored in a Record.	RecordStructures
 * can contain sub-elements which are referred to as PartStructures.  The
 * structure defined in the RecordStructure and its PartStructures is used in
 * for any Records for the Asset.  Records have Parts which parallel
 * PartStructures.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: FileRecord.class.php,v 1.9 2005/02/17 17:34:35 adamfranco Exp $ 
 */
class FileRecord 
	extends Record
{
	
	var $_id;
	var $_recordStructure;
	
	var $_parts;
	
	function FileRecord( &$recordStructure, & $id, $configuration ) {
		$this->_id =& $id;
		$this->_recordStructure =& $recordStructure;
		$this->_configuration = $configuration;
		
		$idManager =& Services::getService("Id");	
		$this->_parts = array();
		$this->_parts['FILE_DATA'] =& new FileDataPart(
									$recordStructure->getPartStructure($idManager->getId('FILE_DATA')),
									$this->_id,
									$this->_configuration);
		$this->_parts['FILE_NAME'] =& new FileNamePart(
									$recordStructure->getPartStructure($idManager->getId('FILE_NAME')),
									$this->_id,
									$this->_configuration);
		$this->_parts['FILE_SIZE'] =& new FileSizePart(
									$recordStructure->getPartStructure($idManager->getId('FILE_SIZE')),
									$this->_id,
									$this->_configuration);
		$this->_parts['MIME_TYPE'] =& new MimeTypePart(
									$recordStructure->getPartStructure($idManager->getId('MIME_TYPE')),
									$this->_id,
									$this->_configuration);
		$this->_parts['THUMBNAIL_DATA'] =& new ThumbnailDataPart(
									$recordStructure->getPartStructure($idManager->getId('THUMBNAIL_DATA')),
									$this->_id,
									$this->_configuration);
		$this->_parts['THUMBNAIL_MIME_TYPE'] =& new ThumbnailMimeTypePart(
									$recordStructure->getPartStructure($idManager->getId('THUMBNAIL_MIME_TYPE')),
									$this->_id,
									$this->_configuration);
	}

	/**
	 * Get the unique Id for this Record.
	 *	
	 * @return object Id
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getId() {
		return $this->_id;
	}

	/**
	 * Create a Part.  Records are composed of Parts. Parts can also contain
	 * other Parts.	 Each Record is associated with a specific RecordStructure
	 * and each Part is associated with a specific PartStructure.
	 * 
	 * @param object Id $partStructureId
	 * @param object mixed $value (original type: java.io.Serializable)
	 *	
	 * @return object Part
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &createPart(& $partStructureId, & $value) {
		$found = FALSE;
		while ($parts->hasNext()) {
			$part =& $parts->next();
			if ($partStructureId->isEqual($part->getId())) {
				break;
				$found = TRUE;
			}
		}
		
		if (!$found)
			throwError(new Error(RepositoryException::UNKNOWN_ID(), "FileRecord", true));
		
		$partIdString = $partId->getIdString();
		
//		if (is_object($this->_parts[$partIdString]))
//			throwError(new Error(PERMISSION_DENIED.": Can't add another field to a
//			non-multi-valued part.", "FileRecord", true));
//		} else {
//			
//			switch ($partIdString) {
//				case "FILE_DATA":
//					$className = "FileDataPart";
//					break;
//				case "FILE_NAME":
//					$className = "FileNamePart";
//					break;
//				case "FILE_SIZE":
//					$className = "FileSizePart";
//					break;
//				case "MIME_TYPE":
//					$className = "MimeTypePart";
//					break;
//				default:
//					throwError(new Error(OPERATION_FAILED, "FileRecord", true));
//			}
//			
//			$this->_parts[$partIdString] =& new $className(
//									$part,
//									$this->_id,
//									$this->configuration);
//		}
		
		$this->_parts[$partIdString]->updateValue($value);
		
		return $this->_parts[$partIdString];
	}

	/**
	 * Delete a Part and all its Parts.
	 * 
	 * @param object Id $partId
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deletePart(& $partId) {
		$string = $partId->getIdString();
		if (ereg("(.*)-(FILE_SIZE|FILE_NAME|FILE_DATA|MIME_TYPE|THUMBNAIL_DATA|THUMBNAIL_MIME_TYPE)",$string,$r)) {
			$recordId = $r[1];
			$field = $r[2];
			
			if ($this->_isLastPart($field)) {
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
	 * Get all the Parts in the Record.	 Iterators return a set, one at a time.
	 *	
	 * @return object PartIterator
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getParts() {
		// Create an iterator and return it.
		$partIterator =& new HarmoniPartIterator($this->_parts);
		
		return $partIterator;
	}

	/**
	 * Return true if this Record is multi-valued; false otherwise.	 This is determined by the implementation.
	 * 
	 * WARNING: NOT IN OSID - Use at your own risk
	 *
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function isMultivalued() {
		return true; // we allow as many Records of any RecordStructure as people want.
	}

	
	/**
	 * Get the RecordStructure associated with this Record.
	 *	
	 * @return object RecordStructure
	 * 
	 * @throws object RepositoryException An exception with one of
	 *		   the following messages defined in
	 *		   org.osid.repository.RepositoryException may be thrown: {@link
	 *		   org.osid.repository.RepositoryException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.repository.RepositoryException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.repository.RepositoryException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.repository.RepositoryException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function &getRecordStructure() {
		return $this->_recordStructure;
	}
	
	/**
	 * Return TRUE if the Part of the passed Id is the last one, and the whole schebang should be deleted.
	 * 
	 * WARNING: NOT IN OSID - Use at your own risk
	 * 
	 * @param string $idString
	 * @return boolean
	 * @access private
	 * @since 10/25/04
	 */
	function _isLastPart ($idString) {
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
	
// 	/**
// 	 * Used with storeFromRecord to convert from one file storage 
// 	 * system to another.
// 	 *
// 	 * WARNING: NOT IN OSID
// 	 * 
// 	 * @param object FileRecord $fileRecord
// 	 * @return void
// 	 * @access public
// 	 * @since 2/17/05
// 	 */
// 	function storeToRecord (& $fileRecord ) {
// 		$fileRecord->storeFromFileRecord($this);
// 	}
// 	
// 	/**
// 	 * Used with storeToRecord to convert from one
// 	 * file storage system to another.
// 	 *
// 	 * WARNING: NOT IN OSID
// 	 * 
// 	 * @param object FileRecord $fileRecord
// 	 * @return void
// 	 * @access public
// 	 * @since 2/17/05
// 	 */
// 	function storeFromeRecord (& $fileRecord) {
// 		$this->_copyPartsValues($fileRecord);
// 	}
// 	
// 	/**
// 	 * Used by the storeToRecord methods to copy the necessary data.
// 	 * 
// 	 * @param object FileRecord $fileRecord
// 	 * @return void
// 	 * @access private
// 	 * @since 2/17/05
// 	 */
// 	function _copyPartsValues ( &$fileRecord ) {
// 		$origParts =& $fileRecord->getParts();
// 		while ($origParts->hasNextPart()) {
// 			$origPart =& $origParts->nextParts();
// 			$origPartStructure =& $origPart->getPartStructure();
// 			$origPartStructureId =& $origPartStructure->getId();
// 			
// 			$this->_parts[$origPartStructureId->getIdString()]
// 								->updateValue($origPart->getValue());
// 		}
// 	}	
	
}