<?

require_once(OKI2."/osid/repository/Record.php");
require_once(HARMONI."/oki2/repository/HarmoniPart.class.php");
require_once(HARMONI."/oki2/repository/HarmoniPartIterator.class.php");


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
 * @version $Id: HarmoniRecord.class.php,v 1.13 2005/07/18 14:45:26 gabeschine Exp $ 
 */

class HarmoniRecord 
	extends RecordInterface
{
	
	var $_record;
	var $_recordStructure;
	
	var $_createdParts;
	
	function HarmoniRecord( &$recordStructure, & $record ) {
		$this->_record=& $record;
		$this->_recordStructure =& $recordStructure;
		
		$this->_createdParts = array();
	}
 /**
	 * Get the unique Id for this Record.
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
	function &getId () { 
		$idManager =& Services::getService("Id");
		$id = $this->_record->getID();
		return $idManager->getId($id);
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
	function &createPart ( &$partStructureId, &$value ) { 
		ArgumentValidator::validate($value, ExtendsValidatorRule::getRule("SObject"));
		$partID = $partStructureId->getIdString();
		
		// we need to find the label associated with this ID
		$schema =& $this->_record->getSchema();
		foreach ($schema->getAllIDs() as $id) {
			$part =& $schema->getField($id);
			if ($partID == $id) break;
		}
		$label = $schema->getFieldLabelFromID($id);
		$this->_record->makeFull(); // make sure we have a full data representation.
		// If the value is deleted, add a new version to it.
		if ($this->_record->numValues($label, true) && $this->_record->isValueDeleted($label)) {
			$this->_record->undeleteValue($label);
			$this->_record->setValue($label, $value);
		
		// If the field is not multi-valued AND has a value AND that value is not deleted, 
		// throw an error.
		} else if (!$part->getMultFlag() 
			&& $this->_record->numValues($label) 
			&& $this->_record->getCurrentValue($label)) {
			
			throwError(new Error(RepositoryException::PERMISSION_DENIED().": Can't add another field to a
			non-multi-valued part.", "HarmoniRecord", true));
		
		// If we dont' have an existing, deleted field to add to, create a new index.
		} else {
			$this->_record->setValue($label, $value, NEW_VALUE);
		}
			
		$this->_record->commit(TRUE);
		
		return new HarmoniPart(new HarmoniPart($this->_recordStructure, $field),
			$this->_record->getRecordFieldValue($label, $this->_record->numValues($label)-1));
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
	function deletePart ( &$partId ) { 
		$string = $partId->getIdString();
		if (ereg("([0-9]+)::(.+)::([0-9]+)",$string,$r)) {
			$recordId = $r[1];
			$label = $r[2];
			$index = $r[3];
			
			if ($this->_record->getID() == $recordId) {
				$this->_record->deleteValue($label, $index);
				$this->_record->commit(TRUE);
			}
		} else {
			throwError(new Error(RepositoryException::UNKNOWN_ID().": $string", "HarmoniPart", true));
		}
	}

	/**
	 * Get all the Parts in the Record.	 Iterators return a set, one at a time.
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
	function &getParts () { 
		// Get all of the PartStructures in this structure
		$partStructures =& $this->_recordStructure->getPartStructures();
		while ($partStructures->hasNext()) {
			$partStructure =& $partStructures->next();
			$id = $partStructure->getId();
			$idString = $id->getIdString();
			$allRecordFieldValues =& $this->_record->getRecordFieldValues($idString);
			// Create an Part for each valueVersionObj
			if (count($allRecordFieldValues)) {
				foreach (array_keys($allRecordFieldValues) as $key) {
					if ($activeValue =& $allRecordFieldValues[$key]->getActiveVersion()
						&& !isset($this->_createdParts[$activeValue->getID()]))
						$this->_createdParts[$activeValue->getID()] =& new HarmoniPart(
													$partStructure, $allRecordFieldValues[$key]);
				}
			}
		}
		
		// Create an iterator and return it.
		$partIterator =& new HarmoniPartIterator($this->_createdParts);
		
		return $partIterator;
	}

	/**
	 * Return true if this Record is multi-valued; false otherwise.	 This is determined by the implementation.
	 * 
	 * WARNING: NOT IN OSID
	 *
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function isMultivalued() {
		return true; // we allow as many Records of any RecordStructure as people want.
	}

	/**
	 * Get the RecordStructure associated with this Record.
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
	function &getRecordStructure () { 
		return $this->_recordStructure;
	}
}
