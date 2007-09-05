<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: QueryResult.interface.php,v 1.4 2007/09/05 21:38:59 adamfranco Exp $
 */

/**
 * The QueryResult interface provides the functionality common to all query results.
 *
 * For example, you can determine if the query ran successfully and how many table rows were affected.
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: QueryResult.interface.php,v 1.4 2007/09/05 21:38:59 adamfranco Exp $
 */

interface QueryResultInterface {

	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, UPDATE, or
	 * INSERT query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 * @access public
	 */ 
	function getNumberOfRows() ;

}

?>