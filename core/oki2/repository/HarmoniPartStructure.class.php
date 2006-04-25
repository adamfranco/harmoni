<?

require(OKI2."osid/repository/PartStructure.php");

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
 * @version $Id: HarmoniPartStructure.class.php,v 1.11 2006/04/25 21:03:18 adamfranco Exp $  
 */
class HarmoniPartStructure extends PartStructure
//	extends java.io.Serializable
{

	var $_schemaField;
	var $_recordStructure;
	
	function HarmoniPartStructure(&$recordStructure, &$schemaField) {
		$this->_schemaField =& $schemaField;
		$this->_recordStructure =& $recordStructure;
	}
	
	/**
	 * Get the display name for this PartStructure.
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
		return $this->_schemaField->getDisplayName();
	}


	/**
	 * Update the display name for this PartStructure.
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDisplayName ( $displayName ) { 
		$this->_schemaField->updateDisplayName($displayName);
		$this->_schemaField->update();
		$id =& $this->getId();
		$this->_schemaField->commit($id->getIdString());
	} 
	
	/**
	 * Get the description for this PartStructure.
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
		if ($desc = $this->_schemaField->getDescription()) return $desc;
		return "A HarmoniDataManager field of type '".$this->_schemaField->getType()."'.";
	}
	
	/**
	 * Update the description for this PartStructure.
	 *
	 * WARNING: NOT IN OSID
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.repository.RepositoryException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function updateDescription ( $description ) { 
		$this->_schemaField->updateDescription($description);
		$this->_schemaField->update();
		$id =& $this->getId();
		$this->_schemaField->commit($id->getIdString());
	} 
	
	 /**
	 * Get the Type for this PartStructure.
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
		if (!isset($this->_type)) {
			$type = $this->_schemaField->getType();
			$this->_type =& new HarmoniType("Repository", "edu.middlebury.harmoni", $type);
		}
		
		return $this->_type;
	}

	/**
	 * Get the unique Id for this PartStructure.
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
		return $idManager->getId(
			$this->_schemaField->getID()
		);
	}

	/**
	 * Get all the PartStructures in the PartStructure.	 Iterators return a
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
		$array = array();
		$obj =& new HarmoniNodeIterator($array);
		return $obj; // @todo replace with HarmoniPartStructureIterator
	}

	 /**
	 * Return true if this PartStructure is automatically populated by the
	 * Repository; false otherwise.	 Examples of the kind of PartStructures
	 * that might be populated are a time-stamp or the Agent setting the data.
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
	function isPopulatedByRepository () { 
		return false;
	}

	/**
	 * Return true if this PartStructure is mandatory; false otherwise.
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
	function isMandatory () { 
		return $this->_schemaField->isRequired();
	}
	
	/**
	 * Update the mandatory flag for this PartStructure.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param boolean $isMandatory
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
	function updateIsMandatory ( $isMandatory ) { 
		$this->_schemaField->setRequired($isMandatory);
		$this->_schemaField->update();
		$id =& $this->getId();
		$this->_schemaField->commit($id->getIdString());
	} 

	/**
	 * Return true if this PartStructure is repeatable; false otherwise. This
	 * is determined by the implementation.
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
		return $this->_schemaField->getMultFlag();
	}
	
	/**
	 * Update the repeatable flag for this PartStructure.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @param boolean $isRepeatable
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
	function updateIsRepeatable ( $isRepeatable ) { 
		$this->_schemaField->setMultFlag($isMandatory);
		$this->_schemaField->update();
		$id =& $this->getId();
		$this->_schemaField->commit($id->getIdString());
	} 


	
	/**
	 * Get the RecordStructure associated with this PartStructure.
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

	/**
	 * Validate a Part against its PartStructure.  Return true if valid; false
	 * otherwise.  The status of the Asset holding this Record is not changed
	 * through this method.	 The implementation may throw an Exception for any
	 * validation failures and use the Exception's message to identify
	 * specific causes.
	 * 
	 * @param object Part $part
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
	function validatePart ( &$part ) { 
		// we can check if the part (ie, RecordFieldValue) has values of the right type.
		// @todo
		
		return true;
	}
	
	/**
	 * Answer the authoritative values for this part.
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @return object ObjectIterator
	 * @access public
	 * @since 4/25/06
	 */
	function &getAuthoritativeValues () {
		if (!isset($this->_authoritativeValueObjects)) {
			$dtm =& Services::getService("DataTypeManager");
			$type = $this->getType();
			$class = $dtm->primitiveForType($type->getKeyword());
			
			$this->_loadAuthoritativeValueStrings();
			$this->_authoritativeValueObjects = array();
			
			foreach ($this->_authoritativeValueStrings as $valueString)
				eval('$this->_authoritativeValueObjects[$valueString] =& '.$class.'::fromString($valueString);');
		}
		$iterator =& new HarmoniIterator($this->_authoritativeValueObjects);
		return $iterator;
	}
	
	/**
	 * Answer true if the value pass is authoritative.
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @param object $value
	 * @return boolean
	 * @access public
	 * @since 4/25/06
	 */
	function isAuthoritativeValue ( &$value ) {
		if (!isset($this->_authoritativeValueStrings))
			$this->_loadAuthoritativeValueStrings();
		
		return in_array($value->asString(), $this->_authoritativeValueStrings);		
	}
	
	/**
	 * Remove an authoritative value.
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @param object $value
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function removeAuthoritativeValue ( &$value ) {
		if ($this->isAuthoritativeValue($value)) {
			// remove the object from our objects array
			if (isset($this->_authoritativeValueObjects[$value->asString()]))
				unset($this->_authoritativeValueObjects[$value->asString()]);
				
			// Remove the string from our strings array
			unset($this->_authoritativeValueStrings[array_search($value->asString(), $this->_authoritativeValueStrings)]);
			
			// Remove the value from our database
			$query =& new DeleteQuery;
			$query->setTable('dr_authoritative_values');
			$id =& $this->getId();
			$query->addWhere("fk_partstructure = '".addslashes($id->getIdString())."'");
			$query->addWhere("value = '".addslashes($value->asString())."'");
			
			$dbc =& Services::getService("Database");
			$repositoryManager =& Services::getService("Repository");
			$configuration =& $repositoryManager->getConfiguration();
			$dbc->query($query, $configuration->getProperty('database_index'));
		}
	}
	
	/**
	 * Add an authoritative value
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @param object $value
	 * @return void
	 * @access public
	 * @since 4/25/06
	 */
	function addAuthoritativeValue ( &$value ) {
		if (!$this->isAuthoritativeValue($value)) {
			// add the object to our objects array
			$this->_authoritativeValueObjects[$value->asString()] =& $value;
				
			// add the string to our strings array
			$this->_authoritativeValueStrings[] = $value->asString();
			
			// add the value to our database
			$query =& new InsertQuery;
			$query->setTable('dr_authoritative_values');
			$query->setColumns(array('fk_partstructure', 'value'));
			$id =& $this->getId();
			$query->addRowOfValues(array(
				"'".addslashes($id->getIdString())."'",
				"'".addslashes($value->asString())."'"));
			
			$dbc =& Services::getService("Database");
			$repositoryManager =& Services::getService("Repository");
			$configuration =& $repositoryManager->getConfiguration();
			$dbc->query($query, $configuration->getProperty('database_index'));
		}
	}
	
	/**
	 * Load the authoritative value list
	 *
	 * WARNING: NOT in OSID
	 * 
	 * @return void
	 * @access private
	 * @since 4/25/06
	 */
	function _loadAuthoritativeValueStrings () {
		if (!isset($this->_authoritativeValueStrings)) {
			$this->_authoritativeValueStrings = array();
			
			$query =& new SelectQuery;
			$query->addTable('dr_authoritative_values');
			$query->addColumn('value');
			$id =& $this->getId();
			$query->addWhere("fk_partstructure = '".addslashes($id->getIdString())."'");
			$query->addOrderBy("value", ASCENDING);
			
			$dbc =& Services::getService("Database");
			$repositoryManager =& Services::getService("Repository");
			$configuration =& $repositoryManager->getConfiguration();
			$result =& $dbc->query($query, $configuration->getProperty('database_index'));
			
			while ($result->hasMoreRows()) {
				$this->_authoritativeValueStrings[] = $result->field('value');
				$result->advanceRow();
			}
			
			$result->free();
		}
	}
}
