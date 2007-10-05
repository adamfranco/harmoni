<?php
/**
 * @since 10/4/07
 * @package harmoni.osid_v2.simple_table_repository
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SimpleTableRecord.class.php,v 1.1 2007/10/05 14:02:56 adamfranco Exp $
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
 * @version $Id: SimpleTableRecord.class.php,v 1.1 2007/10/05 14:02:56 adamfranco Exp $
 */
class SimpleTableRecord
	extends RecordInterface
	// implements Record
{

	/**
	 * @var object $idMgr;  
	 * @access public
	 * @since 10/4/07
	 */
	public $idMgr;
	
	/**
	 * Constructor
	 * 
	 * @param object SimpleTableRecordStructure $recordStructure
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function __construct ($idMgr, SimpleTableRecordStructure $recordStructure) {
		$this->idMgr = $idMgr;
		$this->recordStructure = $recordStructure;
	}
	
	/**
	 * Add a part to this record. Used only in the implementation.
	 * 
	 * @param object SimpleTablePart $part
	 * @return void
	 * @access public
	 * @since 10/4/07
	 */
	public function addPart (SimpleTablePart $part) {
		$struct = $part->getPartStructure();
		if (!$this->recordStructure->getId()->isEqual($struct->getRecordStructure()->getId()))
			throw new ConfigurationErrorException ("Invalid part to add to this record.");
		
		if (!isset($this->partsByPartStructure[$struct->getId()->getIdString()]))
			$this->partsByPartStructure[$struct->getId()->getIdString()] = array();
		
		$part->setRecord($this);
		
		$part->setId($this->idMgr->getId(
			$struct->getId()->getIdString().".".count($this->partsByPartStructure[$struct->getId()->getIdString()])));
		
		$this->parts[$part->getId()->getIdString()] = $part;
		
		$this->partsByPartStructure[$struct->getId()->getIdString()][] = $part;
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
	function updateDisplayName ( $displayName ) {
		throw new UnimplementedException();
	} 
	
	/**
	 * Get the display name for this Record.
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
		return $this->recordStructure->getDisplayName()." - 1";
	} 
	
	/**
	 * Get the unique Id for this Record.
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
		return $this->idMgr->getId($this->recordStructure->getId()->getIdString()."-1");
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
	 * Get all the Parts in the Record.  Iterators return a set, one at a time.
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
		return new HarmoniIterator($this->parts);
	} 
	
	/**
	 * Get the part from the record that matches the passed Id
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @param object HarmoniId
	 * @return object HarmoniPart
	 * @access public
	 * @since 10/10/05
	 */
	function getPart ($id) {
		if (!isset($this->parts[$id->getIdString()]))
			throw new UnknownIdException();
		return $this->parts[$id->getIdString()];
	}
	
	/**
     * Get the Parts of the Records for this Asset that are based on this
     * RecordStructure PartStructure's unique Id.
     *
     * WARNING: NOT IN OSID (as of July 2005)
     * 
     * @param object Id $partStructureId
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
     *         UNIMPLEMENTED}, {@link
     *         org.osid.repository.RepositoryException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.repository.RepositoryException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    function getPartsByPartStructure ( $partStructureId ) {
    	if (!isset($this->partsByPartStructure[$partStructureId->getIdString()]))
    		return new HarmoniIterator(array());
    	return new HarmoniIterator($this->partsByPartStructure[$partStructureId->getIdString()]);
    }
	
	/**
	 * Get the RecordStructure associated with this Record.
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
		return $this->recordStructure;
	} 
	
}

?>