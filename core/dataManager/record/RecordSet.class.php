<?

/**
 * The RecordSet class holds a list of IDs and their Records in a specific record set.
 * @package harmoni.datamanager
 * @version $Id: RecordSet.class.php,v 1.3 2004/07/27 20:44:23 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class RecordSet {
	
	var $_recordIDs;
	var $_records;
	var $_newRecords;
	var $_deletedRecordIDs;
	var $_fetchedFull;
	var $_myID;
	
	var $_dirty;
	
	function RecordSet($id) {
		$this->_recordIDs = array();
		$this->_records = array();
		$this->_newRecords = array();
		$this->_deletedRecordIDs = array();
		
		$this->_myID = $id;
		
		$this->_dirty = false;
		$this->_fetchedFull = false;
	}
	
	/**
	 * Takes an associative array of columns from a database query and populates internal variables.
	 * @param ref array $row
	 * @return void
	 */
	function takeRow(&$row) {
		// If the asset is valid and active:
		if ($row["record_active"] == "1") {
			// This has to be in here, otherwise we don't get a reference to the record
			// and when we try to do things to all of our records, we have problems.
			// This problem comes up when commit is called as it only looks at 
			// _records, not recordIDs.
			$recordManager =& Services::getService("RecordManager");
			$this->_records[] =& $this->_mgr->fetchDataSet( $row["fk_record"] );
			
			$this->_recordIDs[] = $row["fk_record"];
			
		// If the dataset exists, but is inactive:
		} else if ($row["record_active"] == "0"){
			$this->_deletedRecordIDs[] = $row["fk_record"];
		}
		
		// if we get NULL for the record_active field, then the record has been pruned.
		// We'll just let it be deleted when we update.
	}
	
	/**
	 * Fetches all the {@link Record}s that we know about. If $editable is TRUE, they will be fetched full (not read-only).
	 * @param optional boolean $editable Defaults to FALSE.
	 * @param optional mixed $limitResults NOT IMPLEMENTED.
	 */
	function &fetchRecords($editable = false, $limitResults = null) {
		// We need to fetch the dataSets if:
		// 	We dont' have any 
		// 		OR
		// 	Our counts don't match
		// 		OR
		// 	We're not fetched full and we are supposed to be editable.
		if (!count($this->_records) 
			|| (count($this->_records) != count($this->_recordIDs)) 
			|| (!$this->_fetchedFull && $editable)) {
			
			$recordManager =& Services::getService("RecordManager");
			$records =& $recordManager->fetchRecords($this->_recordIDs, $editable, $limitResults);
			// Cycle through the resulting records to put them in an indexed array
			$this->_records = array();
			foreach (array_keys($records) as $key) {
				$this->_records[] =& $records[$key];
			}
			
			$this->_fetchedFull = $editable;
		}
		
		if (count($this->_newRecords)) {
			$records = array();
			for($i=0; $i<count($this->_records); $i++) {
				$records[] =& $this->_records[$i];
			}
			for($i=0; $i<count($this->_newRecord); $i++) {
				$records[] =& $this->_newRecords[$i];
			}
			return $records;
		}
				
		return $this->_records;
	}
	
	/**
	 * Returns an array of Record IDs that we know about.
	 * @return array
	 */
	function getRecordIDs() {
		return $this->_recordIDs;
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
	 * Attempts to commit our {@link Record}s to the database and update our mapping.
	 * @return void
	 */
	function commit() {
		$ids =	array();
		
		if (count($this->_newRecords)) {
			for($i=0; $i<count($this->_newRecords); $i++) {
				$this->_newRecords[$i]->commit();
				$ids[] = $this->_newRecords[$i]->getID();
			}
			$this->_newRecords = array();
		}
		
		if (count($this->_records)) {
			for($i=0; $i<count($this->_records); $i++) {
				// only save if they were fetched not read only.
				if ($this->_records[$i]->getFetchMode() & RECORD_FULL) 
					$this->_records[$i]->commit();
				$ids[] = $this->_records[$i]->getID();
			}
			$this->_records = array();
			$this->_fetchedFull = false;
		}
		
		if ($this->_dirty) {
			// syncrhonize the database
			if (!count($ids)) {
				$ids = $this->_recordIDs;
			}
			
			// Make sure that we only have one ID for each record.
			$ids = array_unique($ids);

			$dbHandler =& Services::getService("DBHandler");
			// first delete all the old mappings
			$query =& new DeleteQuery;
			$query->setTable("dm_record_set");
			$query->setWhere("dm_record_set.id=".$this->_myID);
//			printpre(MySQL_SQLGenerator::generateSQLQuery($query));
			$dbHandler->query($query, DATAMANAGER_DBID);
			
			if (count($ids)) {
				// next insert all our mappings back in.
				$query =& new InsertQuery;
				$query->setTable("dm_record_set");
				$query->setColumns(array("id","fk_record"));
				foreach ($ids as $id) {
					$query->addRowOfValues(array($this->_myID, $id));
				}
				
				// Add back in the deleted record IDs so that we dont' loose
				// our reference to them.
				foreach ($this->_deletedRecordIDs as $id) {
					$query->addRowOfValues(array($this->_myID, $id));
				}
				
//				printpre(MySQL_SQLGenerator::generateSQLQuery($query));
				$dbHandler->query($query,DATAMANAGER_DBID);
				// done!
			}
			
			$this->_recordIDs = $ids;
		}
	}
	
	/**
	 * Adds the given ID to our list of Records.
	 * @param integer $id
	 * @return void
	 */
	function addRecordID( $id ) {
		ArgumentValidator::validate($id, new IntegerValidatorRule);
		$this->_dirty = true;
		
		$this->_recordIDs[] = $id;
		$recordManager =& Services::getService("RecordManager");
		$this->_records[] =& $recordManager->fetchRecord( $id );
	}
	
	/**
	 * Adds the given {@link Record} to our list.
	 * @param ref object $record
	 * @return void
	 */
	function addRecord(&$record) {
		$this->_dirty = true;
		
		if ($id=$record->getID()) {
			$this->_records[] =& $record;
			$this->_recordIDs[] = $id;
		} else {
			$this->_newRecords[] =& $record;
		}
	}
	
	/**
	 * Returns an array of merged tag-dates (as {@link DateTime} objects) which can be used to setup our Records as they were on a specific date.
	 * @access public
	 * @return array
	 */
	function &getMergedTagDates()
	{
		// first get all the tags for each of our Records, then ask them for their dates. avoid duplicates
		$tagManager =& Services::getService("TagManager");
		$dates = array();
		$dateStrings = array();
		foreach ($this->_recordIDs as $id) {
			$tags =& $tagManager->getTagDescriptors($id);
			foreach (array_keys($tags) as $key) {
				$date =& $tags[$key]->getDate();
				$str = $date->toString();
				if (!in_array($str, $dateStrings)) {
					$dateStrings[] = $str;
					$dates[] =& $date;
				}
			}
		}
		
		return $dates;
	}
	
	/**
	 * Returns all of the {@link Record}s within this Set to the state they were in on the given date.
	 * @param ref object $date A {@link DateTime} object.
	 * @access public
	 * @return boolean
	 */
	function revertToDate(&$date)
	{
		// this function goes through each Record, gets all the tags, and finds the one that has the closest tag
		// date to $date, as long as the tag date is *before* $date.
		// then, we activate that tag on the Record and commit it to the database
		$tagManager =& Services::getService("TagManager");
		
		$this->fetchRecords(true); // get all our records read-write
		
		foreach (array_keys($this->_records) as $index) {
			$tags =& $tagManager->fetchTags($this->_records[$index]->getID());
			
			$closest = null;
			$separation = 0;
			foreach (array_keys($tags) as $key) {
				$tagDate =& $tags[$key]->getDate();
				if (($sep = DateTime::compare($tagDate, $date)) <= 0 && $sep < $separation) {
					$separation = $sep;
					$closest =& $tags[$key];
				}
			}
			
			if ($closest) {
				// we're going to activate the tag, then commit the Record
				$this->_records[$index]->activateTag($closest);
				$this->_records[$index]->commit();
			}
		}
		return true;
	}
	
}

?>