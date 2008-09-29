<?php

require_once HARMONI."dataManager/search/SearchCriteria.interface.php";

/**
 * Limits a search to exclude all other {@link Schema}s except the one specified.
 *
 * @package harmoni.datamanager.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SchemaSearch.class.php,v 1.8 2007/09/04 20:25:32 adamfranco Exp $
 */
class SchemaSearch extends SearchCriteria {
	
	var $_type;
	
	/**
	 * The constructor.
	 * @param string $id The id that describes the {@link Schema}.
	 */
	function SchemaSearch( $id ) {
		throwError(
			new Error(
				"SchemaSearch has been deprecated. Use RecordManager::getRecordIDsByType().",
				"RecordManager",
				true
			));
	}
	
	function returnSearchString() {
		$mgr = Services::getService("SchemaManager");
		$id = $mgr->getIDByType($this->_type);
		
		if (!$id) return null;
		return "dm_record.fk_schema='".addslashes($id)."'";
	}

	function postProcess($ids) { return $ids; }

}
