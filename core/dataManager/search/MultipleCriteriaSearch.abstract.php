<?

require_once HARMONI."dataManager/search/SearchCriteria.interface.php";
/**
 * An abstract class on which to build Criteria that are made up of multiple other search criteria objects.
 * @package harmoni.datamanager.search
 * @version $Id: MultipleCriteriaSearch.abstract.php,v 1.2 2004/11/02 21:41:59 adamfranco Exp $
 * @copyright 2004, Middlebury College
 * @abstract
 */
class MultipleCriteriaSearch extends SearchCriteria {
	
	var $_criteria;
	
	function addCriteria (&$criteria) {
		if (!is_array($this->_criteria)) {
			$this->_criteria = array();
		}
		
		$this->_criteria[] =& $criteria;
	}
	
}