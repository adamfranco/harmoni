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
 * @version $Id: ActiveRecordsSearch.class.php,v 1.3 2005/01/19 21:09:43 adamfranco Exp $
 */
class ActiveRecordsSearch extends SearchCriteria {
	
	function returnSearchString() {
		return "dm_record.active=1";
	}

	function postProcess($ids) { return $ids; }
}

?>
