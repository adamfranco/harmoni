<?

require_once HARMONI."dataManager/search/MultipleCriteriaSearch.abstract.php";
/**
 * The OrSearch criteria takes a list of other search criteria and OR's them together in the SQL query.
 * @package harmoni.datamanager.search
 * @version $Id: OrSearch.class.php,v 1.2 2004/08/10 16:29:27 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class OrSearch extends MultipleCriteriaSearch {
	
	function returnSearchString() {
		$parts = array();
		
		foreach (array_keys($this->_criteria) as $key) {
			if ($string = $this->_criteria[$key]->returnSearchString()) $parts[] = $string;
		}
		
		if (!count($parts)) return null;
		return "(" . implode(" OR ",$parts) . ")";
	}
	
}