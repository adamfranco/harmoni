<?php

/**
 * The QueryResult interface provides the functionality common to all query results.
 *
 * The QueryResult interface provides the functionality common to all query results.
 * For example, you can determine if the query ran successfully and how many table rows were affected.
 * @version $Id: QueryResult.interface.php,v 1.2 2004/04/20 19:48:58 adamfranco Exp $
 * @package harmoni.dbc
 * @access public
 * @copyright 2003 
 */

class QueryResultInterface {

	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, UPDATE, or
	 * INSERT query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 * @access public
	 */ 
	function getNumberOfRows() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

}

?>