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
* @version $Id: DataSet.class.php,v 1.19 2004/01/08 21:10:01 gabeschine Exp $
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
		$this->_idManager = $idManager;
		$this->_dbID = $dbID;
		$this->_dataSetTypeDef = $dataSetTypeDef;
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
	* @return int
	* @desc Returns this DataSet's ID.
	*/
	function getID() { return $this->_myID; }
	
	/**
	* @return bool
	* @desc Returns TRUE if this DataSet is read only (cannot be edited).
	*/
	function readOnly() {
		return true;
	}
	
	/**
	* @return bool
	* @desc Returns TRUE if this is a {@link CompactDataSet}.
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
	* @return ref object
	* @param string $label
	* @param optional int $index default=0.
	* @desc Returns the active {@link ValueVersion} object for value $index under $label.
	*/
	function &getActiveValue($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		$valueVersions =& $this->getValueVersionsObject($label, $index);
		
		return $valueVersions->getActiveValue();
	}
	
	/**
	* @return ref object
	* @param string $label
	* @param optional int $index default=0.
	* @desc Returns the {@link ValueVersions} object associated with $index under $label.
	*/
	function &getValueVersionsObject($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->getValue($index);
	}
	
	/**
	* @return ref array
	* @param string $label
	* @desc Returns an array of {@link ValueVersions} objects for all indexes under $label.
	*/
	function &getAllValueVersionsObjects($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->getAllValues();
	}
	
	/**
	* @return bool
	* @param array $arrayOfRows
	* @desc Creates a number of {@link FieldValues} objects based on an array of database rows.
	*/
	function populate( $arrayOfRows = null ) {
		
		// ok, we're going to passed an array of rows that corresonds to
		// our label[index] = valueVersion[n] setup.
		// that means we have to separate out the rows that have to do with each
		// label, and hand each package to a FieldValues object.
		
		$myID = null;
		
		$packages = array();
		
		foreach ($arrayOfRows as $line) {
			$label = $line['datasettypedef_label'];
			if (!is_array($packages[$label])) $packages[$label] = array();
			
			$packages[$label][] = $line;
			
			if (!$myID && $line['dataset_id']) $myID = $line['dataset_id'];
		}
		
		if (!$myID) {
			throwError ( new Error(
				"Serious error fetching DataSet: no ID was stored in the database!","DataSet",true));
			return false;
		}
		
		$this->_myID = $myID;

		// now go through each label we've found and populate the FieldValues object
		foreach (array_keys($packages) as $label) {
/*			if (!($fieldDefinition =& $this->_dataSetTypeDef->fieldExists($label))) {
				throwError( new Error(
					"Serious error with DataSetTypeDefinition mappings. DataSet contains field with label '$label'
					but no corresponding FieldDefinition was found within the DataSetTypeDefinition.",
					"FullDataSet",true));
				return false;
			}
			
			$newFV =& new FieldValues($fieldDefinition, $this, $label);
			$newFV->populate($package[$label]);*/
			// above = dumb. _fields array should have been setup by the constructor.
			
			if (!isset($this->_fields[$label])) {
				throwError( new Error("Could not populate DataSet with label '$label' because it doesn't
				seem to be defined in the DatSetTypeDefinition.","DataSet",true));
			}
			$this->_fields[$label]->populate($packages[$label]);
		}
		
	}
	
	/**
	* @return int
	* @param string $label
	* @desc Returns the number of values we have set for $label.
	*/
	function numValues($label) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->numValues();
	}
	
	/**
	* @return bool
	* @desc Returns TRUE if this DataSet was created with Version Control.
	*/
	function isVersionControlled() {
		return $this->_versionControlled;
	}
}


/**
* Stores a full representation of the data for a dataset, including all inactive and deleted versions
* of values. Can be edited, etc.
* @package harmoni.datamanager
* @version $Id: DataSet.class.php,v 1.19 2004/01/08 21:10:01 gabeschine Exp $
* @copyright 2004, Middlebury College
*/
class FullDataSet extends CompactDataSet {
	
	function FullDataSet(&$idManager, $dbID, &$dataSetTypeDef, $verControl=false ) {
		parent::CompactDataSet($idManager, $dbID, $dataSetTypeDef, $verControl);
/*		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		$this->_idManager = $idManager;
		$this->_dbID = $dbID;
		$this->_dataSetTypeDef = $dataSetTypeDef;
		$this->_fields = array();
		
		// set up the individual fields
		foreach ($dataSetTypeDef->getAllLabels() as $label) {
			$def =& $dataSetTypeDef->getFieldDefinition($label);
			$this->_fields[$label] =& new FieldValues($def, $this, $label );
			unset($def);
		}
*/	}
	
