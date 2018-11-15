<?php

/**
 * Holds information about a specific field within a {@link Schema}. Defines
 * what type of data the field holds (string, integer, etc) and if it can have multiple values.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SchemaField.class.php,v 1.16 2007/09/04 20:25:32 adamfranco Exp $
 * @author Gabe Schine
 */
class SchemaField {
	
	var $_id;
	var $_schema;
	var $_displayName;
	var $_type;
	var $_mult;
	var $_label;
	var $_required;
	var $_description;
	var $_associated;
	var $_active;
		
	var $_addToDB;
	var $_delete;
	var $_update;
	
	/**
	 * Constructor
	 * @param string $label the unique label for this field.
	 * @param string $name the field's display name
	 * @param string $type The string name as registered with the {@link DataTypeManager} of the data type (ie, "string", "integer", "boolean", etc)
	 * @param optional string $description a description for this field
	 * @param optional boolean $mult flag specifying if multiple values are allowed
	 * @param optional boolean $required flag specifying if we will disallow a database commit without at least one value for this field
	 * @param optional boolean $active flag specifying if this field is to be used or no.
	 */
	function __construct( $label, $name, $type, $description="", $mult=false, $required=false, $active=true ) {
		ArgumentValidator::validate($mult, BooleanValidatorRule::getRule());
		ArgumentValidator::validate($type, StringValidatorRule::getRule());
		ArgumentValidator::validate($label, StringValidatorRule::getRule());
		ArgumentValidator::validate($name, StringValidatorRule::getRule());
		ArgumentValidator::validate($required, BooleanValidatorRule::getRule());
		ArgumentValidator::validate($active, BooleanValidatorRule::getRule());
		$this->_id = null;
		$this->_associated = false;
		$this->_mult = $mult;
		$this->_required = $required;
		$this->_description = $description;
		$this->_displayName = $name;
		$this->_type = $type;
		$this->_label = $label;
		$this->_active = $active;
		
		$this->_addToDB = false;
		$this->_delete = false;
		$this->_update = false;
		
		$this->_schema = null;
		
		$this->_idManager = Services::getService("Id");
		
//		print "first time name: ".$this->_displayName."<br>";
		
		// let's do a quick check and make sure that this type is registered
//		$typeMgr = Services::getService("DataTypeManager");
//		if (!$typeMgr->typeRegistered($type)) {
//			// throw an error
//			throwError( new HarmoniError("Could not create new SchemaField for type '$type' because it doesn't
//				seem to be a valid type. All types must be registered with a DataTypeManager first.","DataManager",true));
//			return false;
//		}
	}
	
	/**
	 * After being added to a {@link Schema}, it calls associate() to tie us
	 * to its type. This way, we can only be added to one Schema.
	 * @param ref object $schema The schema to which we are being added.
	 * @return void
	 * @access public
	 */
	function associate( $schema ) {
		
		// first check if we're already attached to a Schema.
		// if so, we're gonna dump
		if ($this->_associated) {
			throwError( new HarmoniError( "I'm (label '".$this->_label."') already associated with Schema type '".HarmoniType::typeToString($this->_schema->getType())."'. You shouldn't be trying to add me to multiple Schemas. Bad form.","DataManager",true));
			return false;
		}
		
		$this->_associated = true;
		$this->_schema =$schema;
		
		$this->_id = $schema->getID() . "." . $this->_label;
	}
	
	/**
	 * Returns this field's ID (assuming it has been associated with a Schema)
	 * @return string
	 * @access public
	 */
	function getID() {
		return $this->_id;
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
		ArgumentValidator::validate($mult, BooleanValidatorRule::getRule());
		$this->_mult = $mult;
	}
	
	/**
	 * Returns this field's description.
	 * @access public
	 * @return string
	 */
	function getDescription()
	{
		return $this->_description;
	}
	
	/**
	 * Returns our text-label.
	 * @return string
	 * @access public
	 */
	function getLabel() {
		return $this->_label;
	}
	
	/**
	 * Returns our display name.
	 * @return string
	 * @access public
	 */
	function getDisplayName() {
		return $this->_displayName;
	}
	
	/**
	 * Returns the {@link DataType} registered with the {@link DataTypeManager} that we are tied to.
	 * @return string
	 * @access public
	 */
	function getType() { return $this->_type; }
	
