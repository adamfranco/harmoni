<?

/**
 * Holds information about a specific version of a value index of a field in a {@link Record}. Information held
 * includes: Date created/modified, active/not active (ie, deleted), and the actual value object (usually a {@link Primitive}). 
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: RecordFieldData.class.php,v 1.14 2005/07/13 17:41:12 adamfranco Exp $
 * @author Gabe Schine
 */
class RecordFieldData {
	
	var $_myID;
	var $_dataID;
	
	var $_date = null;
	var $_primitive = null;
	var $_active = false;
	
	var $_parent = null;
	
	var $_update = false;
	var $_prune = false;
	var $_recast = false;
	
	function RecordFieldData(&$parent, $active=false) {
		$this->_date =& DateAndTime::now();
		$this->_active = $active;
		
		$this->_parent =& $parent;
	}
	
	/**
	 * Returns an exact data-specific replica of the current object.
	 * @param ref object $parent The new parent object to use instead of our parent.
	 * @return ref object
	 * @access public
	 */
	function &replicate(&$parent) {
		$newObj =& new RecordFieldData($parent, $this->_active);
		
		$date = $this->_date; // in PHP4 this will replicate the DateAndTime
		$newObj->setDate($date);
		$newObj->setValueFromPrimitive($this->_primitive->replicate());
		
		$newObj->update();
		
		return $newObj;
	}
	
	/**
	 * Flags this RecordFieldData to be updated to the database upon commit().
	 * @return void
	 * @access public
	 */
	function update() { $this->_update=true; }
	
	/**
	 * Changes the active flag of this RecordFieldData to $active.
	 * @param bool $active
	 * @return void
	 * @access public
	 */
	function setActiveFlag($active) {
//		ArgumentValidator::validate($active, BooleanValidatorRule::getRule());
		
		$this->_active = $active;
		
		// if for some reason we are going to be pruned, and the new active flag is true, let's not prune
		if ($active===true) $this->_prune = false;
	}
	
	/**
	 * Returns the current active flag.
	 * @access public
	 * @return bool
	 */
	function getActiveFlag()
	{
		return $this->_active;
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
		$dbHandler =& Services::getService("DatabaseManager");
//		$recordField =& $this->_parent->getRecordField();
//		$record =& $recordField->getRecord();
//		$dbID = $dataSet->getDatabaseId();
		
		$this->_myID = $row['record_field_id'];
		$this->_date =& $dbHandler->fromDBDate($row['record_field_modified'],DATAMANAGER_DBID);
		// $this->_active was set by parent on construction
		
		// now we need to create the valueObj
		$recordField =& $this->_parent->getRecordField();
		$schemaField =& $recordField->getSchemaField();
		$type = $schemaField->getType();
		
		$dataTypeManager =& Services::getService("DataTypeManager");
		$valueObj =& $dataTypeManager->newStorablePrimitive($type);
		
		$valueObj->populate($row);
		$this->_dataID = $row['fk_data'];
		
		$this->_primitive =& $valueObj;
		
	}
	
	/**
	 * Flags us for deletion from the DB.
	 * @return void
	 * @access public
	 */
	function prune() {
		$this->_prune = true;
		// if we're pruning, there's no point in updating the DB
		$this->_update = false;
	}
	
	/**
	 * Re-casts our internal {@link Primitive} data object as a {@link StorablePrimitive} of the same data type.
	 * @access public
	 * @return void
	 */
	function recastAsStorable()
	{
		if ($this->_recast) return;
		$dataTypeManager =& Services::getService("DataTypeManager");
		$recordField =& $this->_parent->getRecordField();
		$schemaField =& $recordField->getSchemaField();
		$type = $schemaField->getType();
		
		$newObj =& $dataTypeManager->recastAsStorablePrimitive($this->_primitive, $type);
		if ($newObj) {
			$this->_primitive =& $newObj;
			$this->_recast = true;
		}
	}
	
