<?php

require_once HARMONI."metaData/manager/FieldValues.class.php";

/**
 * @package harmoni.datamanager
 * @constant int NEW_VALUE Used when setting the value of a new index within a field.
 */
define("NEW_VALUE",-1);

/**
* Stores a compact version of a dataset. The compact version does not include any inactive versions of values
* or deleted values in order to save on database query time. However, this also makes it read-only. Any
* changes to a DataSet must be done using a {@link FullDataSet}.
* @access public
* @package harmoni.datamanager
* @version $Id: DataSet.class.php,v 1.29 2004/01/22 21:06:38 adamfranco Exp $
* @copyright 2004, Middlebury College
*/
class CompactDataSet {
	
	var $_idManager;
	var $_dbID;
	var $_dataSetTypeDef;
	var $_versionControlled;
	var $_fields;
	var $_full;
	
	var $_myID;
	var $_active;
	
	function CompactDataSet(&$idManager, $dbID, &$dataSetTypeDef, $verControl=false) {
		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		ArgumentValidator::validate($idManager, new ExtendsValidatorRule("IDManager"));
		$this->_idManager =& $idManager;
		$this->_dbID = $dbID;
		$this->_dataSetTypeDef =& $dataSetTypeDef;
		$this->_fields = array();
		$this->_versionControlled = $verControl;
		$this->_active = true;
		
		$this->_myID = null;
		
		// set up the individual fields
		foreach ($dataSetTypeDef->getAllLabels(true) as $label) {
			$def =& $dataSetTypeDef->getFieldDefinition($label);
			$this->_fields[$label] =& new FieldValues($def, $this, $label );
			unset($def);
		}
	}
	
	/**
	 * Returns this dataset's DataSetTypeDefinition
	 * @return ref object
	 */
	function &getDataSetTypeDefinition() {
		return $this->_dataSetTypeDef;
	}
	
	/**
	 * Returns the OKI type associated with this DataSet.
	 * @return ref object
	 */
	function &getType() {
		return $this->_dataSetTypeDef->getType();
	}
	
	/**
	* Returns this DataSet's ID.
	* @return int
	*/
	function getID() { return $this->_myID; }
	
	/**
	* Returns TRUE if this DataSet is read only (cannot be edited).
	* @return bool
	*/
	function readOnly() {
		return true;
	}
	
	/**
	* Returns TRUE if this is a {@link CompactDataSet}.
	* @return bool
	*/
	function isCompact() {
		return true;
	}
	
	function _checkLabel($label, $function) {
		if (!$this->_dataSetTypeDef->fieldExists($label)) {
			throwError(new FieldNotFoundError($label,OKITypeToString($this->_dataSetTypeDef->getType())));
			return false;
		}
		return true;
	}
	
	/**
	* Returns the active {@link ValueVersion} object for value $index under $label.
	* @return ref object
	* @param string $label
	* @param optional int $index default=0.
	*/
	function &getActiveValue($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		$valueVersions =& $this->getValueVersionsObject($label, $index);
		
		return $valueVersions->getActiveValue();
	}
	
	/**
	* Returns the {@link ValueVersions} object associated with $index under $label.
	* @return ref object
	* @param string $label
	* @param optional int $index default=0.
	*/
	function &getValueVersionsObject($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->getValue($index);
	}
	
	/**
	* Returns an array of {@link ValueVersions} objects for all indexes under $label.
	* @return ref array
	* @param string $label
	*/
	function &getAllValueVersionsObjects($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->getAllValues();
	}
	
