<?

require_once HARMONI."dataManager/search/SearchCriteria.interface.php";

/**
 * Limits a search to exclude all other {@link Schema}s except the one specified.
 * @package harmoni.datamanager.search
 * @version $Id: SchemaSearch.class.php,v 1.3 2005/01/08 22:17:05 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class SchemaSearch extends SearchCriteria {
	
	var $_type;
	
	/**
	 * The constructor.
	 * @param ref object $theType The {@link HarmoniType} that describes the {@link Schema}.
	 */
	function SchemaSearch( &$theType ) {
		$this->_type = $theType;
	}
	
	function returnSearchString() {
		$mgr =& Services::getService("SchemaManager");
		$id = $mgr->getIDByType($this->_type);
		
		if (!$id) return null;
		return "dm_record.fk_schema=$id";
	}

	function postProcess($ids) { return $ids; }

}

?>
