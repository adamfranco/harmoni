<?

// holds multiple values for a given label + index
class ValueVersions {
	
	var $_numVersions;
	var $_parent;
	
	var $_versions;
	
	function ValueVersions (&$parent) {
		$this->_parent =& $parent;
		$this->_numVersions = 0;
	}
	
	function populate( $arrayOfRows ) {
		
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
//			$this->_versions[] =& $newVer;
//			$this->_numVersions++;
			
			// tell the new version to update to the DB on commit();
			$newVer->update();
			
			// now, we h have to activate the new version
			$oldVer =& $this->getActiveVersion();
			if ($oldVer) {
				$oldVer->setActiveFlag(false);
				$oldVer->update();
			}
			$newVer->setActiveFlag(true);
			
			// all done (we hope)
			return true;
		}
		
		// let's just set the value of the existing one.
		$actVer =& $this->getActiveVersion();
//		$actVer->getValue();
		$actVer->takeValue($value);
		
		// now tell actVer to update the DB on commit()
		$actVer->update();
		return true;
	}
	
	function &newVerObject($active = false) {
		$this->_versions[$this->numVersions()] =& new ValueVersion($this,$active);
		$this->_numVersions++;
		return $this->_versions[$this->numVersions()-1];
	}
	
	function &getActiveVersion() {
		if ($this->_numVersions == 0) {
			return $this->newVerObject(true);
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
	
}

class ValueVersion {
	
	var $_myID;
	
	var $_date;
	var $_valueObj;
	var $_active;
	
	var $_parent;
	
	var $_update;
	
	function ValueVersion(&$parent, $active=false) {
		$this->_date = null; // @todo - should we create a new DateTime::now() or leave null?
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
	
	function populate( $arrayOfRows ) {
		
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