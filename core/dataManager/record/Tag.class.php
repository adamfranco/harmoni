<?

/**
* Stores the mapping between a Tag and the specific versions of values within a Record that were
* created when the Record was tagged. A tag can be thought of like a CVS tag, where each file in CVS is like
* a specific value in a record. Each value has its own number of versions, and a Tag can remember
* all the versions that were active at any given time.
* @access public
* @package harmoni.datamanager
* @version $Id: Tag.class.php,v 1.2 2004/07/27 18:15:26 gabeschine Exp $
* @copyright 2004, Middlebury College
*/
class Tag {
	
	var $_myID;
	var $_recordID;
	var $_date;
	
	var $_mappings;
	
	var $_loaded;
	
	function Tag( $recordID, &$date, $id = null ) {		
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
			$label = $row["schema_field_label"];
			$index = $row["record_field_index"];
			$verID = $row["record_field_id"];
			
			if (isset($this->_mappings[$label][$index])) throwError ( new Error(
				"While creating Tag mappings, we already have a mapping for $label -> $index. What's going on?","Tag",true));
			
			$this->_mappings[$label][$index] = $verID;
		}
		
		$this->_loaded = true;
	}
	
	/**
	 * Returns the {@link DateTime} timestamp of this tag.
	 * @return ref object
	 * @access public
	 */
	function &getDate() {
		return $this->_date;
	}
	
	/**
	 * Returns the specific version of a value that was active when this tag was created.
	 * @param string $label The field label to look for.
	 * @param int $index The specific index within that label to look for.
	 * @return int The version ID.
	 * @access public
	 */
	function getMapping($label, $index) {
		return $this->_mappings[$label][$index]?$this->_mappings[$label][$index]:null;
	}
	
	/**
	 * Checks whether a mapping for this $label was defined when the tag was created.
	 * @return bool
	 * @param string $label
	 * @access public
	 */
	function haveMappings($label) {
		return isset($this->_mappings[$label])?true:false;
	}
	
	/**
	 * Returns the ID of the {@link Record} for which this Tag was created.
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
		
		$query->addColumn("label","schema_field_label","dm_schema_field");
		
		$query->setWhere("fk_tag=".$this->_myID);
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, DATAMANAGER_DBID);
		
		if (!$result) throwError( new UnknownDBError("Tag"));
		
		$tagRows = array();
		
		while ($result->hasMoreRows()) {
			$a = $result->getCurrentRow();
			$result->advanceRow();
			
			$tagRows[] = $a;
		}
		
		$this->populate($tagRows);
		return true;
	}
	
}