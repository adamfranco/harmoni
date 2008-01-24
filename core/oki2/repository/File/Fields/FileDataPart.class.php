<?php

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
 * @version $Id: FileDataPart.class.php,v 1.15 2008/01/24 19:09:29 adamfranco Exp $
 */
 
class FileDataPart 
	extends Part 
{

	var $_recordId;
	var $_partStructure;
	var $_data;
	
	function FileDataPart( $partStructure, $recordId, $configuration, $asset ) {
		$this->_recordId =$recordId;
		$this->_partStructure =$partStructure;
		$this->_configuration =$configuration;
		$this->_asset =$asset;
		
		// Set our data to NULL, so that we can know if it has not been checked
		// for yet. If we search for data, but don't have any, or the data is
		// an empty string, it will have value "" instead of NULL
		$this->_data = NULL;
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
	function getId() {
		$idManager = Services::getService("Id");
		return $idManager->getId($this->_recordId->getIdString()."-FILE_DATA");
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
	function createPart($partStructureId, $value) {
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
	function deletePart($partId) {
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
	function getParts() {
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
		// If we don't have the data, load it from the database.
//		if ($this->_data === NULL) {
			$dbHandler = Services::getService("DatabaseManager");
			
			// Get the data from the database,
			$query = new SelectQuery;
			$query->addTable("dr_file");
			$query->addTable("dr_file_data", LEFT_JOIN, "dr_file.id = dr_file_data.fk_file");
			$query->addColumn("data");
			$query->addWhere("dr_file.id = '".$this->_recordId->getIdString()."'");
			
			$result =$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
			
			// If no data was found, return an empty string.
			if ($result->getNumberOfRows() == 0)
				$data = "";
//				$this->_data = "";
			else
				$data = base64_decode($result->field("data"));
//				$this->_data = base64_decode($result->field("data"));
			$result->free();		
//		}
		
		return $data; //this->_data;
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
//		ArgumentValidator::validate($value, StringValidatorRule::getRule());
		$dbHandler = Services::getService("DatabaseManager");
		
		// Delete the row if we are setting the value to null
		if (is_null($value)) {
			$query = new DeleteQuery;
			$query->setTable("dr_file_data");
			$query->addWhere("fk_file = '".$this->_recordId->getIdString()."'");
			$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
			
			$this->_asset->updateModificationDate();
			return;
		}
		
		// Store the data in the object in case its asked for again.
//		$this->_data = $value;

		// Make sure that the dr_file row is inserted.
		$query = new InsertQuery;
		$query->setTable("dr_file");
		$query->addValue("id", $this->_recordId->getIdString());
		try {
			$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		} catch (QueryDatabaseException $e) {
			// If an error is thrown inserting (because the file already exists)
			// ignore it.
		}
		
		$dbHandler->beginTransaction($this->_configuration->getProperty("database_index"));
	// Base64 encode the data to preserve it,
	// then write it to the database.
	
		// Check to see if the data is in the database
		$query = new SelectQuery;
		$query->addTable("dr_file_data");
		$query->addColumn("COUNT(*) as count");
		$query->addWhere("fk_file = '".$this->_recordId->getIdString()."'");
		$result =$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		// If it already exists, use an update query.
		if ($result->field("count") > 0) {
			$query = new UpdateQuery;
			$query->setTable("dr_file_data");
			$query->setColumns(array("data"));
			$query->setValues(array("'".base64_encode($value)."'"));
			$query->addWhere("fk_file = '".$this->_recordId->getIdString()."'");
		}
		// If it doesn't exist, use an insert query.
		else {
			$query = new InsertQuery;
			$query->setTable("dr_file_data");
			$query->setColumns(array("fk_file","data"));
			$query->setValues(array("'".$this->_recordId->getIdString()."'",
									"'".base64_encode($value)."'"));
		}
		$result->free();
//		printpre($query);
//		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		
		// run the query
		$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		// Update the size row.
		$query = new UpdateQuery;
		$query->setTable("dr_file");
		$query->addValue("size", strval(strlen($value)));
		$query->addWhereEqual("id", $this->_recordId->getIdString());
		$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		$dbHandler->commitTransaction($this->_configuration->getProperty("database_index"));
		
		$this->_asset->updateModificationDate();
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
	function getPartStructure() {
		return $this->_partStructure;
	}
}
