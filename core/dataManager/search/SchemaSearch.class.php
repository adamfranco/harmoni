<?

require_once HARMONI."dataManager/search/SearchCriteria.interface.php";

/**
 * Limits a search to exclude all other {@link Schema}s except the one specified.
 *
 * @package harmoni.datamanager.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SchemaSearch.class.php,v 1.4 2005/01/19 21:09:43 adamfranco Exp $
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
