<?

require_once(HARMONI."/oki/dr/HarmoniInfoPart.class.php");
require_once(HARMONI."/oki/dr/HarmoniInfoPartIterator.class.php");

/**
 * Each Asset has one of the AssetType supported by the DigitalRepository.  There are also zero or more InfoStructures required by the DigitalRepository for each AssetType. InfoStructures provide structural information.  The values for a given Asset's InfoStructure are stored in an InfoRecord.  InfoStructures can contain sub-elements which are referred to as InfoParts.  The structure defined in the InfoStructure and its InfoParts is used in for any InfoRecords for the Asset.  InfoRecords have InfoFields which parallel InfoParts.  <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 *
 * @package harmoni.osid_v1.dr
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniInfoStructure.class.php,v 1.22 2005/01/26 17:37:53 adamfranco Exp $ */
class HarmoniInfoStructure extends InfoStructure
//	extends java.io.Serializable
{
	
	var $_schema;
	var $_createdInfoParts;
	
	function HarmoniInfoStructure( &$schema ) {
		$this->_schema =& $schema;
		
		// create an array of created InfoParts so we can return references to
		// them instead of always making new ones.
		$this->_createdInfoParts = array();
	}
	
	/**
	 * Get the name for this InfoStructure.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() {
		$type =& $this->_schema->getType();
		
		return $type->getKeyword();
	}

	/**
	 * Get the description for this InfoStructure.
	 * @return String the name
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() {
		$type =& $this->_schema->getType();
		
		return $type->getDescription();
	}

	/**
	 * Get the Unique Id for this InfoStructure.
	 * @return object osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() {
		$sharedManager =& Services::getService("Shared");
		return $sharedManager->getId($this->_schema->getID());
	}

	/**
	 * Get the InfoPart in the InfoStructure with the specified Id.
	 * @param object $infoPartId
	 * @return object InfoPart
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoPart(& $infoPartId) {
		if (!$this->_createdInfoParts[$infoPartId->getIdString()]) {
			$this->_schema->load();
			$this->_createdInfoParts[$infoPartId->getIdString()] =& new HarmoniInfoPart($this, $this->_schema->getFieldById($infoPartId->getIdString()));
		}
		
		return $this->_createdInfoParts[$infoPartId->getIdString()];
	}

	/**
	 * Get all the InfoParts in the InfoStructure.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return object InfoPartIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getInfoParts() {
		$this->_schema->load();
		$array = array();
		foreach ($this->_schema->getAllLabels() as $label) {
			$fieldDef =& $this->_schema->getField($label);
			if (!$this->_createdInfoParts[$this->_schema->getFieldID($label)])
				 $this->_createdInfoParts[$this->_schema->getFieldID($label)] =& new HarmoniInfoPart($this, $fieldDef);
		}
		
		return new HarmoniInfoPartIterator($this->_createdInfoParts);
	}
	// :: full java declaration :: public InfoPartIterator getInfoParts()

	/**
	 * Get the schema for this InfoStructure.  The schema is defined by the implementation, e.g. Dublin Core.
	 * @return String
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getSchema() {
		return "Harmoni DataManager User-defined Schema";
	}

	/**
	 * Get the format for this InfoStructure.  The format is defined by the implementation, e.g. XML.
	 * @return String
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getFormat() {
		return "DataManagerPrimatives";
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
		ArgumentValidator::validate($displayName, new StringValidatorRule);
		ArgumentValidator::validate($description, new StringValidatorRule);
		ArgumentValidator::validate($infoPartType, new ExtendsValidatorRule("Type"));
		ArgumentValidator::validate($isMandatory, new BooleanValidatorRule);
		ArgumentValidator::validate($isRepeatable, new BooleanValidatorRule);
		ArgumentValidator::validate($isPopulatedByDR, new BooleanValidatorRule);
				
		$fieldDef =& new SchemaField($displayName, $infoPartType->getKeyword(), $description, $isRepeatable, $isMandatory);
		$this->_schema->addField($fieldDef);
		$fieldDef->addToDB();
 		$this->_schema->commitAllFields();

		$idString =& $this->_schema->getFieldId($displayName);
		
		$this->_createdInfoParts[$idString] =& new HarmoniInfoPart($this,
																$fieldDef);
		return $this->_createdInfoParts[$idString];
	}

	/**
	 * Get the possible types for InfoParts.
	 *
	 * @return object TypeIterator The Types supported in this implementation.
	 */
	function getInfoPartTypes() {
		$types = array();
		
		$typeMgr =& Services::getService("DataTypeManager");
		foreach ($typeMgr->getRegisteredTypes() as $dataType) {
			$types[] =& new HarmoniType ("DR","Harmoni",$dataType);
		}
		
		$typeIterator =& new HarmoniTypeIterator($types);
		return $typeIterator;
	}
	
}
