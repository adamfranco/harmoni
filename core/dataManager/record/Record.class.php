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
* A Record is a set of data matching a certain {@link Schema}. The Record can be fetched from the database in a number of
* ways, which can be changed at runtime. See the RECORD_* constants.
* @access public
* @package harmoni.datamanager
* @version $Id: Record.class.php,v 1.15 2005/01/03 20:50:31 adamfranco Exp $
* @copyright 2004, Middlebury College
*/
class Record {
	
	var $_myID;
	var $_active;
	
	var $_schema;
	var $_versionControlled;
	var $_fields;
	var $_creationDate;
	var $_dateFromDB = false;
	var $_fetchMode;
	var $_fetchedValueIDs;

	var $_prune;
	var $_pruneConstraint;
	
	function Record(&$schema, $verControl=false) {
		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		ArgumentValidator::validate($schema, new ExtendsValidatorRule("Schema"));

		$this->_schema =& $schema;
		$this->_fields = array();
		$this->_versionControlled = $verControl;
		$this->_active = true;
		$this->_fetchMode = -1;
		$this->_fetchedValueIDs = array();
		
		$this->_myID = null;
		
		$this->_creationDate =& DateTime::now();
		
		// set up the individual fields
		foreach ($schema->getAllLabels(true) as $label) {
			$def =& $schema->getField($label);
			$this->_fields[$label] =& new RecordField($def, $this);
			unset($def);
		}
	}
	
	/**
	 * Returns this dataset's DataSetTypeDefinition
	 * @return ref object
	 */
	function &getSchema() {
		return $this->_schema;
	}
	
