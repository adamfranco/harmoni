<?

require_once HARMONI."dataManager/search/MultipleCriteriaSearch.abstract.php";

/**
 * Takes multiple other criteria and AND's them together in the SQL query.
 *
 * @package harmoni.datamanager.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AndSearch.class.php,v 1.4 2005/01/19 21:09:43 adamfranco Exp $
 */
class AndSearch extends MultipleCriteriaSearch {
	
	function returnSearchString() {
		$parts = array();
		
		// we will return the first criteria now, and then work through the rest in turn later with post-processing.
		// this is to avoid a problem with multiple AND-searches where the criteria may all be true for a given record, but not true for one single row returned describing a part of the record.
		
		/*foreach (array_keys($this->_criteria) as $key) {
			if ($string = $this->_criteria[$key]->returnSearchString()) $parts[] = $string;
		}*/
		
		if (!count($this->_criteria)) return null;
		$keys = array_keys($this->_criteria);
		return $this->_criteria[$keys[0]]->returnSearchString();
//		return "(" . implode(" AND ",$parts) . ")";
	}
	
	function postProcess($ids) {
		// let's go through index 1-n of the criteria and keep narrowing down our lsit of ids.
		$rm =& Services::getService("RecordManager");

		$keys = array_keys($this->_criteria);
		for($i=1; $i < count($keys); $i++) {
			$ids = $rm->getRecordIDsBySearch($this->_criteria[$keys[$i]], $ids);
		}
		return $ids;
	}
	
}

?>
