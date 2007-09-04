<?php
/**
 * @since 12/5/06
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RemoteFileRecord.class.php,v 1.2 2007/09/04 20:25:44 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/Fields/FileUrlPart.class.php");
require_once(dirname(__FILE__)."/Fields/RemoteFileSizePart.class.php");

/**
 * Remote fileRecords are just like FileRecords, but they reference file-data that
 * lies at a remote web-accessible location.
 * 
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
 * @since 12/5/06
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RemoteFileRecord.class.php,v 1.2 2007/09/04 20:25:44 adamfranco Exp $
 */
class RemoteFileRecord
	extends FileRecord
{
		
	/**
	 * Constructor
	 * 
	 * @param <##>
	 * @return object
	 * @access public
	 * @since 12/5/06
	 */
	function RemoteFileRecord ( $recordStructure, $id, $configuration, $asset ) {
		$this->FileRecord($recordStructure, $id, $configuration, $asset);
		
		unset($this->_parts['FILE_DATA'], $this->_parts['FILE_SIZE']);
		
		$idManager = Services::getService("Id");
		
		$this->_parts['FILE_URL'] = new FileUrlPart(
									$recordStructure->getPartStructure($idManager->getId('FILE_URL')),
									$this->_id,
									$this->_configuration,
									$this->_asset);
		$this->_parts['FILE_SIZE'] = new RemoteFileSizePart(
									$recordStructure->getPartStructure($idManager->getId('FILE_SIZE')),
									$this->_id,
									$this->_configuration,
									$this->_asset);
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
	function deletePart($partId) {
		$string = $partId->getIdString();
		if (ereg("(.*)-(".implode("|", array_keys($this->_parts)).")",$string,$r)) {
			$recordId = $r[1];
			$field = $r[2];
			
			if ($this->_isLastPart($field)) {
				$dbHandler = Services::getService("DatabaseManager");
				
				// Delete the data
				$query = new DeleteQuery();
				$query->setTable("dr_file_url");
				$query->setWhere("FK_file = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				
				// Delete the thumbnail
				$query = new DeleteQuery();
				$query->setTable("dr_thumbnail");
				$query->setWhere("FK_file = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				
				// delete the file row.
				$query = new DeleteQuery();
				$query->setTable("dr_file");
				$query->setWhere("id = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				
			} else {
				$this->_parts[$field]->updateValue("NULL");
			}
		} else {
			throwError(new Error(RepositoryException::UNKNOWN_ID().": $string", "FileRecord", true));
		}
		
		$this->_asset->updateModificationDate();
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
		$query->addTable("dr_file_url", LEFT_JOIN, "dr_file.id = dr_file_url.FK_file");
		$query->addTable("dr_thumbnail", LEFT_JOIN, "dr_file.id = dr_thumbnail.FK_file");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_file.FK_mime_type = file_mime_type.id", "file_mime_type");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_thumbnail.FK_mime_type = thumbnail_mime_type.id", "thumbnail_mime_type");
		$query->addColumn("filename", "FILE_NAME");
		$query->addColumn("size", "FILE_SIZE");
		$query->addColumn("file_mime_type.type", "MIME_TYPE");
		$query->addColumn("dr_file_url.url", "FILE_URL");
		$query->addColumn("thumbnail_mime_type.type", "THUMBNAIL_MIME_TYPE");
		$query->addColumn("dr_thumbnail.data", "THUMBNAIL_DATA");
		$query->addWhere("dr_file.id = '".$this->_id->getIdString()."'");
		$result =$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		if (!$result->getNumberOfRows()) {
			$result->free();
			return TRUE;
		}
		
		$fields = array('FILE_NAME', 'FILE_SIZE', 'MIME_TYPE', 'FILE_URL', 'THUMBNAIL_MIME_TYPE', 'THUMBNAIL_DATA');
		
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
		$query->addTable("dr_file_url", LEFT_JOIN, "dr_file.id = dr_file_url.FK_file");
		$query->addTable("dr_thumbnail", LEFT_JOIN, "dr_file.id = dr_thumbnail.FK_file");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_file.FK_mime_type = file_mime_type.id", "file_mime_type");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_thumbnail.FK_mime_type = thumbnail_mime_type.id", "thumbnail_mime_type");
		$query->addColumn("filename");
		$query->addColumn("size");
		$query->addColumn("dr_file.width", "file_width");
		$query->addColumn("dr_file.height", "file_height");
		$query->addColumn("dr_file_url.url", "url");
		$query->addColumn("file_mime_type.type", "file_type");
		$query->addColumn("thumbnail_mime_type.type", "thumbnail_type");
		$query->addColumn("dr_thumbnail.width", "thumb_width");
		$query->addColumn("dr_thumbnail.height", "thumb_height");
		$query->addWhere("dr_file.id = '".$this->_id->getIdString()."'");
		
		$result =$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		if ($result->getNumberOfRows()) {
			$this->_parts['FILE_NAME']->_updateValue($result->field('filename'));
			$this->_parts['FILE_URL']->_updateValue($result->field('url'));
			$this->_parts['FILE_SIZE']->_updateValue($result->field('size'));
			$this->_parts['MIME_TYPE']->_updateValue($result->field('file_type'));
			$this->_parts['DIMENSIONS']->_updateValue(array($result->field('file_width'), $result->field('file_height')));
			$this->_parts['THUMBNAIL_MIME_TYPE']->_updateValue($result->field('thumbnail_type'));
			$this->_parts['THUMBNAIL_DIMENSIONS']->_updateValue(array($result->field('thumb_width'), $result->field('thumb_height')));
		}
		
		$this->_partsLoaded = true;
    }
	
}

?>