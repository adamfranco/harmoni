<?

/**
 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 *
 * @package harmoni.osid_v1.dr
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniInfoPart.class.php,v 1.13 2005/01/19 23:23:05 adamfranco Exp $
 */
class HarmoniInfoPart extends InfoPart
//	extends java.io.Serializable
{

	var $_schemaField;
	var $_infoStructure;
	
	function HarmoniInfoPart(&$infoStructure, &$schemaField) {
		$this->_schemaField =& $schemaField;
		$this->_infoStructure =& $infoStructure;
	}
	
	/**
	 * Get the name for this InfoPart.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() {
		return $this->_schemaField->getLabel();
	}

	/**
	 * Get the description for this InfoPart.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() {
		if ($desc = $this->_schemaField->getDescription()) return $desc;
		return "A HarmoniDataManager field of type '".$this->_schemaField->getType()."'.";
	}
	
	/**
	 * Get the type for this InfoPart
	 *
	 * WARNING!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * This method is not part of the OSID, but we
	 * have submitted a proposal for its addition.
	 * Use at your own risk.
	 * /WARNING
	 *
	 * @return object Type
	 */
	function &getType() {
		if (!isset($this->_type)) {
			$type = $this->_schemaField->getType();
			$this->_type =& new HarmoniType("DR", "Harmoni", $type);
		}
		
		return $this->_type;
	}

	/**
	 * Get the Unique Id for this InfoPart.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() {
		$sharedManager =& Services::getService("Shared");
		return $sharedManager->getId(
			$this->_infoStructure->_schema->getFieldID(
				$this->_schemaField->getLabel()
			)
		);
	}

	/**
	 * Get all the InfoParts in the InfoPart.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoPartIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoParts() {
		$array = array();
		return new HarmoniNodeIterator($array); // @todo replace with HarmoniInfoPartIterator
	}

	/**
	 * Return true if this InfoPart is automatically populated by the DigitalRepository; false otherwise.  Examples of the kind of InfoParts that might be populated are a time-stamp or the Agent setting the data.
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function isPopulatedByDR() {
		return false;
	}

	/**
	 * Return true if this InfoPart is mandatory; false otherwise.
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function isMandatory() {
		return $this->_schemaField->isRequired();
	}

	/**
	 * Return true if this InfoPart is repeatable; false otherwise.
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function isRepeatable() {
		return $this->_schemaField->getMultFlag();
	}

	/**
	 * Get the InfoPart associated with this InfoStructure.
	 * @return object InfoStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoStructure() {
		return $this->_infoStructure;
	}

	/**
	 * Validate an InfoField against its InfoPart.  Return true if valid; false otherwise.  The status of the Asset holding this InfoRecord is not changed through this method.  The implementation may throw an Exception for any validation failures and use the Exception's message to identify specific causes.
	 * @param object infoField
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function validateInfoField(& $infoField) {
		// we can check if the infoField (ie, ValueVersions) has values of the right type.
		// @todo
		
		return true;
	}
	// :: full java declaration :: public boolean validateInfoField(InfoField infoField)
}
