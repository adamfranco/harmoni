<?

require_once HARMONI."metaData/manager/search/SearchCriteria.interface.php";

class DataSetTypeSearch extends SearchCriteria {
	
	var $_type;
	
	function DataSetTypeSearch( &$theType ) {
		$this->_type = $theType;
	}
	
	function returnSearchString() {
		$mgr =& Services::getService("DataSetTypeManager");
		$id = $mgr->getIDForType($this->_type);
		
		if (!$id) return null;
		return "dataset.fk_datasettype=$id";
	}
	
	function getTypeList() {
		// since we are limiting us to one dataset type, we will return a list
		// of *all* datasettypes, since in a sense we are specifying search
		// criteria for all types.
		
		$mgr =& Services::getService("DataSetTypeManager");
		
		return $mgr->getAllDataSetTypeIDs();
	}
	
}

?>