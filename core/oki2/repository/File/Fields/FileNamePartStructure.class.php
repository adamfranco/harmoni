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
 * @version $Id: FileNamePartStructure.class.php,v 1.9 2008/02/06 15:37:53 adamfranco Exp $ 
 */
class FileNamePartStructure 
	implements PartStructure
//	extends java.io.Serializable
{

	var $_partStructure;
	
	function FileNamePartStructure($recordStructure) {
		$this->_recordStructure =$recordStructure;
	}
	
	/**
	 * Get the display name for this PartStructure.
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
		return "File Name";
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
	 * Get the description for this PartStructure.
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
		return "The name of the file.";
	}
	
	/**
	 * Get the Type for this PartStructure.
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
	function getType() {
		if (!isset($this->_type)) {
			$this->_type = new HarmoniType("Repository", "edu.middlebury.harmoni", "string");
		}
		
		return $this->_type;
	}

	/**
	 * Get the unique Id for this PartStructure.
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
		return $idManager->getId("FILE_NAME");
	}

	/**
	 * Get all the PartStructures in the PartStructure.	 Iterators return a
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
	function getPartStructures() {
		$array = array();
		$obj = new HarmoniNodeIterator($array);
		return $obj; // @todo replace with HarmoniPartStructureIterator
	}

	/**
	 * Return true if this PartStructure is automatically populated by the
	 * Repository; false otherwise.	 Examples of the kind of PartStructures
	 * that might be populated are a time-stamp or the Agent setting the data.
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
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function isPopulatedByRepository() {
		return FALSE;
	}

	/**
	 * Return true if this PartStructure is mandatory; false otherwise.
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
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function isMandatory() {
		return TRUE;
	}

	/**
	 * Return true if this PartStructure is repeatable; false otherwise. This
	 * is determined by the implementation.
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
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function isRepeatable() {
		return FALSE;
	}

	/**
	 * Get the RecordStructure associated with this PartStructure.
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
	 * Validate a Part against its PartStructure.  Return true if valid; false
	 * otherwise.  The status of the Asset holding this Record is not changed
	 * through this method.	 The implementation may throw an Exception for any
	 * validation failures and use the Exception's message to identify
	 * specific causes.
	 * 
	 * @param object Part $part
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
	function validatePart(Part $part) {
		// we can check if the Part (ie, ValueVersions) has values of the right type.
		// @todo
		
		return true;
	}

/*********************************************************
 * Authority Lists:
 *	The OSID does not have any support for authority lists.
 * 	These methods could have been placed in another system,
 * 	but have been placed here for ease of locating them.
 * 	Also involved with Authority Lists is a SearchType:
 * 		Repository::edu.middlebury.harmoni::AuthorityValue
 *	which takes a PartStructure Id and a Value to search on.
 *********************************************************/
	
	/**
	 * Answer the authoritative values for this part.
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @return object ObjectIterator
	 * @access public
	 * @since 4/25/06
	 */
	function getAuthoritativeValues () {
		$array = array();
		$iterator = new HarmoniIterator($array);
		return $iterator;
	}
	
	/**
	 * Answer true if the value pass is authoritative.
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @param object $value
	 * @return boolean
	 * @access public
	 * @since 4/25/06
	 */
	function isAuthoritativeValue ( $value ) {
		return false;	
	}
	
	/**
	 * Remove an authoritative value.
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @param object $value
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function removeAuthoritativeValue ( $value ) {
	}
	
	/**
	 * Add an authoritative value
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @param object $value
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function addAuthoritativeValue ( $value ) {
		$false = false;
		return $false;
	}
	
	/**
	 * Add an authoritative value
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @param string $valueString
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function addAuthoritativeValueAsString ( $valueString ) {
	}
	
	/**
	 * Answer the Primative object appropriate for this part, whose value is
	 * represented by the input string.
	 * 
	 * @param string $valueString
	 * @return object
	 * @access public
	 * @since 4/27/06
	 */
	function createValueObjectFromString ( $valueString ) {
		$false = false;
		return $false;
	}
}
