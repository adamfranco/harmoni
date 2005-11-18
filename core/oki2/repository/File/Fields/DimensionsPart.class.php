<?
/**
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: DimensionsPart.class.php,v 1.7 2005/11/18 21:26:06 adamfranco Exp $
 */
 
require_once(dirname(__FILE__)."/../getid3.getimagesize.php");

/**
 * The DimensionsPart attempts to extract height, width, and mime type info from
 * a file, in an array similar to that returned from GetImageSize() method. 
 * If the file is not an image and/or such information can not be determined, 
 * this part has a boolean value of false. 
 *
 * @package harmoni.osid_v2.repository
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: DimensionsPart.class.php,v 1.7 2005/11/18 21:26:06 adamfranco Exp $
 */
class DimensionsPart 
	extends Part
{

	var $_recordId;
	var $_partStructure;
	var $_dimensions;
	
	/**
	 * Constructor
	 * 
	 * @param object PartStructure $partStructure
	 * @param object Id $recordId
	 * @param object Properties $configuration
	 * @param object Record $record
	 * @return object
	 * @access public
	 * @since 10/17/05
	 */
	function DimensionsPart( &$partStructure, &$recordId, &$configuration, &$record ) {
		$this->_recordId =& $recordId;
		$this->_partStructure =& $partStructure;
		$this->_configuration =& $configuration;
		$this->_record =& $record;
		
		$this->_table = "dr_file";
		$this->_idColumn = "id";
		$this->_widthColumn = 'width';
		$this->_heightColumn = 'height';
		$idManager =& Services::getService("Id");
		$this->_dataPartStructId =& $idManager->getId("FILE_DATA");
		$this->_mimeTypePartStructId =& $idManager->getId("MIME_TYPE");
		
		// Set our dimensions to NULL, so that we can know if it has not been checked
		// for yet. If we search for info, but don't have any, or the dimensions is
		// an empty string, it will have value FALSE instead of NULL
		$this->_dimensions = NULL;
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
		$partStructureId =& $this->_partStructure->getId();
		return $idManager->getId($this->_recordId->getIdString()
					."-".$partStructureId->getIdString());
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
	function &createPart(& $partStructuretId, & $value) {
		throwError(
			new Error(UNIMPLEMENTED, "HarmoniPart", true));
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
		// If we don't have the dimensions, fetch the mime type and data and try to
		// populate the dimensions if appropriate.
		if ($this->_dimensions === NULL) {
			$dbHandler =& Services::getService("DatabaseManager");
			
			$query =& new SelectQuery;
			$query->addTable($this->_table);
			$query->addColumn($this->_widthColumn);
			$query->addColumn($this->_heightColumn);
			$query->addColumn("(height IS NOT NULL AND width IS NOT NULL)",
				"dimensions_exist");
			$query->addWhere($this->_idColumn." = '".$this->_recordId->getIdString()."'");
			
			$result =& $dbHandler->query($query, 
				$this->_configuration->getProperty("database_index"));
			
			if ($result->getNumberOfRows() == 0) {
				$this->_dimensions = FALSE;
			} else if ($result->field("dimensions_exist") == false) {
				// Get the MIME type
				$mimeTypeParts =& $this->_record->getPartsByPartStructure(
					$this->_mimeTypePartStructId);
				$mimeTypePart =& $mimeTypeParts->next();
				$mimeType = $mimeTypePart->getValue();
				
				// Only try to get dimensions from image files
				if (ereg("^image.*$", $mimeType)) {					
					$dataParts =& $this->_record->getPartsByPartStructure(
						$this->_dataPartStructId);
					$dataPart =& $dataParts->next();
					$this->_dimensions = 
						GetDataImageSize($dataPart->getValue());
					if (isset($this->_dimensions[2]))
						unset($this->_dimensions[2]);
					$this->updateValue($this->_dimensions);
				} else
					$this->_dimensions = FALSE;
			} else {
				$this->_width = $result->field($this->_widthColumn);
				$this->_height = $result->field($this->_heightColumn);
				$this->_dimensions = array($this->_width, $this->_height);
			}
			$result->free();
		}
		
		return $this->_dimensions;
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
		if (is_array($value)) {
			$this->_dimensions = $value;
			
			$dbHandler =& Services::getService("DatabaseManager");

			$query =& new SelectQuery;
			$query->addTable($this->_table);
			$query->addColumn("COUNT(*)", "count");
			$query->addWhere($this->_idColumn." = '".$this->_recordId->getIdString()."'");
			
			$result =& $dbHandler->query($query, 
				$this->_configuration->getProperty("database_index"));
			
			if ($result->field("count") > 0) {
				$query =& new UpdateQuery;
				$query->setTable($this->_table);
				$query->setColumns(array($this->_widthColumn, $this->_heightColumn));
				$query->setValues(array("'".$this->_dimensions[0]."'",
					"'".$this->_dimensions[1]."'"));
				$query->addWhere($this->_idColumn." = '".$this->_recordId->getIdString()."'");
			} else {
				$query =& new InsertQuery;
				$query->setTable($this->_table);
				$query->setColumns(array($this->_idColumn, $this->_widthColumn, $this->_heightColumn));
				$query->setValues(array("'".$this->_recordId->getIdString()."'",
					"'".$this->_dimensions[0]."'",
					"'".$this->_dimensions[1]."'"));
			}
			$result->free();
			
			$dbHandler->query($query, 
				$this->_configuration->getProperty("database_index"));
		}
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
	
	/**
	 * Allow the file record to update the fetch from its own queries
	 * 
	 * @param array $value
	 * @return void
	 * @access private
	 * @since 11/17/05
	 */
	function _updateValue ( $value ) {
		if ($value[0] && $value[1]) {
			$this->_dimensions = $value;
			$this->_width = $value[0];
			$this->_height = $value[1];
		}		
	}
}
