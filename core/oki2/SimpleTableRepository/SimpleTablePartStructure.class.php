<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTablePartStructure.class.php,v 1.2 2008/02/06 15:37:45 adamfranco Exp $
 */ 

/**
 * A simple PartStructure
 * 
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTablePartStructure.class.php,v 1.2 2008/02/06 15:37:45 adamfranco Exp $
 */
class SimpleTablePartStructure
	implements PartStructure
{
	
	/**
	 * @var object Id $id;  
	 * @access private
	 * @since 10/4/07
	 */
	private $id;
	
	/**
	 * @var string $displayName;  
	 * @access private
	 * @since 10/4/07
	 */
	private $displayName;
	
	/**
	 * @var string $description;  
	 * @access private
	 * @since 10/4/07
	 */
	private $description;
	
	/**
	 * @var boolean $isMandatory;  
	 * @access private
	 * @since 10/4/07
	 */
	private $isMandatory;
	
	/**
	 * @var boolean $isRepeatable;  
	 * @access private
	 * @since 10/4/07
	 */
	private $isRepeatable;
	
	/**
	 * Constructor
	 * 
	 * @param object Id $id
	 * @param string $displayName
	 * @param string $description
	 * @param boolean $isMandatory
	 * @param boolean $isRepeatable
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __construct (Id $id, $displayName, $description, $isMandatory, $isRepeatable) {
		$this->id = $id;
		$this->displayName = $displayName;
		$this->description = $description;
		
		if ($isMandatory)
			$this->isMandatory = true;
		else
			$this->isMandatory = false;
			
		if ($isRepeatable)
			$this->isRepeatable = true;
		else
			$this->isRepeatable = false;
		
	}
	
	/**
	 * Set the record structure. Only used inside of the implementation
	 * 
	 * @param object SimpleTableRecordStructure $recordStructure
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function setRecordStructure (SimpleTableRecordStructure $recordStructure) {
		$this->recordStructure = $recordStructure;
	}
	
	/**
	 * Update the display name for this PartStructure.
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
	function updateDisplayName ( $displayName ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the display name for this PartStructure.
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
	function getDisplayName () { 
		return $this->displayName;
	} 
	
	/**
	 * Get the description for this PartStructure.
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
	function getDescription () { 
		return $this->description;
	} 
	
	/**
	 * Get the unique Id for this PartStructure.
	 *  
	 * @return object Id
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
	function getId () { 
		return $this->id;
	} 
	
	/**
	 * Get the Type for this PartStructure.
	 *  
	 * @return object Type
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
	function getType () { 
		return new Type('PartStructures', 'edu.middlebury', 'string');
	} 
	
	/**
	 * Return true if this PartStructure is automatically populated by the
	 * Repository; false otherwise.  Examples of the kind of PartStructures
	 * that might be populated are a time-stamp or the Agent setting the data.
	 *  
	 * @return boolean
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
	function isPopulatedByRepository () { 
		return false;
	} 
	
	/**
	 * Return true if this PartStructure is mandatory; false otherwise.
	 *  
	 * @return boolean
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
	function isMandatory () { 
		return $this->isMandatory;
	} 
	
	/**
	 * Return true if this PartStructure is repeatable; false otherwise. This
	 * is determined by the implementation.
	 *  
	 * @return boolean
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
	function isRepeatable () { 
		return $this->isRepeatable;
	} 
	
	/**
	 * Get the RecordStructure associated with this PartStructure.
	 *  
	 * @return object RecordStructure
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
	function getRecordStructure () {
		if (!isset($this->recordStructure))
			throw new OperationFailedException();
			
		return $this->recordStructure;
	} 
	
	/**
	 * Get all the PartStructures in the PartStructure.  Iterators return a
	 * set, one at a time.
	 *  
	 * @return object PartStructureIterator
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
	function getPartStructures () { 
		return new HarmoniIterator(array());
	} 
	
	/**
	 * Validate a Part against its PartStructure.  Return true if valid; false
	 * otherwise.  The status of the Asset holding this Record is not changed
	 * through this method.  The implementation may throw an Exception for any
	 * validation failures and use the Exception's message to identify
	 * specific causes.
	 * 
	 * @param object Part $part
	 *  
	 * @return boolean
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
	function validatePart ( Part $part ) { 
		throw new UnimplementedException();
	} 
}

?>