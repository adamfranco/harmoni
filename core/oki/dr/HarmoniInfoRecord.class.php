<?

require_once(HARMONI."/oki/dr/HarmoniInfoField.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoFieldIterator.class.php");

/**
 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 *
 * @package harmoni.osid.dr
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniInfoRecord.class.php,v 1.16 2005/01/19 21:10:07 adamfranco Exp $ */
class HarmoniInfoRecord extends InfoRecord
//	extends java.io.Serializable
{
	
	var $_record;
	var $_infoStructure;
	
	var $_createdInfoFields;
	
	function HarmoniInfoRecord( &$infoStructure, & $record ) {
		$this->_record=& $record;
		$this->_infoStructure =& $infoStructure;
		
		$this->_createdInfoFields = array();
	}

	/**
	 * Get the Unique Id for this InfoRecord.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getId() {
		$sharedManager =& Services::getService("Shared");
		$id = $this->_record->getID();
		return $sharedManager->getId($id);
	}

	/**
	 * Create an InfoField.  InfoRecords are composed of InfoFields. InfoFields can also contain other InfoFields.  Each InfoRecord is associated with a specific InfoStructure and each InfoField is associated with a specific InfoPart.
	 * @param object infoPartId
	 * @param mixed value
	 * @return object InfoField
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function &createInfoField(& $infoPartId, & $value) {
		ArgumentValidator::validate($value, new ExtendsValidatorRule("Primitive"));
		$fieldID = $infoPartId->getIdString();
		
		// we need to find the label associated with this ID
		$schema =& $this->_record->getSchema();
		foreach ($schema->getAllLabels() as $label) {
			$field =& $schema->getField($label);
			if ($fieldID == $schema->getFieldID($label)) break;
		}
		$this->_record->makeFull(); // make sure we have a full data representation.
		// If the value is deleted, add a new version to it.
		if ($this->_record->numValues($label) && $this->_record->deleted($label)) {
			$this->_record->undeleteValue($label);
			$this->_record->setValue($label, $value);
		
		// If the field is not multi-valued AND has a value AND that value is not deleted, 
		// throw an error.
		} else if (!$field->getMultFlag() 
			&& $this->_record->numValues($label) 
			&& $this->_record->getCurrentValue($label)) {
			
			throwError(new Error(PERMISSION_DENIED.": Can't add another field to a
			non-multi-valued part.", "HarmoniInfoRecord", true));
		
		// If we dont' have an existing, deleted field to add to, create a new index.
		} else {
			$this->_record->setValue($label, $value, NEW_VALUE);
		}
			
		$this->_record->commit(TRUE);
		
		return new HarmoniInfoField(new HarmoniInfoPart($this->_infoStructure, $field),
			$this->_record->getRecordFieldValue($label, $this->_record->numValues($label)-1));
	}

	/**
	 * Delete an InfoField and all its InfoFields.
	 * @param object infoFieldId
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following 
	 * messages defined in osid.dr.DigitalRepositoryException may be thrown: 
	 * {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link DigitalRepositoryException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.dr
	 */
	function deleteInfoField(& $infoFieldId) {
		$string = $infoFieldId->getIdString();
		if (ereg("([0-9]+)::(.+)::([0-9]+)",$string,$r)) {
			$recordId = $r[1];
			$label = $r[2];
			$index = $r[3];
			
			$this->_record->deleteValue($label, $index);
			$this->_record->commit(TRUE);
		} else {
			throwError(new Error(UNKNOWN_ID.": $string", "HarmoniInfoField", true));
		}
	}

	/**
	 * Get all the InfoFields in the InfoRecord.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoFieldIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getInfoFields() {
		// Get all of the InfoParts in this structure
		$infoParts =& $this->_infoStructure->getInfoParts();
		while ($infoParts->hasNext()) {
			$infoPart =& $infoParts->next();
			$allRecordFieldValues =& $this->_record->getAllRecordFieldValues($infoPart->getDisplayName());
			// Create an InfoField for each valueVersionObj
			if (count($allRecordFieldValues)) {
				foreach (array_keys($allRecordFieldValues) as $key) {
					if ($activeValue =& $allRecordFieldValues[$key]->getActiveVersion()
						&& !$this->_createdInfoFields[$activeValue->getId()])
						$this->_createdInfoFields[$activeValue->getId()] =& new HarmoniInfoField(
													$infoPart, $allRecordFieldValues[$key]);
				}
			}
		}
		
		// Create an iterator and return it.
		$fieldIterator =& new HarmoniInfoFieldIterator($this->_createdInfoFields);
		
		return $fieldIterator;
	}

	/**
	 * Return true if this InfoRecord is multi-valued; false otherwise.  This is determined by the implementation.
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function isMultivalued() {
		return true; // we allow as many InfoRecords of any InfoStructure as people want.
	}

	/**
	 * Get the InfoStructure associated with this InfoRecord.
	 * @return object InfoStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function &getInfoStructure() {
		return $this->_infoStructure;
	}
}
