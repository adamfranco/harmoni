<?php

require_once(HARMONI."metaData/manager/FieldDefinition.class.php");

/**
 * Holds the descriptive information about a specific OKI-style DataSetType. DataSetTypes
 * define the fields available in a DataSet, the number of values allowed in that field.
 * Using the class the actual data structure can be set up in the PHP code and then
 * synchronized to the database using the {@link DataSetTypeManager}.
 * @package harmoni.datamanager
 * @version $Id: DataSetTypeDefinition.class.php,v 1.24 2004/08/03 20:19:51 adamfranco Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class DataSetTypeDefinition {
	
	var $_dbID;
	var $_type;
	var $_id;
	
	var $_loaded;
	
	var $_fields;
	
	var $_manager;
	
	var $_revision;
	
	function DataSetTypeDefinition(&$manager, $dbID, &$type, $id=null, $revision) {
		ArgumentValidator::validate($type, new ExtendsValidatorRule("TypeInterface"));
		ArgumentValidator::validate($dbID, new IntegerValidatorRule);
		
		$this->_manager =& $manager;
		$this->_dbID = $dbID;
		$this->_type =& $type;
		$this->_revision = $revision;
		
		$this->_loaded = false;
		$this->_fields = array();
		
		// if all we're passed is a type, try to get the ID from the DataSetTypeManager
		if (!$id) {
			$id = $manager->getIDForType($type);
		}
		
		$this->_id = $id;
	}
	
	/**
	 * Adds a new field to the TypeDefinition.
	 * @param ref object $fieldDefinition A {@link FieldDefinition} object to add.
	 * @return void
	 * @access public
	 */
	function addNewField(&$fieldDefinition) {
		$this->_addField($fieldDefinition);
	}
	
	/**
	* Returns the {@link HarmoniType} object associated with this definition.
	* @return ref object
	*/
	function &getType() {
		ArgumentValidator::validate($this->_type, new ExtendsValidatorRule("TypeInterface"));
		return $this->_type;
	}
	
	/**
	 * Returns this structure's revision number.
	 * @access public
	 * @return int
	 */
	function getRevision()
	{
		return $this->_revision;
	}
	
	/**
	 * Sets the revision number of this data set type.
	 * @param int $revision
	 * @access public
	 * @return void
	 */
	function setRevision($revision)
	{
		$this->_revision = $revision;
	}
	
	/**
	* Returns the unique ID of this definition.
	* @return int
	*/
	function getID() { return $this->_id; }
	
	/**
	* Adds a field to the Type Definition, consisting of a label and a multiple-values flag.
	* @return void
	* @param ref object $fieldDefinition A {@link FieldDefinition} object.
	* @param optional int $id The ID in the Database referring to this field.
	* @access private
	*/
	function _addField(&$fieldDefinition, $id=null) {
		ArgumentValidator::validate($fieldDefinition, new ExtendsValidatorRule("FieldDefinition"));
		
		$label = $fieldDefinition->getLabel();
		
		// if we already have a field labeled $label we die
		if (isset($this->_fields[$label]))
			throwError( new Error("Already have a field with label '$label' defined in DataSetTypeDefinition '".OKITypeToString($this->_type)."'. If you feel this is in error, remember that previously deleted FieldDefinitions retain their label so as to avoid data fragmentation.","DataSetTypeDefinition",true));
		
		// associate this field definition with our DataSetTypeDefinition
		$fieldDefinition->associate($this, $this->_dbID, $id);
		
		// add it to our list of fields
		$this->_fields[$label] =& $fieldDefinition;
	}
	
	/**
	* Loads the definition data from the database, if not already done.
	* @return bool FALSE on error.
	*/
	function load() {
		// load our fields from the database
		if ($this->loaded()) {
//			throwError( new Error("Already loaded from the database for type ".OKITypeToString($this->_type).".","DataSetTypeDefinition",true));
			return true;
		}
		
		// if we were not initialized with an ID, that means that we're not meant to interface with the DB
		if (!$this->_id) {
			throwError( new Error("The DataSetTypeDefinition object of type '".OKITypeToString($this->_type)."'
			was not meant to interface with the database.","DataSetTypeDefinition",true));
			return false;
		}
		
		$query =& new SelectQuery;
		$query->addTable("datasettypedef");
		$query->addColumn("datasettypedef_id");
		$query->addColumn("datasettypedef_label");
		$query->addColumn("datasettypedef_mult");
		$query->addColumn("datasettypedef_required");
		$query->addColumn("datasettypedef_active");
		$query->addColumn("datasettypedef_fieldtype");
		$query->addColumn("datasettypedef_description");
		$query->setWhere("fk_datasettype=".$this->_id);
		
		$dbHandler =& Services::requireService("DBHandler");
		$result =& $dbHandler->query($query,$this->_dbID);
		if (!$result) {
			throwError( new UnknownDBError("DataSetTypeDefinition") );
		}
		
		$rows = array();
		while ($result->hasMoreRows()) {
			$rows[] = $result->getCurrentRow();
			$result->advanceRow();
		}
		
		$this->populate($rows);
		return true;
	}
	
	/**
	* Populates the object with {@link FieldDefinition} objects based on a number of rows from the database.
	* @return void
	* @param array $arrayOfRows
	*/
	function populate($arrayOfRows) {
		foreach ($arrayOfRows as $a) {
			$newField =& new FieldDefinition($a['datasettypedef_label'],$a['datasettypedef_fieldtype'],
					(($a['datasettypedef_mult'])?true:false),
					($a['datasettypedef_required']?true:false),
					(($a['datasettypedef_active'])?true:false),
					$a['datasettypedef_description']
					);
			$this->_addField($newField, $a['datasettypedef_id']);
			unset($newField);
		}
		
		$this->_loaded = true;
	}
	
	/**
	* Returns true/false depending on if we've loaded our definition data.
	* @return bool
	*/
	function loaded() { return $this->_loaded; }
	
	/**
	* Returns the number of fields we have defined.
	* @return int
	*/
	function fieldCount() {
		return count($this->_fields);
	}
	
	/**
	* Removes the definition for $label from the TypeDefinition.
	* @return void
	* @param string $label The string label of the field to delete.
	*/
	function deleteField($label) {
		unset($this->_fields[$label]);
	}
	
	/**
	* Returns a list of labels defined.
	* @return array
	* @param optional bool $includeInactive If TRUE will also return fields that are inactive (deleted from the definition).
	*/
	function getAllLabels( $includeInactive = false ) {
		$array = array();
		foreach (array_keys($this->_fields) as $label) {
			if ($includeInactive || $this->_fields[$label]->isActive()) $array[] = $label;
		}
		return $array;
	}
	
	/**
	* Returns the {@link FieldDefinition} object for $label.
	* @return ref object
	* @param string $label
	*/
	function &getFieldDefinition($label) {
		if (!isset($this->_fields[$label])) {
			throwError(new Error("DataSetTypeDefinition::getFieldDefinition($label) - I don't have a field labeled '$label'. I'm of type '".OKITypeToString($this->_type)."'.","DataSetTypeDefinition",true));
			return false;
		}
		
		return $this->_fields[$label];
	}
	
	/**
	* Returns the {@link FieldDefinition} object for $id.
	* @param integer $id
	* @return ref object
	* @param string $label
	*/
	function &getFieldDefinitionById($id) {
		foreach (array_keys($this->_fields) as $label) {
			if ($this->_fields[$label]->getID() == $id)
				return $this->_fields[$label];
		}
		
		throwError(new Error("DataSetTypeDefinition::getFieldDefinitionById($id) - I don't have a field of Id '$id'. I'm of type '".OKITypeToString($this->_type)."'.","DataSetTypeDefinition",true));
	}
	
	/**
	* Spiders through all the fields and commits them to the database. Is called from {@link DataSetTypeManager::synchronize()}.
	* @return void
	* @access public
	*/
	function commitAllFields() {
		// go through all our fields and call commit();
		foreach ($this->getAllLabels() as $label) {
			$this->_fields[$label]->commit();
		}
	}
	
	/**
	* Returns if the field $label is defined.
	* @return boolean
	* @param string $label
	*/
	function fieldExists($label) {
		return (isset($this->_fields[$label]))?true:false;
	}
	
	/**
	* Returns the DataType for field referenced by $label.
	* @return string
	* @param string $label
	*/
	function getFieldType($label) {
		if (!$this->fieldExists($label)) return false;
		
		return $this->_fields[$label]->getType();
	}
	
	/**
	 * Returns the description of a field.
	 * @param string $label The label of the field.
	 * @access public
	 * @return string
	 */
	function getFieldDescription($label)
	{
		if ($this->fieldExists($label)) {
			return $this->_fields[$label]->getDescription();
		}
		return null;
	}
}

?>