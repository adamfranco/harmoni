<?

require_once HARMONI."dataManager/search/SearchCriteria.interface.php";

/**
 * Limits a search to exclude all inactive {@link Record}s.
 * @package harmoni.datamanager.search
 * @version $Id: ActiveRecordsSearch.class.php,v 1.1 2004/07/27 20:23:43 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class ActiveRecordsSearch extends SearchCriteria {
	
	function returnSearchString() {
		return "dm_record.active=1";
	}
}

?>