	/**
	* Creates a number of {@link FieldValues} objects based on an array of database rows.
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
	 * Takes one row from a database and populates our objects with it.
	 * @param ref array $row
	 * @return void
	 */
	function takeRow( &$row ) {
		// this is gonna be a bit different of a setup than the populate() function
		// (which should now be deprecated)
		
		// see if we can't get our ID from the row
		if (!$this->_myID && $row['dataset_id']) $this->_myID = $row['dataset_id'];
		else if ($row['dataset_id'] != $this->_myID) {
			throwError( new Error("Can not take database row because it does not seem to correspond with our
			DataSet ID.", "DataSet",true));
		}
		
		$label = $row['datasettypedef_label'];
		
		if (!isset($this->_fields[$label])) {
			throwError( new Error("Could not populate DataSet with label '$label' because it doesn't
				seem to be defined in the DatSetTypeDefinition.","DataSet",true));
		}
		
		$this->_fields[$label]->takeRow($row);
	}
	
	/**
	* Returns the number of values we have set for $label.
	* @return int
	* @param string $label
	*/
	function numValues($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
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
}


/**
* Stores a full representation of the data for a dataset, including all inactive and deleted versions
* of values. Can be edited, etc.
* @package harmoni.datamanager
* @version $Id: DataSet.class.php,v 1.29 2004/01/22 21:06:38 adamfranco Exp $
* @copyright 2004, Middlebury College
*/
class FullDataSet extends CompactDataSet {
	
	var $_prune;
	var $_pruneConstraint;
	
	function FullDataSet(&$idManager, $dbID, &$dataSetTypeDef, $verControl=false ) {
		parent::CompactDataSet($idManager, $dbID, $dataSetTypeDef, $verControl);
		
		$this->_prune=false;
	}
	
	/**
	* Returns false since this DataSet is editable.
	* @return bool
	*/
	function readOnly() {
		return false;
	}

	/**
	* Returns FALSE since this is a Full dataset.
	* @return bool
	*/
	function isCompact() {
		return false;
	}

	/**
	* Sets the value of $index under $label to $obj where $obj is a {@link DataType}.
	* @return bool
	* @param string $label
	* @param ref object $obj
	* @param optional int $index default=0
	*/
	function setValue($label, &$obj, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		if ($index == NEW_VALUE) {
			return $this->_fields[$label]->addValue($obj);
		}
		return $this->_fields[$label]->setValue($index, $obj);
	}
	
	/**
	* Returns TRUE if the value $index under $label is inactive.
	* @return bool
	* @param string $label
	* @param optional int $index default=0
	*/
	function deleted($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		$vers =& $this->_fields[$label]->getValue($index);
		return !($vers->isActive());
	}
		
	/**
	* Commits (either inserts or updates) the data for this DataSet into the database.
	* @return bool
	*/
	function commit() {
		// the first thing we're gonna do is check to make sure that all our required fields
		// have at least one value.
		foreach ($this->_dataSetTypeDef->getAllLabels() as $label) {
			$fieldDef =& $this->_dataSetTypeDef->getFieldDefinition($label);
			if ($fieldDef->isRequired() && ($this->_fields[$label]->numValues() == 0 ||
					$this->_fields[$label]->numActiveValues() == 0)) {
				throwError(new Error("Could not commit DataSet to database because the required field '$label' does
				not have any values!","FullDataSet",true));
				return false;
			}
		}
		
		if ($this->_myID) {
			// we're already in the database
			$query =& new UpdateQuery();
			
			$query->setTable("dataset");
			$query->setColumns(array("dataset_active","dataset_ver_control"));
			$query->setValues(array(
				($this->_active)?1:0,
				($this->_versionControlled)?1:0
				));
			$query->setWhere("dataset_id=".$this->_myID);
		} else {
			// we'll have to make a new entry
			$dataSetTypeManager =& Services::getService("DataSetTypeManager");
			
			$this->_myID = $this->_idManager->newID(new HarmoniType("Harmoni","HarmoniDataManager","DataSet"));
			
			$query =& new InsertQuery();
			$query->setTable("dataset");
			$query->setColumns(array("dataset_id","fk_datasettype","dataset_created","dataset_active","dataset_ver_control"));
			$query->addRowOfValues(array(
				$this->_myID,
				$dataSetTypeManager->getIDForType($this->_dataSetTypeDef->getType()),
				"NOW()",
				($this->_active)?1:0,
				($this->_versionControlled)?1:0
				));
		}
		
		// execute the query;
		$dbHandler =& Services::getService("DBHandler");
		
		$result =& $dbHandler->query($query,$this->_dbID);
		
		if (!$result) {
			throwError( new UnknownDBError("FullDataSet") );
			return false;
		}
		
		// now let's cycle through our FieldValues and commit them
		foreach ($this->_dataSetTypeDef->getAllLabels() as $label) {
			$this->_fields[$label]->commit();
		}
		
		if ($this->_prune) {
			$constraint =& $this->_pruneConstraint;
			
			// check if we have to delete any dataset tags based on our constraints
			$constraint->checkDataSetTags($this);
			
			$tagMgr =& Services::getService("DataSetTagManager");
			
			// if we are no good any more, delete ourselves completely
			if (!$constraint->checkDataSet($this)) {
				// now, remove any tags from the DB that have to do with us, since they will no longer
				// be valid.
				$tagMgr->pruneTags($this);
				
				$query =& new DeleteQuery();
				$query->setTable("dataset");
				$query->setWhere("dataset_id=".$this->getID());
				
				$dbHandler->query($query, $this->_dbID);
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
	* Uses the {@link DataSetTagManager} service to add a tag of the current state (in the DB) of this DataSet.
	* @return void
	* @param optional object $date An optional DateTime to specify the date that should be attached to the tag instead of the current date/time.
	*/
	function tag($date=null) {
		$tagMgr =& Services::getService("DataSetTagManager");
		$tagMgr->tagToDB($this, $date);
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
	* Creates an exact (specific to the data) copy of the DataSet, that can then be inserted into
	* the DB as a new set with the same data.
	* @return ref object A new {@link FullDataSet} object.
	*/
	function &clone() {
		$newSet =& new FullDataSet($this->_idManager, $this->_dbID, $this->_dataSetTypeDef, $this->_versionControlled);
		
		foreach ($this->_dataSetTypeDef->getAllLabels() as $label) {
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
		$this->_pruneConstraint =& $versionConstraint;
		$this->_prune=true;
		
		// just step through each FieldValues object and call prune()
		foreach ($this->_dataSetTypeDef->getAllLabels(true) as $label) {
			$this->_fields[$label]->prune($versionConstraint);
		}
	}
	
	/**
	* Spiders through all of the values under $label and deactivates them.
	* @return bool
	* @param string $label
	*/
	function deleteAllValues($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
		$num = $this->_fields[$label]->numValues();
		$good = true;
		for($i=0; $i<$num; $i++) {
			if (!$this->_fields[$label]->deleteValue($i)) $good=false;
		}
		
		return $good;
	}
	
	/**
	* Deactivates all the versions of $index under $label.
	* @return bool
	* @param string $label
	* @param optional int $index default=0
	*/
	function deleteValue($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->deleteValue($index);
	}
	
	/**
	* Re-activates the newest version of $index under $label.
	* @return bool
	* @param string $label
	* @param optional int $index default=0
	*/
	function undeleteValue($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->undeleteValue($index);
	}
	
	/**
	* Deactivates the DataSet upon commit().
	* @return void
	*/
	function delete() {
		$this->_active = false;
	}
	
	/**
	* Takes a tag object and activates the appropriate versions of values based on the tag mappings.
	* @return bool
	* @param ref object $tag A {@link DataSetTag} object.
	*/
	function activateTag(&$tag) {
		// check to make sure the tag is affiliated with us
		if ($this->getID() != $tag->getDataSetID()) {
			throwError (new Error("Can not activate tag because it is not affiliated with my DataSet","DataSet",true));
			return false;
		}
		
		// load the mapping data for the tag
		$tag->load();
		
		foreach ($this->_dataSetTypeDef->getAllLabels(true) as $label) {
			// if the tag doesn't have any mappings for $label, skip it
//			if (!$tag->haveMappings($label)) continue;
			for ($i=0; $i<$this->numValues($label); $i++) {
				$newVerID = $tag->getMapping($label, $i);
				
				// go through each version and deactivate all versions unless they are active and $verID
				$vers =& $this->getValueVersionsObject($label, $i);
				foreach ($vers->getVersionList() as $verID) {
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
}

/**
 *@package harmoni.datamanager
 */
class FieldNotFoundError extends Error {
	function FieldNotFoundError($label,$type) {
		parent::Error("The field labeled '$label' was not found in DataSetType '$type'.","DataSet",true);
	}
}

/**
 * @package harmoni.datamanager
 */
class ValueIndexNotFoundError extends Error {
	function ValueIndexNotFoundError($label,$id,$index) {
		parent::Error("The value index $index was not found for field '$label' in DataSet ID $id.","DataSet",true);
	}
}

/**
 * Renders within PRE tags a full representation of a DataSet and all of its data.
 * @package harmoni.datamanager
 * @param ref object A {@link FullDataSet} or {@link CompactDataSet} to render.
 */
function renderDataSet(&$dataSet) {
	ArgumentValidator::validate($dataSet,new ExtendsValidatorRule("CompactDataSet"));
	
	$fields = $dataSet->_dataSetTypeDef->getAllLabels(true); // @todo This is referencing another object's private variables. Bad! -Adam
	
	print "<PRE>";
	print "dataSet of type '".OKITypeToString($dataSet->_dataSetTypeDef->getType())."', ";
	print "version controlled = ".($dataSet->isVersionControlled()?"yes":"no");
	print $dataSet->isActive()?"":" (inactive)";
	print "\n\n";
	foreach ($fields as $label) {
		$fieldDef =& $dataSet->_dataSetTypeDef->getFieldDefinition($label);
		$numValues = $dataSet->numValues($label);
		
		print "$label".(($fieldDef->isActive())?"":" (inactive)").": $numValues values\n";
		
		for ($i=0; $i<$numValues; $i++) {
			$vers =& $dataSet->getValueVersionsObject($label,$i);
			print "\t$i: ".$vers->numVersions()." versions\n";
			
			$verList = $vers->getVersionList();
			foreach ($verList as $verID) {
				$ver =& $vers->getVersion($verID);
				print "\t\t$verID, active=".(($ver->isActive())?"yes":"no").", ";
				$date =& $ver->getDate();
				print $date->toString().": ";
				$val =& $ver->getValue();
				if ($ver->_update) print "(flagged for update) ";
				if ($ver->_prune) print "(to be pruned) ";
				print $val->toString()."\n";
			}
		}
		
	}
	print "</PRE>";
}

/**
 * Renders an array of DataSets using {@link renderDataSet()}.
 * @package harmoni.datamanager
 * @param ref array An array of DataSets to render.
 */
function renderDataSetArray(&$sets) {
	foreach (array_keys($sets) as $id) {
		print "<P>DataSet ID <b>$id</b><br>";
		renderDataSet($sets[$id]);
	}
}

?>