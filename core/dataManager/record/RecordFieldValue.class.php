<?

require_once(HARMONI."dataManager/record/RecordFieldData.class.php");

/**
 * @constant string NEW_VERSION Used when created a new version to be attached to a value.
 * @package harmoni.datamanager
 */
define("NEW_VERSION","new");

/**
 * Responsible for keeping track of multiple versions of a value for a specific index within a 
 * field within a Record.
 * @package harmoni.datamanager
 * @version $Id: RecordFieldValue.class.php,v 1.8 2005/01/05 18:18:21 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class RecordFieldValue {
	
	var $_numVersions;
	var $_parent;
	
	var $_myIndex;
	
	var $_versions;
	var $_oldVersion;
	
	function RecordFieldValue (&$parent, $myIndex) {
		$this->_parent =& $parent;
		$this->_numVersions = 0;
		$this->_myIndex = $myIndex;
		
		$this->_versions = array();
		$this->_oldVersion = null;
	}
	
	/**
	* Sets up a number of {@link RecordFieldData} objects based on an array of database rows.
	* @return void
	* @param ref array $arrayOfRows
	*/
	function populate( &$arrayOfRows ) {
		// we are responsible for keeping track of multiple RecordFieldData objects,
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
		if ($row['record_field_id']) {
			$verID = $row['record_field_id'];
			$active = $row['record_field_active']?true:false;
			$this->_versions[$verID] =& new RecordFieldData($this,$active);
			$this->_versions[$verID]->populate($row);
			$this->_numVersions++;
		}
	}
	
	/**
	* Commits the existing (and new, if applicable) versions of this value to the database. If the Record
	* is version controlled and the new value is the same as the old value, it is ignored.
	* @return void
	*/
	function commit() {
		// before we commit, if we have a newVersion and an oldVersion,
		// let's check to see if their values are equal. if they are, 
		// we can scrap the new version to save on DB space.
		if ($this->_versions[NEW_VERSION] && $this->_oldVersion) {
			$oldVal =& $this->_oldVersion->getPrimitive();
			$newVal =& $this->_versions[NEW_VERSION]->getPrimitive();
			
			if ($oldVal->isEqual($newVal)) {
				// let's kill the new version
				unset($this->_versions[NEW_VERSION]);
				$this->_numVersions--;
				$this->_oldVersion->setActiveFlag(true);
			}
		}
		
		// keep track of those versions that will be pruned, so we unset them after pruning.
		$pruned = array();
		
		foreach ($this->getVersionIDs() as $ver) {
			if ($this->_versions[$ver]->willPrune()) $pruned[] = $ver;
			$this->_versions[$ver]->commit();
		}
		
		// now if we just committed a NEW_VERSION, let's move it to its proper place in the array
		if (isset($this->_versions[NEW_VERSION])) {
			$ref =& $this->_versions[NEW_VERSION];
			$id = $ref->getID();
			if (!$id) return;
			
			$this->_versions[$id] =& $this->_versions[NEW_VERSION];
			// now unset the old
			unset ($this->_versions[NEW_VERSION], $ref);
			// done.
		}
		
		foreach ($pruned as $id) {
			unset($this->_versions[$id]);
		}
	}
	
	/**
	 * USED INTERNALLY: Returns true if all of our versions are about to be pruned.
	 * @access public
	 * @return bool
	 */
	function willPruneAll()
	{
		foreach ($this->getVersionIDs() as $id) {
			$ver =& $this->getVersion($id);
			if (!$ver->willPrune()) return false;
		}
		
		return true;
	}
	
	/**
	* Goes through all the old versions of values and actually DELETES them from the database.
	* @param ref object $versionConstraint A {@link VersionConstraint) on which to base our pruning.
	* @return void
	*/
	function prune($versionConstraint) {
		$versionConstraint->checkRecordFieldValue($this);
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
		
		// now go through and tell all our values to update.
		foreach ($this->getVersionIDs() as $id) {
			$ver =& $this->getVersion($id);
			$ver->update();
		}
		
		return true;
	}
	
	/**
	 * Returns the index of this RecordFieldValue object.
	 *
	 * @return integer The index.
	 */
	function getIndex() {
		return $this->_myIndex;
	}
	
	/**
	* "Sets" the value of this specific index to $value. If the Record is version controlled, a new
	* version is added. Otherwise, the current active version is modified.
	* @return bool
	* @param ref object $value A {@link Primitive} object.
	*/
	function setValueFromPrimitive(&$value) {
		// if we're version controlled, we're adding a new version
		// otherwise, we're just setting the existing (or only active) one.
		if ($this->_parent->_parent->isVersionControlled()) {		// @todo This is referencing another object's private variables. Bad!! Fix this!
			// we're going to add a new version
			// which means, we add a new RecordFieldValue with a *clone*
			// of the primitive, so that it gets added to the DB.
			$newVer =& $this->newRecordFieldData();
			$newVer->setValueFromPrimitive($value->clone());
			
			// all done (we hope)
			return true;
		}
		
		// let's just set the value of the existing one.
		// if we have an active version, set that one.
		if (!$this->hasActiveValue()) {
			$this->undelete();
		}
		
		$actVer =& $this->getActiveVersion();
		$actVal =& $actVer->getPrimitive();
		
		if ($actVal && $actVal->isEqual($value)) 
			return true;

		$actVer->takeValueFromPrimitive($value);
		$actVer->setDate(DateTime::now());
		
		// now tell actVer to update the DB on commit()
		$actVer->update();
		return true;
	}
	
	/**
	* Returns a reference to a new {@link RecordFieldData} object and adds it to the list of versions for this value. USED INTERNALLY ONLY
	* @access protected
	* @return ref object
	*/
	function &newRecordFieldData() {
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
			
			$this->_versions[NEW_VERSION] =& new RecordFieldData($this,true);
			$this->_versions[NEW_VERSION]->update();
			$this->_numVersions++;
		}
		return $this->_versions[NEW_VERSION];
	}
	
	/**
	* Returns the active {@link RecordFieldData} object or FALSE if none exists. If no versions have yet been
	* set, a new {@link RecordFieldData} object is created.
	* @return ref object or false
	*/
	function &getActiveVersion() {
		if ($this->_numVersions == 0) {
			return $this->newRecordFieldData();
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
	function getVersionIDs() {
		return array_keys($this->_versions);
	}
	
	/**
	* Returns the {@link RecordFieldData} object associated with version ID $verID.
	* @return ref object
	* @param int $verID
	*/
	function &getVersion( $verID ) {
		if (!isset($this->_versions[$verID])) {
			throwError( new Error("Could not find version ID $verID.","Record",true));
		}
		return $this->_versions[$verID];
	}
	
	/**
	* Deactivates all existing versions for this value.
	* @return void
	*/
	function delete() {
		// go through all the versions and deactivate them, if we are version controlled.
		// otherwise, go through the *one* version we have and actually prune it from the DB.
		if ($this->_parent->_parent->isVersionControlled()) {
			foreach ($this->getVersionIDs() as $ver) {
				if ($this->_versions[$ver]->getActiveFlag()) {
					$this->_versions[$ver]->setActiveFlag(false);
					$this->_versions[$ver]->update(); // update to DB on commit()
				}
			}
		} else {
			// although there should be only one version here, let's go through all to mamke sure
			foreach($this->getVersionIDs() as $ver) {
				$this->_versions[$ver]->prune();
			}
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
		$ver->update(); // update to DB on commit()
	}
	
	/**
	 * Calls either {@link RecordFieldValue::delete() delete()} or {@link RecordFieldValue::undelete() undelete()} depending on the value passed.
	 * @param bool $bool
	 * @access public
	 * @return void
	 */
	function setActiveFlag($bool)
	{
		if ($bool) $this->undelete();
		else $this->delete();
	}
	
	/**
	* Returns the most recently created version for this value.
	* @return ref object The newest {@link RecordFieldData} object.
	*/
	function &getNewestVersion() {
		$newest = null;
		if ($this->numVersions()) {
			foreach ($this->getVersionIDs() as $ver) {
				$version =& $this->getVersion($ver);
				
				if ($newest == null || (DateTime::compare($newest->getDate(), $version->getDate()) > 0)) {
					$newest =& $version;
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
		
		return $this->hasActiveValue();
	}
	
	/**
	 * Returns TRUE if we have an active version.
	 * @return bool
	 */
	function hasActiveValue() {
		foreach ($this->getVersionIDs() as $verID) {
			if ($this->_versions[$verID]->isActive()) return true;
		}
		return false;
	}
	
	/**
	* Returns a new {@link RecordFieldData} object that is an exact data-specific clone of the current object.
	* @param ref object A reference to a {@link RecordField} object that will act as the parent.
	* @return ref object
	*/
	function &clone(&$parent) {
		$newObj =& new RecordFieldValue($parent, $this->_myIndex);
		
		foreach ($this->getVersionIDs() as $verID) {
			$ver =& $this->getVersion($verID);
			
			$newObj->_versions[++$newObj->_numVersions] =& $ver->clone($newObj);
		}
		
		return $newObj;
	}
	
	/**
	 * Returns the {@link RecordField} object that the current object is a part of.
	 * @return ref object FieldValues The parent {@link RecordField} object
	 */
	function &getRecordField() {
		return $this->_parent;
	}
	
	/**
	 * Returns the id this RecordFieldValue object. The unique ID for the info 
	 * field should be the
	 * 		RecordID::SchemaFieldLabel::RecordFieldValueIndex
	 * @return ref object Id The id of this object.
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

?>