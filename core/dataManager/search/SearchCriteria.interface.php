<?

/**
 * @constant int SEARCH_TYPE_EQUALS Specifies a search of value1=value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_EQUALS", 0);
/**
 * @constant int SEARCH_TYPE_EQUALS Specifies a search of value1>value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_GREATER_THAN", 1);
/**
 * @constant int SEARCH_TYPE_EQUALS Specifies a search of value1<value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_LESS_THAN", 2);
/**
 * @constant int SEARCH_TYPE_EQUALS Specifies a search of value1>=value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_GREATER_THAN_OR_EQUALS", 3);
/**
 * @constant int SEARCH_TYPE_EQUALS Specifies a search of value1<=value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_LESS_THAN_OR_EQUALS", 4);
/**
 * @constant int SEARCH_TYPE_EQUALS Specifies a search of value2 contains value1 (strings).
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_CONTAINS", 5);


/**
 * Search criteria are used when fetching a large number of {@link Record}s but you want to limit those
 * down to ones that only match certain criteria. Criteria could hypothetically be anything imaginable,
 * as long as they can be represented within an SQL query.
 * @package harmoni.datamanager.search
 * @version $Id: SearchCriteria.interface.php,v 1.1 2004/07/27 20:23:43 gabeschine Exp $
 * @copyright 2004, Middlebury College
 */
class SearchCriteria {
	
	/**
	 * Returns a string with what will end up part of an SQL query in the WHERE clause.
	 * @return string
	 * @access public
	 */
	function returnSearchString() { }
	
}

?>