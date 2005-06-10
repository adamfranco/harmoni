<?

require_once(HARMONI."dataManager/record/RecordSet.class.php");

/**
 * The StorableRecordSet allows you to store a {@link RecordSet} in the database.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: StorableRecordSet.class.php,v 1.9 2005/06/10 13:46:55 gabeschine Exp $
 */
class StorableRecordSet extends RecordSet {
	
	var $_fetchedIDs;
	var $_storedRecordIDs;
	var $_fetchMode;
	var $_myID;
	
	function StorableRecordSet($id) {
		parent::RecordSet();
		$this->_myID = $id;
		
		$this->_fetchMode = -1;
		
		$this->_fetchedIDs = array();
		$this->_storedRecordIDs = array();
	}
	
	/**
	 * Takes an associative array of columns from a database query and populates internal variables.
	 * @param ref array $row
	 * @return void
	 */
	 function takeRow(&$row) {
	 	if (in_array($row["fk_record"], $this->_fetchedIDs)) return;
	 	$recordManager =& Services::getService("RecordManager");
	 	$this->_storedRecordIDs[] = $row["fk_record"];
	 }

	/**
	 * Fetches all the {@link Record}s that we know about. 
	 * Use {@link RecordSet::getRecords()} to get the fetched records.
	 * @param optional int $mode Defaults to RECORD_CURRENT. Specifies the fetch mode. Must be one of the RECORD_* constants.
	 * @param optional mixed $limitResults NOT IMPLEMENTED.
	 * @return void
	 */
	function loadRecords($mode=RECORD_CURRENT, $limitResults = null) {
	 	$recordManager =& Services::getService("RecordManager");
	 	$records =& $recordManager->fetchRecords($this->getRecordIDs(), $mode, $limitResults);
	 	// Cycle through the resulting records to put them in an indexed array
	 	if (!is_array($this->_records)) $this->_records = array();
	 	foreach (array_keys($records) as $key) {
	 		$id = $records[$key]->getID();
//	 		if (in_array($id, $this->_fetchedIDs)) continue;
	 		if ($this->getRecordByID($id)==null) $this->_records[] =& $records[$key];
	 		if (!in_array($id, $this->_fetchedIDs)) $this->_fetchedIDs[] = $id;
	 	}

	 	$this->_fetchMode = $mode;
	}
	 
	/**
	 * Returns an array of Record IDs that we know about.
	 * @return array
	 */
	function getRecordIDs() {
		return array_unique(array_merge($this->_storedRecordIDs, parent::getRecordIDs()));
	}
	
	/**
	 * Returns our ID.
	 * @access public
	 * @return int
	 */
	function getID()
	{
		return $this->_myID;
	}
	
	/**
	 * Removes the given record from the set.
	 * @param ref object $record A {@link Record} object.
	 * @access public
	 * @return void
	 */
	function removeRecord(&$record)
	{
		$id = $record->getID();
		parent::removeRecord($record);
		
		// now remove the $id from our internal list, if it's there.
		if (in_array($id, $this->_storedRecordIDs)) {
			$new = array();
			foreach ($this->_storedRecordIDs as $rID) {
				if ($id != $rID) $new[] = $rID;
			}
			$this->_storedRecordIDs = $new;
		}
		
		// and this list, to avoid messing up numRecords().
		if (in_array($id, $this->_fetchedIDs)) {
			$new = array();
			foreach ($this->_fetchedIDs as $rID) {
				if ($id != $rID) $new[] = $rID;
			}
			$this->_fetchedIDs = $new;
		}
	}
	
	
	/**
	 * Attempts to commit our {@link Record}s to the database and update our mapping.
	 * @param boolean optional $ignoreMandatory If true, doesn't fail if mandatory
	 *		fields don't have values.
	 * @return void
	 */
	function commit($ignoreMandatory=false) {
		$ids =	array();
		if (count($this->_records)) {
			for($i=0; $i<count($this->_records); $i++) {
				$this->_records[$i]->commit($ignoreMandatory);
				$ids[] = $this->_records[$i]->getID();
			}
			$this->_records = array();
			$this->_fetchMode = -1;
		}
		
		if ($this->_dirty) {
			// syncrhonize the database
			$ids = array_merge($ids, $this->_storedRecordIDs);
			
			// Make sure that we only have one ID for each record.
			$ids = array_unique($ids);

			$dbHandler =& Services::getService("DatabaseManager");
			// first delete all the old mappings
			$query =& new DeleteQuery;
			$query->setTable("dm_record_set");
			$query->setWhere("dm_record_set.id='".addslashes($this->_myID)."'");
//			printpre(MySQL_SQLGenerator::generateSQLQuery($query));
			$dbHandler->query($query, DATAMANAGER_DBID);
			
			if (count($ids)) {
				// next insert all our mappings back in.
				$query =& new InsertQuery;
				$query->setTable("dm_record_set");
				$query->setColumns(array("id","fk_record"));
				foreach ($ids as $id) {
					$query->addRowOfValues(array("'".addslashes($this->_myID)."'", "'".addslashes($id)."'"));
					if (!in_array($id, $this->_storedRecordIDs)) $this->_storedRecordIDs[] = $id;
				}
				
//				printpre(MySQL_SQLGenerator::generateSQLQuery($query));
				$dbHandler->query($query,DATAMANAGER_DBID);
				// done!
			}
		}
	}
	
	/**
	 * Adds the given ID to our list of Records.
	 * @param integer $id
	 * @return void
	 */
	function addRecordID( $id ) {
		ArgumentValidator::validate($id, IntegerValidatorRule::getRule());
		$this->_dirty = true;
		
		$recordManager =& Services::getService("RecordManager");
		$this->_records[] =& $recordManager->fetchRecord( $id );
		$this->_storedRecordIDs[] = $id;
	}
	
	/**
	 * Remove a record by ID.
	 * @param int $id
	 * @access public
	 * @return void
	 */
	function removeRecordByID($id)
	{
		$record =& $this->getRecordByID($id);
		if ($record) $this->removeRecord($record);
	}
	
	/**
	 * Returns a {@link Record} by ID.
	 * @param int $id
	 * @access public
	 * @return ref object
	 */
	function &getRecordByID($id)
	{
		for ($i = 0; $i < count($this->_records); $i++) {
			if ($this->_records[$i]->getID() == $id) return $this->_records[$i];
		}
		
		if (in_array($id, $this->_storedRecordIDs)) {
			$mgr =& Services::getService("RecordManager");
			$record =& $mgr->fetchRecord($id);
			$this->_fetchedIDs[] = $id;
			$this->_records[] =& $record;
			return $record;
		}
		
		return ($null=null);
	}
	
	/**
	 * Returns all of the {@link Record}s within this Set to the state they were in on the given date.
	 * @param ref object $date A {@link DateTime} object.
	 * @access public
	 * @return boolean
	 */
	function revertToDate(&$date)
	{
		$this->loadRecords(RECORD_FULL);
		
		parent::revertToDate($date);
	}
}

?>
