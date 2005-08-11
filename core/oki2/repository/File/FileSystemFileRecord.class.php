<?

require_once(dirname(__FILE__)."/Fields/FileSystemFileDataPart.class.php");
require_once(dirname(__FILE__)."/Fields/FileNamePart.class.php");
require_once(dirname(__FILE__)."/Fields/FileSizePart.class.php");
require_once(dirname(__FILE__)."/Fields/MimeTypePart.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailDataPart.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailMimeTypePart.class.php");
require_once(HARMONI."/oki2/repository/HarmoniPartIterator.class.php");

/**
 * This Record will use a FileSystemFileDataPart to store the file data in the
 * filesystem.
 *
 * Important configuration options:
 *		- 'use_filesystem_for_files'
 *		- 'file_data_path'
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
 * @version $Id: FileSystemFileRecord.class.php,v 1.5 2005/08/11 17:58:39 cws-midd Exp $ 
 */
class FileSystemFileRecord 
	extends FileRecord
{
	
	function FileSystemFileRecord( &$recordStructure, & $id, $configuration ) {
		$this->_id =& $id;
		$this->_recordStructure =& $recordStructure;
		$this->_configuration = $configuration;
		
		$idManager =& Services::getService("Id");	
		$this->_parts = array();
		$this->_parts['FILE_DATA'] =& new FileSystemFileDataPart(
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
				$dbHandler =& Services::getService("DatabaseManager");
				
				// Delete the data
				$file = $this->_parts['FILE_DATA']->_getFilePath();
				if (!unlink($file))
					throwError(new Error(RepositoryException::OPERATION_FAILED()
						.": '$file' could not be deleted.", "FileSystemFileRecord", true));
				
				// Delete the thumbnail
				$query =& new DeleteQuery();
				$query->setTable("dr_thumbnail");
				$query->setWhere("FK_file = '".$this->_id->getIdString()."'");
				$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				
				// Delete the data row in case we were switching from another type
				// that used it.
				$query =& new DeleteQuery();
				$query->setTable("dr_file_data");
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
			throwError(new Error(RepositoryException::UNKNOWN_ID().": $string", "FileSystemFileRecord", true));
		}
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
// 		$query->addTable("dr_file_data", LEFT_JOIN, "dr_file.id = dr_file_data.FK_file");
		$query->addTable("dr_thumbnail", LEFT_JOIN, "dr_file.id = dr_thumbnail.FK_file");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_file.FK_mime_type = file_mime_type.id", "file_mime_type");
		$query->addTable("dr_mime_type", LEFT_JOIN, "dr_thumbnail.FK_mime_type = thumbnail_mime_type.id", "thumbnail_mime_type");
		$query->addColumn("filename");
		$query->addColumn("size");
		$query->addColumn("file_mime_type.type", "file_type");
// 		$query->addColumn("dr_file_data.data", "file_data");
		$query->addColumn("thumbnail_mime_type.type", "thumbnail_type");
		$query->addColumn("dr_thumbnail.data", "thumbnail_data");
		$query->addWhere("dr_file.id = '".$this->_id->getIdString()."'");
		$result =& $dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		$file = $this->_parts['FILE_DATA']->_getFilePath();
		
		if (!$result->getNumberOfRows() && !file_exists($file)) {
			$result->free();
			return TRUE;
		}
		
		$fields = array('filename', 'size', 'file_type', 'thumbnail_type', 'thumbnail_data');
		
		$countValues = 0;
		foreach ($fields as $field) {
			if ($result->field($field))
				$countValues++;
		}
		$result->free();
		
		if (file_exists($file))
			$countValues++;
		
		if ($countValues <= 1)
			return TRUE;
		else 
			return FALSE;
	}
	
	
}