	/**
	 * Returns the indices (indexes) of each value for the given field. Can then be retrieved with any getValue-type function.
	 * @access public
	 * @param string $label
	 * @return array An array of integers
	 */
	function getIndices($label)
	{
		return $this->_fields[$label]->getIndices();
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
	 * Returns the OKI type associated with this Record.
	 * @return ref object
	 */
	function &getType() {
		return $this->_schema->getType();
	}
	
	/**
	* Returns this Record's ID.
	* @return int
	*/
	function getID() { 
		return $this->_myID;
	}
	
	function _checkLabel($label) {
		if (!$this->_schema->fieldExists($label)) {
			throwError(new FieldNotFoundError($label,OKITypeToString($this->_schema->getType())));
			return false;
		}
		return true;
	}
	
	/**
	 * Re-indexes all the values in a multi-valued field so that they increment by 1 started at 0. 
	 * @access public
	 * @return void
	 */
	function reIndex($label)
	{
		$this->_checkLabel($label);
		
		$this->_fields[$label]->reIndex();
	}
	
	/**
	* Returns the active {@link RecordFieldData} object for value $index under $label.
	* @return ref object
	* @param string $label
	* @param optional int $index default=0.
	*/
	function &getCurrentValue($label, $index=0) {
		$this->_checkLabel($label);
		
		$versions =& $this->getRecordFieldValue($label, $index);
		
		return $versions->getActiveVersion();
	}
	
	/**
	 * Returns the active {@link Primitive} value for the given $index under $label.
	 * @param string $label
	 * @param optional integer $index defaults to 0
	 * @access public
	 * @return ref object
	 */
	function &getCurrentValuePrimitive($label, $index=0)
	{
		$value =& $this->getCurrentValue($label, $index);
		return $value->getPrimitive();
	}
	
	/**
	 * Returns the active value for a label/index by calling $function on the {@link Primitive} that is returned.
	 * @param string $function The function to call.
	 * @param string $label The label.
	 * @param optional int $index defaults to 0
	 * @access public
	 * @return ref mixed
	 */
	function &getCurrentValueByFunction($function, $label, $index=0)
	{
		$prim =& $this->getCurrentValuePrimitive($label, $index);
		return $prim->$function();
	}
	
	/**
	 * Returns a string value for $index under $label. What is returned depends on the DataType.
	 * @param string $label
	 * @param optional int $index default=0.
	 */
	function getStringValue($label, $index=0) {
		
		$actVer =& $this->getCurrentValue($label, $index);
		if (!$actVer) return null;
		
		$val =& $actVer->getPrimitive();
		if (!$val) return null;
		
		return $val->toString();
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
	* Returns the {@link RecordFieldValue} object associated with $index under $label.
	* @return ref object
	* @param string $label
	* @param optional int $index default=0.
	*/
	function &getRecordFieldValue($label, $index=0) {
		$this->_checkLabel($label);
		return $this->_fields[$label]->getRecordFieldValue($index);
	}
	
	/**
	* Returns an array of {@link RecordFieldValue} objects for all indexes under $label.
	* @return ref array
	* @param string $label
	*/
	function &getAllRecordFieldValues($label) {
		$this->_checkLabel($label);
		return $this->_fields[$label]->getAllRecordFieldValues();
	}
	
	/**
	* INTERNAL USE ONLY: Creates a number of {@link RecordFieldValue} objects based on an array of database rows.
	* @return bool
	* @param ref array $arrayOfRows
	*/
	function populate( &$arrayOfRows ) {
		
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
	function takeRow( &$row ) {
		
		// see if we can't get our ID from the row
		if (!$this->_myID && $row['record_id']) 
			$this->_myID = $row['record_id'];
		else if ($row['record_id'] != $this->_myID) {
			throwError( new Error("Can not take database row because it does not seem to correspond with our
			Record ID.", "Record",true));
		}
		
		// let's check if we have our creation date set yet.
		if (!$this->_dateFromDB) {
			$dbHandler=& Services::getService("DBHandler");
			$this->_creationDate =& $dbHandler->fromDBDate($row["record_created"], DATAMANAGER_DBID);
			$this->_dateFromDB = true;
		}
		
		// if this is an empty Record, we're going to get a row with NULL values for all
		// columns not in the "dm_record_field" table. so, let's check for that and return if it's the case.
		if (!$row['record_field_id']) return;
		
		// now, we need to check if we've already accounted for this specific value from the database
		if (in_array($row['record_field_id'], $this->_fetchedValueIDs)) return;
		$label = $row['schema_field_label'];

		if (!isset($this->_fields[$label])) {
			throwError( new Error("Could not populate Record with label '$label' because it doesn't
				seem to be defined in the Schema.","record",true));
		}
		
		$this->_fields[$label]->takeRow($row);
		
		$this->_fetchedValueIDs[] = $row['record_field_id'];
		
	}
	
	/**
	 * Returns the {@link DateTime} object specifying when this Record was created.
	 * @access public
	 * @return ref object
	 */
	function &getCreationDate()
	{
		return $this->_creationDate;
	}
	
	/**
	* Returns the number of values we have set for $label.
	* @return int
	* @param string $label
	*/
	function numValues($label) {
		$this->_checkLabel($label);
		
		return $this->_fields[$label]->numValues();
	}
	
	/**
	* Returns TRUE if this DataSet was created with Version Control.
	* @return bool
	*/
	function isVersionControlled() {
		return $this->_versionControlled;
	}
	
	/**
	 * Returns if this DataSet is active or not.
	 * @return bool
	 */
	function isActive() {
		return $this->_active;
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
		
		$this->_fields[$label]->deleteValue($index);
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
		
		$this->_fields[$label]->undeleteValue($index);
	}
	
	/**
	 * Returns true if the given value has been deleted.
	 * @param string $label the field label to check.
	 * @param optional int $index The index (defaults to 0) to check.
	 * @access public
	 * @return bool
	 */
	function deleted($label, $index = 0)
	{
		$this->_checkLabel($label);
		
		return $this->_fields[$label]->deleted($index);
	}
	
	/**
	* Sets the value of $index under $label to $obj where $obj is a {@link Primitive}.
	* @return bool
	* @param string $label
	* @param ref object $obj
	* @param optional int $index default=0
	*/
	function setValue($label, &$obj, $index=0) {
		$this->_checkLabel($label);
		if ($index == NEW_VALUE) {
			return $this->_fields[$label]->addValueFromPrimitive($obj);
		}
		return $this->_fields[$label]->setValueFromPrimitive($index, $obj);
	}
	
	/**
	* Commits (either inserts or updates) the data for this Record into the database.
	* @param boolean optional $ignoreMandatory If true, doesn't fail if mandatory
	*		fields don't have values.
	* @return bool
	*/
	function commit($ignoreMandatory=false) {
		// the first thing we're gonna do is check to make sure that all our required fields
		// have at least one value.
		foreach ($this->_schema->getAllLabels() as $label) {
			$fieldDef =& $this->_schema->getField($label);
			if ($fieldDef->isRequired() && ($this->_fields[$label]->numValues() == 0 ||
					$this->_fields[$label]->numActiveValues() == 0) && !$ignoreMandatory) {
				throwError(new Error("Could not commit Record to database because the required field '$label' does
				not have any values!","Record",true));
				return false;
			}
		}
		
		// Get the DBHandler
		$dbHandler =& Services::getService("DBHandler");
		
		if ($this->_myID) {
			// we're already in the database
			$query =& new UpdateQuery();
			
			$query->setTable("dm_record");
			$query->setColumns(array("active","ver_control"));
			$query->setValues(array(
				($this->_active)?1:0,
				($this->_versionControlled)?1:0
				));
			$query->setWhere("id=".$this->_myID);

			// execute the query;
			$result =& $dbHandler->query($query,DATAMANAGER_DBID);
			
		} else {
			// we'll have to make a new entry
			$schemaManager =& Services::getService("SchemaManager");
			
			$sharedManager =& Services::getService("Shared");
			$id =& $sharedManager->createId();
			$this->_myID = $id->getIdString();
			
			$query =& new InsertQuery();
			$query->setTable("dm_record");
			$query->setColumns(array("id","fk_schema","created","active","ver_control"));
			$query->addRowOfValues(array(
				$this->_myID,
				$this->_schema->getID(),
				$dbHandler->toDBDate($this->_creationDate,DATAMANAGER_DBID),
				($this->_active)?1:0,
				($this->_versionControlled)?1:0
				));
		}
		
		// execute the query;		
		$result =& $dbHandler->query($query,DATAMANAGER_DBID);
		
		if (!$result) {
			throwError( new UnknownDBError("Record") );
			return false;
		}
		
		// now let's cycle through our FieldValues and commit them
		foreach ($this->_schema->getAllLabels() as $label) {
			$this->_fields[$label]->commit();
		}
		
		if ($this->_prune) {
			$constraint =& $this->_pruneConstraint;
			
			// check if we have to delete any dataset tags based on our constraints
			$constraint->checkTags($this);
			
			$tagMgr =& Services::getService("TagManager");
			
			// if we are no good any more, delete ourselves completely
			if (!$constraint->checkRecord($this)) {
				// now, remove any tags from the DB that have to do with us, since they will no longer
				// be valid.
				$tagMgr->pruneTags($this);
				
				$query =& new DeleteQuery();
				$query->setTable("dm_record");
				$query->setWhere("id=".$this->getID());
				
				$dbHandler->query($query, DATAMANAGER_DBID);

				$query =& new DeleteQuery();
				$query->setTable("dm_record_set");
				$query->setWhere("fk_record=".$this->getID());

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
	* Uses the {@link TagManager} service to add a tag of the current state (in the DB) of this Record.
	* @return void
	* @param optional object $date An optional {@link DateTime} to specify the date that should be attached to the tag instead of the current date/time.
	*/
	function tag($date=null) {
		$this->makeCurrent();
		$tagMgr =& Services::getService("TagManager");
		$tagMgr->tagRecord($this, $date);
	}
	
	/**
	* Calls both commit() and tag().
	* @return void
	* @param optional object $date An optional {@link DateTime} object for tagging. If specified, it will use $date instead of the current date and time.
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
	* Creates an exact (specific to the data) copy of the Record, that can then be inserted into
	* the DB as a new set with the same data.
	* @return ref object A new {@link Record} object.
	*/
	function &clone() {
		
		$this->makeFull();
		
		$newSet =& new Record($this->_schema, $this->_versionControlled);
		// @todo
		foreach ($this->_schema->getAllLabels() as $label) {
			for($i=0;$i<$this->numValues($label); $i++) {
				$newSet->_fields[$label]->_values[$i] =& $this->_fields[$label]->_values[$i]->clone($newSet->_fields[$label]);
				$newSet->_fields[$label]->_numValues++;
			}
		}
		
		return $newSet;
	}
	
	/**
	* Goes through all the old versions of values and actually DELETES them from the database.
	* @param ref object $versionConstraint A {@link VersionConstraint) on which to base our pruning.
	* @return void
	*/
	function prune(&$versionConstraint) {
		
		$this->makeFull();
				
		$this->_pruneConstraint =& $versionConstraint;
		$this->_prune=true;
		
		// just step through each FieldValues object and call prune()
		foreach ($this->_schema->getAllLabels(true) as $label) {
			$this->_fields[$label]->prune($versionConstraint);
		}
	}
	
	/**
	* Changes this Records active flag.
	* @param boolean $bool The new value.
	* @return void
	*/
	function setActiveFlag($bool) {
		ArgumentValidator::validate($bool, new BooleanValidatorRule());
		$this->_active = $bool;
	}
	
	/**
	* Takes a tag object and activates the appropriate versions of values based on the tag mappings.
	* @return bool
	* @param ref object $tag A {@link Tag} object.
	*/
	function activateTag(&$tag) {
		// check to make sure the tag is affiliated with us
		if ($this->getID() != $tag->getRecordID()) {
			throwError (new Error("Can not activate tag because it is not affiliated with this Record.","Record",true));
			return false;
		}
		
		// load the mapping data for the tag
		$tag->load();
		
		$this->makeFull();
		
		foreach ($this->_schema->getAllLabels(true) as $label) {
			// if the tag doesn't have any mappings for $label, skip it
//			if (!$tag->haveMappings($label)) continue;
			for ($i=0; $i<$this->numValues($label); $i++) {
				$newVerID = $tag->getMapping($label, $i);
				
				// go through each version and deactivate all versions unless they are active and $verID
				$vers =& $this->getRecordFieldValue($label, $i);
				foreach ($vers->getVersionIDs() as $verID) {
					$verObj =& $vers->getVersion($verID);
					
					// if it's our active vers in the Tag, activate it
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
		
		$labels = $this->_schema->getAllLabels();
		foreach ($labels as $label) {
			$field = $this->_fields[$label]->getSchemaField();
			if ($field->getMultFlag()) {
				$array[$label] = array();
				foreach ($this->getIndices($label) as $i) {
					$value =& $this->getCurrentValue($label,$i);
					$primitive =& $value->getPrimitive();
					$array[$label][] = $primitive->toString();
				}
			} else {
				if ($this->numValues($label)) {
					$value =& $this->getCurrentValue($label);
					$primitive =& $value->getPrimitive();
					$array[$label] = $primitive->toString();
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
		
//		print "<b>makeFull()</b><br />";
//		printDebugBacktrace(debug_backtrace());
		
		if (!$this->getID()) return;
		
		$recordManager =& Services::getService("RecordManager");
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
		
		$recordManager =& Services::getService("RecordManager");
		$recordManager->fetchRecord($this->getID(), RECORD_CURRENT);
	}
	
	/**
	 * Deletes this record (de-activeates it). If $prune=true, it will also be removed from the database upon commit().
	 * @param optional bool $prune If set to TRUE will remove all records from the database upon commit().
	 * @access public
	 * @return void
	 */
	function delete($prune=false)
	{
		$this->setActiveFlag(false);
		if ($prune) $this->prune(new PruneAllVersionConstraint());
	}

}

/**
 *@package harmoni.datamanager
 */
class FieldNotFoundError extends Error {
	function FieldNotFoundError($label,$type) {
		parent::Error("The field labeled '$label' was not found in schema '$type'.","Record",true);
	}
}

/**
 * @package harmoni.datamanager
 */
class ValueIndexNotFoundError extends Error {
	function ValueIndexNotFoundError($label,$id,$index) {
		parent::Error("The value index $index was not found for field '$label' in Record ID $id.","Record",true);
	}
}

?>
