<?

require_once HARMONI."dataManager/search/MultipleCriteriaSearch.abstract.php";
/**
 * The OrSearch criteria takes a list of other search criteria and OR's them together in the SQL query.
 *
 * @package harmoni.datamanager.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OrSearch.class.php,v 1.4 2005/01/19 21:09:43 adamfranco Exp $
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

	function postProcess($ids) { return $ids; }
	
}
