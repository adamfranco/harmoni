<?php

require_once(HARMONI."metaData/manager/FieldDefinition.class.php");

/**
 * Holds the descriptive information about a specific OKI-style DataSetType. DataSetTypes
 * define the fields available in a DataSet, the number of values allowed in that field.
 * Using the class the actual data structure can be set up in the PHP code and then
 * synchronized to the database using the {@link DataSetTypeManager}.
 * @package harmoni.datamanager
 * @version $Id: DataSetTypeDefinition.class.php,v 1.13 2004/01/08 21:10:01 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class DataSetTypeDefinition {
	
	var $_manager;
	var $_idmanager;
	var $_dbID;
	var $_type;
	var $_id;
	
	var $_loaded;
	
	var $_fields;
	
	function DataSetTypeDefinition(&$manager, &$idmanager, $dbID, &$type, $id=null) {
		$this->_manager =& $manager;
		$this->_idmanager =& $idmanager;
		$this->_dbID = $dbID;
		$this->_type =& $type;
		
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
	* @return ref object
	* @desc Returns the {@link HarmoniType} object associated with this definition.
	*/
	function &getType() {
		return $this->_type;
	}
	
	/**
	* @return int
	* @desc Returns the unique ID of this definition.
	*/
	function getID() { return $this->_id; }
	
	/**
	* @return void
	* @param ref object $fieldDefinition A {@link FieldDefinition} object.
	* @param optional int $id The ID in the Database referring to this field.
	* @desc Adds a field to the Type Definition, consisting of a label and a multiple-values flag.
	* @access 
	*/
	function _addField(&$fieldDefinition, $id=null) {
		ArgumentValidator::validate($fieldDefinition, new ExtendsValidatorRule("FieldDefinition"));
		
		$label = $fieldDefinition->getLabel();
		
		// if we already have a field labeled $label we die
		if (isset($this->_fields[$label]))
			throwError( new Error("Already have a field with label '$label' defined in DataSetTypeDefinition '".OKITypeToString($this->_type)."'. If you feel this is in error, remember that previously deleted FieldDefinitions retain their label so as to avoid data fragmentation.","DataSetTypeDefinition",true));
		
		// associate this field definition with our DataSetTypeDefinition
		$fieldDefinition->associate($this, $this->_idmanager, $this->_dbID, $id);
		
		// add it to our list of fields
		$this->_fields[$label] =& $fieldDefinition;
	}
	
	/**
	* @return bool FALSE on error.
	* @desc Loads the definition data from the database, if not already done.
	*/
	function load() {
		// load our fields from the database
		if ($this->loaded()) {
//			throwError( new Error("Already loaded from the database for type ".OKITypeToString($this->_type).".","DataSetTypeDefinition",true));
			return true;
		}
		
		$this->_loaded = true;
		
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
		$query->addColumn("datasettypedef_active");
		$query->addColumn("datasettypedef_fieldtype");
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
	* @return void
	* @param array $arrayOfRows
	* @desc Populates the object with {@link FieldDefinition} objects based on a number of rows from the database.
	*/
	function populate($arrayOfRows) {
		foreach ($arrayOfRows as $a) {
			$newField =& new FieldDefinition($a['datasettypedef_label'],$a['datasettypedef_fieldtype'],
					(($a['datasettypedef_mult'])?true:false),
					(($a['datasettypedef_active'])?true:false)
					);
			$this->_addField($newField, $a['datasettypedef_id']);
			unset($newField);
		}
	}
	
	/**
	* @return bool
	* @desc Returns true/false depending on if we've loaded our definition data.
	*/
	function loaded() { return $this->_loaded; }
	
	/**
	* @return int
	* @desc Returns the number of fields we have defined.
	*/
	function fieldCount() {
		return count($this->_fields);
	}
	
	/**
	* @return void
	* @param string $label The string label of the field to delete.
	* @desc Removes the definition for $label from the TypeDefinition.
	*/
	function deleteField($label) {
		unset($this->_fields[$label]);
	}
	
	/**
	* @return array
	* @param optional bool $includeInactive If TRUE will also return fields that are inactive (deleted from the definition).
	* @desc Returns a list of labels defined.
	*/
	function getAllLabels( $includeInactive = false ) {
		$array = array();
		foreach (array_keys($this->_fields) as $label) {
			if ($includeInactive || $this->_fields[$label]->isActive()) $array[] = $label;
		}
		return $array;
	}
	
	/**
	* @return ref object
	* @param string $label
	* @desc Returns the {@link FieldDefinition} object for $label.
	*/
	function &getFieldDefinition($label) {
		if (!isset($this->_fields[$label])) {
			throwError(new Error("DataSetTypeDefinition::getFieldDefinition($label) - I don't have a field labeled '$label'. I'm of type '".OKITypeToString($this->_type)."'.","DataSetTypeDefinition",true));
			return false;
		}
		
		return $this->_fields[$label];
	}
	
	/**
	* @return void
	* @desc Spiders through all the fields and commits them to the database. Is called from {@link DataSetTypeManager::synchronize()}.
	* @access public
	*/
	function commitAllFields() {
		// go through all our fields and call commit();
		foreach ($this->getAllLabels() as $label) {
			$this->_fields[$label]->commit();
		}
	}
	
	/**
	* @return boolean
	* @param string $label
	* @desc Returns if the field $label is defined.
	*/
	function fieldExists($label) {
		return (isset($this->_fields[$label]))?true:false;
	}
	
	/**
	* @return string
	* @param string $label
	* @desc Returns the DataType for field referenced by $label.
	*/
	function getFieldType($label) {
		if (!$this->fieldExists($label)) return false;
		
		return $this->_fields[$label]->getType();
	}
}


?>