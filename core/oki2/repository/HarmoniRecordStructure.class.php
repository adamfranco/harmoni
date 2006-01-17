<?
require_once(OKI2."osid/repository/RecordStructure.php");
require_once(HARMONI."/oki2/repository/HarmoniPartStructure.class.php");
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
 * @version $Id: HarmoniRecordStructure.class.php,v 1.25 2006/01/17 20:06:22 adamfranco Exp $ 
 */

class HarmoniRecordStructure 
	extends RecordStructure
{
	
	var $_schema;
	var $_createdParts;
	
	function HarmoniRecordStructure( &$schema ) {
		$this->_schema =& $schema;
		
		// create an array of created PartStructures so we can return references to
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
	 * @access public
	 */
	function getDisplayName () { 
		return $this->_schema->getDisplayName();
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
	 * @access public
	 */
	function updateDisplayName ( $displayName ) { 
		$schemaCopy =& $this->_schema->deepCopy();
		$schemaCopy->updateDisplayName($displayName);
		$schemaManager =& Services::getService("SchemaManager");
		$schemaManager->synchronize($schemaCopy);
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
	 * @access public
	 */
	function getDescription () { 
		return $this->_schema->getDescription();
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
	 * @access public
	 */
	function &getId () { 
		$idManager =& Services::getService("Id");
		return $idManager->getId($this->_schema->getID());
	}

	/**
	 * Get the PartStructure in the RecordStructure with the specified Id.
	 * @param object $infoPartId
	 * @return object PartStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getPartStructure(& $partId) {
		ArgumentValidator::validate($partId, ExtendsValidatorRule::getRule("Id"));
		if (!isset($this->_createdParts[$partId->getIdString()])) {
			$this->_schema->load();
			$this->_createdParts[$partId->getIdString()] =& new HarmoniPartStructure($this, $this->_schema->getField($partId->getIdString()));
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
	 * @access public
	 */
	function &getPartStructures () { 
		$this->_schema->load();
		$array = array();
		foreach ($this->_schema->getAllIDs() as $id) {
			$fieldDef =& $this->_schema->getField($id);
			if (!isset($this->_createdParts[$id]))
				 $this->_createdParts[$id] =& new HarmoniPartStructure($this, $fieldDef);
		}
		
		$obj =& new HarmoniRecordStructureIterator($this->_createdParts);
		
		return $obj;
	}

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
	 * @access public
	 */
	function getSchema () { 
		$other = $this->_schema->getOtherParameters();
		if (isset($other['schema'])) return $other['schema'];
		return "Harmoni DataManager User-defined Schema: ".$this->_schema->getID();
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
	 * @access public
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
	 * @access public
	 */
	function getFormat () { 
		$other = $this->_schema->getOtherParameters();
		if (isset($other['format'])) return $other['format'];
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
	 * @access public
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
	 * @access public
	 */
	function validateRecord ( &$record ) { 
		// all we can really do is make sure the DataSet behind the Record is of the correct
		// type to match this RecordStructure (DataSetTypeDefinition).
		
		return true; // for now
	}

	/**
	 * Create an PartStructure in this RecordStructure. This is not part of the Repository OSID at 
	 * the time of this writing, but is needed for dynamically created 
	 * RecordStructures/PartStructures.
	 *
	 * @param string $displayName	The DisplayName of the new RecordStructure.
	 * @param string $description	The Description of the new RecordStructure.
	 * @param object Type $type		One of the InfoTypes supported by this implementation.
	 *								E.g. string, shortstring, blob, datetime, integer, float,
	 *								
	 * @param boolean $isMandatory	True if the PartStructure is Mandatory.
	 * @param boolean $isRepeatable True if the PartStructure is Repeatable.
	 * @param boolean $isPopulatedByDR	True if the PartStructure is PopulatedBy the DR.
	 * @param optional object $id			An optional {@link HarmoniId} object for this part structure.
	 *
	 * @return object PartStructure The newly created PartStructure.
	 */
	function createPartStructure($displayName, $description, &$partType, $isMandatory, $isRepeatable, $isPopulatedByRepository, $theid=null) {
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule());
		ArgumentValidator::validate($description, StringValidatorRule::getRule());
		ArgumentValidator::validate($partType, ExtendsValidatorRule::getRule("Type"));
		ArgumentValidator::validate($isMandatory, BooleanValidatorRule::getRule());
		ArgumentValidator::validate($isRepeatable, BooleanValidatorRule::getRule());
		ArgumentValidator::validate($isPopulatedByRepository, BooleanValidatorRule::getRule());
		
		if ($theid == null) {
			$idManager =& Services::getService("Id");
			$id =& $idManager->createId();
			$label = $id->getIdString();
		} else {
			// check if this ID follows our Schema's ID
			$id =& $theid;
			if (strpos($id->getIdString(), $this->_schema->getID()) != 0) {
				throwError(new Error("Could not create PartStructure -- the passed ID does not conform to the Schema's internal ID: ".$this->_schema->getID(), "Repository", true));
			}
			
			$label = str_replace($this->_schema->getID() . ".", "", $id->getIdString());
		}
		$fieldDef =& new SchemaField($label, $displayName, $partType->getKeyword(), $description, $isRepeatable, $isMandatory);
		$schema =& $this->_schema->deepCopy();
		$schema->addField($fieldDef);
		$sm =& Services::getService("SchemaManager");
		$sm->synchronize($schema);
		$this->_schema =& $sm->getSchemaByID($this->_schema->getID());

		$idString =& $this->_schema->getFieldIDFromLabel($label);
		
		$this->_createdParts[$idString] =& new HarmoniPartStructure($this,
																$fieldDef);
		return $this->_createdParts[$idString];
	}

	/**
	 * Get the possible types for PartStructures.
	 * 
	 * WARNING: NOT IN OSID - Use at your own risk.
	 *
	 * @return object TypeIterator The Types supported in this implementation.
	 */
	function getPartStructureTypes() {
		$types = array();
		
		$typeMgr =& Services::getService("DataTypeManager");
		foreach ($typeMgr->getRegisteredTypes() as $dataType) {
			$types[] =& new HarmoniType ("Repository","edu.middlebury.harmoni",$dataType);
		}
		
		$typeIterator =& new HarmoniTypeIterator($types);
		return $typeIterator;
	}
	
}
