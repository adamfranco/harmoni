<?

require_once HARMONI."core/metaData/manager/search/MultipleCriteriaSearch.abstract.php";

class AndSearch extends MultipleCriteriaSearch {
	
	function returnSearchString() {
		$parts = array();
		
		foreach (array_keys($this->_criteria) as $key) {
			$parts[] = $this->_criteria[$key]->returnSearchString();
		}
		
		if (!count($parts)) return "";
		return "(" . implode(" AND ",$parts) . ")";
	}
	
}

?>