<?

/**
 * @constant int SEARCH_TYPE_EQUALS Specifies a search of value1=value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_EQUALS", 0);
/**
 * @constant int SEARCH_TYPE_GREATER_THAN Specifies a search of value1>value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_GREATER_THAN", 1);
/**
 * @constant int SEARCH_TYPE_LESS_THAN Specifies a search of value1<value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_LESS_THAN", 2);
/**
 * @constant int SEARCH_TYPE_GREATER_THAN_OR_EQUALS Specifies a search of value1>=value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_GREATER_THAN_OR_EQUALS", 3);
/**
 * @constant int SEARCH_TYPE_LESS_THAN_OR_EQUALS Specifies a search of value1<=value2.
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_LESS_THAN_OR_EQUALS", 4);
/**
 * @constant int SEARCH_TYPE_CONTAINS Specifies a search of value2 contains value1 (strings).
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_CONTAINS", 5);
/**
 * @constant int SEARCH_TYPE_IN_LIST Specifies a search of value2 that matches a value in the list (array of values).
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_IN_LIST", 6);
/**
 * @constant int SEARCH_TYPE_NOT_IN_LIST Specifies a search of value2 that does not match any value in the list (array of strings).
 * @package harmoni.datamanager.search
 */
define("SEARCH_TYPE_NOT_IN_LIST", 7);


/**
 * Search criteria are used when fetching a large number of {@link Record}s but you want to limit those
 * down to ones that only match certain criteria. Criteria could hypothetically be anything imaginable,
 * as long as they can be represented within an SQL query.
 *
 * @package harmoni.datamanager.search
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: SearchCriteria.interface.php,v 1.4 2006/04/28 15:53:21 adamfranco Exp $
 */
class SearchCriteria {
	
	/**
	 * Returns a string with what will end up part of an SQL query in the WHERE clause.
	 * @return string
	 * @access public
	 */
	function returnSearchString() { }
	
	/**
	 * Returns an array of new IDs, giving the criteria the opportunity to do post-processing if that is desired. If no post-processing is to be done, it should return what is passed.
	 * @param array $ids A list of IDs found by searching with the criteria.
	 * @return array
	 * @access public
	 */
	function postProcess($ids) {}
}

?>
