<?

/**
* Stores the mapping between a DataSetTag and the specific versions of values within a DataSet that were
* created when the DataSet was tagged. A tag can be thought of like a CVS tag, where each file in CVS is like
* a specific value in a dataset. Each value has its own number of versions, and a DataSetTag can remember
* all the versions that were active at any given time.
* @access public
* @package harmoni.datamanager
* @version $Id: DataSetTag.class.php,v 1.5 2004/01/07 21:20:19 gabeschine Exp $
* @copyright 2004, Middlebury College
*/
class DataSetTag {
	
	var $_myID;
	var $_myDataSet;
	var $_date;
	
	var $_mappings;
	
	var $_loaded;
	
	function DataSetTag( $myID, $dataSetID, &$date ) {		
		$this->_myID = $myID;
		$this->_myDataSet = $dataSetID;
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
			$label = $row["datasettypedef_label"];
			$index = $row["datasetfield_index"];
			$verID = $row["datasetfield_id"];
			
			if (isset($this->_mappings[$label][$index])) throwError ( new Error(
				"While creating DataSetTag mappings, we already have a mapping for $label -> $index. What's going on?","DatatSetTag",true));
			
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
	 * Returns the ID of the DataSet for which this Tag was created.
	 * @return int
	 * @access public
	 */
	function getDataSetID() { return $this->_myDataSet; }
	
	/**
	 * Loads the tag mapping data from the database, if it hasn't done so already.
	 * @return bool
	 * @access public
	 */
	function load() {
		if ($this->_loaded) return true;
		
		// load the data
		
		$query =& new SelectQuery;
		
		$query->addTable("dataset_tag_map");
		$query->addTable("datasetfield",INNER_JOIN,"fk_datasetfield=datasetfield_id");
		$query->addTable("datasettypedef",INNER_JOIN,"fk_datasettypedef=datasettypedef_id");
		
		$query->addColumn("datasetfield_index");
		$query->addColumn("datasetfield_id");
		
		$query->addColumn("datasettypedef_label");
		
		$query->setWhere("fk_dataset_tag=".$this->_myID);
		
		$dbHandler =& Services::getService("DBHandler");
		$result =& $dbHandler->query($query, $this->_dbID);
		
		if (!$result) throwError( new UnknownDBError("DataSetTag"));
		
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