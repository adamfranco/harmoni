<?

require_once HARMONI."metaData/manager/search/SearchCriteria.interface.php";

/**
 * Limits a search to exclude all inactive datasets.
 * @package harmoni.datamanager.search
 * @version $Id: ActiveDataSetsSearch.class.php,v 1.1 2004/01/15 20:55:28 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class ActiveDataSetsSearch extends SearchCriteria {
	
	function returnSearchString() {
		return "dataset.dataset_active=1";
	}
	
	function getTypeList() {
		// we want only those rows with active dataset flag, so ignore all others.
		
		$mgr =& Services::getService("DataSetTypeManager");
		
		return $mgr->getAllDataSetTypeIDs();
	}
	
}

?>