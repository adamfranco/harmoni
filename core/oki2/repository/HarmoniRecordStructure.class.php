<?

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
 * @package harmoni.XXXX.YYYYYY
 * 
 * @copyright Copyright &copy;2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @version $Id: HarmoniRecordStructure.class.php,v 1.3 2005/01/19 22:28:24 adamfranco Exp $ 
 */


class HarmoniRecordStructure extends RecordStructure
//	extends java.io.Serializable
{
	
	var $_schema;
	var $_createdParts;
	
	function HarmoniRecordStructure( &$schema ) {
		$this->_schema =& $schema;
		
		// create an array of created InfoParts so we can return references to
		// them instead of always making new ones.
		$this->_createdParts = array();
	}
	
	/**
	 * Get the display name for this RecordStructure.
	 *	
	 * @return string
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
	 * @public
	 */
	function getDisplayName () { 
		$type =& $this->_schema->getType();
		
		return $type->getKeyword();
	}

	/**
	 * Update the display name for this RecordStructure.
	 * 
	 * @param string $displayName
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
	 * @public
	 */
	function updateDisplayName ( $displayName ) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	} 

	 /**
	 * Get the description for this RecordStructure.
	 *	
	 * @return string
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
	 * @public
	 */
	function getDescription () { 
		$type =& $this->_schema->getType();
		
		return $type->getDescription();
	}

	/**
	 * Get the unique Id for this RecordStructure.
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
	 * @public
	 */
	function &getId () { 
		$idManager =& Services::getService("Id");
		return $idManager->getId($this->_schema->getID());
	}

	/**
	 * Get the InfoPart in the InfoStructure with the specified Id.
	 * @param object $infoPartId
	 * @return object InfoPart
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid_v2.dr
	 */
	function &getInfoPart(& $partId) {
		if (!$this->_createdParts[$partId->getIdString()]) {
			$this->_schema->load();
			$this->_createdParts[$partId->getIdString()] =& new HarmoniPart($this, $this->_schema->getFieldById($partId->getIdString()));
		}
		
		return $this->_createdParts[$partId->getIdString()];
	}

	/**
	 * Get all the PartStructures in the RecordStructure.  Iterators return a
	 * set, one at a time.
	 *	
	 * @return object PartStructureIterator
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
	 * @public
	 */
	function &getPartStructures () { 
		$this->_schema->load();
		$array = array();
		foreach ($this->_schema->getAllLabels() as $label) {
			$fieldDef =& $this->_schema->getField($label);
			if (!$this->_createdParts[$this->_schema->getFieldID($label)])
				 $this->_createdParts[$this->_schema->getFieldID($label)] =& new HarmoniPart($this, $fieldDef);
		}
		
		return new HarmoniRecordStructureIterator($this->_createdParts);
	}
	// :: full java declaration :: public InfoPartIterator getInfoParts()

	/**
	 * Get the schema for this RecordStructure.	 The schema is defined by the
	 * implementation, e.g. Dublin Core.
	 *	
	 * @return string
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
	 * @public
	 */
	function getSchema () { 
		return "Harmoni DataManager User-defined Schema";
	}

	/**
	 * Return true if this RecordStructure is repeatable; false otherwise.
	 * This is determined by the implementation.
	 *	
	 * @return boolean
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
	 * @public
	 */
	function isRepeatable () { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	} 

	/**
	 * Get the format for this RecordStructure.	 The format is defined by the
	 * implementation, e.g. XML.
	 *	
	 * @return string
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
	 * @public
	 */
	function getFormat () { 
		return "DataManagerPrimatives";
	}
	
	/**
	 * Get the Type for this RecordStructure.
	 *	
	 * @return object Type
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
	 * @public
	 */
	function &getType () { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	} 


	/**
	 * Validate a Record against its RecordStructure.  Return true if valid;
	 * false otherwise.	 The status of the Asset holding this Record is not
	 * changed through this method.	 The implementation may throw an Exception
	 * for any validation failures and use the Exception's message to identify
	 * specific causes.
	 * 
	 * @param object Record $record
	 *	
	 * @return boolean
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
	 *		   NULL_ARGUMENT}
	 * 
	 * @public
	 */
	function validateRecord ( &$record ) { 
		// all we can really do is make sure the DataSet behind the infoRecord is of the correct
		// type to match this InfoStructure (DataSetTypeDefinition).
		
		return true; // for now
	}

	/**
	 * Create an InfoPart in this InfoStructure. This is not part of the Repository OSID at 
	 * the time of this writing, but is needed for dynamically created 
	 * InfoStructures/InfoParts.
	 *
	 * @param string $displayName	The DisplayName of the new InfoStructure.
	 * @param string $description	The Description of the new InfoStructure.
	 * @param object Type $type		One of the InfoTypes supported by this implementation.
	 *								E.g. string, shortstring, blob, datetime, integer, float,
	 *								
	 * @param boolean $isMandatory	True if the InfoPart is Mandatory.
	 * @param boolean $isRepeatable True if the InfoPart is Repeatable.
	 * @param boolean $isPopulatedByDR	True if the InfoPart is PopulatedBy the DR.
	 *
	 * @return object InfoPart The newly created InfoPart.
	 */
	function createPart($displayName, $description, & $partType, $isMandatory, $isRepeatable, $isPopulatedByRepository) {
		ArgumentValidator::validate($displayName, new StringValidatorRule);
		ArgumentValidator::validate($description, new StringValidatorRule);
		ArgumentValidator::validate($partType, new ExtendsValidatorRule("TypeInterface"));
		ArgumentValidator::validate($isMandatory, new BooleanValidatorRule);
		ArgumentValidator::validate($isRepeatable, new BooleanValidatorRule);
		ArgumentValidator::validate($isPopulatedByRepository, new BooleanValidatorRule);
				
		$fieldDef =& new SchemaField($displayName, $partType->getKeyword(), $description, $isRepeatable, $isMandatory);
		$this->_schema->addField($fieldDef);
		$fieldDef->addToDB();
		$this->_schema->commitAllFields();

		$idString =& $this->_schema->getFieldId($displayName);
		
		$this->_createdParts[$idString] =& new HarmoniPart($this,
																$fieldDef);
		return $this->_createdParts[$idString];
	}

	/**
	 *WARNING! Not in the OSID, use at your own risk
	 *Get the possible types for InfoParts.
	 *
	 * @return object TypeIterator The Types supported in this implementation.
	 */
	function getPartTypes() {
		$types = array();
		
		$typeMgr =& Services::getService("DataTypeManager");
		foreach ($typeMgr->getRegisteredTypes() as $dataType) {
			$types[] =& new HarmoniType ("Repository","Harmoni",$dataType);
		}
		
		$typeIterator =& new HarmoniTypeIterator($types);
		return $typeIterator;
	}
	
}
