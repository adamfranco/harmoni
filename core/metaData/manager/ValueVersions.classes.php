<?

/**
 * @constant string NEW_VERSION Used when created a new version to be attached to a value.
 * @package harmoni.datamanager
 */
define("NEW_VERSION","new");

/**
 * Responsible for keeping track of multiple versions of a value for a specific index within a 
 * field within a DataSet.
 * @package harmoni.datamanager
 * @version $Id: ValueVersions.classes.php,v 1.31 2004/03/31 19:13:26 adamfranco Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class ValueVersions {
	
	var $_numVersions;
	var $_parent;
	
	var $_myIndex;
	
	var $_versions;
	var $_oldVersion;
	
	function ValueVersions (&$parent, $myIndex) {
		$this->_parent =& $parent;
		$this->_numVersions = 0;
		$this->_myIndex = $myIndex;
		
		$this->_versions = array();
		$this->_oldVersion = null;
	}
	
	/**
	* Sets up a number of {@ValueVersion} objects based on an array of database rows.
	* @return void
	* @param ref array $arrayOfRows
	*/
	function populate( &$arrayOfRows ) {
		// we are responsible for keeping track of multiple ValueVersion objects,
		// each corresponding to a specific version of a value of a field.
		
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
		if ($row['datasetfield_id']) {
			$verID = $row['datasetfield_id'];
			$active = $row['datasetfield_active']?true:false;
			
			$this->_versions[$verID] =& new ValueVersion($this,$active);
			$this->_versions[$verID]->populate($row);
			$this->_numVersions++;
		}
	}
	
	/**
	* Commits the existing (and new, if applicable) versions of this value to the database. If the DataSet
	* is version controlled and the new value is the same as the old value, it is ignored.
	* @return void
	*/
	function commit() {
		// before we commit, if we have a newVersion and an oldVersion,
		// let's check to see if their values are equal. if they are, 
		// we can scrap the new version to save on DB space.
		if ($this->_versions[NEW_VERSION] && $this->_oldVersion) {
			$oldVal =& $this->_oldVersion->getValue();
			$newVal =& $this->_versions[NEW_VERSION]->getValue();
			
			if ($oldVal->isEqual($newVal)) {
				// let's kill the new version
				unset($this->_versions[NEW_VERSION]);
				$this->_numVersions--;
				$this->_oldVersion->setActiveFlag(true);
			}
		}
		
		foreach ($this->getVersionList() as $ver) {
			$this->_versions[$ver]->commit();
		}
		
		// now if we just committed a NEW_VERSION, let's move it to its proper place in the array
		if ($this->_versions[NEW_VERSION]) {
			$ref =& $this->_versions[NEW_VERSION];
			$id = $ref->getID();
			if (!$id) return;
			
			$this->_versions[$id] =& $this->_versions[NEW_VERSION];
			// now unset the old
			unset ($this->_versions[NEW_VERSION], $ref);
			// done.
		}
	}
	
	/**
	* Goes through all the old versions of values and actually DELETES them from the database.
	* @param ref object $versionConstraint A {@link VersionConstraint) on which to base our pruning.
	* @return void
	*/
	function prune($versionConstraint) {
		$versionConstraint->checkValueVersions($this);
		
/*		// just step through each ValueVersion object and call prune();
		foreach ($this->getVersionList() as $verID) {
			$ver =& $this->getVersion($verID);
			$ver->prune();
		}*/
	}
	
	/**
	* Returns the number of versions we have set for this value.
	* @return int
	*/
	function numVersions() {
		return $this->_numVersions;
	}
	
	/**
	* sets the index of this entry to $index.
	* @param int $index
	* @return bool TRUE if the index was changed. FALSE if not.
	*/
	function setIndex( $index ) {
		if ($index == $this->_myIndex) return false;
		$this->_myIndex = $index;
		return true;
	}
	
	/**
	 * Returns the index of this ValueVersionsObj
	 *
	 * @return integer The index.
	 */
	function getIndex() {
		return $this->_myIndex;
	}
	
	/**
	* "Sets" the value of this specific index to $value. If the DataSet is version controlled, a new
	* version is added. Otherwise, the current active version is modified.
	* @return bool
	* @param ref object $value A {@link DataType} object.
	*/
	function setValue(&$value) {
		// if we're version controlled, we're adding a new version
		// otherwise, we're just setting the existing (or only active) one.
		if ($this->_parent->_parent->isVersionControlled()) {		// @todo This is referencing another object's private variables. Bad!! Fix this!
			// we're going to add a new version
			// which means, we add a new VersionValue with a *clone*
			// of the value, so that it gets added to the DB.
			$newVer =& $this->newVerObject();
			$newVer->setValue($value->clone());
			
			// tell the new version to update to the DB on commit();
//			$newVer->update();
			
/*			// now, we h have to activate the new version
			$oldVer =& $this->getActiveVersion();
			if ($oldVer) {
				$oldVer->setActiveFlag(false);
				$oldVer->update();
			}
*/			
			// above functionality moved to newVerObject().
//			$newVer->setActiveFlag(true);
			
			// all done (we hope)
			return true;
		}
		
		// let's just set the value of the existing one.
		// if we have an active version, set that one.
		if (!$this->hasActiveValue()) {
			$this->undelete();
		}
		
		$actVer =& $this->getActiveVersion();
		$actVal =& $actVer->getValue();
		
		if ($actVal && $actVal->isEqual($value)) 
			return true;

		$actVer->takeValue($value);
		$actVer->setDate(DateTime::now());
		
		// now tell actVer to update the DB on commit()
		$actVer->update();
		return true;
	}
	
	/**
	* Returns a reference to a new {@link ValueVersion} object and adds it to the list of versions for this value.
	* @return ref object
	*/
	function &newVerObject() {
/*		if (!$this->numVersions()) $newID=1;
		else $newID = max($this->getVersionList()) + 1;
		$this->_versions[$newID] =& new ValueVersion($this,$active);
		$this->_numVersions++;
		return $this->_versions[$newID];*/
		
		
		// change from above because:
		// we don't want a new version *every* time a pageload occurs
		// and a new value is entered into the field. we only want
		// one new version per commit()
		if (!isset($this->_versions[NEW_VERSION])) {
			// first deactivate the old one
			if ($this->_numVersions) {
				$old =& $this->getActiveVersion();
				if ($old) {
					$old->setActiveFlag(false);
					$old->update();
					$this->_oldVersion =& $old;
				}
			}
			
			$this->_versions[NEW_VERSION] =& new ValueVersion($this,true);
			$this->_versions[NEW_VERSION]->update();
			$this->_numVersions++;
		}
		return $this->_versions[NEW_VERSION];
	}
	
	/**
	* Returns the active {@link ValueVersion} object or FALSE if none exists. If no versions have yet been
	* set, a new {@link ValueVersion} object is created.
	* @return ref object or false
	*/
	function &getActiveVersion() {
		if ($this->_numVersions == 0) {
			return $this->newVerObject();
		}
		
		foreach (array_keys($this->_versions) as $id) {
			if ($this->_versions[$id]->isActive()) return $this->_versions[$id];
		}
		
		// if we get here there were no active versions.
		$false = false; // to compensate for the return reference
		return $false;
	}
	
	/**
	* Returns an array of version IDs set for this value.
	* @return array
	*/
	function getVersionList() {
		return array_keys($this->_versions);
	}
	
	/**
	* Returns the {@link ValueVersion} object associated with version ID $verID.
	* @return ref object
	* @param int $verID
	*/
	function &getVersion( $verID ) {
		if (!isset($this->_versions[$verID])) {
			throwError( new Error("Could not find version ID $verID.","ValueVersions",true));
		}
		return $this->_versions[$verID];
	}
	
	/**
	* Deactivates all existing versions for this value.
	* @return void
	*/
	function delete() {
		// go through all the versions and deactivate them.
		foreach ($this->getVersionList() as $ver) {
			$this->_versions[$ver]->setActiveFlag(false);
			$this->_versions[$ver]->update(); // update to DB on commit()
		}
	}
	
	/**
	* Re-activates the newest version value for this index.
	* @return void|true if we're already active.
	*/
	function undelete() {
		// if we're not active, go through and find the newest ver, then activate it.
		if ($this->isActive()) return true;
		
		$ver =& $this->getNewestVersion();
		$ver->setActiveFlag(true);
	}
	
	/**
	* Returns the most recently created version for this value.
	* @return ref object The newest {@link ValueVersion} object.
	*/
	function & getNewestVersion() {
		$newest = null;
		if ($this->numVersions()) {
			foreach ($this->getVersionList() as $ver) {
				$ver =& $this->getVersion($ver);
				
				if ($newest == null || (DateTime::compare($newest->getDate(), $ver->getDate()) > 0)) {
					$newest =& $ver;
				}
			}
		}
		return $newest;
	}
	
	/**
	* Returns TRUE if a version is active, or if we have no versions defined yet. FALSE otherwise.
	* @return bool
	*/
	function isActive() {
		if ($this->_numVersions == 0) return true; // if we don't have any values yet, assume we are active
		
		foreach (array_keys($this->_versions) as $id) {
			if ($this->_versions[$id]->isActive()) return true;
		}
		return false;
	}
	
	/**
	 * Returns TRUE if we have an active version.
	 * @return bool
	 */
	function hasActiveValue() {
		foreach ($this->getVersionList() as $verID) {
			if ($this->_versions[$verID]->isActive()) return true;
		}
		return false;
	}
	
	/**
	* Returns a new ValueVersions object that is an exact data-specific clone of the current object.
	* @param ref object A reference to a {@link FieldValues} object that will act as the parent.
	* @return ref object
	*/
	function &clone(&$parent) {
		$newObj =& new ValueVersions($parent, $this->_myIndex);
		
		foreach ($this->getVersionList() as $verID) {
			$ver =& $this->getVersion($verID);
			
			$newObj->_versions[++$newObj->_numVersions] =& $ver->clone($newObj);
		}
		
		return $newObj;
	}
	
	/**
	 * Returns the FieldValues object that is the current object is a part of.
	 * @return ref object FieldValues The parent FieldValues object
	 */
	function getFieldValues() {
		return $this->_parent;
	}
	
	/**
	 * Returns the id this ValueVersions object. The unique ID for the info 
	 * field should be the
	 * 		DataSetID::FieldValuesLabel::ValueVersionsIndex
	 * @return ref object Id The id of this ValueVersions object.
	 */
	function getId() {
		if (!$this->_id) {
			$sharedManager =& Services::getService("Shared");
			$FieldValuesId =& $this->_parent->getId();
			$idString = $FieldValuesId->getIdString()."::".$this->_myIndex;
			$this->_id =& $sharedManager->getId($idString);
		}
		return $this->_id;
	}
}

