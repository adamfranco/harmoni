<?

require_once HARMONI."metaData/manager/ValueVersions.classes.php";

/**
 * Holds a number of indexes for values within a specific field within a DataSet. For those fields with
 * only one value, only index 0 will be used. Otherwise, indexes will be created in numerical order (1, 2, ...).
 * @package harmoni.datamanager
 * @version $Id: FieldValues.class.php,v 1.18 2004/01/26 19:16:22 adamfranco Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class FieldValues {
	
	var $_numValues;
	var $_values;
	
	var $_parent;
	var $_fieldDefinition;
	var $_myLabel;
	
	function FieldValues( &$fieldDefinition, &$parent, $label ) {
		$this->_numValues = 0;
		
		$this->_myLabel = $label;
		
		$this->_parent =& $parent;
		$this->_fieldDefinition =& $fieldDefinition;
		
		$this->_values = array();
	}
	
	/**
	* Takes a number of DB rows and sets up {@link ValueVersions} objects corresponding to the data within the rows.
	* @return bool
	* @param ref array $arrayOfRows
	*/
	function populate( &$arrayOfRows ) {
		foreach (array_keys($arrayOfRows) as $key) {
			$this->takeRow($arrayOfRows[$key]);
		}
		
		// ok, we are responsible for keeping track of multiple values for any given
		// label. we'll go through the rows and group them by index
//		$packages = array();
		
//		foreach ($arrayOfRows as $line) {
//			$index = $line['datasetfield_index'];
//			if (!is_numeric($index)) {
//				throwError( new Error(
//					"Serious error in FieldValues. Index '$index' given to us is not numeric!","FieldValues",true));
//				return false;
//			}
//			
//			if (!is_array($packages[$index])) $packages[$index] = array();
//			$packages[$index][] = $line;
//		}
//		
//		// no go through each index and setup the ValueVersions object.
//		$i = -1;
//		foreach (array_keys($packages) as $index) {
//			$i = $this->_parent->readOnly()?$i+1:$index; // this is to compensate for skipped indexes - see below
//			$this->_values[$i] =& new ValueVersions($this,$i);
//			$this->_values[$i]->populate($packages[$index]);
//			$this->_numValues++;
//		}
		
		// if the dataset is fetched read-only, we have to be sure that our indexes are
		// in order, going from 0 -> numValues. if an index was deleted, there may
		// be a gap.
//		$tmp =& array_slice($this->_values,0);
//		$this->_values =& $tmp;
	}
	
	/**
	 * Takes a single row from a database and attempts to populate local objects.
	 * @param ref array $row
	 * @return void
	 */
	function takeRow( &$row ) {
		// If we don't just have null values...
		if ($row['datasetfield_index'] != NULL) {
			$index = $row['datasetfield_index'];
			// the below will: if we are readOnly (compact), then only one value (one row) will be
			// passed for each index, so we number the indexes ourselves. otherwise, the real index
			// is used, and we number them that way.
			$i = $this->_parent->readOnly()?count($this->_values):$index; // this is to compensate for skipped indexes
			if (!isset($this->_values[$i])) {
				$this->_values[$i] =& new ValueVersions($this,$i);
				$this->_numValues++;
			}
			$this->_values[$i]->takeRow($row);
		}
	}
	
	/**
	* Spiders through each index and calls commit() on it.
	* @return void
	*/
	function commit() {
		// cycle through each index and commit()
		for ($i=0; $i<$this->numValues(); $i++) {
			$this->_values[$i]->commit();
		}
	}
	
	/**
	* Goes through all the old versions of values and actually DELETES them from the database.
	* @param ref object $versionConstraint A {@link VersionConstraint) on which to base our pruning.
	* @return void
	*/
	function prune($versionConstraint) {
		if ($this->_parent->readOnly()) return;
		// just step through each ValueVersions object and call prune()
		for ($i=0, $j=0; $i<$this->numValues(); $i++) {
			$this->_values[$i]->prune($versionConstraint);
			
			// now, if we are pruning and we will completely remove an index within this field,
			// we need to re-index the fields and make sure they update.
			// so, if the field is going to have an active value, then we're going to re-index it
			if ($this->_values[$i]->isActive()) {
				if ($this->_values[$i]->setIndex($j++)) {
					$ver =& $this->_values[$i]->getActiveVersion();
					$ver->update();
				}
			}
		}
	}
	
	/**
	* Returns the {@link ValueVersions} object associated with $index.
	* @return ref object
	* @param int $index
	*/
	function &getValue($index) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index];
	}
	
	/**
	* Returns an array of {@link ValueVersions} objects set for each index.
	* @return array
	*/
	function &getAllValues() {
		return $this->_values;
	}
	
	/**
	* Checks to make sure that the {@link DataType} object is of the appropriate type for this label.
	* @return bool
	* @param ref object $object The {@link DataType} object.
	*/
	function _checkObjectType(&$object) {
		$dataTypeManager =& Services::requireService("DataTypeManager");
		$type = $this->_fieldDefinition->getType();
		
		if ($dataTypeManager->isObjectOfDataType($object,$type)) return true;
		
		// otherwise... throw an error.
		throwError( new Error(
		"While trying to add/set a value in DataSet ID ".$this->_parent->getID().", we recieved an unexpected
		data type. Expecting: $type, but got an object of class ".get_class($object).".", "FieldValues",true));
		return false;
	}
	
	/**
	* Adds $value to a new index within this label, assuming it allows multiple values.
	* @return bool
	* @param ref object $value A {@link DataType} object.
	*/
	function addValue(&$value) {
		if ($this->_parent->readOnly()) {
			throwError( new Error("Can not add value to DataSet because it was fetched
			from the database readonly. You must re-fetch it fully to make changes.","FieldValues",true));
		}
		
		// if we are one-value only and we already have a value, throw an error.
		// allow addValue() if we don't have any values yet.
		if (!$this->_fieldDefinition->getMultFlag() && $this->_numValues) {
			$label = $this->_myLabel;
			throwError ( new Error(
			"Field label '$label' can not add a new value because it does not allow multiple
				values. In DataSetType ".OKITypeToString($this->_parent->_dataSetTypeDef->getType()).".",
			"DataSet",true));
			return false;
		}
		$this->_checkObjectType($value);
		
		$this->_values[$this->_numValues] =& new ValueVersions($this, $this->_numValues);
		$this->_values[$this->_numValues]->setValue($value);
		$this->_numValues++;
		return true;
	}
	
	/**
	* Attempts to set the value of $index to $value. If the DataSet is version controlled, this will 
	* add a new version rather than set the existing value.
	* @return bool
	* @param int $index
	* @param ref object $value A {@link DataType} object.
	*/
	function setValue($index, &$value) {
		if ($this->_parent->readOnly()) {
			throwError( new Error("Can not set value in DataSet because it was fetched
			from the database readonly. You must re-fetch it fully to make changes.","FieldValues",true));
		}
		
		// any field can have at least one value.. if index 0 is not yet set up, set it up
		if ($index == 0 && !isset($this->_values[0])) {
			$this->_values[0] =& new ValueVersions($this, 0);
			$this->_numValues++;
		}
		
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		return $this->_values[$index]->setValue($value);
	}
	
	/**
	* Deactivates all versions under index $index.
	* @return bool
	* @param int $index
	*/
	function deleteValue($index) {
		if ($this->_parent->readOnly()) {
			throwError( new Error("Can not set value in DataSet because it was fetched
			from the database readonly. You must re-fetch it fully to make changes.","FieldValues",true));
		}
		
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		return $this->_values[$index]->delete();
	}	
	
	/**
	* Re-activates the newest version of $index.
	* @return bool
	* @param int $index
	*/
	function undeleteValue($index) {
		if ($this->_parent->readOnly()) {
			throwError( new Error("Can not set value in DataSet because it was fetched
			from the database readonly. You must re-fetch it fully to make changes.","FieldValues",true));
		}
		
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		return $this->_values[$index]->undelete();
	}
	
	/**
	* Returns the number of values for this label we have set.
	* @return int
	*/
	function numValues() { return $this->_numValues; }
	
	/**
	 * Returns the number of ACTIVE values for this label.
	 * @return int
	 */
	function numActiveValues() {
		$count = 0;
		for($i=0; $i<$this->numValues(); $i++) {
			if ($this->_values[$i]->hasActiveValue()) $count++;
		}
		return $count;
	}
	
	/**
	* Returns the number of versions we have set for specific $index.
	* @return int
	* @param optional int $index Defaults to 0.
	*/
	function numVersions( $index=0 ) {
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
	function getVersionList( $index=0 ) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		return $this->_values[$index]->getVersionList();
	}
	
	/**
	* Returns the {@link ValueVersion} object associated with $verID under $index.
	* @return ref object
	* @param int $verID
	* @param optional int $index Defaults to 0.
	*/
	function &getVersion( $verID, $index=0 ) {
		if (!isset($this->_values[$index])) {
			throwError( new ValueIndexNotFoundError($this->_myLabel, $this->_parent->getID(), $index));
		}
		
		return $this->_values[$index]->getVersion($verID);
	}
	
}

?>