<?php

require_once HARMONI."dataManager/record/RecordField.class.php";

/**
 * @package harmoni.datamanager
 * @constant int NEW_VALUE Used when setting the value of a new index within a field.
 */
define("NEW_VALUE",-1);
/**
 * @package harmoni.datamanager
 * @constant int RECORD_NODATA Specifies that only the record descriptor has been fetched - no data.
 */
define("RECORD_NODATA",0);
/**
 * @package harmoni.datamanager
 * @constant int RECORD_CURRENT Specifies that all active values for fields have been fetched.
 */
define("RECORD_CURRENT",2);
/**
 * @package harmoni.datamanager
 * @constant int RECORD_FULL Specifies that all values active and inactive (all versions) have been fetched.
 */
define("RECORD_FULL",4);


/**
* A DMRecord is a set of data matching a certain {@link Schema}. The DMRecord can be fetched from the database in a number of
* ways, which can be changed at runtime. See the RECORD_* constants.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Record.class.php,v 1.41 2008/02/06 15:37:42 adamfranco Exp $
*/
class DMRecord {
	
	var $_myID;
	
	var $_delete;
	var $_schema;
	var $_versionControlled;
	var $_fields;
	var $_creationDate;
	var $_dateFromDB = false;
	var $_fetchMode;
	var $_fetchedValueIDs;

	var $_prune;
	var $_pruneConstraint;
	
	/**
	 * Constructor
	 * @param mixed $schema Either a {@link Schema} object or a string ID of the schema to use.
	 * @param optional boolean $verControl If set to TRUE this DMRecord will use version-control.
	 * @param optional int $fetchMode USED INTERNALLY
	 */
	function __construct($schema, $verControl=false, $fetchMode = RECORD_FULL) {
		ArgumentValidator::validate($verControl, BooleanValidatorRule::getRule());
//		ArgumentValidator::validate($schema, ExtendsValidatorRule::getRule("Schema"));
		
		if (is_object($schema)) {
			$schemaID = $schema->getID();
		} else $schemaID = $schema; // it's a string (we hope)
		
		$schemaManager = Services::getService("SchemaManager");
		
		$schema =$schemaManager->getSchemaByID($schemaID);
		$schema->load();
		
		$this->_schema =$schema;
		$this->_fields = array();
		$this->_versionControlled = $verControl;
		$this->_fetchMode = $fetchMode;
		$this->_fetchedValueIDs = array();
		
		$this->_creationDate = DateAndTime::now();
		
		$this->_myID = null;
		
		$this->_delete = false;
		
		// set up the individual fields
		foreach ($schema->getAllIDs(true) as $label) {
			$def =$schema->getField($label);
			$this->_fields[$label] = new RecordField($def, $this);
			unset($def);
		}
		
		$this->_idManager = Services::getService("Id");
	}
	
	/**
	 * Returns this DMRecord's {@link Schema}
	 * @return ref object
	 */
	function getSchema() {
		return $this->_schema;
	}
	
	/**
	 * Returns the indices (indexes) of each value for the given field. Can then be retrieved with any getValue-type function.
	 * @access public
	 * @param string $label
	 * @param optional boolean $includeInactive Includes the inactive values for 'label'. Default: false
	 * @return array An array of integers
	 */
	function getIndices($label, $includeInactive = false)
	{
		$this->_checkLabel($label);
		$id = $this->_getFieldID($label);
		return $this->_fields[$id]->getIndices($includeInactive);
	}
	
	/**
	 * Returns the indices (indexes) of each value for the given field. Can then be retrieved with any getValue-type function.
	 * @access public
	 * @param string $label
	 * @return array An array of integers
	 * @deprecated use getIndices().
	 */
	function getActiveIndices($label)
	{
		return $this->getIndices($label);
	}
	
	/**
	 * INTERNAL USE ONLY: Sets the fetch mode.
	 * @access public
	 * @return void
	 */
	function setFetchMode($mode)
	{
		$this->_fetchMode = $mode;
	}
	
	/**
	 * Returns the Schema ID associated with this DMRecord.
	 * @return string
	 */
	function getSchemaID() {
		return $this->_schema->getID();
	}
	
