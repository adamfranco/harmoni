<?php

/**
 * Holds information about a specific label within a {@link DataSetTypeDefinition}. Defines
 * what type of data the field holds (string, integer, etc) and if it can have multiple values.
 * @package harmoni.datamanager
 * @version $Id: FieldDefinition.class.php,v 1.12 2004/03/31 19:13:26 adamfranco Exp $
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
	var $_required;
	var $_dbID;
	var $_associated;
	
	var $_addToDB;
	var $_delete;
	var $_update;
	
	var $_active;
	
	function FieldDefinition( $label, $type, $mult=false, $required=false, $active=true ) {
		ArgumentValidator::validate($mult, new BooleanValidatorRule());
		ArgumentValidator::validate($type, new StringValidatorRule());
		ArgumentValidator::validate($label, new StringValidatorRule());
//		ArgumentValidator::validate($verControl, new BooleanValidatorRule());
		$this->_dbID = null;
		$this->_myID = null;
		$this->_associated = false;
		$this->_mult = $mult;
		$this->_required = $required;
		$this->_type = $type;
		$this->_label = $label;
		$this->_active = $active;
		
		$this->_addToDB = false;
		$this->_delete = false;
		$this->_update = false;
		
		$this->_dataSetTypeDefinition = null;
		
		// let's do a quick check and make sure that this type is registered
		$typeMgr =& Services::requireService("DataTypeManager");
		if (!$typeMgr->typeRegistered($type)) {
			// throw an error
			throwError( new Error("Could not create new FieldDefinition for type '$type' because it doesn't
				seem to be a valid type. All types must be registered with a DataTypeManager first.","FieldDefinition",true));
			return false;
		}
	}
	
	/**
	 * After being added to a {@link DataSetTypeDefinition}, it calls associate() to tie us
	 * to its DataSetType. This way, we can only be added to one DataSetTypeDefinition.
	 * @param ref object $dataSetTypeDefinition The definition to which we are being added.
	 * @param int $dbID The DB index to use with the {@link DBHandler}.
	 * @param optional int $myID Optionally, our ID in the database.
	 * @return void
	 * @access public
	 */
	function associate( &$dataSetTypeDefinition,
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
		$this->_dataSetTypeDefinition =& $dataSetTypeDefinition;
	}
	
	/**
	 * Returns if this field is allowed to have multiple values.
	 * @return bool
	 * @access public
	 */
	function getMultFlag() { return $this->_mult; }
	
	/**
	 * Returns if this field is required to hold at least one value.
	 * @return bool
	 */
	function isRequired() {
		return $this->_required;
	}
	
	/**
	 * Sets if this field should be required or not.
	 * @return void
	 * @param bool $req
	 */
	function setRequired($req) {
		$this->_required = $req;
	}	
	
	/**
	 * Sets if this field is allowed to have multiple values.
	 * @param bool $mult
	 * @return void
	 * @access public
	 */
	function setMultFlag( $mult ) {
		ArgumentValidator::validate($mult, new BooleanValidatorRule());
		$this->_mult = $mult;
	}
	
	/**
	 * Returns our ID in the database.
	 * @return int
	 * @access public
	 */
	function getID() { return $this->_myID; }
	
	/**
	 * Returns our text-label.
	 * @return string
	 * @access public
	 */
	function getLabel() {
		return $this->_label;
	}
	
	/**
	 * Returns the {@link DataType} registered with the {@link DataTypeManager} that we are tied to.
	 * @return string
	 * @access public
	 */
	function getType() { return $this->_type; }
	
	/**
	 * Reflects any changes made locally to the database.
	 * @return bool
	 * @access public
	 */
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
			"datasettypedef_mult","datasettypedef_fieldtype","datasettypedef_active","datasettypedef_required"));
			
			$sharedManager =& Services::getService("Shared");
			$newID =& $sharedManager->createId();
			
			$dataSetTypeID = $this->_dataSetTypeDefinition->getID();
			
			$query->addRowOfValues(array(
					$newID->getIdString(),
					$dataSetTypeID,
					"'".addslashes($this->_label)."'",
					(($this->_mult)?1:0),
					"'".addslashes($this->_type)."'",
					1,
					($this->_required?1:0)
			));
			
			$result =& $dbHandler->query($query,$this->_dbID);
			if (!$result || $result->getNumberOfRows() != 1) {
				throwError( new UnknownDBError("FieldDefinition") );
				return false;
			}
			
			$this->_myID = $newID->getIdString();
			return true;
		}
		
		if ($this->_update) {
			// do some updating
			$query = new UpdateQuery();
			$query->setTable("datasettypedef");
			$query->setColumns(array("datasettypedef_mult","datasettypedef_active","datasettypedef_required"));
			$query->setWhere("datasettypedef_id=".$this->getID());
			
			$query->setValues(array(
					(($this->_mult)?1:0),
					(($this->_active)?1:0),
					($this->_required?1:0)
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
	
	/**
	 * Flags that we should deactivate ourselves upon commit()
	 * @return void
	 * @access public
	 */
	function delete() {
		// mark this as deleted, only removed when commit() is called.
		$this->_delete = true;
	}
	
	/**
	 * Flags that we should add ourselves to the databse as a new row upon commit().
	 * @return void
	 * @access public
	 */
	function addToDB() {
		// mark as new so we add it to the DB upon commit().
		$this->_addToDB = true;
	}
	
	/**
	 * Flags that we should update an existing row in the database upon commit().
	 * @return 
	 * @access public
	 */
	function update() {
		// mark this as updated so we update the DB upon commit().
		$this->_update = true;
	}
	
	/**
	 * Returns a replica of this object.
	 * @return ref object A new {@link FieldDefinition} object.
	 * @access public
	 */
	function &clone() {
		$newField =& new FieldDefinition($this->_label, $this->_type, $this->_mult );
		return $newField;
	}
	
	/**
	 * Returns if this field is active within the DataSetTypeDefinition or not.
	 * @return bool
	 * @access public
	 */
	function isActive() { return $this->_active; }
	
	/**
	 * Sets if this field should be active within the DataSetTypeDefinition.
	 * @param bool $bool
	 * @return void
	 * @access public
	 */
	function setActiveFlag($bool) { $this->_active=$bool; }
}

/**
 * @package harmoni.datamanager
 */
class HarmoniFieldDefinitionType extends HarmoniType {
	function HarmoniFieldDefinitionType() {
		parent::HarmoniType("Harmoni","HarmoniDataManager","FieldDefinition",
		"Defines a certain field within a DataSetTypeDefinition.");
	}
}

?>
