<?

/**
 * Stores the mapping between a RecordTag and the specific versions of values within a Record that were
 * created when the Record was tagged. A tag can be thought of like a CVS tag, where each file in CVS is like
 * a specific value in a record. Each value has its own number of versions, and a RecordTag can remember
 * all the versions that were active at any given time.
 *
 * @package harmoni.datamanager
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Tag.class.php,v 1.8 2006/11/30 22:02:16 adamfranco Exp $
 */
class RecordTag {
	
	var $_myID;
	var $_recordID;
	var $_date;
	
	var $_mappings;
	
	var $_loaded;
	
	function RecordTag( $recordID, &$date, $id = null ) {		
		$this->_myID = $myID;
		$this->_recordID = $recordID;
		$this->_date =& $date;
		
		$this->_loaded = false;
	}
	
	/**
	 * Takes an array of database rows and populates the local mapping arrays based on those rows.
	 * @param array $arrayOfRows
	 * @return void
	 * @access public
	 */
	function populate( $arrayOfRows ) {
		foreach ($arrayOfRows as $row) {
			$id = $row["schema_field_id"];
			$index = $row["record_field_index"];
			$verID = $row["record_field_id"];
			
			if (isset($this->_mappings[$id][$index])) throwError ( new Error(
				"While creating RecordTag mappings, we already have a mapping for $label -> $index. What's going on?","RecordTag",true));
			
			$this->_mappings[$id][$index] = $verID;
		}
		
		$this->_loaded = true;
	}
	
	/**
	 * Returns the {@link DateAndTime} timestamp of this tag.
	 * @return ref object
	 * @access public
	 */
	function &getDate() {
		return $this->_date;
	}
	
	/**
	 * Returns the specific version of a value that was active when this tag was created.
	 * @param string $id The field id to look for.
	 * @param int $index The specific index within that label to look for.
	 * @return int The version ID.
	 * @access public
	 */
	function getMapping($id, $index) {
		return $this->_mappings[$id][$index]?$this->_mappings[$id][$index]:null;
	}
	
	/**
	 * Checks whether a mapping for this $id was defined when the tag was created.
	 * @return bool
	 * @param string $id
	 * @access public
	 */
	function haveMappings($id) {
		return isset($this->_mappings[$id]);
	}
	
	/**
	 * Returns the ID of the {@link Record} for which this RecordTag was created.
	 * @return int
	 * @access public
	 */
	function getRecordID() { return $this->_recordID; }
	
	/**
	 * Returns our ID.
	 * @return int
	 */
	function getID() { return $this->_myID; }
	
	/**
	 * Loads the tag mapping data from the database, if it hasn't done so already.
	 * @return bool
	 * @access public
	 */
	function load() {
		if ($this->_loaded) return true;
		
		// load the data
		
		$query =& new SelectQuery;
		
		$query->addTable("dm_tag_map");
		$query->addTable("dm_record_field",INNER_JOIN,"dm_tag_map.fk_record_field=dm_record_field.id");
		$query->addTable("dm_schema_field",INNER_JOIN,"dm_record_field.fk_schema_field=dm_schema_field.id");
		
		$query->addColumn("index","record_field_index","dm_record_field");
		$query->addColumn("id","record_field_id","dm_record_field");
		
		$query->addColumn("id","schema_field_id","dm_schema_field");
		
		$query->setWhere("fk_tag='".addslashes($this->_myID)."'");
		
		$dbHandler =& Services::getService("DatabaseManager");
		$result =& $dbHandler->query($query, DATAMANAGER_DBID);
		
		if (!$result) throwError( new UnknownDBError("RecordTag"));
		
		$tagRows = array();
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$tagRows[] = $a;
		}
		
		$result->free();
		
		$this->populate($tagRows);
		return true;
	}
	
}