<?php

require_once(HARMONI."dataManager/schema/SchemaField.class.php");

/**
 * Holds the descriptive information about a specific OKI-style DataManager Schema. Schemas
 * define the fields available in a {@link DMRecord}, the number of values allowed in that field.
 * Using the class the actual data structure can be set up in the PHP code and then
 * synchronized to the database using the {@link SchemaManager}.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Schema.class.php,v 1.22 2008/02/06 15:37:43 adamfranco Exp $
 * @author Gabe Schine
 */
class Schema extends SObject {
	
	var $_id;
	
	var $_displayName;
	var $_description;
	
	var $_loaded;
	
	var $_fields;
	var $_fieldIDs;
	
	var $_revision;
	
	var $_isCreatedByManager;
	
	var $_otherParameters;
	
	/**
	 * @param string $id A unique type/ID string. Differentiates this Schema from others.
	 * @param string $displayName This Schema's display name.
	 * @param int $revision The internal revision number. Useful for keeping track if the Schema definition in the database matches that which you need.
	 * @param optional string $description A description.
	 * @param optional mixed $otherParameters Other parameters to associated with this Schema. Can be anything. 
	 */
	function Schema($id, $displayName, $revision=1, $description="", $otherParameters=null) {
		$this->_id = $id;
		$this->_displayName = $displayName;
		$this->_revision = $revision;
		$this->_description = $description;
		$this->_otherParameters = $otherParameters;
		
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
	 * Updates the other parameters associated with this Schema. The parameters can be anything
	 * that may be useful.
	 * @param mixed $otherParameters
	 * @access public
	 * @return void
	 */
	function updateOtherParameters ($otherParameters) {
		$this->_otherParameters = $otherParameters;
	}
	
	/**
	 * Returns the other parameters associated with this Schema. It may be NULL or whatever
	 * was set at Schema creation time.
	 * @access public
	 * @return mixed
	 */
	function getOtherParameters () {
		return $this->_otherParameters;
	}
	
	/**
	 * Adds a new field to the Schema.
	 * @param ref object $field A {@link SchemaField} object to add.
	 * @return ref object Returns the same {@link SchemaField} that was passed.
	 * @access public
	 */
	function addField($field) {
		$this->_addField($field);
		return $field;
	}
	
	/**
	* Returns the type/ID associated with this definition.
	* @return ref object
	*/
	function getID() {
		return $this->_id;
	}
	
	/**
	 * Returns the display name.
	 * @return string
	 * @access public
	 */
	function getDisplayName() {
		return $this->_displayName;
	}
	
	/**
	 * Returns the description.
	 * @return string
	 * @access public
	 */
	function getDescription() {
		return $this->_description;
	}
	
	/**
	 * Sets the description.
	 * @param string $description
	 * @return void
	 * @access public
	 */
	function updateDescription($description) {
		$this->_description = $description;
	}
	
	/**
	 * Sets the display name.
	 * @param string $name
	 * @return void
	 * @access public
	 */
	function updateDisplayName($name) {
		$this->_displayName = $name;
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
	function _addField($field) {
		ArgumentValidator::validate($field, ExtendsValidatorRule::getRule("SchemaField"));
		
		$id = $this->getID() . "." . $field->getLabel();
		
		// if we already have a field labeled $label we die
		if (isset($this->_fields[$id]))
			throwError( new Error("Already have a field with ID '$id' defined in Schema '".$this->getID()."'. If you feel this is in error, remember that previously deleted SchemaFields retain their id so as to avoid data fragmentation.","DataManager",true));
		
		// associate this field definition with this Schema
		$field->associate($this);
		
		// add it to our list of fields
		$this->_fields[$id] =$field;
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
		if (!$this->_isCreatedByManager) {
			throwError( new Error("The Schema object of type '".HarmoniType::typeToString($this->_type)."'
				was not meant to interface with the database.","DataManager",true));
			return false;
		}

		$query = new SelectQuery;
		$query->addTable("dm_schema_field");
		$query->addColumn("id","","dm_schema_field");
		$query->addColumn("name","","dm_schema_field");
		$query->addColumn("mult","","dm_schema_field");
		$query->addColumn("required","","dm_schema_field");
		$query->addColumn("active","","dm_schema_field");
		$query->addColumn("fieldtype","","dm_schema_field");
		$query->addColumn("description","","dm_schema_field");
		$query->setWhere("fk_schema='".addslashes($this->_id)."'");
		
		$dbHandler = Services::getService("DatabaseManager");
		$result =$dbHandler->query($query,DATAMANAGER_DBID);
		if (!$result) {
			throwError( new UnknownDBError("DataManager") );
		}
		
		$rows = array();
		while ($result->hasMoreRows()) {
			$rows[] = $result->getCurrentRow();
			$result->advanceRow();
		}
		
		$result->free();
		
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
			$label = str_replace($this->getID() . ".", "", $a['id']);
			$newField = new SchemaField($label,$a['name'],$a['fieldtype'],
					$a['description'],
					(($a['mult'])?true:false),
					($a['required']?true:false),
					(($a['active'])?true:false)
					);
			$this->_addField($newField);
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
	function deleteFieldByLabel($label) {
		$this->_fields[$this->getID() . "." . $label]->delete();
	}
	
	/**
	 * Removes the definition for field $id from the Schema.
	 * @param string $id
	 * @return void
	 */
	function deleteField($id) {
		debug::output("Deleting Field: ".$id."\n ".((isset($this->_fields[$id])?'exists':"doesn't exist")), DEBUG_SYS5, "DataManager");
		$this->_fields[$id]->delete();
	}
	
	/**
	 * Returns the label of a field given its ID.
	 * @param string $id
	 * @return string
	 * @access public
	 */
	function getFieldLabelFromID($id) {
		$label = str_replace($this->getID() . ".", "", $id);
		if (!isset($this->_fields[$id])) {
			throwError(new Error("Schema::getFieldLabelFromID($id) - could not find a field corresponding to id.", "DataManager", true));
		}
		return $label;
	}
	
	/**
	 * Returns the ID of a field given its label.
	 * @param string $label
	 * @return string
	 * @access public
	 */
	function getFieldIDFromLabel($label) {
		$id = $this->getID() . "." . $label;
		if (!isset($this->_fields[$id])) {
			throwError(new Error("Schema::getFieldIDFromLabel($label) - could not find a field corresponding to label.", "DataManager", true));
		}
		return $id;
	}
	/**
	* Returns a list of field ids defined.
	* @return array
	* @param optional bool $includeInactive If TRUE will also return fields that are inactive (deleted from the definition).
	* @deprecated Use getAllFieldIDs() instead.
	*/
	function getAllIDs( $includeInactive = false ) {
		return $this->getAllFieldIDs($includeInactive);
	}
	
	/**
	* Returns a list of field ids defined.
	* @return array
	* @param optional bool $includeInactive If TRUE will also return fields that are inactive (deleted from the definition).
	*/
	function getAllFieldIDs( $includeInactive = false ) {
		$array = array();
		foreach (array_keys($this->_fields) as $id) {
			if ($includeInactive || $this->_fields[$id]->isActive()) $array[] = $id;
		}
		return $array;
	}
	
	/**
	 * Returns a list of labels defined (similar to getAllIDs())
	 * @return array
	 * @param optional bool $includeInactive if TRUE will also return fields that are inactive in this Schema
	 */
	function getAllLabels( $includeInactive = false ) {
		$array = array();
		foreach (array_keys($this->_fields) as $id) {
			if ($includeInactive || $this->_fields[$id]->isActive()) {
				$label = str_replace($this->getID().".", "", $id);
				$array[] = $label;
			}
		}
		return $array;
	}
	
	/**
	* Returns the {@link SchemaField} object for $id.
	* @return ref object
	* @param string $id
	*/
	function getField($id) {
		if (!isset($this->_fields[$id])) {
			throwError(new Error("I don't have a field id '$id'. I'm of type '".$this->getID()."'.","DataManager",true));
			return false;
		}
		
		return $this->_fields[$id];
	}

	/**
	* Spiders through all the fields and commits them to the database. Is called from {@link SchemaManager::synchronize()}.
	* @return void
	* @access public
	*/
	function commitAllFields() {
		// go through all our fields and call commit();
		foreach ($this->getAllIDs() as $id) {
			$this->_fields[$id]->commit($id);
		}
	}
	
	/**
	* Returns if the field $id is defined.
	* @return boolean
	* @param string $id
	*/
	function fieldExists($id) {
		return isset($this->_fields[$id]);
	}
	
	/**
	 * Returns if the field $label is defined.
	 * @return boolean
	 * @param string $label The field's label.
	 */
	function fieldExistsByLabel($label) {
		$id = $this->getID().".".$label;
		return $this->fieldExists($id);
	}
	
	/**
	* Returns the DataType for field referenced by $id.
	* @return string
	* @param string $id
	*/
	function getFieldType($id) {
		if (!$this->fieldExists($id)) return false;
		
		return $this->_fields[$id]->getType();
	}
	
	/**
	 * Returns the description of a field.
	 * @param string $id The label of the field.
	 * @access public
	 * @return string
	 */
	function getFieldDescription($id)
	{
		if ($this->fieldExists($id)) {
			return $this->_fields[$id]->getDescription();
		}
		return null;
	}
	
	/**
	 * Returns the display name of a field.
	 * @param string $id
	 * @access public
	 * @return void
	 */
	function getFieldDisplayName($id) 
	{
		if ($this->fieldExists($id)) {
			return $this->_fields[$id]->getDisplayName();
		}
		return null;
	}
	
	/**
	 * bla! - deepCopy baby!
	 * @return ref object
	 * @access public
	 */
	function deepCopy() {
		$schema = new Schema($this->getID(), $this->getDisplayName(), $this->getRevision(), $this->getDescription(), $this->getOtherParameters());
		foreach (array_keys($this->_fields) as $key) {
			$field =$this->_fields[$key];
			$newField =$field->replicate();
			$schema->addField($newField);
		}
		return $schema;
	}
}

?>
