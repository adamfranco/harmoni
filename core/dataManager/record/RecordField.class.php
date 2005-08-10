<?

require_once HARMONI."dataManager/record/RecordFieldValue.class.php";

/**
 * Holds a number of indexes for values within a specific field within a Record. For those fields with
 * only one value, only index 0 will be used. Otherwise, indexes will be created in numerical order (1, 2, ...).
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RecordField.class.php,v 1.16 2005/08/10 13:25:21 gabeschine Exp $
 **/
class RecordField {
	
	var $_values;
	
	var $_parent;
	var $_schemaField;
	var $_myLabel;
	
	var $_id;
	
	function RecordField( &$schemaField, &$parent ) {
		$this->_myLabel = $schemaField->getLabel();
		
		$this->_parent =& $parent;
		$this->_schemaField =& $schemaField;
		
		$this->_values = array();
	}
	
	/**
	* Takes a number of DB rows and sets up {@link RecordFieldValue} objects corresponding to the data within the rows.
	* @return bool
	* @param ref array $arrayOfRows
	*/
	function populate( &$arrayOfRows ) {
		foreach (array_keys($arrayOfRows) as $key) {
			$this->takeRow($arrayOfRows[$key]);
		}
	}
	
	/**
	 * Takes a single row from a database and attempts to populate local objects.
	 * @param ref array $row
	 * @return void
	 */
	function takeRow( &$row ) {
		// If we don't just have null values...
		if ($row['record_field_index'] != NULL) {
			$i = $row['record_field_index'];
			if (!isset($this->_values[$i])) {
//				print "importing index $i : " . print_r($row, 1) . "<br>";
				$this->_values[$i] =& new RecordFieldValue($this,$i);
			}
			$this->_values[$i]->takeRow($row);
		}
	}
	
	/**
	 * Returns the indices for a multi-valued field. Will only return those values that are active (for version-controlled Records).
	 * @param optional boolean $includeInactive Includes inactive indices as well.
	 * @access public
	 * @return array
	 */
	function getIndices($includeInactive = false)
	{
		if ($includeInactive)
			return array_keys($this->_values);
		
		$array = array();
		foreach (array_keys($this->_values) as $key) {
			if (!$this->isIndexDeleted($key))
				$array[] = $key;
		}
		
		return $array;
	}
	
	/**
	 * Re-indexes all the values so that they start from 0 and increment by 1. Useful when indexes in the middle have been deleted.
	 * @access public
	 * @return void
	 */
	function reIndex()
	{
		$this->_parent->makeFull();
		
		$indices = $this->getIndices();
		
		$i = 0;
		$newValues = array();
		
		foreach($indices as $index) {
			$value =& $this->getRecordFieldValue($index);
			$value->setIndex($i);
			$newValues[$i] =& $value;
			$i++;
		}
		
		$this->_values =& $newValues;
	}
	
	/**
	* Spiders through each index and calls commit() on it.
	* @return void
	*/
	function commit() {
		// cycle through each index and commit()
		// if any indexes are going to be completely pruned, we need to keep track of those
		// so that we can unset them after we're done comitting. 
		
		$pruned = array();
		
		foreach ($this->getIndices(true) as $i) {
			if ($this->_values[$i]->willPruneAll()) $pruned[] = $i;
			$this->_values[$i]->commit();
		}
		
		foreach ($pruned as $i) {
				unset ($this->_values[$i]);
		}
	}
	
	/**
	* Goes through all the old versions of values and actually DELETES them from the database once commit() is called.
	* @param ref object $versionConstraint A {@link VersionConstraint) on which to base our pruning.
	* @return void
	*/
	function prune($versionConstraint) {
		$this->_parent->makeFull();
		// just step through each ValueVersions object and call prune()
		$j = 0;
		foreach ($this->getIndices(true) as $i) {
			$this->_values[$i]->prune($versionConstraint);
			
			// now, if we are pruning and we will completely remove an index within this field,
			// we need to re-index the fields and make sure they update.
			// so, if the field is going to have an active value, then we're going to re-index it (???? or always?)
			$this->_values[$i]->setIndex($j++);
		}
	}
	
