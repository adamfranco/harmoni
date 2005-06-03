<?php

require_once(HARMONI."dataManager/schema/SchemaField.class.php");

/**
 * Holds the descriptive information about a specific OKI-style DataManager Schema. Schemas
 * define the fields available in a {@link Record}, the number of values allowed in that field.
 * Using the class the actual data structure can be set up in the PHP code and then
 * synchronized to the database using the {@link SchemaManager}.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Schema.class.php,v 1.13 2005/06/03 13:40:15 adamfranco Exp $
 * @author Gabe Schine
 */
class Schema {
	
	var $_type;
	
	var $_loaded;
	
	var $_fields;
	var $_fieldIDs;
	
	var $_revision;
	
	var $_isCreatedByManager;
	
	/**
	 * @param ref object $type A {@link HarmoniType} object. Differentiates this Schema from others - like its unique identifier.
	 * @param int $revision The internal revision number. Useful for keeping track if the Schema definition in the database matches that which you need.
	 */
	function Schema(&$type, $revision=1) {
		ArgumentValidator::validate($type, ExtendsValidatorRule::getRule("Type"));

		$this->_type =& $type;
		$this->_revision = $revision;
		
		$this->_loaded = false;
		$this->_fields = array();
		
		$this->_isCreatedByManager = false;
		
		$this->_fieldIDs = array();
	}
	
	/**
	 * FOR INTERNAL USE - tells this object that it was instantiated by the manager.
	 * @access public
	 * @return void
	 */
	function setManagerFlag()
	{
		$this->_isCreatedByManager = true;
	}
	
	/**
	 * Adds a new field to the Schema.
	 * @param ref object $field A {@link SchemaField} object to add.
	 * @return ref object Returns the same {@link SchemaField} that was passed.
	 * @access public
	 */
	function &addField(&$field) {
		$this->_addField($field);
		return $field;
	}
	
	/**
	* Returns the {@link HarmoniType} object associated with this definition.
	* @return ref object
	*/
	function &getType() {
		return $this->_type;
	}
	
	/**
	 * Returns this schema's revision number.
	 * @access public
	 * @return int
	 */
	function getRevision()
	{
		return $this->_revision;
	}
	
	/**
	 * Sets the revision number of this schema.
	 * @param int $revision
	 * @access public
	 * @return void
	 */
	function setRevision($revision)
	{
		$this->_revision = $revision;
	}
	
	/**
	* Adds a field to the Schema, consisting of a label and a multiple-values flag.
	* @return void
	* @param ref object $field A {@link SchemaField} object.
	* @param optional int $id The ID in the Database referring to this field.
	* @access private
	*/
	function _addField(&$field) {
		ArgumentValidator::validate($field, ExtendsValidatorRule::getRule("SchemaField"));
		
		$label = $field->getLabel();
		
		// if we already have a field labeled $label we die
		if (isset($this->_fields[$label]))
			throwError( new Error("Already have a field with label '$label' defined in Schema '".HarmoniType::typeToString($this->_type)."'. If you feel this is in error, remember that previously deleted SchemaFields retain their label so as to avoid data fragmentation.","DataManager",true));
		
		// associate this field definition with this Schema
		$field->associate($this);
		
		// add it to our list of fields
		$this->_fields[$label] =& $field;
	}
	
	/**
	 * Returns our ID in the database.
	 * @access public
	 * @return int
	 */
	function getID()
	{
		$schemaManager =& Services::getService("SchemaManager");
		return $schemaManager->getIDByType($this->getType());
	}
	
