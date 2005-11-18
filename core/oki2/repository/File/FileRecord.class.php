<?

require_once(dirname(__FILE__)."/Fields/FileDataPart.class.php");
require_once(dirname(__FILE__)."/Fields/FileNamePart.class.php");
require_once(dirname(__FILE__)."/Fields/FileSizePart.class.php");
require_once(dirname(__FILE__)."/Fields/MimeTypePart.class.php");
require_once(dirname(__FILE__)."/Fields/DimensionsPart.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailDataPart.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailMimeTypePart.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailDimensionsPart.class.php");
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
 * @version $Id: FileRecord.class.php,v 1.20 2005/11/18 21:26:05 adamfranco Exp $ 
 */
class FileRecord 
	extends RecordInterface
{
	
	var $_id;
	var $_recordStructure;
	
	var $_parts;
	var $_partsLoaded;
	
	function FileRecord( &$recordStructure, & $id, &$configuration ) {
		$this->_id =& $id;
		$this->_recordStructure =& $recordStructure;
		$this->_configuration =& $configuration;
		
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
		$this->_parts['DIMENSIONS'] =& new DimensionsPart(
									$recordStructure->getPartStructure($idManager->getId('DIMENSIONS')),
									$this->_id,
									$this->_configuration,
									$this);
		$this->_parts['THUMBNAIL_DATA'] =& new ThumbnailDataPart(
									$recordStructure->getPartStructure($idManager->getId('THUMBNAIL_DATA')),
									$this->_id,
									$this->_configuration);
		$this->_parts['THUMBNAIL_MIME_TYPE'] =& new ThumbnailMimeTypePart(
									$recordStructure->getPartStructure($idManager->getId('THUMBNAIL_MIME_TYPE')),
									$this->_id,
									$this->_configuration);
		$this->_parts['THUMBNAIL_DIMENSIONS'] =& new ThumbnailDimensionsPart(
									$recordStructure->getPartStructure($idManager->getId('THUMBNAIL_DIMENSIONS')),
									$this->_id,
									$this->_configuration,
									$this);
		
		$this->_partsLoaded = false;
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
		foreach($this->_parts as $key => $val){
			if($partStructureId->isEqual($val->getId()))
			break;
			$found=TRUE;
/*
		while ($parts->hasNext()) {
			$part =& $parts->next();
			if ($partStructureId->isEqual($part->getId())) {
				break;
				$found = TRUE;
			}
*/		}
		
		if (!$found)
			throwError(new Error(RepositoryException::UNKNOWN_ID(), "FileRecord", true));
		
		$partIdString = $partStructureId->getIdString();
		
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
		if (ereg("(.*)-(".implode("|", array_keys($this->_parts)).")",$string,$r)) {
			$recordId = $r[1];
			$field = $r[2];
			
			if ($this->_isLastPart($field)) {
				$dbHandler =& Services::getService("DatabaseManager");
				
				// Delete the data
				$query =& new DeleteQuery();
				$query->setTable("dr_file_data");
				$query->setWhere("FK_file = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				
				// Delete the thumbnail
				$query =& new DeleteQuery();
				$query->setTable("dr_thumbnail");
				$query->setWhere("FK_file = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				
				// delete the file row.
				$query =& new DeleteQuery();
				$query->setTable("dr_file");
				$query->setWhere("id = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
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
		$this->_loadParts();
		
		// Create an iterator and return it.
		$partIterator =& new HarmoniPartIterator($this->_parts);
		
		return $partIterator;
	}

	/**
	 * Get the part from the record that matches the passed Id
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @param object HarmoniId
	 * @return object HarmoniPart
	 * @access public
	 * @since 10/10/05
	 */
	function &getPart ($id) {
		$parts =& $this->getParts();
		
		while ($parts->hasNext()) {
			$part =& $parts->next();
			if ($part->getId() == $id)
				return $part;
		}
		$false = false;
		return $false;
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
		$dbHandler =& Services::getService("DatabaseManager");
	
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
		$result =& $dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		if (!$result->getNumberOfRows()) {
			$result->free();
			return TRUE;
		}
		
		$fields = array('filename', 'size', 'file_type', 'file_data', 'thumbnail_type', 'thumbnail_data');
		
		$countValues = 0;
		foreach ($fields as $field) {
			if ($result->field($field))
				$countValues++;
		}
		$result->free();
		
		if ($countValues <= 1)
			return TRUE;
		else 
			return FALSE;
	}
	
	/**
     * Get the Parts of the Records for this Asset that are based on this
     * RecordStructure PartStructure's unique Id.
     *
     * WARNING: NOT IN OSID (as of July 2005)
     * 
     * @param object Id $partStructureId
     *  
     * @return object PartIterator
     * 
     * @throws object RepositoryException An exception with one of
     *         the following messages defined in
     *         org.osid.repository.RepositoryException may be thrown: {@link
     *         org.osid.repository.RepositoryException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.repository.RepositoryException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.repository.RepositoryException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.repository.RepositoryException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.repository.RepositoryException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    function &getPartsByPartStructure ( &$partStructureId ) {
    	$this->_loadParts();
    	
    	$partArray = array();
    	$partArray[] =& $this->_parts[$partStructureId->getIdString()];
		$partsIterator =& new HarmoniIterator($partArray);
		return $partsIterator;
    }
    
    /**
     * Do a single query to load all of the small-valued parts for the record;
     * that is, everything but the file and thumb data.
     * 
     * @return void
     * @access private
     * @since 11/17/05
     */
    function _loadParts () {
		if ($this->_partsLoaded)
			return;
		
    	$dbHandler =& Services::getService("DBHandler");
    	
    	$query =& new SelectQuery;
		$query->addTable("dr_file");
		$query->addTable("dr_thumbnail", LEFT_JOIN, "dr_file.id = dr_thumbnail.FK_file");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_file.FK_mime_type = file_mime_type.id", "file_mime_type");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_thumbnail.FK_mime_type = thumbnail_mime_type.id", "thumbnail_mime_type");
		$query->addColumn("filename");
		$query->addColumn("size");
		$query->addColumn("dr_file.width", "file_width");
		$query->addColumn("dr_file.height", "file_height");
		$query->addColumn("file_mime_type.type", "file_type");
		$query->addColumn("thumbnail_mime_type.type", "thumbnail_type");
		$query->addColumn("dr_thumbnail.width", "thumb_width");
		$query->addColumn("dr_thumbnail.height", "thumb_height");
		$query->addWhere("dr_file.id = '".$this->_id->getIdString()."'");
		
		$result =& $dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		$this->_parts['FILE_NAME']->_updateValue($result->field('filename'));
		$this->_parts['FILE_SIZE']->_updateValue($result->field('size'));
		$this->_parts['MIME_TYPE']->_updateValue($result->field('file_type'));
		$this->_parts['DIMENSIONS']->_updateValue(array($result->field('file_width'), $result->field('file_height')));
		$this->_parts['THUMBNAIL_MIME_TYPE']->_updateValue($result->field('thumbnail_type'));
		$this->_parts['THUMBNAIL_DIMENSIONS']->_updateValue(array($result->field('thumb_width'), $result->field('thumb_height')));
		
		$this->_partsLoaded = true;
    }
	
}