	/**
	* Returns the {@link RecordFieldValue} object associated with $index.
	* @return ref object
	* @param int $index
	*/
	function &getRecordFieldValue($index) {
		$this->_parent->makeCurrent();
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index];
	}
	
	/**
	* Checks to make sure that the {@link Primitive} object is of the appropriate type for this label.
	* @return bool
	* @param ref object $object The {@link Primitive} object.
	*/
	function _checkObjectType(&$object) {
		$dataTypeManager =& Services::getService("DataTypeManager");
		$type = $this->_schemaField->getType();
		
		if ($dataTypeManager->isObjectOfDataType($object,$type)) return true;
		
		// otherwise... throw an error.
		throwError( new Error(
		"While trying to add/set a value in Record ID ".$this->_parent->getID().", we recieved an unexpected
		data type. Expecting: $type, but got an object of class ".get_class($object).".", "Record",true));
		return false;
	}
	
	/**
	* Adds $value to a new index within this label, assuming it allows multiple values.
	* @return bool
	* @param ref object $value A {@link SObject} object.
	*/
	function addValueFromPrimitive(&$value) {
		// make sure that we have all our values & indices represented before trying to add a new one
		// or we might "overwrite" an existing one that's been deactivated.
		$this->_parent->makeFull();

		// if we are one-value only and we already have a value, throw an error.
		// allow addValue() if we don't have any values yet.
		if (!$this->_schemaField->getMultFlag() && $this->numValues(true)) {
			$label = $this->_myLabel;
			throwError ( new Error(
			"Field label '$label' can not add a new value because it does not allow multiple
				values. In Schema ".$this->_parent->getSchemaID().".",
			"Record",true));
			return false;
		}
		$this->_checkObjectType($value);
		
		$newIndex = $this->_getNextAvailableIndex();
		
		$this->_values[$newIndex] =& new RecordFieldValue($this, $newIndex);
		$this->_values[$newIndex]->setValueFromPrimitive($value);
		return true;
	}
	
	function _getNextAvailableIndex() {
		for($i=0; true; $i++) {
			if (!in_array($i,$this->getIndices(true))) return $i;
		}
		print "<b>Eh? We can't find a new index?</b><br />";
		printDebugBacktrace(); exit();
	}
	
	/**
	* Attempts to set the value of $index to $value. If the Record is version controlled, this will 
	* add a new version rather than set the existing value.
	* @return bool
	* @param int $index
	* @param ref object $value A {@link SObject} object.
	*/
	function setValueFromPrimitive($index, &$value) {
		$this->_parent->makeFull();
		// any field can have at least one value.. if index 0 is not yet set up, set it up
		if ($index == 0 && !isset($this->_values[0])) {
			$this->addValueFromPrimitive($value);
		}
		
		if (!isset($this->_values[$index])) {
			// if we allow multiple values, just create a new value at $index
			if ($this->_schemaField->getMultFlag()) {
				$this->_values[$index] =& new RecordFieldValue($this, $index);
			} else
				throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		return $this->_values[$index]->setValueFromPrimitive($value);
	}
	
	/**
	* Deactivates all versions under index $index.
	* @return bool
	* @param int $index
	*/
	function deleteValue($index) {
		
		$this->_parent->makeCurrent();
		
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		// if we are version-controlled, just unset the active flag.
		// otherwise, we will actually delete the value from the db.
		// this functionality is actually handled by RecordFieldValue
		$this->_values[$index]->setActiveFlag(false);
		return true;
	}	
	
	/**
	* Re-activates the newest version of $index.
	* @return bool
	* @param int $index
	*/
	function undeleteValue($index) {
		
		$this->_parent->makeFull();
		
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		$this->_values[$index]->setActiveFlag(true);
		return true;
	}
	
	/**
	 * Checks if the index has been deleted.
	 * @param integer $index
	 * @access public
	 * @return bool
	 */
	function isIndexDeleted($index)
	{
		$this->_parent->makeFull();
		
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		return !$this->_values[$index]->isActive();
	}
	
	/**
	* Returns the number of values for this label we have set.
	* @return int
	* @access public
	* @param optional boolean $includeInactive if TRUE will include inactive values in the count.
	*/
	function numValues($includeInactive = false) { 
		if ($includeInactive) {
			$this->_parent->makeFull(); 
			return count($this->_values);
		}
		
		$this->_parent->makeCurrent();
		return count($this->getIndices());		
	}

	/**
	* Returns the number of versions we have set for specific $index.
	* @return int
	* @param optional int $index Defaults to 0.
	*/
	function numVersions( $index=0 ) {
		$this->_parent->makeFull();
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index]->numVersions();
	}
	
	/**
	* Returns an array of version IDs associated with $index.
	* @return array
	* @param optional int $index Defaults to 0.
	*/
	function getVersionIDs( $index=0 ) {
		$this->_parent->makeFull();
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index]->getVersionIDs();
	}
	
	/**
	* Returns the {@link RecordFieldData} object associated with $verID under $index.
	* @return ref object
	* @param int $verID
	* @param optional int $index Defaults to 0.
	*/
	function &getVersion( $verID, $index=0 ) {
		$this->_parent->makeFull();
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		return $this->_values[$index]->getVersion($verID);
	}
	
	/**
	 * Returns the Record object that the current object is a part of.
	 * @return ref object Record The parent Record object
	 */
	function &getRecord() {
		return $this->_parent;
	}
	
	/**
	 * Returns the {@link SchemaField} object for the this RecordField object.
	 * @return ref objectThe {@link SchemaField} object.
	 */
	function &getSchemaField() {
		return $this->_schemaField;
	}

	/**
	 * Returns the id of this RecordField object.
	 * @return ref object Id The id of this RecordField object.
	 */
	function &getId() {
		if (!isset($this->_id)) {
			if (OKI_VERSION > 1)
				$idManager =& Services::getService("Id");
			else
				$idManager =& Services::getService("Shared");
			
			$idString = $this->_parent->getID()."::".$this->_myLabel;
			$this->_id =& $idManager->getId($idString);
		}
		return $this->_id;
	}
	
}

?>
