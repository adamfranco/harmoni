<?php

require_once("Query.abstract.php");

/**
 * An UpdateQuery interface provides the tools to build an SQL UPDATE query.
 *
 * @version $Id: UpdateQuery.interface.php,v 1.2 2003/07/10 02:34:19 gabeschine Exp $
 * @package harmoni.dbc
 * @copyright 2003 
 */

class UpdateQueryInterface extends Query {

	/**
	 * Sets the table to update.
	 * @param string $table The table to update.
	 * @access public
	 */
	function setTable($table) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Sets the columns to update in the table.
	 * @param array $table The columns to update in the table.
	 * @access public
	 */
	function setColumns($columns) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Specifies the values that the will be assigned to the columns specified with setColumns().
	 *
	 * @param array The values that the will be assigned to the columns specified with setColumns().
	 * @access public
	 */
	function setValues($values) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

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