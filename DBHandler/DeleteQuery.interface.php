<?php

require_once("Query.abstract.php");

/**
 * A DeleteQuery interface provides the tools to build an SQL DELETE query.
 *
 * @version $Id: DeleteQuery.interface.php,v 1.2 2003/07/10 02:34:19 gabeschine Exp $
 * @package harmoni.dbc
 * @copyright 2003 
 */

class DeleteQueryInterface extends Query {

	/**
	 * Sets the table to delete from.
	 * @param string $table The table to delete from.
	 * @access public
	 */
	function setTable($table) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Specifies the condition in the WHERE clause.
	 *
	 * The query will execute only on rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string The WHERE clause condition.
	 * @access public
	 */
	function setWhere($condition) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

}
?>