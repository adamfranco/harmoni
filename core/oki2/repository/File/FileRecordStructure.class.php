<?

require_once(dirname(__FILE__)."/Fields/FileDataPartStructure.class.php");
require_once(dirname(__FILE__)."/Fields/FileNamePartStructure.class.php");
require_once(dirname(__FILE__)."/Fields/FileSizePartStructure.class.php");
require_once(dirname(__FILE__)."/Fields/MimeTypePartStructure.class.php");
require_once(dirname(__FILE__)."/Fields/DimensionsPartStructure.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailDataPartStructure.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailMimeTypePartStructure.class.php");
require_once(HARMONI."/oki2/repository/HarmoniPartStructureIterator.class.php");

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
 * @version $Id: FileRecordStructure.class.php,v 1.12 2006/12/06 20:44:59 adamfranco Exp $ 
 */
class HarmoniFileRecordStructure 
	extends RecordStructure
{
	
	var $_partStructures;
	
	function HarmoniFileRecordStructure() {
		$this->_schema =& $schema;
		
		// create an array of created PartStructures so we can return references to
		// them instead of always making new ones.
		if (!is_array($this->_partStructures))
			$this->_partStructures = array();
		$this->_partStructures['FILE_DATA'] =& new FileDataPartStructure($this);
		$this->_partStructures['FILE_NAME'] =& new FileNamePartStructure($this);
		$this->_partStructures['MIME_TYPE'] =& new MimeTypePartStructure($this);
		$this->_partStructures['FILE_SIZE'] =& new FileSizePartStructure($this);
		$this->_partStructures['DIMENSIONS'] =& new DimensionsPartStructure($this, 'DIMENSIONS');
		$this->_partStructures['THUMBNAIL_DATA'] =& new ThumbnailDataPartStructure($this);
		$this->_partStructures['THUMBNAIL_MIME_TYPE'] =& new ThumbnailMimeTypePartStructure($this);
		$this->_partStructures['THUMBNAIL_DIMENSIONS'] =& new DimensionsPartStructure($this,  'THUMBNAIL_DIMENSIONS');
	}
	
	/**
	 * Get the display name for this RecordStructure.
	 *	
	 * @return string
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
	function getDisplayName() {
		return "File";
	}
	
	/**
	 * Get the description for this RecordStructure.
	 *	
	 * @return string
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
	function getDescription() {
		return "A structure for storing binary files.";
	}

	/**
	 * Get the unique Id for this RecordStructure.
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
		$idManager =& Services::getService("Id");
		return $idManager->getId('FILE');
	}
	
	/**
	 * Get the Type for this RecordStructure.
	 *	
	 * @return object Type
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
	function &getType () { 
		$type =& new Type("RecordStructures", "edu.middlebury.harmoni", "File", "RecordStructures that store files.");
		return $type;
	} 

	/**
	 * Get all the PartStructures in the RecordStructure.  Iterators return a
	 * set, one at a time.
	 *	
	 * @return object PartStructureIterator
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
	function &getPartStructure(& $partStructureId) {
		if ($this->_partStructures[$partStructureId->getIdString()]) {		
			return $this->_partStructures[$partStructureId->getIdString()];
		} else {
			throwError(new Error(RepositoryException::UNKNOWN_ID(), "Repository :: FileRecordStructure", TRUE));
		}
	}

	/**
	 * Get all the PartStructures in the RecordStructure.  Iterators return a
	 * set, one at a time.
	 *	
	 * @return object PartStructureIterator
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
	function &getPartStructures() {
		$obj =& new HarmoniPartStructureIterator($this->_partStructures);
		return $obj;
	}

	/**
	 * Get the schema for this RecordStructure.	 The schema is defined by the
	 * implementation, e.g. Dublin Core.
	 *	
	 * @return string
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
	function getSchema() {
		return "Harmoni File Schema";
	}

	/**
	 * Get the format for this RecordStructure.	 The format is defined by the
	 * implementation, e.g. XML.
	 *	
	 * @return string
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
	function getFormat() {
		return "Harmoni File";
	}

	/**
	 * Validate a Record against its RecordStructure.  Return true if valid;
	 * false otherwise.	 The status of the Asset holding this Record is not
	 * changed through this method.	 The implementation may throw an Exception
	 * for any validation failures and use the Exception's message to identify
	 * specific causes.
	 * 
	 * @param object Record $record
	 *	
	 * @return boolean
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
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function validateRecord(& $record) {
		// all we can really do is make sure the DataSet behind the Record is of the correct
		// type to match this RecordStructure (DataSetTypeDefinition).
		
		return true; // for now
	}

	/**
	 * Get the possible types for PartStructures.
	 *
	 * @return object TypeIterator The Types supported in this implementation.
	 */
	function getPartStructureTypes() {
		$types = array();
		$obj =& new HarmoniIterator($types);
		return $obj;
	}
	
}
