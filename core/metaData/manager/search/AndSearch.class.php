<?

require_once HARMONI."metaData/manager/search/MultipleCriteriaSearch.abstract.php";

/**
 * Takes multiple other criteria and AND's them together in the SQL query.
 * @package harmoni.datamanager.search
 * @version $Id: AndSearch.class.php,v 1.4 2004/01/15 02:26:09 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class AndSearch extends MultipleCriteriaSearch {
	
	function returnSearchString() {
		$parts = array();
		
		foreach (array_keys($this->_criteria) as $key) {
			if ($string = $this->_criteria[$key]->returnSearchString()) $parts[] = $string;
		}
		
		if (!count($parts)) return null;
		return "(" . implode(" AND ",$parts) . ")";
	}
	
}

?>