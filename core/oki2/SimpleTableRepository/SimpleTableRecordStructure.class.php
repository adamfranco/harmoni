<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableRecordStructure.class.php,v 1.3 2008/02/06 15:37:45 adamfranco Exp $
 */ 

/**
 * A simple Record Structure
 * 
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableRecordStructure.class.php,v 1.3 2008/02/06 15:37:45 adamfranco Exp $
 */
class SimpleTableRecordStructure
	implements RecordStructure
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
	 * @var string $format;  
	 * @access private
	 * @since 10/4/07
	 */
	private $format;
	
	/**
	 * @var array $partStructures;  
	 * @access private
	 * @since 10/4/07
	 */
	private $partStructures;
	
	/**
	 * Constructor
	 * 
	 * @param object Id $id
	 * @param string $displayName
	 * @param string $description
	 * @param string $format
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __construct (Id $id, $displayName, $description, $format) {
		$this->id = $id;
		$this->displayName = $displayName;
		$this->description = $description;
		$this->format = $format;
		
		$this->partStructures = array();
	}
	
	/**
	 * Add a part structure
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param object SimpleTablePartStructure $partStructure
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function addPartStructure (SimpleTablePartStructure $partStructure) {
		$partStructure->setRecordStructure($this);
		$this->partStructures[$partStructure->getId()->getIdString()] = $partStructure;
	}
	
	/**
	 * Update the display name for this RecordStructure.
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
	 *         UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function updateDisplayName ( $displayName ) { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the display name for this RecordStructure.
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
	 * Get the description for this RecordStructure.
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
	 * Get the unique Id for this RecordStructure.
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
	 * Get the Type for this RecordStructure.
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
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the schema for this RecordStructure.  The schema is defined by the
	 * implementation, e.g. Dublin Core.
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
	function getSchema () { 
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the format for this RecordStructure.  The format is defined by the
	 * implementation, e.g. XML.
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
	function getFormat () { 
		return $this->format;
	} 
	
	/**
	 * Return true if this RecordStructure is repeatable; false otherwise.
	 * This is determined by the implementation.
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
		return false;
	} 
	
	/**
	 * Get the PartStructure in the RecordStructure with the specified Id.
	 * @param object $infoPartId
	 * @return object PartStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getPartStructure(Id $partStructureId) {
		if (!isset($this->partStructures[$partStructureId->getIdString()]))
			throw new UnknownIdException("<strong>".$partStructureId->getIdString()."</strong> was not found in <strong>".implode(", ", array_keys($this->partStructures))."</strong>.");
		
		return $this->partStructures[$partStructureId->getIdString()];
	}
	
	/**
	 * Get all the PartStructures in the RecordStructure.  Iterators return a
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
		return new HarmoniIterator($this->partStructures);
	} 
	
	/**
	 * Validate a Record against its RecordStructure.  Return true if valid;
	 * false otherwise.  The status of the Asset holding this Record is not
	 * changed through this method.  The implementation may throw an Exception
	 * for any validation failures and use the Exception's message to identify
	 * specific causes.
	 * 
	 * @param object Record $record
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
	function validateRecord ( Record $record ) { 
		throw new UnimplementedException();
	} 

}

?>