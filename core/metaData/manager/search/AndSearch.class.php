<?

require_once HARMONI."metaData/manager/search/MultipleCriteriaSearch.abstract.php";

class AndSearch extends MultipleCriteriaSearch {
	
	function returnSearchString() {
		$parts = array();
		
		foreach (array_keys($this->_criteria) as $key) {
			if ($string = $this->_criteria[$key]->returnSearchString()) $parts[] = $string;
		}
		
		if (!count($parts)) return "";
		return "(" . implode(" AND ",$parts) . ")";
	}
	
}

?>