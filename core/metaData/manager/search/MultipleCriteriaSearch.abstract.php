<?

require_once HARMONI."metaData/manager/search/SearchCriteria.interface.php";
/**
 * An abstract class on which to build Criteria that are made up of multiple other search criteria objects.
 * @package harmoni.datamanager.search
 * @version $Id: MultipleCriteriaSearch.abstract.php,v 1.3 2004/01/14 21:09:25 gabeschine Exp $
 * @copyright 2004, Middlebury College
 * @abstract
 */
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