	/**
	 * Reflects any changes made locally to the database.
	 * @param optional int $id The ID in the database to update (if not adding...).
	 * @return int Returns our ID in the database or NULL upon error.
	 * @access public
	 */
	function commit($id=null) {
		if (!$this->_schema->getID() || (!$this->_addToDB && !$id)) {
			// we have no ID, we probably can't commit...unless we're going to be added to the DB.
			// we'll also fail if our dataSetTypeDef doesn't have an ID. that meaning it wasn't meant to be
			// synchronized into the database.
			throwError( new HarmoniError("Could not commit() to database because either: 1) we don't have a local ID, 
			meaning we were not meant to be synchronized with the database, or 2) the Schema to which we 
			belong is not linked with the database. (label: ".$this->_label.", schema name: ".$this->_schema->getDisplayName().")",
			"DataManager",true));
			return null;
		}
		
		$dbHandler = Services::getService("DatabaseManager");
		
		if ($this->_addToDB) {
			$query = new InsertQuery();
			$query->setTable("dm_schema_field");
			$query->setColumns(array("id","fk_schema","name","mult","fieldtype","active","required","description"));
			
			$query->addRowOfValues(array(
					"'".addslashes($id)."'",
					"'".addslashes($this->_schema->getID())."'",
					"'".addslashes($this->_displayName)."'",
					(($this->_mult)?1:0),
					"'".addslashes($this->_type)."'",
					1,
					($this->_required?1:0),
					"'".addslashes($this->_description)."'"
			));
			
			$this->_addToDB = false;
			
			$result =$dbHandler->query($query,DATAMANAGER_DBID);
			if (!$result || $result->getNumberOfRows() != 1) {
				throwError( new UnknownDBError("DataManager") );
				return false;
			}
			
			return $id;
		}
		
		if ($this->_update) {
			// do some updating
			$query = new UpdateQuery();
			$query->setTable("dm_schema_field");
			$query->setColumns(array("name","mult","active","required","description"));
			$query->setWhere("id='".addslashes($id)."'");
			
			$query->setValues(array(
					"'".addslashes($this->_displayName)."'",
					(($this->_mult)?1:0),
					(($this->_active)?1:0),
					($this->_required?1:0),
					"'".addslashes($this->_description)."'"
			));
			
			$this->_update = false;
			
			$result =$dbHandler->query($query,DATAMANAGER_DBID);
			if (!$result || $result->getNumberOfRows() != 1) {
				throwError( new UnknownDBError("DataManager") );
				return null;
			}
			
			return $id;			
		}
		
		if ($this->_delete) {
			// let's get rid of this bad-boy
			$query = new UpdateQuery();
			$query->setTable("dm_schema_field");
			$query->setWhere("id='".addslashes($id)."'");
			$query->setColumns(array("active"));
			$query->setValues(array(0));

			$this->_delete = false;
			
			$result =$dbHandler->query($query,DATAMANAGER_DBID);
// 			if (!$result || $result->getNumberOfRows() != 1) {
// 				throwError( new UnknownDBError("DataManager") );
// 				return false;
// 			}
			
			return $id;
		}
		
		// if we're here... nothing happened... no problems
		return $id;
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
	 * @return ref object A new {@link SchemaField} object.
	 * @access public
	 */
	function replicate() {
		$newField = new SchemaField($this->_label, $this->_displayName,  $this->_type, $this->_description, $this->_mult, $this->_required );
		return $newField;
	}
	
	/**
	 * Returns if this field is active within the {@link Schema} or not.
	 * @return bool
	 * @access public
	 */
	function isActive() { return $this->_active; }
	
	/**
	 * Sets if this field should be active within the {@link Schema}.
	 * @param bool $bool
	 * @return void
	 * @access public
	 */
	function setActiveFlag($bool) { $this->_active=$bool; }
	
	/**
	 * Sets this field's description.
	 * @param string $description
	 * @access public
	 * @return void
	 */
	function updateDescription($description)
	{
		$this->_description = $description;
	}
	
	/**
	 * Sets this field's display name.
	 * @param string $name
	 * @access public
	 * @return void
	 */
	function updateDisplayName($name) {
		$this->_displayName = $name;
	}
}