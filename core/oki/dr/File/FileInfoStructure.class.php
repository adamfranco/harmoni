<?

require_once(dirname(__FILE__)."/Fields/FileDataInfoPart.class.php");
require_once(dirname(__FILE__)."/Fields/FileNameInfoPart.class.php");
require_once(dirname(__FILE__)."/Fields/FileSizeInfoPart.class.php");
require_once(dirname(__FILE__)."/Fields/MimeTypeInfoPart.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailDataInfoPart.class.php");
require_once(dirname(__FILE__)."/Fields/ThumbnailMimeTypeInfoPart.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoPartIterator.class.php");

	/**
	 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package harmoni.osid_v1.dr
	 */
class HarmoniFileInfoStructure extends InfoStructure
//	extends java.io.Serializable
{
	
	var $_createdInfoParts;
	
	function HarmoniFileInfoStructure() {
		$this->_schema =& $schema;
		
		// create an array of created InfoParts so we can return references to
		// them instead of always making new ones.
		$this->_infoParts = array();
		$this->_infoParts['FILE_DATA'] =& new FileDataInfoPart($this);
		$this->_infoParts['FILE_NAME'] =& new FileNameInfoPart($this);
		$this->_infoParts['MIME_TYPE'] =& new MimeTypeInfoPart($this);
		$this->_infoParts['FILE_SIZE'] =& new FileSizeInfoPart($this);
		$this->_infoParts['THUMBNAIL_DATA'] =& new ThumbnailDataInfoPart($this);
		$this->_infoParts['THUMBNAIL_MIME_TYPE'] =& new ThumbnailMimeTypeInfoPart($this);
	}
	
	/**
	 * Get the name for this InfoStructure.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() {
		return "File";
	}

	/**
	 * Get the description for this InfoStructure.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() {
		return "A structure for storing binary files.";
	}

	/**
	 * Get the Unique Id for this InfoStructure.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() {
		$sharedManager =& Services::getService("Shared");
		return $sharedManager->getId('FILE');
	}

	/**
	 * Get the InfoPart in the InfoStructure with the specified Id.
	 * @param object $infoPartId
	 * @return object InfoPart
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoPart(& $infoPartId) {
		if ($this->_infoParts[$infoPartId->getIdString()]) {		
			return $this->_infoParts[$infoPartId->getIdString()];
		} else {
			throwError(new Error(UNKNOWN_ID, "Digital Repository :: FileInfoStructure", TRUE));
		}
	}

	/**
	 * Get all the InfoParts in the InfoStructure.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoPartIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoParts() {
		return new HarmoniInfoPartIterator($this->_infoParts);
	}

	/**
	 * Get the schema for this InfoStructure.  The schema is defined by the implementation, e.g. Dublin Core.
	 * @return String
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getSchema() {
		return "Harmoni File Schema";
	}

	/**
	 * Get the format for this InfoStructure.  The format is defined by the implementation, e.g. XML.
	 * @return String
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getFormat() {
		return "Harmoni File";
	}

	/**
	 * Validate an InfoRecord against its InfoStructure.  Return true if valid; false otherwise.  The status of the Asset holding this InfoRecord is not changed through this method.  The implementation may throw an Exception for any validation failures and use the Exception's message to identify specific causes.
	 * @param object infoRecord
	 * @return boolean
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DigitalRepositoryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function validateInfoRecord(& $infoRecord) {
		// all we can really do is make sure the DataSet behind the infoRecord is of the correct
		// type to match this InfoStructure (DataSetTypeDefinition).
		
		return true; // for now
	}

	/**
	 * Create an InfoPart in this InfoStructure. This is not part of the DR OSID at 
	 * the time of this writing, but is needed for dynamically created 
	 * InfoStructures/InfoParts.
	 *
	 * @param string $displayName 	The DisplayName of the new InfoStructure.
	 * @param string $description 	The Description of the new InfoStructure.
	 * @param object Type $type	 	One of the InfoTypes supported by this implementation.
	 *								E.g. string, shortstring, blob, datetime, integer, float,
	 *								
	 * @param boolean $isMandatory 	True if the InfoPart is Mandatory.
	 * @param boolean $isRepeatable True if the InfoPart is Repeatable.
	 * @param boolean $isPopulatedByDR 	True if the InfoPart is PopulatedBy the DR.
	 *
	 * @return object InfoPart The newly created InfoPart.
	 */
	function createInfoPart($displayName, $description, & $infoPartType, $isMandatory, $isRepeatable, $isPopulatedByDR) {
		throwError(new Error(UNIMPLEMENTED, "Digital Repository :: FileInfoStructure", TRUE));
	}

	/**
	 * Get the possible types for InfoParts.
	 *
	 * @return object TypeIterator The Types supported in this implementation.
	 */
	function getInfoPartTypes() {
		$types = array();
		return new HarmoniIterator($types);
	}
	
}
