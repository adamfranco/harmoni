<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UpdateQueryResult.interface.php,v 1.3 2005/04/07 16:33:23 adamfranco Exp $
 */
 
require_once("QueryResult.interface.php");

/**
 * The UPDATEQueryResult interface provides the functionality common to all UPDATE query results.
 *
 * For example, you can get the primary key for the last UPDATEion, get number of UPDATEed rows, etc.
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UpdateQueryResult.interface.php,v 1.3 2005/04/07 16:33:23 adamfranco Exp $
 */

class UpdateQueryResultInterface extends QueryResultInterface {

	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, INSERT, or
	 * UPDATE query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 * @access public
	 */ 
	function getNumberOfRows() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

}

?>