	/**
	* Loads the definition data from the database, if not already done.
	* @return bool FALSE on error.
	*/
	function load() {
		// load our fields from the database
		if ($this->loaded()) {
//			throwError( new Error("Already loaded from the database for type ".HarmoniType::typeToString($this->_type).".","DataSetTypeDefinition",true));
			return true;
		}

		// attempt to get our ID from the SchemaManager
		if ($this->_isCreatedByManager) {
			$schemaManager =& Services::getService("SchemaManager");
			$id = $schemaManager->getIDByType($this->getType());
		} else {
			throwError( new Error("The Schema object of type '".HarmoniType::typeToString($this->_type)."'
				was not meant to interface with the database.","DataManager",true));
			return false;
		}
		if (!$id) {
			throwError( new Error("The Schema object of type '".HarmoniType::typeToString($this->getType())."' cannot be loaded because it does not have an associated database ID!","DataManager",true));
		}

		$query =& new SelectQuery;
		$query->addTable("dm_schema_field");
		$query->addColumn("id","","dm_schema_field");
		$query->addColumn("label","","dm_schema_field");
		$query->addColumn("mult","","dm_schema_field");
		$query->addColumn("required","","dm_schema_field");
		$query->addColumn("active","","dm_schema_field");
		$query->addColumn("fieldtype","","dm_schema_field");
		$query->addColumn("description","","dm_schema_field");
		$query->setWhere("fk_schema='".addslashes($id)."'");
		
		$dbHandler =& Services::getService("DatabaseManager");
		$result =& $dbHandler->query($query,DATAMANAGER_DBID);
		if (!$result) {
			throwError( new UnknownDBError("DataManager") );
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
	* Populates the object with {@link SchemaField} objects based on a number of rows from the database.
	* @return void
	* @param array $arrayOfRows
	*/
	function populate($arrayOfRows) {
		foreach ($arrayOfRows as $a) {
			$newField =& new SchemaField($a['label'],$a['fieldtype'],
					$a['description'],
					(($a['mult'])?true:false),
					($a['required']?true:false),
					(($a['active'])?true:false)
					);
			$this->_addField($newField);
			$this->_fieldIDs[$a['label']] = $a['id'];
			unset($newField);
		}
		
		$this->_loaded = true;
	}
	
	/**
	* Returns true/false depending on if we've loaded our definition data.
	* @param optional boolean $set If specified, will set the loaded flag to the passed value. USED INTERNALLY.
	* @return bool
	*/
	function loaded($set=null) { 
		if ($set != null) $this->_loaded=$set;
		return $this->_loaded; 
	}
	
	/**
	* Returns the number of fields we have defined.
	* @return int
	*/
	function fieldCount() {
		return count($this->_fields);
	}
	
	/**
	* Removes the definition for $label from the Schema.
	* @return void
	* @param string $label The string label of the field to delete.
	*/
	function deleteField($label) {
		unset($this->_fields[$label], $this->_fieldIDs[$label]);
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
	* Returns the {@link SchemaField} object for $label.
	* @return ref object
	* @param string $label
	*/
	function &getField($label) {
		if (!isset($this->_fields[$label])) {
			throwError(new Error("I don't have a field labeled '$label'. I'm of type '".HarmoniType::typeToString($this->_type)."'.","DataManager",true));
			return false;
		}
		
		return $this->_fields[$label];
	}
	
	/**
	 * Returns the ID in the database associated with a given field label.
	 * @param string $label 
	 * @access public
	 * @return int
	 */
	function getFieldID($label)
	{
		return $this->_fieldIDs[$label];
	}
	
	/**
	* Spiders through all the fields and commits them to the database. Is called from {@link SchemaManager::synchronize()}.
	* @return void
	* @access public
	*/
	function commitAllFields() {
		// go through all our fields and call commit();
		foreach ($this->getAllLabels() as $label) {
			$this->_fieldIDs[$label] = $this->_fields[$label]->commit($this->_fieldIDs[$label]);
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
	 * Returns the {@link SchemaField} associated with the ID passed.
	 * @param int $id
	 * @access public
	 * @return ref object
	 */
	function getFieldByID($id)
	{
		// find the label
		foreach (array_keys($this->_fields) as $label) {
			if ($this->getFieldID($label) == $id) return $this->_fields[$label];
		}
		
		return null;
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