	/**
	* Returns this DMRecord's ID.
	* @return int
	*/
	function getID() { 
		return $this->_myID;
	}
	
	function _checkLabel($label) {
		if (!$this->_schema->fieldExistsByLabel($label)) {
			throwError(new FieldNotFoundError($label,$this->_schema->getID()));
			return false;
		}
		
		// If the schema has changed since we were created, ensure that we
		// have a valid field object
		$id = $this->_getFieldID($label);
		if (!isset($this->_fields[$id])) {
			$def =$this->_schema->getField($this->_schema->getFieldIDFromLabel($label));
			$this->_fields[$id] = new RecordField($def, $this);
		}
		
		return true;
	}
	
	/**
	 * Re-indexes all the values in a multi-valued field so that they increment by 1 started at 0. 
	 * @access public
	 * @param string $label The field's label.
	 * @return void
	 */
	function reIndex($label)
	{
		$this->_checkLabel($label);
		
		$this->_fields[$this->_getFieldID($label)]->reIndex();
	}
	
	/**
	 * Returns the full ID of a field, given a label.
	 * @return string
	 * @access private
	 * @param string $label
	 */
	function _getFieldID($label) {
		return $this->_schema->getFieldIDFromLabel($label);
	}
	
	/**
	 * Returns a field's label given its ID.
	 * @return string
	 * @access private
	 * @param string $id
	 */
	function _getFieldLabel($id) {
		return $this->_schema->getFieldLabelFromID($id);
	}
	
	/**
	* Returns the active {@link SObject} value object for $index under $label.
	* @return ref object
	* @param string $label
	* @param optional int $index default=0.
	*/
	function getValue($label, $index=0) {
		$this->_checkLabel($label);
		
		$id = $this->_getFieldID($label);
		
		$versions =$this->_fields[$id]->getRecordFieldValue($index);
		
		if ($versions->hasActiveValue())
			$ver =$versions->getActiveVersion();
		else
			$ver =$versions->getNewestVersion();
			
		return $ver->getPrimitive();
	}
	
	/**
	 * Returns the active value for a label/index by calling $function on the {@link SObject} that is returned.
	 * @param string $function The function to call.
	 * @param string $label The label.
	 * @param optional int $index defaults to 0
	 * @access public
	 * @return ref mixed
	 */
	function getValueByFunction($function, $label, $index=0)
	{
		$prim =$this->getCurrentValue($label, $index);
		return $prim->$function();
	}
	
	/**
	 * Returns a string value for $index under $label. What is returned depends on the DataType.
	 * @param string $label
	 * @param optional int $index default=0.
	 */
	function getStringValue($label, $index=0) {
		
		$actVer =$this->getCurrentValue($label, $index);
		if (!$actVer) return null;
		
		return $actVer->asString();
	}
	
	/**
	* Returns an array of all the string values for the passed label.
	* @param string $label
	* @access public
	* @return array
	*/
	function getStringValues($label) {
		$ar = array();
		foreach($this->getIndices($label) as $index) {
			if (!$this->deleted($label, $index)) $ar[] = $this->getStringValue($label, $index);
		}
		return $ar;
	}
	
	/**
	 * Returns an array of {@link RecordFieldData} objects corresponding to the different
	 * versions available for a given $label/$index - useful for version-controlled Records.
	 * @access public
	 * @param string $label
	 * @param optional integer $index
	 * @return ref array An array keyed by version ID.
	 */
	function getVersions($label, $index=0) {
		$this->_checkLabel($label);
		$id = $this->_getFieldID($label);
		
		$ids = $this->_fields[$id]->getVersionIDs($index);
		
		$array = array();
		foreach ($ids as $verID) {
			$array[$verID] =$this->_fields[$id]->getVersion($verID);
		}
		
		return $array;
	}
	
	/**
	 * Returns all the {@link RecordFieldValue}s objects associated with a field by id.
	 * @param string $id The field's unique ID
	 * @return ref array 
	 * @access public
	 */
	function getRecordFieldValues($id) {
		$this->_checkLabel($this->_getFieldLabel($id));
		$array = array();
		foreach ($this->getIndices($this->_getFieldLabel($id)) as $index) {
			$array[] =$this->_fields[$id]->getRecordFieldValue($index);
		}
		return $array;
	}
	
