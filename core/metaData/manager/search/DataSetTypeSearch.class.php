<?

require_once HARMONI."metaData/manager/search/SearchCriteria.interface.php";

/**
 * Limits a search to exclude all other DataSetTypes except the one specified.
 * @package harmoni.datamanager.search
 * @version $Id: DataSetTypeSearch.class.php,v 1.3 2004/01/14 21:09:25 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class DataSetTypeSearch extends SearchCriteria {
	
	var $_type;
	
	/**
	 * The constructor.
	 * @param ref object $theType The {@link HarmoniType} that describes the DataSetType.
	 */
	function DataSetTypeSearch( &$theType ) {
		$this->_type = $theType;
	}
	
	function returnSearchString() {
		$mgr =& Services::getService("DataSetTypeManager");
		$id = $mgr->getIDForType($this->_type);
		
		if (!$id) return null;
		return "dataset.fk_datasettype=$id";
	}
	
	function getTypeList() {
		// since we are limiting us to one dataset type, we will return a list
		// of *all* datasettypes, since in a sense we are specifying search
		// criteria for all types.
		
		$mgr =& Services::getService("DataSetTypeManager");
		
		return $mgr->getAllDataSetTypeIDs();
	}
	
}

?>