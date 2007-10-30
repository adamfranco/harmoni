<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTablePart.class.php,v 1.2 2007/10/30 16:32:47 adamfranco Exp $
 */ 

/**
 * <##>
 * 
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTablePart.class.php,v 1.2 2007/10/30 16:32:47 adamfranco Exp $
 */
class SimpleTablePart
	extends Part
	// implements Part
{
	/**
	 * @var object SimpleTablePartStructure $partStructure
	 * @access private
	 * @since 10/4/07
	 */
	private $partStructure;
	
	/**
	 * @var Id $id;  
	 * @access private
	 * @since 10/4/07
	 */
	private $id;
	
	/**
	 * @var object record $record;  
	 * @access private
	 * @since 10/4/07
	 */
	private $record;
	
	/**
	 * @var string $value;  
	 * @access private
	 * @since 10/4/07
	 */
	private $value;
	
	/**
	 * Constructor
	 * 
	 * @param object SimpleTablePartStructure $partStructure
	 * @param mixed $value
	 * @param optional string $encoding Default: UTF-8. Allowed values: UTF-8, ISO-8859-1.
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __construct (SimpleTablePartStructure $partStructure, $value, $encoding = 'UTF-8') {
		$this->partStructure = $partStructure;
		
		// Pass through numeric and non-string values
		if (!is_string($value)) {
			$this->value = $value;
			return;
		}
		
		// Pass through UTF-8 strings
		if ($encoding == 'UTF-8') {
			$this->value = $value;
			return;
		}
		
		// Convert non-UTF-8 strings to UTF-8
		$convertedValue = iconv($encoding, 'UTF-8', $value);
		
		// If conversion was a success, use the converted value.
		if ($convertedValue !== false)
			$this->value = $convertedValue;
		// If conversion failed, just use the original.
		else
			$this->value = $value;
	}
	
	/**
	 * Set the record. Used internally in the implementation.
	 * 
	 * @param SimpleTableRecord $record
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function setRecord (SimpleTableRecord $record) {
		$this->record = $record;
	}
	
	/**
	 * Set the id. Used internally in the implementation.
	 * 
	 * @param object Id $id
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function setId (Id $id) {
		$this->id = $id;
	}
	
	/**
	 * Update the display name for this Part.
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
	 * Get the unique Id for this Part.
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
		if (!isset($this->id))
			throw new OperationFailedException();
		return $this->id;
	} 
	
	/**
	 * Get the display name for this Part.
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
		return $this->partStructure->getDisplayName();
	} 
	
	/**
	 * Get the PartStructure associated with this Part.
	 *  
	 * @return object PartStructure
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
	function getPartStructure () { 
		return $this->partStructure;
	} 
	
	/**
	 * Create a Part.  Records are composed of Parts. Parts can also contain
	 * other Parts.  Each Record is associated with a specific RecordStructure
	 * and each Part is associated with a specific PartStructure.
	 * 
	 * @param object Id $partStructureId
	 * @param object mixed $value (original type: java.io.Serializable)
	 *  
	 * @return object Part
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
	function createPart ( $partStructureId, $value ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Delete a Part and all its Parts.
	 * 
	 * @param object Id $partId
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
	function deletePart ( $partId ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get all the Parts in this Part.  Iterators return a set, one at a time.
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
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getParts () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the value for this Part.
	 *  
	 * @return object mixed (original type: java.io.Serializable)
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
	function getValue () { 
		return $this->value;
	} 
	
	/**
	 * Update the value for this Part.
	 * 
	 * @param object mixed $value (original type: java.io.Serializable)
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
	function updateValue ( $value ) { 
		throw new UnimplementedException();
	} 
}

?>