<?

require_once HARMONI."metaData/manager/search/SearchCriteria.interface.php";

/**
 * Limits a search to include ONLY the criteria specified. eg, will cut out all other
 * DataSetTypes even if no criteria are specified.
 * @package harmoni.datamanager.search
 * @version $Id: OnlyThisSearch.class.php,v 1.1 2004/01/15 02:26:09 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class OnlyThisSearch extends SearchCriteria {
	
	var $_criteria;
	
	function OnlyThisSearch(&$criteria) {
		$this->_criteria =& $criteria;
	}
	
	function returnSearchString() {
		return $this->_criteria->returnSearchString();
	}
	
	function getTypeList() {
		// return all dataset types 'cause we want to prevent any from being fetched
		// unless some criteria match.
		
		$mgr =& Services::getService("DataSetTypeManager");
		
		return $mgr->getAllDataSetTypeIDs();
	}
	
}

?>