	/**
	 * Returns the {@link RecordFieldValue} associated with a field by id.
	 * @param string $id The field's unique ID
	 * @param optional integer $index
	 * @return ref object
	 * @access public
	 */
	function getRecordFieldValue($id, $index=0) {
		$this->_checkLabel($this->_getFieldLabel($id));
		return $this->_fields[$id]->getRecordFieldValue($index);
	}
	
	/**
	* INTERNAL USE ONLY: Creates a number of {@link RecordFieldValue} objects based on an array of database rows.
	* @return bool
	* @param ref array $arrayOfRows
	*/
	function populate( $arrayOfRows ) {
		
		// ok, we're going to be passed an array of rows that corresonds to
		// our label[index] = valueVersion[n] setup.
		// that means we have to separate out the rows that have to do with each
		// label, and hand each package to a FieldValues object.

		foreach (array_keys($arrayOfRows) as $key) {
			$this->takeRow($arrayOfRows[$key]);
		}		
	}
	
	/**
	 * INTERNAL USE ONLY: Takes one row from a database and populates our objects with it.
	 * @param ref array $row
	 * @return void
	 */
	function takeRow( $row ) {
		
		// see if we can't get our ID from the row
		if (!$this->_myID && $row['record_id']) 
			$this->_myID = $row['record_id'];
		else if ($row['record_id'] != $this->_myID) {
			throwError( new HarmoniError("Can not take database row because it does not seem to correspond with our
			DMRecord ID.", "DMRecord",true));
		}
		
		// let's check if we have our creation date set yet.
		if (!$this->_dateFromDB) {
			$dbHandler= Services::getService("DatabaseManager");
			$this->_creationDate =$dbHandler->fromDBDate($row["record_created"], DATAMANAGER_DBID);
			$this->_dateFromDB = true;
		}
		
		// if this is an empty DMRecord, we're going to get a row with NULL values for all
		// columns not in the "dm_record_field" table. so, let's check for that and return if it's the case.
		if (!$row['record_field_id']) return;
		
		// now, we need to check if we've already accounted for this specific value from the database
		if (in_array($row['record_field_id'], $this->_fetchedValueIDs)) return;
		$fieldID = $row['schema_field_id'];
		$label = $this->_getFieldLabel($fieldID);

		if (!isset($this->_fields[$fieldID])) {
			throwError( new HarmoniError("Could not populate DMRecord with label '$label' because it doesn't
				seem to be defined in the Schema.","record",true));
		}
		
		$this->_fields[$fieldID]->takeRow($row);
		
		$this->_fetchedValueIDs[] = $row['record_field_id'];
		
	}
	
	/**
	 * Returns the {@link DateAndTime} object specifying when this DMRecord was created.
	 * @access public
	 * @return ref object
	 */
	function getCreationDate()
	{
		return $this->_creationDate;
	}
	
	/**
	* Returns the number of values we have set for $label.
	* @return int
	* @param string $label
	* @param optional boolean $includeInactive If TRUE will include inactive values as well.
	*/
	function numValues($label, $includeInactive = false) {
		$this->_checkLabel($label);
		
		if (!isset($this->_fields[$this->_getFieldID($label)]))
			return 0;
		
		return $this->_fields[$this->_getFieldID($label)]->numValues($includeInactive);
	}
	
	/**
	* Returns TRUE if this DataSet was created with Version Control.
	* @return bool
	*/
	function isVersionControlled() {
		return $this->_versionControlled;
	}
	
	/**
	 * Returns if this DMRecord is about to be deleted or not.
	 * @return bool
	 * @access public
	 */
	function isActive() {
		return !$this->_delete;
	}

	/**
	 * De-activates the value under $label[$index].
	 * @param string $label The field label to delete.
	 * @param optional int $index The index (for multi-value fields) to delete.
	 * @access public
	 * @return void
	 */
	function deleteValue($label, $index=0)
	{
		$this->_checkLabel($label);
		
		$this->_fields[$this->_getFieldID($label)]->deleteValue($index);
	}
	
	/**
	 * Re-activates the value under $label[$index].
	 * @param string $label The field label to un-delete.
	 * @param optional int $index The index (for multi-value fields) to un-delete.
	 * @access public
	 * @return void
	 */
	function undeleteValue($label, $index=0)
	{
		$this->_checkLabel($label);
		
		$this->_fields[$this->_getFieldID($label)]->undeleteValue($index);
	}
	
	/**
	 * Returns true if the given value has been deleted.
	 * @param string $label the field label to check.
	 * @param optional int $index The index (defaults to 0) to check.
	 * @access public
	 * @return bool
	 */
	function isValueDeleted($label, $index = 0)
	{
		$this->_checkLabel($label);
		
		return $this->_fields[$this->_getFieldID($label)]->isIndexDeleted($index);
	}
	
	/**
	* Sets the value of $index under $label to $obj where $obj is an {@link SObject}.
	* @return bool
	* @param string $label
	* @param ref object $obj
	* @param optional int $index default=0
	*/
	function setValue($label, $obj, $index=0) {
		$this->_checkLabel($label);
		$id = $this->_getFieldID($label);
		
		ArgumentValidator::validate($this->_fields[$id],
			ExtendsValidatorRule::getRule("RecordField"));
		
		if ($index == NEW_VALUE) {
			return $this->_fields[$id]->addValueFromPrimitive($obj);
		}
		return $this->_fields[$id]->setValueFromPrimitive($index, $obj);
	}
	
	/**
	* Commits (either inserts or updates) the data for this DMRecord into the database.
	* @param boolean optional $ignoreMandatory If true, doesn't fail if mandatory
	*		fields don't have values.
	* @return bool
	*/
	function commit($ignoreMandatory=false) {
		// Ensure that we have fields for all labels, incase
		// the schema has changed since we were loaded.
		foreach ($this->_schema->getAllLabels() as $label)
			$this->_checkLabel($label);
		
		// Get the DBHandler
		$dbHandler = Services::getService("DatabaseManager");
			
		// the first thing we're gonna do is check to make sure that all our required fields
		// have at least one value.
		if (!$this->_delete) {
			foreach ($this->_schema->getAllIDs() as $id) {
				$fieldDef =$this->_schema->getField($id);
				if ($fieldDef->isRequired() && ($this->_fields[$id]->numValues(true) == 0 ||
						$this->_fields[$id]->numValues() == 0) && !$ignoreMandatory) {
					throwError(new HarmoniError("Could not commit DMRecord to database because the required field '$id' does
					not have any values!","DMRecord",true));
					return false;
				}
			}
		
			
			if ($this->_myID) {
				// we're already in the database
				$query = new UpdateQuery();
				
				$query->setTable("dm_record");
				$query->setColumns(array("ver_control"));
				$query->setValues(array(
					($this->_versionControlled)?1:0
					));
				$query->setWhere("id='".addslashes($this->_myID)."'");
				
			} else {
				// we'll have to make a new entry
				$schemaManager = Services::getService("SchemaManager");
				
				$newID =$this->_idManager->createId();
				$this->_myID = $newID->getIdString();
				
				$query = new InsertQuery();
				$query->setTable("dm_record");
				$query->setColumns(array("id","fk_schema","created","ver_control"));
				$query->addRowOfValues(array(
					"'".addslashes($this->_myID)."'",
					"'".addslashes($this->_schema->getID())."'",
					$dbHandler->toDBDate($this->_creationDate,DATAMANAGER_DBID),
					($this->_versionControlled)?1:0
					));
			}
			
			// execute the query;		
			$result =$dbHandler->query($query,DATAMANAGER_DBID);
			
			if (!$result) {
				throwError( new UnknownDBError("DMRecord") );
				return false;
			}
		}
		
		// now let's cycle through our FieldValues and commit them
		foreach ($this->_schema->getAllIDs() as $id) {
			$this->_fields[$id]->commit();
		}
		
		if ($this->_prune) {
			$constraint =$this->_pruneConstraint;
			
			// check if we have to delete any dataset tags based on our constraints
			$constraint->checkTags($this);
			
			$tagMgr = Services::getService("RecordTagManager");
			
			// if we are no good any more, delete ourselves completely
			if ($this->_delete) {
				// now, remove any tags from the DB that have to do with us, since they will no longer
				// be valid.
				$tagMgr->pruneTags($this);
				
				$query = new DeleteQuery();
				$query->setTable("dm_record");
				$query->setWhere("id='".addslashes($this->getID())."'");
				
				$dbHandler->query($query, DATAMANAGER_DBID);

				$query = new DeleteQuery();
				$query->setTable("dm_record_set");
				$query->setWhere("fk_record='".addslashes($this->getID())."'");

				$dbHandler->query($query, DATAMANAGER_DBID);
			} else {
				// if we're pruning but not deleting the whole shebang, let's
				// make sure that there are no tags in the database with no 
				// mappings whatsoever.
				$tagMgr->checkForEmptyTags($this);
			}
			
		}
		
		return true;
	}
	
	/**
	 * INTERNAL USE ONLY: Returns an array of field IDs that have already been fetched & populated.
	 * @access public
	 * @return array
	 */
	function getFetchedFieldIDs()
	{
		return $this->_fetchedValueIDs;
	}
	
	/**
	* Uses the {@link RecordTagManager} service to add a tag of the current state (in the DB) of this DMRecord.
	* @return void
	* @param optional object $date An optional {@link DateAndTime} to specify the date that should be attached to the tag instead of the current date/time.
	*/
	function tag($date=null) {
		$this->makeCurrent();
		$tagMgr = Services::getService("RecordTagManager");
		$tagMgr->tagRecord($this, $date);
	}
	
	/**
	* Calls both commit() and tag().
	* @return void
	* @param optional object $date An optional {@link DateAndTime} object for tagging. If specified, it will use $date instead of the current date and time.
	*/
	function commitAndTag($date=null) {
		$this->commit();
		$this->tag($date);
	}
	
	/**
	 * INTERNAL USE ONLY: Returns our current fetch mode.
	 * @access public
	 * @return int
	 */
	function getFetchMode()
	{
		return $this->_fetchMode;
	}
	
	/**
	* Creates an exact (specific to the data) copy of the DMRecord, that can then be inserted into
	* the DB as a new set with the same data.
	* @return ref object A new {@link DMRecord} object.
	*/
	function replicate() {
		
		$this->makeFull();
		
		$newSet = new DMRecord($this->_schema, $this->_versionControlled);
		// @todo
		foreach ($this->_schema->getAllIDs() as $id) {
			$label = $this->_getFieldLabel($id);
			foreach($this->getIndices($label, true) as $i) {
				$newSet->_fields[$id]->_values[$i] =$this->_fields[$id]->_values[$i]->replicate($newSet->_fields[$id]);
				$newSet->_fields[$id]->_numValues++;
			}
		}
		
		return $newSet;
	}
	
	/**
	* Goes through all the old versions of values and actually DELETES them from the database.
	* @param ref object $versionConstraint A {@link VersionConstraint) on which to base our pruning.
	* @return void
	*/
	function prune($versionConstraint) {
		
		$this->makeFull();
				
		$this->_pruneConstraint =$versionConstraint;
		$this->_prune=true;
		
		// just step through each FieldValues object and call prune()
		foreach ($this->_schema->getAllIDs(true) as $id) {
			$this->_fields[$id]->prune($versionConstraint);
		}
	}
	
	/**
	* Changes this Records active flag.
	* @param boolean $bool The new value.
	* @return void
	* @deprecated does nothing
	*/
	function setActiveFlag($bool) {
		// does nothing
	}
	
	/**
	* Takes a tag object and activates the appropriate versions of values based on the tag mappings.
	* @return bool
	* @param ref object $tag A {@link RecordTag} object.
	*/
	function activateTag($tag) {
		// check to make sure the tag is affiliated with us
		if ($this->getID() != $tag->getRecordID()) {
			throwError (new HarmoniError("Can not activate tag because it is not affiliated with this DMRecord.","DMRecord",true));
			return false;
		}
		
		// load the mapping data for the tag
		$tag->load();
		
		$this->makeFull();
		
		foreach ($this->_schema->getAllIDs(true) as $id) {
			// if the tag doesn't have any mappings for $label, skip it
//			if (!$tag->haveMappings($label)) continue;
			$label = $this->_getFieldLabel($id);
			foreach ($this->getIndices($label, true) as $i) {
				$newVerID = $tag->getMapping($id, $i);
				
				// go through each version and deactivate all versions unless they are active and $verID
				$vers =$this->getVersions($label, $i);
				foreach (array_keys($vers) as $verID) {
					$verObj =$vers[$verID];
					
					// if it's our active vers in the RecordTag, activate it
					if ($verID == $newVerID) {
						if (!$verObj->isActive()) {
							$verObj->setActiveFlag(true);
							$verObj->update();
						}
					}
					
					// if it's not, deactivate it
					else {
						if ($verObj->isActive()) {
							$verObj->setActiveFlag(false);
							$verObj->update();
						}
					}
				}
			}
		}
		return true;
	}
	
	/**
	 * Returns an array of hashed values for all of our fields. If a field allows multiple values, we return an array of those values instead of just the string value.
	 * @access public
	 * @return array format: array = ("single"=>value, "multiple"=>array(value1,value2,...));
	 */
	function getValuesArray()
	{
		$this->makeCurrent();
		$array = array();
		$array["__id"] = $this->getID();
		
		$ids = $this->_schema->getAllIDs();
		foreach ($ids as $id) {
			$field = $this->_fields[$id]->getSchemaField();
			$label = $this->_getFieldLabel($id);
			if ($field->getMultFlag()) {
				$array[$label] = array();
				foreach ($this->getIndices($label) as $i) {
					$value =$this->getValue($label,$i);
					$array[$label][] = $value->asString();
				}
			} else {
				if ($this->numValues($label)) {
					$value =$this->getValue($label);
					$array[$label] = $value->asString();
				}
			}
		}
		
		return $array;
	}
	
	/**
	 * INTERNAL USE ONLY: makes sure that our representation of the data includes ALL values, active and inactive.
	 * @access public
	 * @return void
	 */
	function makeFull()
	{
		// we will get the RecordManager and ask it to re-fetch our values. We'll also have it exclude those values
		// that we already have fetched.
		if ($this->getFetchMode() >= RECORD_FULL) return;
		
		if (!$this->getID()) return;
		
		$recordManager = Services::getService("RecordManager");
		$recordManager->fetchRecord($this->getID(), RECORD_FULL);
	}
	
	/**
	 * INTERNAL USE ONLY: Makes sure that our representation of the data includes all current values.
	 * @access public
	 * @return void
	 */
	function makeCurrent()
	{
		// we will get the RecordManager to fetch our fields from the database
		if ($this->getFetchMode() >= RECORD_CURRENT) return;

//		print "<b>makeCurrent()</b><br />";
//		printDebugBacktrace(debug_backtrace());
		
		if (!$this->getID()) return;
		
		$recordManager = Services::getService("RecordManager");
		$recordManager->fetchRecord($this->getID(), RECORD_CURRENT);
	}
	
	/**
	 * Deletes the record entirely from the database upon calling commit().
	 * @access public
	 * @return void
	 */
	function delete()
	{
		$this->_delete = true;
		$this->makeFull();
		// also remove all of our data
		$this->prune(new PruneAllVersionConstraint());
	}

}

/**
 *@package harmoni.datamanager
 */
class FieldNotFoundError extends HarmoniError {
	function __construct($label,$type) {
		parent::Error("The field labeled '$label' was not found in schema '$type'.","DMRecord",true);
	}
}

/**
 * @package harmoni.datamanager
 */
class ValueIndexNotFoundError extends HarmoniError {
	function __construct($label,$id,$index) {
		parent::Error("The value index $index was not found for field '$label' in DMRecord ID $id.","DMRecord",true);
	}
}