/**
 * Holds information about a specific version of a value index of a field in a DataSet. Information held
 * includes: Date created/modified, active/not active (ie, deleted), and the actual value object. 
 * @package harmoni.datamanager
 * @version $Id: ValueVersions.classes.php,v 1.31 2004/03/31 19:13:26 adamfranco Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class ValueVersion {
	
	var $_myID;
	
	var $_date;
	var $_valueObj;
	var $_active;
	
	var $_parent;
	
	var $_update;
	var $_prune;
	
	function ValueVersion(&$parent, $active=false) {
//		$this->_date = null; // @todo - should we create a new DateTime::now() or leave null?
		$this->_date =& DateTime::now();
		$this->_valueObj = null;
		$this->_active = $active;
		
		$this->_parent =& $parent;
		
		$this->_update = false;
		$this->_prune = false;
	}
	
	/**
	 * Returns an exact data-specific replica of the current object.
	 * @param ref object $parent The new parent object to use instead of our parent.
	 * @return ref object
	 * @access public
	 */
	function &clone(&$parent) {
		$newObj =& new ValueVersion($parent, $this->_active);
		
		$date = $this->_date; // in PHP4 this will clone the DateTime
		$newObj->_date =& $date;
		$newObj->_valueObj =& $this->_valueObj->clone();
		
		$newObj->update();
		
		return $newObj;
	}
	
	/**
	 * Flags this ValueVersion to be updated to the database upon commit().
	 * @return void
	 * @access public
	 */
	function update() { $this->_update=true; }
	
	/**
	 * Changes the active flag of this ValueVersion to $active.
	 * @param bool $active
	 * @return void
	 * @access public
	 */
	function setActiveFlag($active) {
		ArgumentValidator::validate($active, new BooleanValidatorRule());
		
		$this->_active = $active;
	}
	
	/**
	 * Returns the current active flag.
	 * @return bool
	 * @access public
	 */
	function isActive() { return $this->_active; }
	
	/**
	 * Takes a single database row and sets local data (like the modified timestamp, etc) variables
	 * based on that row.
	 * @param ref array $row The associative database row.
	 * @return void
	 * @access public
	 */
	function populate( &$row ) {
		$dbHandler =& Services::getService("DBHandler");
		$fieldValues =& $this->_parent->getFieldValues();
		$dataSet =& $fieldValues->getDataSet();
		$dbID = $dataSet->getDatabaseId();
		
		$this->_myID = $row['datasetfield_id'];
		$this->_date =& $dbHandler->fromDBDate($row['datasetfield_modified'],$dbID);
		// $this->_active was set by parent on construction
		
		// now we need to create the valueObj
		$valueType =& $this->_parent->_parent->_fieldDefinition->getType();
		
		$dataTypeManager =& Services::getService("DataTypeManager");
		$valueObj =& $dataTypeManager->newDataObject($valueType);
		
		$valueObj->populate($row);
		$valueObj->setID($row['fk_data']);
		
		$this->_valueObj =& $valueObj;
	}
	
	/**
	 * Flags us for deletion from the DB.
	 * @return void
	 * @access public
	 */
	function prune() {
		$this->_prune = true;
	}
	
	/**
	 * Commits any changes that have been made to the database. If neither udpate() nor prune() have been
	 * called, even if changes have been made, they will not be reflected in the database.
	 * @return bool
	 * @access public
	 */
	function commit() {
		
		$dbHandler =& Services::getService("DBHandler");
		$dbID = $this->_parent->_parent->_parent->_dbID;
		
		// associate the valueObject with us. its master.
		$this->_valueObj->setup($this->_parent->_parent->_parent->_dbID);
		
		if ($this->_update) {
			// first we need to commit the actual DataType value
			// so that we can get its ID
			$this->_valueObj->commit();
			
			
			if ($this->_myID) {
				// we're already in the DB. just update the entry
				$query =& new UpdateQuery();
				
				$query->setWhere("datasetfield_id=".$this->_myID);
				$query->setColumns(array("datasetfield_index","datasetfield_active", "datasetfield_modified"));
				$query->setValues(array($this->_parent->_myIndex,($this->_active)?1:0,$dbHandler->toDBDate($this->_date,$dbID)));
			} else {
				// we have to insert a new one
				$query =& new InsertQuery();
				
				$sharedManager =& Services::getService("Shared");
				$newID =& $sharedManager->createId();
				
				$this->_myID = $newID->getIdString();
				$query->setColumns(array(
				"datasetfield_id",
				"fk_dataset",
				"fk_datasettypedef",
				"datasetfield_index",
				"fk_data",
				"datasetfield_active",
				"datasetfield_modified"
				));
				
				$query->addRowOfValues(array(
				$this->_myID,
				$this->_parent->_parent->_parent->getID(),
				$this->_parent->_parent->_fieldDefinition->getID(),
				$this->_parent->_myIndex,
				$this->_valueObj->getID(),
				($this->_active)?1:0,
				$dbHandler->toDBDate($this->_date,$dbID)
				));
			}
			
			$query->setTable("datasetfield");
			
			$result =& $dbHandler->query($query, $dbID);
			
			if (!$result) {
				throwError( new UnknownDBError("ValueVersion") );
				return false;
			}
		}
		
		if ($this->_prune) {
			if ($id = $this->getID()) {
				// ok, let's get rid of ourselves... completely!
				$query =& new DeleteQuery;
				$query->setTable("datasetfield");
				$query->setWhere("datasetfield_id=$id");

				$res =& $dbHandler->query($query, $dbID);
				if (!$res) throwError( new UnknownDBError("ValueVersion"));
				
				// now tell the data object to prune itself
				$this->_valueObj->prune();
				
				// and we have to get rid of any tag mappings where we are included.
				// DEPRECATED:: this has been moved to FullDataSet::prune()
				// cancel that... we need this now for VersionConstraints
				$query =& new DeleteQuery;
				$query->setTable("dataset_tag_map");
				$query->setWhere("fk_datasetfield=$id");
				
				$res =& $dbHandler->query($query, $dbID);
				if (!$res) throwError( new UnknownDBError("ValueVersion"));
			}
		}
		
		// reset the prune flag
		$this->_prune = false;
		
		// reset the update flag
		$this->_update = false;
		
		return true;
		
	}
	
	/**
	 * Returns if this ValueVersion object is flagged to delete itself from the DB upon commit().
	 * @return bool
	 * @access public
	 */
	function willPrune() {
		return $this->_prune;
	}
	
	/**
	 * Takes a {@link DataType} object and hands it to our local DataType object so that it can 
	 * set its own value based on $object.
	 * @param ref object $object
	 * @return void
	 * @access public
	 */
	function takeValue(&$object) {
		if (!$this->_valueObj) $this->setValue($object);
		else $this->_valueObj->takeValue($object);
	}
	
	/**
	 * Sets the local valueObject to be a reference to $object.
	 * @param ref object $object A new {@link DataType} object.
	 * @return void
	 * @access public
	 */
	function setValue(&$object) {
		$this->_valueObj =& $object;
	}
	
	/**
	 * Returns the current value object contained locally.
	 * @return ref object
	 * @access public
	 */
	function &getValue() {
		return $this->_valueObj;
	}
	
	/**
	 * Returns the created/modified timestamp of this specific version.
	 * @return ref object A {@link DataTime} object.
	 * @access public
	 */
	function &getDate() {
		return $this->_date;
	}
	
	/**
	 * Sets the date reflected within our local variables to $date.
	 * @param ref object A {@link DateTime} object.
	 * @return void
	 * @access public
	 */
	function setDate(&$date) {
		ArgumentValidator::validate($date, new ExtendsValidatorRule("DateTime"));
		$this->_date =& $date;
	}
	
	/**
	 * Returns our ID in the database.
	 * @return int
	 * @access public
	 */
	function getID() {
		return $this->_myID;
	}
}

?>