<?php
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
 * @version $Id: HarmoniRecordStructure.class.php,v 1.38 2008/02/06 15:37:52 adamfranco Exp $ 
 */

class HarmoniRecordStructure 
	implements RecordStructure
{
	
	var $_schema;
	var $_createdParts;
	/**
	 * @var object RepositoryManger $manager; 
	 * @access private
	 * @since 10/9/07
	 */
	private $manager;
	
	function __construct(RepositoryManager $manager, $schema, Id $repositoryId ) {
		ArgumentValidator::validate($repositoryId, ExtendsValidatorRule::getRule("Id"));
		
		$this->manager = $manager;
		$this->_schema =$schema;
		$this->_repositoryId =$repositoryId;
		
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
		$this->_schema->updateDisplayName($displayName);
		$schemaManager = Services::getService("SchemaManager");
		$schemaManager->synchronize($this->_schema);
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
	 * Update the description for this RecordStructure.
	 * 
	 * @param string $description
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
	function updateDescription ( $description ) { 
		$this->_schema->updateDescription($description);
		$schemaManager = Services::getService("SchemaManager");
		$schemaManager->synchronize($this->_schema);
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
	function getId () { 
		$idManager = Services::getService("Id");
		return $idManager->getId($this->_schema->getID());
	}

	/**
	 * Get the PartStructure in the RecordStructure with the specified Id.
	 * @param object $infoPartId
	 * @return object PartStructure
	 * @throws osid.dr.DigitalRepositoryException An exception with one of the following messages defined in osid.dr.DigitalRepositoryException may be thrown: {@link DigitalRepositoryException#OPERATION_FAILED OPERATION_FAILED}, {@link DigitalRepositoryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DigitalRepositoryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DigitalRepositoryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getPartStructure(Id $partId) {
		ArgumentValidator::validate($partId, ExtendsValidatorRule::getRule("Id"));
		if (!isset($this->_createdParts[$partId->getIdString()])) {
			$this->_schema->load();
						
			// Check that the schema field exists
			if (!$this->_schema->fieldExists($partId->getIdString()))
				throwError(new HarmoniError(
					"Unknown PartStructure ID: ".$partId->getIdString(), 
					"Repository", true));
				
			$schemaField =$this->_schema->getField($partId->getIdString());
			
			// Check that the schema field is active
			if (!$schemaField->isActive())
				throwError(new HarmoniError(
					"Unknown [Inactive] PartStructure ID: ".$partId->getIdString(), 
					"Repository", true));
			
			$this->_createdParts[$partId->getIdString()] = new HarmoniPartStructure($this->manager, 
				$this, $schemaField, $this->_repositoryId);
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
	function getPartStructures () { 
		$this->_schema->load();
		$array = array();
		foreach ($this->_schema->getAllIDs() as $id) {
			$fieldDef =$this->_schema->getField($id);
			if (!isset($this->_createdParts[$id]))
				 $this->_createdParts[$id] = new HarmoniPartStructure($this->manager, $this, $fieldDef, $this->_repositoryId);
		}
		
		$obj = new HarmoniRecordStructureIterator($this->_createdParts);
		
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
		return _("Plain Text - UTF-8 encoding");
	}
	
	/**
	 * Update the format for this RecordStructure.
	 * 
	 * @param string $format
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
	function updateFormat ( $format ) {
		$other = $this->_schema->getOtherParameters();
		$other['format'] = $format;
		$this->_schema->updateOtherParameters($other);
		$schemaManager = Services::getService("SchemaManager");
		$schemaManager->synchronize($this->_schema);
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
	function getType () { 
		$type = new Type("RecordStructures", "edu.middlebury.harmoni", "DataManagerPrimatives", "RecordStructures stored in the Harmoni DataManager.");
		return $type;
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
	function validateRecord ( Record $record ) { 
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
	function createPartStructure($displayName, $description, Type $partType, $isMandatory, $isRepeatable, $isPopulatedByRepository, $theid=null) {
		ArgumentValidator::validate($displayName, StringValidatorRule::getRule());
		ArgumentValidator::validate($description, StringValidatorRule::getRule());
		ArgumentValidator::validate($partType, ExtendsValidatorRule::getRule("Type"));
		ArgumentValidator::validate($isMandatory, BooleanValidatorRule::getRule());
		ArgumentValidator::validate($isRepeatable, BooleanValidatorRule::getRule());
		ArgumentValidator::validate($isPopulatedByRepository, BooleanValidatorRule::getRule());
		
		if ($theid == null) {
			$idManager = Services::getService("Id");
			$id =$idManager->createId();
			$label = $id->getIdString();
		} else {
			// check if this ID follows our Schema's ID
			$id =$theid;
			if (strpos($id->getIdString(), $this->_schema->getID()) != 0) {
				throwError(new HarmoniError("Could not create PartStructure -- the passed ID does not conform to the Schema's internal ID: ".$this->_schema->getID(), "Repository", true));
			}
			
			$label = str_replace($this->_schema->getID() . ".", "", $id->getIdString());
		}
		$fieldDef = new SchemaField($label, $displayName, $partType->getKeyword(), $description, $isRepeatable, $isMandatory);
		$schema =$this->_schema->deepCopy();
		$schema->addField($fieldDef);
		$sm = Services::getService("SchemaManager");
		$sm->synchronize($schema);
		$this->_schema =$sm->getSchemaByID($this->_schema->getID());

		$idString = $this->_schema->getFieldIDFromLabel($label);
		
		$this->_createdParts[$idString] = new HarmoniPartStructure($this->manager, $this,
																$fieldDef, $this->_repositoryId);
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
		
		$typeMgr = Services::getService("DataTypeManager");
		foreach ($typeMgr->getRegisteredTypes() as $dataType) {
			$types[] = new HarmoniType ("Repository","edu.middlebury.harmoni",$dataType);
		}
		
		$typeIterator = new HarmoniTypeIterator($types);
		return $typeIterator;
	}
	
	/**
	 * Convert this PartStructure and all of its associated Parts to a new type.
	 * Usage of this method may cause data-loss if the types are do not convert well.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param object Id $partStructureId
	 * @param object Type $type
	 * @return void
	 * @access public
	 * @since 6/8/06
	 */
	function convertPartStructureToType ( Id $partStructureId, Type $type, $statusStars = null ) {
		$oldPartStructure =$this->getPartStructure($partStructureId);
		$newPartStructure =$this->createPartStructure(
								$oldPartStructure->getDisplayName(),
								$oldPartStructure->getDescription(),
								$type,
								$oldPartStructure->isMandatory(),
								$oldPartStructure->isRepeatable(),
								$oldPartStructure->isPopulatedByRepository());
		
		// Convert the Data
		$myRecordStructureId = $this->getId();
		$repositories = $this->manager->getRepositories();
		while($repositories->hasNext()) {
			$repository =$repositories->next();
			$recordStructures =$repository->getRecordStructures();
			while($recordStructures->hasNext()) {
				$recordStructure =$recordStructures->next();
				
				// If the current Repository has this record structure, convert
				// the records for it in its assets.
				if ($myRecordStructureId->isEqual($recordStructure->getId())) {
					$assets =$repository->getAssets();
					
					if (!is_null($statusStars))
						$statusStars->initializeStatistics($assets->count());
										
					while ($assets->hasNext()) {
						$asset =$assets->next();
						$records =$asset->getRecordsByRecordStructure(
							$myRecordStructureId);
						while ($records->hasNext()) {
							$record =$records->next();
							$parts =$record->getPartsByPartStructure($partStructureId);
							while ($parts->hasNext()) {
								$oldPart =$parts->next();
								
								$oldValue =$oldPart->getValue();
								$oldValueString = $oldValue->asString();
								
								$newPart =$record->createPart(
												$newPartStructure->getId(),
												$oldPart->getValue());
								$record->deletePart($oldPart->getId());
								
								$newValue =$newPart->getValue();
								
								
								$newValueString = $newValue->asString();
								if ($oldValueString != $newValueString) {
									throwError(new HarmoniError("'$newValueString' should be equal to '$oldValueString'", "repository"));
								}
							}
						}
						
						if (!is_null($statusStars))
							$statusStars->updateStatistics();
					}
				}
			}
		}

		// Delete the old part Structure
		$this->deletePartStructure($partStructureId);
		
		return $newPartStructure;
	}
	
	/**
	 * Delete a PartStucture
	 * 
	 * @param object Id $partStructureId
	 * @return void
	 * @access public
	 * @since 6/8/06
	 */
	function deletePartStructure ( Id $partStructureId ) {
		// Delete the Structure
		$schemaMgr = Services::getService("SchemaManager");
		$recordMgr = Services::getService("RecordManager");
		
		$partStructure =$this->getPartStructure($partStructureId);
		$dummyValues = array(HarmoniString::withValue('4000-02-05'));
		$recordIdsWithValues = $recordMgr->getRecordSetIDsBySearch(
				new FieldValueSearch(
					$this->_schema->getID(),
					$this->_schema->getFieldLabelFromID($partStructureId->getIdString()),
					new HarmoniIterator($dummyValues),
					SEARCH_TYPE_NOT_IN_LIST));
		
		if (count($recordIdsWithValues)) {
			throwError(new HarmoniError(
				RepositoryException::OPERATION_FAILED()
					." when deleting RecordStructure: '"
					.$recordStructureId->getIdString()
					."', Records exist for this RecordStructure.", 
				"Repository", 1));
		}
		
		$sm = Services::getService("SchemaManager");
		$this->_schema->deleteField($partStructureId->getIdString());
		$sm->synchronize($this->_schema);
		
		$partStructure = null;
	}
}