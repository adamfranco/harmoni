<?

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
	
	function &getDate() {
		return $this->_date;
	}
	
	function getMapping($label, $index) {
		return $this->_mappings[$label][$index]?$this->_mappings[$label][$index]:null;
	}
	
	function haveMappings($label) {
		return isset($this->_mappings[$label])?true:false;
	}
	
	function getDataSetID() { return $this->_myDataSet; }
	
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