	/**
	 * Commits any changes that have been made to the database. If neither update() nor prune() have been
	 * called, even if changes have been made, they will not be reflected in the database.
	 * @return bool
	 * @access public
	 */
	function commit() {
		
		$dbHandler =& Services::getService("DatabaseManager");
		
		if ($this->_update) {
			// let's re-cast our primitive to a storablePrimitive
			$this->recastAsStorable();
			// first we need to commit the actual Primitive value
			// so that we can get its ID
			if (!$this->_dataID) 
				$this->_dataID = $this->_primitive->insert(DATAMANAGER_DBID);
			else
				$this->_primitive->update(DATAMANAGER_DBID,$this->_dataID);
			
			
			if ($this->_myID) {
				// we're already in the DB. just update the entry
				$query =& new UpdateQuery();
				
				$query->setWhere("id='".addslashes($this->_myID)."'");
				$query->setColumns(array("value_index","active", "modified"));
				$query->setValues(array($this->_parent->getIndex(),($this->_active)?1:0,
										"'".$dbHandler->toDBDate($this->_date,DATAMANAGER_DBID)."'"));
			} else {
				// we have to insert a new one
				$query =& new InsertQuery();
				
				if (OKI_VERSION > 1)
					$idManager =& Services::getService("Id");
				else
					$idManager =& Services::getService("Shared");
				
				$newID =& $idManager->createId();
				
				$this->_myID = $newID->getIdString();
				$query->setColumns(array(
				"id",
				"fk_record",
				"fk_schema_field",
				"value_index",
				"fk_data",
				"active",
				"modified"
				));
				
				$schema =& $this->_parent->_parent->_parent->getSchema();
				$schemaField =& $this->_parent->_parent->getSchemaField();
				
				$query->addRowOfValues(array(
				"'".addslashes($this->_myID)."'",
				"'".addslashes($this->_parent->_parent->_parent->getID())."'",
				"'".addslashes($schema->getFieldID($schemaField->getLabel()))."'",
				$this->_parent->getIndex(),
				"'".addslashes($this->_dataID)."'",
				($this->_active)?1:0,
				"'".$dbHandler->toDBDate($this->_date,DATAMANAGER_DBID)."'"
				));
			}
			
			$query->setTable("dm_record_field");

			$result =& $dbHandler->query($query, DATAMANAGER_DBID);
			
			if (!$result) {
				throwError( new UnknownDBError("Record") );
				return false;
			}
		}
		
		if ($this->_prune && $this->_dataID) {
			if ($id = $this->getID()) {
				// ok, let's get rid of ourselves... completely!
				$query =& new DeleteQuery;
				$query->setTable("dm_record_field");
				$query->setWhere("id='".addslashes($id)."'");

				$res =& $dbHandler->query($query, DATAMANAGER_DBID);
				if (!$res) throwError( new UnknownDBError("Record"));
				
				// now tell the data object to prune itself
				$this->recastAsStorable();
				$this->_primitive->prune(DATAMANAGER_DBID, $this->_dataID);
				
				// and we have to get rid of any tag mappings where we are included.
				$query =& new DeleteQuery;
				$query->setTable("dm_tag_map");
				$query->setWhere("fk_record_field='".addslashes($id)."'");
				
				$res =& $dbHandler->query($query, DATAMANAGER_DBID);
				if (!$res) throwError( new UnknownDBError("Record"));
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
	 * Takes a {@link Primitive} object and hands it to our local value object so that it can 
	 * set its own value based on $object.
	 * @param ref object $object
	 * @return void
	 * @access public
	 */
	function takeValueFromPrimitive(&$object) {
		if (!$this->_primitive) $this->setValueFromPrimitive($object);
		else $this->_primitive->adoptValue($object);
	}
	
	/**
	 * Sets the local valueObject to be a reference to $object.
	 * @param ref object $object A new {@link Primitive} object.
	 * @return void
	 * @access public
	 */
	function setValueFromPrimitive(&$object) {
		$this->_primitive =& $object;
	}
	
	/**
	 * Returns the current value object contained locally.
	 * @return ref object A {@link Primitive}.
	 * @access public
	 */
	function &getPrimitive() {
		return $this->_primitive;
	}
	
	/**
	 * Returns the created/modified timestamp of this specific version.
	 * @return ref object A {@link DateAndTime} object.
	 * @access public
	 */
	function &getDate() {
		return $this->_date;
	}
	
	/**
	 * Sets the date reflected within our local variables to $date.
	 * @param ref object A {@link DateAndTime} object.
	 * @return void
	 * @access public
	 */
	function setDate(&$date) {
		ArgumentValidator::validate($date,
			HasMethodsValidatorRule::getRule("asDateAndTime"));
		$this->_date =& $date->asDateAndTime();
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
