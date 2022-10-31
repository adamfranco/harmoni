<?php

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
 * @version $Id: FileRecord.class.php,v 1.29 2008/02/06 15:37:52 adamfranco Exp $ 
 */
class FileRecord 
	implements Record
{
	
	var $_id;
	var $_recordStructure;
	
	var $_parts;
	var $_partsLoaded;
	
	function __construct( $recordStructure, $id, $configuration, $asset ) {
		$this->_id =$id;
		$this->_recordStructure =$recordStructure;
		$this->_configuration =$configuration;
		$this->_asset =$asset;
		
		$idManager = Services::getService("Id");	
		$this->_parts = array();
		$this->addFileDataPart($recordStructure);
		$this->_parts['FILE_NAME'] = new FileNamePart(
									$recordStructure->getPartStructure($idManager->getId('FILE_NAME')),
									$this->_id,
									$this->_configuration,
									$this->_asset);
		$this->_parts['FILE_SIZE'] = new FileSizePart(
									$recordStructure->getPartStructure($idManager->getId('FILE_SIZE')),
									$this->_id,
									$this->_configuration,
									$this->_asset);
		$this->_parts['MIME_TYPE'] = new MimeTypePart(
									$recordStructure->getPartStructure($idManager->getId('MIME_TYPE')),
									$this->_id,
									$this->_configuration,
									$this->_asset);
		$this->_parts['DIMENSIONS'] = new DimensionsPart(
									$recordStructure->getPartStructure($idManager->getId('DIMENSIONS')),
									$this->_id,
									$this->_configuration,
									$this,
									$this->_asset);
		$this->_parts['THUMBNAIL_DATA'] = new ThumbnailDataPart(
									$recordStructure->getPartStructure($idManager->getId('THUMBNAIL_DATA')),
									$this->_id,
									$this->_configuration,
									$this->_asset);
		$this->_parts['THUMBNAIL_MIME_TYPE'] = new ThumbnailMimeTypePart(
									$recordStructure->getPartStructure($idManager->getId('THUMBNAIL_MIME_TYPE')),
									$this->_id,
									$this->_configuration,
									$this->_asset);
		$this->_parts['THUMBNAIL_DIMENSIONS'] = new ThumbnailDimensionsPart(
									$recordStructure->getPartStructure($idManager->getId('THUMBNAIL_DIMENSIONS')),
									$this->_id,
									$this->_configuration,
									$this,
									$this->_asset);
		
		$this->_partsLoaded = false;
	}
	
	/**
	 * Add a fileDataPart
	 * 
	 * @param $recordStructure
	 * @return void
	 * @access public
	 * @since 12/6/06
	 */
	function addFileDataPart ($recordStructure) {
		$idManager = Services::getService("Id");	
		$this->_parts['FILE_DATA'] = new FileDataPart(
									$recordStructure->getPartStructure($idManager->getId('FILE_DATA')),
									$this->_id,
									$this->_configuration,
									$this->_asset);
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
	function getId() {
		return $this->_id;
	}
	
	/**
     * Update the display name for this Record.
     * 
     * @param string $displayName
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
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function updateDisplayName ( $displayName ) {
    	throw new UnimplementedException;
    }

    /**
     * Get the display name for this Record.
     *  
     * @return string
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
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getDisplayName () {
    	throw new UnimplementedException;
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
	function createPart(Id $partStructureId, $value) {
		$found = FALSE;
		foreach($this->_parts as $key => $val){
			if($partStructureId->isEqual($val->getId()))
			break;
			$found=TRUE;
/*
		while ($parts->hasNext()) {
			$part =$parts->next();
			if ($partStructureId->isEqual($part->getId())) {
				break;
				$found = TRUE;
			}
*/		}
		
		if (!$found)
			throwError(new HarmoniError(RepositoryException::UNKNOWN_ID(), "FileRecord", true));
		
		$partIdString = $partStructureId->getIdString();
		
//		if (is_object($this->_parts[$partIdString]))
//			throwError(new HarmoniError(PERMISSION_DENIED.": Can't add another field to a
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
//					throwError(new HarmoniError(OPERATION_FAILED, "FileRecord", true));
//			}
//			
//			$this->_parts[$partIdString] = new $className(
//									$part,
//									$this->_id,
//									$this->configuration);
//		}
		
		$this->_parts[$partIdString]->updateValue($value);
		
		// Make sure that we don't trigger deleting of the whole record by deleting
		// and recreating parts
		if (isset($this->_toDelete) && in_array($partIdString, $this->_toDelete)) {
			$key = array_search($partIdString, $this->_toDelete);
			unset ($this->_toDelete[$key]);
		}
		
		$this->_asset->updateModificationDate();
		
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
	function deletePart(Id $partId) {
		$string = $partId->getIdString();
		if (preg_match("/(.*)-(".implode("|", array_keys($this->_parts)).")/",$string,$r)) {
			$recordId = $r[1];
			$field = $r[2];
			
			if ($this->_isLastPart($field)) {
				$dbHandler = Services::getService("DatabaseManager");
				
				// Delete the data
				$query = new DeleteQuery();
				$query->setTable("dr_file_data");
				$query->setWhere("fk_file = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				
				// Delete the thumbnail
				$query = new DeleteQuery();
				$query->setTable("dr_thumbnail");
				$query->setWhere("fk_file = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				
				// delete the file row.
				$query = new DeleteQuery();
				$query->setTable("dr_file");
				$query->setWhere("id = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				
			} else if ($field != "FILE_SIZE") {
				$this->_parts[$field]->updateValue(null);
			}
		} else {
			throwError(new HarmoniError(RepositoryException::UNKNOWN_ID().": $string", "FileRecord", true));
		}
		
		$this->_asset->updateModificationDate();
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
	function getParts() {
		$this->_loadParts();
		
		// Create an iterator and return it.
		$partIterator = new HarmoniPartIterator($this->_parts);
		
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
	function getPart (Id $id) {
		$parts =$this->getParts();
		
		while ($parts->hasNext()) {
			$part =$parts->next();
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
	function getRecordStructure() {
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
		if (!isset($this->_toDelete))
			$this->_toDelete = array();
		
		$dbHandler = Services::getService("DatabaseManager");
	
		// Check to see if the data is in the database
		$query = new SelectQuery;
		$query->addTable("dr_file");
		$query->addTable("dr_file_data", LEFT_JOIN, "dr_file.id = dr_file_data.fk_file");
		$query->addTable("dr_thumbnail", LEFT_JOIN, "dr_file.id = dr_thumbnail.fk_file");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_file.fk_mime_type = file_mime_type.id", "file_mime_type");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_thumbnail.fk_mime_type = thumbnail_mime_type.id", "thumbnail_mime_type");
		$query->addColumn("filename", "FILE_NAME");
		$query->addColumn("size", "FILE_SIZE");
		$query->addColumn("file_mime_type.type", "MIME_TYPE");
		$query->addColumn("dr_file_data.data", "FILE_DATA");
		$query->addColumn("thumbnail_mime_type.type", "THUMBNAIL_MIME_TYPE");
		$query->addColumn("dr_thumbnail.data", "THUMBNAIL_DATA");
		$query->addWhereEqual("dr_file.id", $this->_id->getIdString());
		$result =$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		if (!$result->getNumberOfRows()) {
			$result->free();
			return TRUE;
		}
		
		$fields = array('FILE_NAME', 'FILE_SIZE', 'MIME_TYPE', 'FILE_DATA', 'THUMBNAIL_MIME_TYPE', 'THUMBNAIL_DATA');
		
		$countValues = 0;
		foreach ($fields as $field) {
			if ($result->field($field) && !in_array($field, $this->_toDelete))
				$countValues++;
		}
		$result->free();
		
		$this->_toDelete[] = $idString;
		
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
    function getPartsByPartStructure ( Id $partStructureId ) {
    	$this->_loadParts();
    	
    	$partArray = array();
    	if (isset($this->_parts[$partStructureId->getIdString()]))
	    	$partArray[] =$this->_parts[$partStructureId->getIdString()];
		$partsIterator = new HarmoniIterator($partArray);
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
		
    	$dbHandler = Services::getService("DBHandler");
    	
    	$query = new SelectQuery;
		$query->addTable("dr_file");
		$query->addTable("dr_thumbnail", LEFT_JOIN, "dr_file.id = dr_thumbnail.fk_file");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_file.fk_mime_type = file_mime_type.id", "file_mime_type");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_thumbnail.fk_mime_type = thumbnail_mime_type.id", "thumbnail_mime_type");
		$query->addColumn("filename");
		$query->addColumn("size");
		$query->addColumn("dr_file.width", "file_width");
		$query->addColumn("dr_file.height", "file_height");
		$query->addColumn("file_mime_type.type", "file_type");
		$query->addColumn("thumbnail_mime_type.type", "thumbnail_type");
		$query->addColumn("dr_thumbnail.width", "thumb_width");
		$query->addColumn("dr_thumbnail.height", "thumb_height");
		$query->addWhereEqual("dr_file.id", $this->_id->getIdString());
		
		$result =$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		if ($result->getNumberOfRows()) {
			$this->_parts['FILE_NAME']->_updateValue($result->field('filename'));
			$this->_parts['FILE_SIZE']->_updateValue($result->field('size'));
			$this->_parts['MIME_TYPE']->_updateValue($result->field('file_type'));
			$this->_parts['DIMENSIONS']->_updateValue(array($result->field('file_width'), $result->field('file_height')));
			$this->_parts['THUMBNAIL_MIME_TYPE']->_updateValue($result->field('thumbnail_type'));
			$this->_parts['THUMBNAIL_DIMENSIONS']->_updateValue(array($result->field('thumb_width'), $result->field('thumb_height')));
		}
		
		$this->_partsLoaded = true;
    }
	
}