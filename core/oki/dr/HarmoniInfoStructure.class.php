<?

require_once(HARMONI."/oki/dr/HarmoniInfoPart.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoPartIterator.class.php");

	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dr
	 */
class HarmoniInfoStructure extends InfoStructure
//	extends java.io.Serializable
{
	
	var $_typeDef;
	var $_createdInfoParts;
	
	function HarmoniInfoStructure( &$dataSetTypeDef ) {
		$this->_typeDef =& $dataSetTypeDef;
		
		// create an array of created InfoParts so we can return references to
		// them instead of always making new ones.
		$this->_createdInfoParts = array();
	}
	
	/**
	 * Get the name for this InfoStructure.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function getDisplayName() {
		$type =& $this->_typeDef->getType();
		
		return $type->getKeyword();
	}

	/**
	 * Get the description for this InfoStructure.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function getDescription() {
		$type =& $this->_typeDef->getType();
		
		return $type->getDescription();
	}

	/**
	 * Get the Unique Id for this InfoStructure.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getId() {
		$sharedManager =& Services::getService("Shared");
		return $sharedManager->getId($this->_typeDef->getID());
	}

	/**
	 * Get all the InfoParts in the InfoStructure.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return InfoPartIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function & getInfoParts() {
		$this->_typeDef->load();
		$array = array();
		foreach ($this->_typeDef->getAllLabels() as $label) {
			$array[] = new HarmoniInfoPart($this, $this->_typeDef->getFieldDefinition($label));
		}
		
		return new HarmoniInfoPartIterator($array);
	}
	// :: full java declaration :: public InfoPartIterator getInfoParts()

	/**
	 * Get the schema for this InfoStructure.  The schema is defined by the implementation, e.g. Dublin Core.
	 * @return String
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function getSchema() {
		return "Harmoni DataManager User-defined Schema";
	}

	/**
	 * Get the format for this InfoStructure.  The format is defined by the implementation, e.g. XML.
	 * @return String
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.dr
	 */
	function getFormat() {
		return "Harmoni DataManager DataSetTypeDefinition";
	}

	/**
	 * Validate an InfoRecord against its InfoStructure.  Return true if valid; false otherwise.  The status of the Asset holding this InfoRecord is not changed through this method.  The implementation may throw an Exception for any validation failures and use the Exception's message to identify specific causes.
	 * @param infoRecord
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.dr
	 */
	function validateInfoRecord(& $infoRecord) {
		// all we can really do is make sure the DataSet behind the infoRecord is of the correct
		// type to match this InfoStructure (DataSetTypeDefinition).
		
		return true; // for now
	}
	// :: full java declaration :: public boolean validateInfoRecord(InfoRecord infoRecord)
}
