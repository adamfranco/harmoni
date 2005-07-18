<?

require_once HARMONI."dataManager/search/SearchCriteria.interface.php";

/**
 * Limits a search to exclude all inactive {@link Record}s.
 *
 * @package harmoni.datamanager.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ActiveRecordsSearch.class.php,v 1.4 2005/07/18 14:45:24 gabeschine Exp $
 */
class ActiveRecordsSearch extends SearchCriteria {
	
	function ActiveRecordsSearch() {
		throwError(
			new Error("ActiveRecordsSearch has been deprecated as Records no longer have an active flag.", "RecordManager", true));
	}
	
	function returnSearchString() {
		return "dm_record.active=1";
	}

	function postProcess($ids) { return $ids; }
}

?>
