<?php

require_once(HARMONI."DBHandler/UpdateQuery.interface.php");

/**
 * An UpdateQuery class provides the tools to build an UPDATE query.
 *
 * An UpdateQuery class provides the tools to build an UPDATE query.
 * 
 * @version $Id: UpdateQuery.class.php,v 1.4 2003/07/10 02:34:19 gabeschine Exp $
 * @package harmoni.dbc
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
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($table, $stringRule, true);
		// ** end of parameter validation

		$this->_table = $table;
	}

	/**
	 * Sets the columns to update in the table.
	 * @param array $table The columns to insert into the table.
	 * @access public
	 */
	function setColumns($columns) {
		// ** parameter validation
		$arrayRule =& new ArrayValidatorRule();
		ArgumentValidator::validate($columns, $arrayRule, true);
		// ** end of parameter validation

		$this->_columns = $columns;
	}


	/**
	 * Specifies the values that the will be assigned to the columns specified with setColumns().
	 *
	 * @param array The values that the will be assigned to the columns specified with setColumns().
	 * @access public
	 */
	function setValues($values) {
		// ** parameter validation
		$arrayRule =& new ArrayValidatorRule();
		ArgumentValidator::validate($values, $arrayRule, true);
		// ** end of parameter validation

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
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($condition, $stringRule, true);
		// ** end of parameter validation

		$this->_condition = $condition;
	}


	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		parent::reset();

		// an UPDATE query
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