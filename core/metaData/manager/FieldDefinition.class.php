<?php


class FieldDefinition {
	
	var $_dataSetTypeDefinition;
	var $_myID;
	var $_label;
	var $_type;
	var $_mult;
	var $_versionControlled;
	var $_idManager;
	var $_dbID;
	var $_associated;
	var $_db;
	
	var $_addToDB;
	var $_delete;
	var $_update;
	
	function FieldDefinition( $label, $type, $mult=false, $verControl = false ) {
		ArgumentValidator::validate($mult, new BooleanValidatorRule());
		ArgumentValidator::validate($type, new StringValidatorRule());
		ArgumentValidator::validate($label, new StringValidatorRule());
		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		$this->_db =& Services::requireService("DBHandler");
		$this->_dbID = null;
		$this->_myID = null;
		$this->_associated = false;
		$this->_mult = $mult;
		$this->_type = $type;
		$this->_label = $label;
		$this->_versionControlled = $verControl;
		
		$this->_addToDB = false;
		$this->_delete = false;
		$this->_update = false;
		
		$this->_dataSetTypeDefinition = null;
		$this->_idManager = null;
	}
	
	function associate( &$dataSetTypeDefinition, 
						&$idManager,
						$dbID,
						$myID=null ) {
		// first check if we're already attached to a DataSetTypeDefinition.
		// if so, we're gonna dump
		if ($this->_associated) {
			throwError( new Error( "FieldDefinition::associate() - I'm (label '".$this->_label."') already associated with a FieldSetTypeDefinition of type '".OKITypeToString($this->_fieldSetTypeDefinition->getType())."'. You shouldn't be trying to add me to multiple FieldSetTypes. Bad form.","FieldDefinition.class.php",true));
			return false;
		}
		
		$this->_associated = true;
		$this->_myID = $myID;
		$this->_dbID = $dbID;
		$this->_idManager =& $idManager;
		$this->_dataSetTypeDefinition =& $dataSetTypeDefinition;
	}
	
	function getMultFlag() { return $this->_mult; }
	function setMultFlag( $mult ) {
		ArgumentValidator::validate($mult, new BooleanValidatorRule());
		$this->_mult = $mult;
	}
	
	function getVersionControlFlag() { return $this->_versionControlled; }
	function setVersionControlFlag( $vctl ) {
		ArgumentValidator::validate($vctl, new BooleanValidatorRule());
		$this->_versionControlled = $vctl;
	}
	
	function getID() { return $this->_myID; }
	
	function getLabel() {
		return $this->_label;
	}
	
	function getType() { return $this->_type; }
	
	function commit() {
		if (!$this->_dataSetTypeDefinition->getID() || (!$this->_addToDB && !$this->getID())) {
			// we have no ID, we probably can't commit...unless we're going to be added to the DB.
			// we'll also fail if our dataSetTypeDef doesn't have an ID. that meaning it wasn't meant to be
			// synchronized into the database.
		}
		// ...
	}
	
	function delete() {
		// mark this as deleted, only removed when commit() is called.
		$this->_delete = true;
	}
	
	function addToDB() {
		// mark as new so we add it to the DB upon commit().
		$this->_addToDB = true;
	}
	
	function update() {
		// mark this as updated so we update the DB upon commit().
		$this->_update = true;
	}
	
	function &clone() {
		$newField =& new FieldDefinition($this->_label, $this->_type, $this->_mult, $this->_versionControlled);
		return $newField;
	}
}

?>
