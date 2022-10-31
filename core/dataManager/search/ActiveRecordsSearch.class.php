<?php

require_once HARMONI."dataManager/search/SearchCriteria.interface.php";

/**
 * Limits a search to exclude all inactive {@link DMRecord}s.
 *
 * @package harmoni.datamanager.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: ActiveRecordsSearch.class.php,v 1.6 2008/02/06 15:37:43 adamfranco Exp $
 */
class ActiveRecordsSearch extends SearchCriteria {
	
	function __construct() {
		throwError(
			new HarmoniError("ActiveRecordsSearch has been deprecated as Records no longer have an active flag.", "RecordManager", true));
	}
	
	function returnSearchString() {
		return "dm_record.active=1";
	}

	function postProcess($ids) { return $ids; }
}