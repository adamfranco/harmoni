<?

require_once(HARMONI."/oki/dr/HarmoniInfoField.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoFieldIterator.class.php");

	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package harmoni.osid.dr
	 */
class HarmoniInfoRecord extends InfoRecord
//	extends java.io.Serializable
{
	
	var $_dataSet;
	var $_infoStructure;
	
	var $_createdInfoFields;
	
	function HarmoniInfoRecord( &$infoStructure, & $dataSet ) {
		$this->_dataSet=& $dataSet;
		$this->_infoStructure =& $infoStructure;
		
		$this->_createdInfoFields = array();
	}

	/**
	 * Get the Unique Id for this InfoRecord.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.dr
	 */
	function & getId() {
		$sharedManager =& Services::getService("Shared");
		$id = $this->_dataSet->getID();
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
	function & createInfoField(& $infoPartId, & $value) {
		$fieldID = $infoPartId->getIdString();
		
		// we need to find the label associated with this ID
		$typeDef =& $this->_dataSet->getDataSetTypeDefinition();
		foreach ($typeDef->getAllLabels() as $label) {
			$fieldDef =& $typeDef->getFieldDefinition($label);
			if ($fieldID == $fieldDef->getID()) break;
		}
		
		$fieldType =& $fieldDef->getType();
		$class = $fieldType."DataType";
		$valueObj =& new $class($value);
		
		
		// If the value is deleted, add a new version to it.
		if ($this->_dataSet->numValues($label) && $this->_dataSet->deleted($label)) {
			$this->_dataSet->undeleteValue($label);
			$this->_dataSet->setValue($label, $valueObj);
		
		// If the field is not multi-valued AND has a value AND that value is not deleted, 
		// throw an error.
		} else if (!$fieldDef->getMultFlag() && $this->_dataSet->numValues($label) && $this->_dataSet->getActiveValue($label)) {
			throwError(new Error(PERMISSION_DENIED.": Can't add another field to a
			non-multi-valued part.", "HarmoniInfoRecord", true));
		
		// If we dont' have an existing, deleted field to add to, create a new index.
		} else {
			$this->_dataSet->setValue($label, $valueObj, NEW_VALUE);
		}
			
		$this->_dataSet->commit();
		
		return new HarmoniInfoField(new HarmoniInfoPart($this->_infoStructure, $fieldDef),
			$this->_dataSet->getValueVersionsObject($label, $this->_dataSet->numValues($label)-1));
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
			$dataSetId = $r[1];
			$label = $r[2];
			$index = $r[3];
			
			$this->_dataSet->deleteValue($label, $index);
			$this->_dataSet->commit();
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
	function & getInfoFields() {
		// Get all of the InfoParts in this structure
		$infoParts =& $this->_infoStructure->getInfoParts();
		while ($infoParts->hasNext()) {
			$infoPart =& $infoParts->next();
			$allValueVersions =& $this->_dataSet->getAllValueVersionsObjects($infoPart->getDisplayName());
			// Create an InfoField for each valueVersionObj
			if (count($allValueVersions)) {
				foreach ($allValueVersions as $key => $valueVersion) {
					if ($activeValue =& $allValueVersions[$key]->getActiveVersion()
						&& !$this->_createdInfoFields[$activeValue->getId()])
						$this->_createdInfoFields[$activeValue->getId()] =& new HarmoniInfoField(
													$infoPart, $allValueVersions[$key]);
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
