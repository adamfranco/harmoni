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
 * @version $Id: ThumbnailDataPart.class.php,v 1.11 2007/09/04 20:25:47 adamfranco Exp $
 */
class ThumbnailDataPart extends Part
//	extends java.io.Serializable
{

	var $_recordId;
	var $_partStructure;
	var $_data;
	
	function ThumbnailDataPart( $partStructure, $recordId, $configuration, $asset ) {
		$this->_recordId =$recordId;
		$this->_partStructure =$partStructure;
		$this->_configuration = $configuration;
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
		return $idManager->getId($this->_recordId->getIdString()."-THUMBNAIL_DATA");
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
			$query->addTable("dr_thumbnail");
			$query->addColumn("data");
			$query->addWhere("FK_file = '".$this->_recordId->getIdString()."'");
			
			$result =$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
			
			// If no data was found, return an empty string.
			if ($result->getNumberOfRows() == 0)
				$data = "";
				//$this->_data = "";
			else
				$data = base64_decode($result->field("data"));
				//$this->_data = base64_decode($result->field("data"));
			$result->free();
//		}
		
		return $data;// $this->_data;
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
		
		// Store the data in the object in case its asked for again.
//		$this->_data = $value;
		
	// Base64 encode the data to preserve it,
	// then write it to the database.
		$dbHandler = Services::getService("DatabaseManager");
	
		// Check to see if the data is in the database
		$query = new SelectQuery;
		$query->addTable("dr_thumbnail");
		$query->addColumn("COUNT(*) as count");
		$query->addWhere("FK_file = '".$this->_recordId->getIdString()."'");
		$result =$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
		// If it already exists, use an update query.
		if ($result->field("count") > 0) {
			$query = new UpdateQuery;
			$query->setTable("dr_thumbnail");
			$query->setColumns(array("data"));
			$query->setValues(array("'".base64_encode($value)."'"));
			$query->addWhere("FK_file = '".$this->_recordId->getIdString()."'");
		}
		// If it doesn't exist, use an insert query.
		else {
			$query = new InsertQuery;
			$query->setTable("dr_thumbnail");
			$query->setColumns(array("FK_file","data"));
			$query->setValues(array("'".$this->_recordId->getIdString()."'",
									"'".base64_encode($value)."'"));
		}
		$result->free();
//		printpre($query);
//		printpre(MySQL_SQLGenerator::generateSQLQuery($query));
		
		// run the query
		$dbHandler->query($query, $this->_configuration->getProperty("database_index"));
		
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
