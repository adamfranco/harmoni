<?

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
 * @version $Id: ThumbnailMimeTypePart.class.php,v 1.7 2005/04/04 18:23:59 adamfranco Exp $
 */
class ThumbnailMimeTypePart extends Part
//	extends java.io.Serializable
{

	var $_recordId;
	var $_partStructure;
	var $_type;
	
	function ThumbnailMimeTypePart( &$partStructure, &$recordId, $configuration ) {
		$this->_recordId =& $recordId;
		$this->_partStructure =& $partStructure;
		$this->_configuration = $configuration;
		
		// Set our name to NULL, so that we can know if it has not been checked
		// for yet. If we search for name, but don't have any, or the name is
		// an empty string, it will have value "" instead of NULL
		$this->_type = NULL;
	}
	
	
	/**
	 * Get the unique Id for this Part.
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
		return $idManager->getId($this->_recordId->getIdString()."-THUMBNAIL_MIME_TYPE");
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
	function &createPar(& $partStructureId, & $value) {
		throwError(
			new Error(RepositoryException::UNIMPLEMENTED(), "HarmoniPart", true));
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
		throwError(
			new Error(RepositoryException::UNIMPLEMENTED(), "HarmoniPart", true));
	}

	/**
	 * Get all the Parts in this Part.	Iterators return a set, one at a time.
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
		throwError(
			new Error(RepositoryException::UNIMPLEMENTED(), "HarmoniPart", true));
	}

	
	/**
	 * Get the value for this Part.
	 *	
	 * @return object mixed (original type: java.io.Serializable)
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
	function getValue() {
		// If we don't have the type, load it from the database.
		if ($this->_type === NULL) {
			$dbHandler =& Services::getService("DatabaseManager");
			
			// Get the type from the database,
			$query =& new SelectQuery;
			$query->addColumn("type");
			$query->addTable("dr_thumbnail");
			$query->addTable("dr_mime_type", INNER_JOIN, "FK_mime_type = dr_mime_type.id");
			$query->addWhere("FK_file= '".$this->_recordId->getIdString()."'");
			
			$result =& $dbHandler->query($query, $this->_configuration->getProperty("database_index"));
			
			// If no name was found, return an empty string.
			if ($result->getNumberOfRows() == 0)
				$this->_type = 0;
			else
				$this->_type = $result->field("type");
		}
		
		return $this->_type;
	}
	/**
	 * Update the value for this Part.
	 * 
	 * @param object mixed $value (original type: java.io.Serializable)
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
	function updateValue($value) {
		ArgumentValidator::validate($value, NonzeroLengthStringValidatorRule::getRule());
		
		// Store the name in the object in case its asked for again.
		$this->_type = $value;
		
	// then write it to the database.
		$dbHandler =& Services::getService("DatabaseManager");
		
		// If we have a key, make sure it exists.
		if ($this->_type && $this->_type != "NULL") {
			// Check to see if the type is in the database
			$query =& new SelectQuery;
			$query->addTable("dr_mime_type");
			$query->addColumn("id");
			$query->addWhere("type = '".$this->_type."'");
			$result =& $dbHandler->query($query, $this->_configuration->getProperty("database_index"));
			
			// If it doesn't exist, insert it.
			if (!$result->getNumberOfRows()) {
				$query =& new InsertQuery;
				$query->setTable("dr_mime_type");
				$query->setColumns(array("type"));
				$query->setValues(array("'".addslashes($this->_type)."'"));
				
				$result2 =& $dbHandler->query($query, $this->_configuration->getProperty("database_index"));
				$mimeId = "'".$result2->getLastAutoIncrementValue()."'";
			} else {
				$mimeId = "'".$result->field("id")."'";
			}
		} 
		// If we don't have an Id, set the key to NULL.
		else {
			$mimeId = "NULL";
		}
			
		// add its id to the file.
		$query =& new UpdateQuery;
		$query->setTable("dr_thumbnail");
		$query->setColumns(array("FK_mime_type"));
		$query->setValues(array($mimeId));
		$query->addWhere("FK_file = '".$this->_recordId->getIdString()."'");
		
		// run the query
		$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
	}

	/**
	 * Get the PartStructure associated with this Part.
	 *	
	 * @return object PartStructure
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
	function &getPartStructure() {
		return $this->_partStructure;
	}
}
