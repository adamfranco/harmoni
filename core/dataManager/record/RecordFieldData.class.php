<?

/**
 * Holds information about a specific version of a value index of a field in a DataSet. Information held
 * includes: Date created/modified, active/not active (ie, deleted), and the actual value object. 
 * @package harmoni.datamanager
 * @version $Id: RecordFieldData.class.php,v 1.1 2004/07/26 04:21:16 gabeschine Exp $
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
