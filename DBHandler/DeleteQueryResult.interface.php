<?php

require_once("QueryResult.interface.php");

/**
 * The DELETEQueryResult interface provides the functionality common to all DELETE query results.
 *
 * The DELETEQueryResult interface provides the functionality common to all DELETE query results.
 * For example, you can get the primary key for the last DELETEion, get number of DELETEed rows, etc.
 * @version $Id: DeleteQueryResult.interface.php,v 1.3 2003/08/06 22:32:39 gabeschine Exp $
 * @package harmoni.interfaces.dbc
 * @access public
 * @copyright 2003 
 */

class DeleteQueryResultInterface extends QueryResultInterface {

	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a UPDATE, INSERT, or
	 * DELETE query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 * @access public
	 */ 
	function getNumberOfRows() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

}

?>