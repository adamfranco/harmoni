<?php

require_once(HARMONI."DBHandler/classes/UpdateQuery.interface.php");

/**
 * An UpdateQuery class provides the tools to build an UPDATE query.
 *
 * An UpdateQuery class provides the tools to build an UPDATE query.
 * 
 * @version $Id: UpdateQuery.class.php,v 1.1 2003/06/24 20:56:25 gabeschine Exp $
 * @package harmoni.dbhandler
 * @copyright 2003 
 */

class UpdateQuery extends UpdateQueryInterface {

	/**
	 * @var string $_table The name of the table to update.
	 * @access private
	 */
	var $_table;

	/**
	 * @var array $_columns A list of the columns we will be updating.
	 * @access private
	 */
	var $_columns;

	/**
	 * @var array $_values List of values that will be assigned to the columns.
	 * @access private
	 */
	var $_values;

	/**
	 * @var string $_condition This will store the condition in the WHERE clause.
	 * @access private
	 */
	var $_condition;


	/**
	 * This is the constructor for a MySQL UPDATE query.
	 * @access public
	 */
	function UpdateQuery() {
		$this->reset();
	}
	

	/**
	 * Sets the table to update.
	 * @param string $table The table to insert into.
	 * @access public
	 */
	function setTable($table) {
		$this->_table = $table;
	}

	/**
	 * Sets the columns to update in the table.
	 * @param array $table The columns to insert into the table.
	 * @access public
	 */
	function setColumns($columns) {
		$this->_columns = $columns;
	}


	/**
	 * Specifies the values that the will be assigned to the columns specified with setColumns().
	 *
	 * @param array The values that the will be assigned to the columns specified with setColumns().
	 * @access public
	 */
	function setValues($values) {
		$this->_values = $values;
	}
	

	/**
	 * Specifies the condition in the WHERE clause.
	 *
	 * The query will execute only on rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string The WHERE clause condition.
	 * @access public
	 */
	function setWhere($condition) {
		$this->_condition = $condition;
	}


	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		parent::reset();

		// a DELETE query
		$this->_type = UPDATE;
		
		// default query configuration:
		
		// no table to update
		$this->_table = "";

		// no columns to update
		$this->_columns = array();

		// one row of values with no values specified
		$this->_values = array();
		
		// no WHERE condition, by default
		$this->_condition = "";
	}

}
?>