<?

define("NEW_VERSION","new");

/**
 * Responsible for keeping track of multiple versions of a value for a specific index within a 
 * field within a DataSet.
 * @package harmoni.datamanager
 * @version $Id: ValueVersions.classes.php,v 1.10 2004/01/01 19:03:42 gabeschine Exp $
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
	
	function populate( $arrayOfRows ) {
		// we are responsible for keeping track of multiple ValueVersion objects,
		// each corresponding to a specific version of a value of a field.
		
		// we are going to hand each line in turn to a ValueVersion object
		foreach ($arrayOfRows as $line) {
			$verID = $line['datasetfield_id'];
			$active = ($line['datasetfield_active'])?true:false;
			
			$this->_versions[$verID] =& new ValueVersion($this,$active);
			$this->_versions[$verID]->populate($line);
			$this->_numVersions++;
		}
	}
	
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
	
	function numVersions() {
		return $this->_numVersions;
	}
	
	function setValue(&$value) {
		// if we're version controlled, we're adding a new version
		// otherwise, we're just setting the existing (or only active) one.
		if ($this->_parent->_parent->isVersionControlled()) {
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
		$actVer =& $this->getActiveVersion();
		$actVer->takeValue($value);
		
		// now tell actVer to update the DB on commit()
		$actVer->update();
		return true;
	}
	
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
	
	function getVersionList() {
		return array_keys($this->_versions);
	}
	
	function &getVersion( $verID ) {
		if (!isset($this->_versions[$verID])) {
			throwError( new Error("Could not find version ID $verID.","ValueVersions",true));
		}
		return $this->_versions[$verID];
	}
	
	function delete() {
		// go through all the versions and deactivate them.
		foreach ($this->getVersionList() as $ver) {
			$this->_versions[$ver]->setActiveFlag(false);
			$this->_versions[$ver]->update(); // update to DB on commit()
		}
	}
	
	function undelete() {
		// if we're not active, go through and find the newest ver, then activate it.
		if ($this->isActive()) return true;
		
		$ver =& $this->getNewestVersion();
		$ver->setActiveFlag(true);
	}
	
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
	
	function isActive() {
		if ($this->_numVersions == 0) return true; // if we don't have any values yet, assume we are active
		
		foreach (array_keys($this->_versions) as $id) {
			if ($this->_versions[$id]->isActive()) return true;
		}
		return false;
	}
}

/**
 * Holds information about a specific version of a value index of a field in a DataSet. Information held
 * includes: Date created/modified, active/not active (ie, deleted), and the actual value object. 
 * @package harmoni.datamanager
 * @version $Id: ValueVersions.classes.php,v 1.10 2004/01/01 19:03:42 gabeschine Exp $
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
	
	function ValueVersion(&$parent, $active=false) {
//		$this->_date = null; // @todo - should we create a new DateTime::now() or leave null?
		$this->_date =& DateTime::now();
		$this->_valueObj = null;
		$this->_active = $active;
		
		$this->_parent =& $parent;
		
		$this->_update = false;
	}
	
	function update() { $this->_update=true; }
	
	function setActiveFlag($active) {
		ArgumentValidator::validate($active, new BooleanValidatorRule());
		
		$this->_active = $active;
	}
	
	function isActive() { return $this->_active; }
	
	function populate( $row ) {
		$dbHandler =& Services::getService("DBHandler");
		$dbID = $this->_parent->_parent->_parent->_dbID;
		
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
	
	function commit() {
		if (!$this->_update) return false; // if we weren't flagged to update, git out
		
		// first we need to commit the actual DataType value
		// so that we can get its ID
		$this->_valueObj->setup($this->_parent->_parent->_parent->_idManager,
								$this->_parent->_parent->_parent->_dbID);
		$this->_valueObj->commit();
		
		$dbHandler =& Services::getService("DBHandler");
		$dbID = $this->_parent->_parent->_parent->_dbID;
		
		if ($this->_myID) {
			// we're already in the DB. just update the entry
			$query =& new UpdateQuery();
			
			$query->setWhere("datasetfield_id=".$this->_myID);
			$query->setColumns(array("datasetfield_active", "datasetfield_modified"));
			$query->setValues(array(($this->_active)?1:0,$dbHandler->toDBDate($this->_date,$dbID)));
		} else {
			// we have to insert a new one
			$query =& new InsertQuery();
			
			$this->_myID = $this->_parent->_parent->_parent->_idManager->newID(
					new HarmoniType("Harmoni","HarmoniDataManager","DataSetField"));
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
		
		return true;
		
	}
	
	function takeValue(&$object) {
		if (!$this->_valueObj) $this->setValue($object);
		else $this->_valueObj->takeValue($object);
	}
	
	function setValue(&$object) {
		$this->_valueObj =& $object;
	}
	
	function &getValue() {
		return $this->_valueObj;
	}
	
	function &getDate() {
		return $this->_date;
	}
	
	function setDate(&$date) {
		ArgumentValidator::validate($date, new ExtendsValidatorRule("DateTime"));
		$this->_date =& $date;
	}
	
	function getID() {
		return $this->_myID;
	}
}

?>