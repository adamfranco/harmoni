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
	
	function getMapping($label, $index) {
		return $this->_mappings[$label][$index]?$this->_mappings[$label][$index]:null;
	}
	
	function getDataSetID() { return $this->_myDataSet; }
	
	function load() {
		if ($this->_loaded) return true;
		
		// load the data
	}
	
}