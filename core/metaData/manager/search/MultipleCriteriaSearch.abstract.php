<?

require_once HARMONI."metaData/manager/search/SearchCriteria.interface.php";

class MultipleCriteriaSearch extends SearchCriteria {
	
	var $_criteria;
	
	function addCriteria (&$criteria) {
		if (!is_array($this->_criteria)) {
			$this->_criteria = array();
		}
		
		$this->_criteria[] = $criteria;
	}
	
	function getTypeList() {
		$list = array();
		foreach (array_keys($this->_criteria) as $key) {
			$ids = $this->_criteria[$key]->getTypeList();
			
			foreach ($ids as $id) {
				$list[] = $id;
			}
		}
		
		return $list;
	}
	
}