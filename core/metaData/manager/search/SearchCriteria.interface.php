<?

/**
 * Search criteria are used when fetching a large number of DataSets but you want to limit those
 * down to ones that only match certain criteria. Criteria could hypothetically be anything imaginable,
 * as long as they can be represented within an SQL query.
 * @package harmoni.datamanager.search
 * @version $Id: SearchCriteria.interface.php,v 1.2 2004/01/14 21:09:25 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class SearchCriteria {
	
	function returnSearchString() { }
	
	// returns an array of DataSetType IDs for which this object specifies search criteria
	function getTypeList() { }
	
}

?>