<?php

/**
 * Holds information about a specific label within a {@link DataSetTypeDefinition}. Defines
 * what type of data the field holds (string, integer, etc) and if it can have multiple values.
 * @package harmoni.datamanager
 * @version $Id: FieldDefinition.class.php,v 1.8 2004/01/07 19:14:13 gabeschine Exp $
 * @author Gabe Schine
 * @copyright 2004
 * @access public
 **/
class FieldDefinition {
	
	var $_dataSetTypeDefinition;
	var $_myID;
	var $_label;
	var $_type;
	var $_mult;
	var $_idManager;
	var $_dbID;
	var $_associated;
	
	var $_addToDB;
	var $_delete;
	var $_update;
	
	var $_active;
	
	function FieldDefinition( $label, $type, $mult=false, $active=true ) {
		ArgumentValidator::validate($mult, new BooleanValidatorRule());
		ArgumentValidator::validate($type, new StringValidatorRule());
		ArgumentValidator::validate($label, new StringValidatorRule());
//		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		$this->_dbID = null;
		$this->_myID = null;
		$this->_associated = false;
		$this->_mult = $mult;
		$this->_type = $type;
		$this->_label = $label;
		$this->_active = $active;
		
		$this->_addToDB = false;
		$this->_delete = false;
		$this->_update = false;
		
		$this->_dataSetTypeDefinition = null;
		$this->_idManager = null;
		
		// let's do a quick check and make sure that this type is registered
		$typeMgr =& Services::requireService("DataTypeManager");
		if (!$typeMgr->typeRegistered($type)) {
			// throw an error
			throwError( new Error("Could not create new FieldDefinition for type '$type' because it doesn't
				seem to be a valid type. All types must be registered with a DataTypeManager first.","FieldDefinition",true));
			return false;
		}
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
			throwError( new Error("Could not commit() to database because either: 1) we don't have a local ID, 
			meaning we were not meant to be synchronized with the database, or 2) the DataSetTypeDefinition to which we 
			belong is not linked with the database. (label: ".$this->_label.", dataset type: ".OKITypeToString($this->_dataSetTypeDefinition->getType()).")",
			"FieldDefinition",true));
			return false;
		}
		
		$dbHandler =& Services::requireService("DBHandler");
		
		if ($this->_addToDB) {
			if ($this->getID()) {
				throwError (new Error("Can't add new FieldDefinition to database (label: ".$this->_label.", type: ".$this->_type
				.") because it seems it's already in the database with id ".$this->getID(),"FieldDefinition",true));
				return false;
			}
			$query = new InsertQuery();
			$query->setTable("datasettypedef");
			$query->setColumns(array("datasettypedef_id","fk_datasettype","datasettypedef_label",
			"datasettypedef_mult","datasettypedef_fieldtype","datasettypedef_active"));
			
			$newID = $this->_idManager->newID( new HarmoniFieldDefinitionType() );
			$dataSetTypeID = $this->_dataSetTypeDefinition->getID();
			
			$query->addRowOfValues(array(
					$newID,
					$dataSetTypeID,
					"'".addslashes($this->_label)."'",
					(($this->_mult)?1:0),
					"'".addslashes($this->_type)."'",
					1
			));
			
			$result =& $dbHandler->query($query,$this->_dbID);
			if (!$result || $result->getNumberOfRows() != 1) {
				throwError( new UnknownDBError("FieldDefinition") );
				return false;
			}
			
			$this->_myID = $newID;
			return true;
		}
		
		if ($this->_update) {
			// do some updating
			$query = new UpdateQuery();
			$query->setTable("datasettypedef");
			$query->setColumns(array("datasettypedef_mult","datasettypedef_active"));
			$query->setWhere("datasettypedef_id=".$this->getID());
			
			$query->setValues(array(
					(($this->_mult)?1:0),
					(($this->_active)?1:0)
			));
			
			$result =& $dbHandler->query($query,$this->_dbID);
			if (!$result || $result->getNumberOfRows() != 1) {
				throwError( new UnknownDBError("FieldDefinition") );
				return false;
			}
			return true;			
		}
		
		if ($this->_delete) {
			// let's get rid of this bad-boy
			$query =& new UpdateQuery();
			$query->setTable("datasettypedef");
			$query->setWhere("datasettypedef_id=".$this->getID());
			$query->setColumns(array("datasettypedef_active"));
			$query->setValues(array(0));
			
			$result =& $dbHandler->query($query,$this->_dbID);
			if (!$result || $result->getNumberOfRows() != 1) {
				throwError( new UnknownDBError("FieldDefinition") );
				return false;
			}
			
			$this->_myID=null;
			
			return true;
		}
		
		// if we're here... nothing happened... no problems
		return true;
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
		$newField =& new FieldDefinition($this->_label, $this->_type, $this->_mult );
		return $newField;
	}
	
	function isActive() { return $this->_active; }
	function setActiveFlag($bool) { $this->_active=$bool; }
}

class HarmoniFieldDefinitionType extends HarmoniType {
	function HarmoniFieldDefinitionType() {
		parent::HarmoniType("Harmoni","HarmoniDataManager","FieldDefinition",
		"Defines a certain field within a DataSetTypeDefinition.");
	}
}

?>
