<?php

require_once("Query.abstract.php");

	/**
	 * Used with the setTable() method to indicate that no join will be performed. 
	 * @const NO_JOIN No join will be performed.
	 * @package harmoni.dbc
	 */
	define("NO_JOIN", 1);

	/**
	 * Used with the setTable() method to indicate that a left join will be performed. 
	 * @const LEFT_JOIN A left join will be performed.
	 * @package harmoni.dbc
	 */
	define("LEFT_JOIN", 2);

	/**
	 * Used with the setTable() method to indicate that an inner join will be performed. 
	 * @const INNER_JOIN An inner join will be performed.
	 * @package harmoni.dbc
	 */
	define("INNER_JOIN", 3);

	/**
	 * Used with the setTable() method to indicate that a right join will be performed. 
	 * @const RIGHT_JOIN A right join will be performed.
	 * @package harmoni.dbc
	 */
	define("RIGHT_JOIN", 4);

	/**
	 * Used with the setOrderBy() method to indicate that the order will be ascending. Used by {@link SelectQueryInterface::setOrderBy()}.
	 * @const ASCENDING The order will be ascending.
	 * @package harmoni.dbc
	 */
	define("ASCENDING", 5);

	/**
	 * Used with the setOrderBy() method to indicate that the order will be descending. Used by {@link SelectQueryInterface::setOrderBy()}.
	 * @const DESCENDING The order will be descending.
	 * @package harmoni.dbc
	 */
	define("DESCENDING", 6);


/**
 * A SelectQuery interface provides the tools to build an SQL SELECT query.
 *
 * @version $Id: SelectQuery.interface.php,v 1.11 2003/08/11 03:12:46 gabeschine Exp $
 * @package harmoni.interfaces.dbc
 * @copyright 2003 
 */

class SelectQueryInterface extends Query {

	/**
	 * Adds a table to the FROM clause of the SELECT query.
	 * 
	 * Adds a table to the FROM clause of the SELECT statement. At any moment,
	 * a current set of tables is maintained in the object, so when a new one
	 * is added, it is combined with the current set.
	 * @param string $table The table to add to the FROM clause.
	 * @param integer $joinType Specifies what type of join to perform between
	 * the current set of tables and the table being added. Could be one of
	 * the following: NO_JOIN, LEFT_JOIN, INNER_JOIN, RIGHT_JOIN.
	 * @param string $joinCondition If a join is to be performed, then this
	 * will indicate the join condition.
	 * @param string alias An alias for this table.
	 * @use NO_JOIN
	 * @use LEFT_JOIN
	 * @use INNER_JOIN
	 * @use RIGHT_JOIN
	 * @access public
	 */
	function addTable($table, $joinType = NO_JOIN, $joinCondition = "", $alias = "") { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Sets the columns to select.
	 * Sets the columns to select.
	 * Note: addColumn() and setColumns() can be used together in any order.
	 * However, calling setColumns() after addColumn() resets the list of columns.
	 * @param array $column The columns to select. This is a one-dimensional array
	 * of the column names. If you want aliases you have to include the alias
	 * in the column name itself. For example: array("user_id AS id", "user_name AS name")
	 * For a better approach, see addColumn().
	 * @access public
	 * @deprecated June 24, 2003 - Use addColumn() instead.
	 * @see {@link SelectQueryInterface::addColumn()}
	 */
	function setColumns($columns) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	
	
	/**
	 * Adds a new column to the SELECT query.
	 * Adds a new column to the SELECT query. This method is an alternative to the
	 * setColumns() method. It adds one column at a time, and also provides
	 * the ability to explicitly specify the alias of the column to select.
	 * Note: addColumn() and setColumns() can be used together in any order.
	 * However, calling setColumns() after addColumn() resets the list of columns.
	 * @param string $column The name of the column.
	 * @param optional string $alias The alias of the column.
	 * @param optional string $table An optional name of the table where
	 * the column resides.
	 * will be used.
	 * @access public
	 * @see {@link SelectQueryInterface::setColumns()}
	 */ 
	function addColumn($column, $alias = "", $table = "") {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");	
	}

	

	/**
	 * Specifies the condition in the WHERE clause.
	 *
	 * The query will return only rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string condition The WHERE clause condition.
	 * @deprecated July 07, 2003 - Use addWhere() instead.
	 * @access public
	 */
	function setWhere($condition) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	
	/**
	 * Adds a new condition in the WHERE clause.
	 * 
	 * The query will return only rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string condition The WHERE clause condition to add.
	 * @param integer logicalOperation The logical operation to use to connect
	 * this WHERE condition with the previous WHERE conditions. Allowed values:
	 * <code>_AND</code> , <code>_OR</code> , and <code>_XOR</code>. 
	 * @method public addWhere
	 * @return void 
	 */
	function addWhere($condition, $logicalOperation = _AND) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	


	/**
	 * Sets the GROUP BY and HAVING clause.
	 * 
	 * This method sets the GROUP BY clause of the SELECT statement. In addition,
	 * if $condition is specified, it includes the HAVING clause. If the method is never
	 * called, no GROUP BY or HAVING clause will be included.
	 * @param array $columns An array of the columns to group by. Ideally, the
	 * columns should be in the list provided by setColumns().
	 * @param string $condition An optional condition to be included in the
	 * HAVING clause.
	 * @access public
	 */
	function setGroupBy($columns, $condition = "") { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Add a column to the ORDER BY clause.
	 * 
	 * This method adds a column to the ORDER BY clause of the SELECT statement. If the method is never
	 * called, no ORDER BY clause will be included. The order of the columns in the
	 * clause will coincide with the order, in which they were added with this method.
	 * @param string $column A column to order by.
	 * @param integer $direction An optional parameter specifying ascending or descending
	 * sorting order. Allowed values are: ASCENDING, DESCENDING.
	 * @use ASCENDING
	 * @use DESCENDING
	 * @access public
	 */
	function addOrderBy($column, $direction) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Specifies whether distinct rows will be returned.
	 * 
	 * Use this method to specify whether the rows returned by the SELECT query
	 * have to be distinct (i.e. only unique rows) or not. If the method is never 
	 * called, then the default value is not distinct.
	 * @param boolean $distinct If true, then only unique rows will be returned.
	 * @access public
	 */
	function setDistinct($distinct) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	
	/**
	 * Limits the number of rows to the specified number.
	 * 
	 * Limits the number of rows returned by the SELECT query to the specified 
	 * number.
	 * @param integer $numberOfRows The number of rows to return
	 * @access public
	 */
	function limitNumberOfRows($numberOfRows) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	
	
	/**
	 * Starts the results from the specified row.
	 * 
	 * Starts the results of the SELECT query from the specified row.
	 * @param integer $startingRow The number of the starting row. Numbers
	 * start with 1 for the first row, 2 for the second row, and so forth.
	 * @access public
	 */
	function startFromRow($startFromRow) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
}
?>