	/**
	* @return bool
	* @desc Returns false since this DataSet is editable.
	*/
	function readOnly() {
		return false;
	}

	/**
	* @return bool
	* @desc Returns FALSE since this is a Full dataset.
	*/
	function isCompact() {
		return false;
	}

	/**
	* @return bool
	* @param string $label
	* @param ref object $obj
	* @param optional int $index default=0
	* @desc Sets the value of $index under $label to $obj where $obj is a {@link DataType}.
	*/
	function setValue($label, &$obj, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		if ($index == NEW_VALUE) {
			return $this->_fields[$label]->addValue($obj);
		}
		return $this->_fields[$label]->setValue($index, $obj);
	}
	
	/**
	* @return bool
	* @param string $label
	* @param optional int $index default=0
	* @desc Returns TRUE if the value $index under $label is inactive.
	*/
	function deleted($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		$vers =& $this->_fields[$label]->getValue($index);
		return !($vers->isActive());
	}
		
	/**
	* @return bool
	* @desc Commits (either inserts or updates) the data for this DataSet into the database.
	*/
	function commit() {
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
		
		return true;
	}
	
	/**
	* @return void
	* @param optional object $date An optional DateTime to specify the date that should be attached to the tag instead of the current date/time.
	* @desc Uses the {@link DataSetTagManager} service to add a tag of the current state (in the DB) of this DataSet.
	*/
	function tag($date=null) {
		$tagMgr =& Services::getService("DataSetTagManager");
		$tagMgr->tagToDB($this, $date);
	}
	
	/**
	* @return void
	* @param optional object $date An optional {@link DateTime} object for tagging. If specified, it will use $date instead of the current date and time.
	* @desc Calls both commit() and tag().
	*/
	function commitAndTag($date=null) {
		$this->commit();
		$this->tag($date);
	}
	
	/**
	* @return ref object A new {@link FullDataSet} object.
	* @desc Creates an exact (specific to the data) copy of the DataSet, that can then be inserted into
	* the DB as a new set with the same data.
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
	* @return void
	* @desc Goes through all the old versions of values and actually DELETES them from the database.
	*/
	function prune() {
		// just step through each FieldValues object and call prune()
		foreach ($this->_dataSetTypeDef->getAllLabels(true) as $label) {
			$this->_fields[$label]->prune();
		}
	}
	
	/**
	* @return bool
	* @param string $label
	* @desc Spiders through all of the values under $label and deactivates them.
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
	* @return bool
	* @param string $label
	* @param optional int $index default=0
	* @desc Deactivates all the versions of $index under $label.
	*/
	function deleteValue($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->deleteValue($index);
	}
	
	/**
	* @return bool
	* @param string $label
	* @param optional int $index default=0
	* @desc Re-activates the newest version of $index under $label.
	*/
	function undeleteValue($label, $index=0) {
		$this->_checkLabel($label, __FUNCTION__);
		
		return $this->_fields[$label]->undeleteValue($index);
	}
	
	/**
	* @return void
	* @desc Deactivates the DataSet upon commit().
	*/
	function delete() {
		$this->_active = false;
	}
	
	/**
	* @return bool
	* @param ref object $tag A {@link DataSetTag} object.
	* @desc Takes a tag object and activates the appropriate versions of values based on the tag mappings.
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
			if (!$tag->haveMappings($label)) continue;
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
 * @package harmoni.datamanager
 * @param ref object A {@link FullDataSet} or {@link CompactDataSet} to render.
 * @desc Renders within PRE tags a full representation of a DataSet and all of its data.
 */
function renderDataSet(&$dataSet) {
	$fields = $dataSet->_dataSetTypeDef->getAllLabels(true);
	
	print "<PRE>";
	print "dataSet of type '".OKITypeToString($dataSet->_dataSetTypeDef->getType())."', ";
	print "version controlled = ".($dataSet->isVersionControlled()?"yes":"no")."\n\n";
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
 * @package harmoni.datamanager
 * @param ref array An array of DataSets to render.
 * @desc Renders an array of DataSets using {@link renderDataSet()}.
 */
function renderDataSetArray(&$sets) {
	foreach (array_keys($sets) as $id) {
		print "<P>DataSet ID <b>$id</b><br>";
		renderDataSet($sets[$id]);
	}
}

?>