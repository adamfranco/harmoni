<?php

require_once(HARMONI."DBHandler/InsertQuery.interface.php");

/**
 * An InsertQuery object provides the tools to build an INSERT query.
 *
 * This is an abstract class that simply provides all the accessor methods,
 * initialization steps, etc. What is left to be implemented is the
 * generateSQLQuery() method.
 * 
 * @version $Id: InsertQuery.class.php,v 1.3 2003/06/26 16:18:06 dobomode Exp $
 * @package harmoni.dbhandler
 * @copyright 2003 
 */

class InsertQuery extends InsertQueryInterface {

	/**
	 * @var string $_table The name of the table to insert into.
	 * @access private
	 */
	var $_table;

	/**
	 * @var array $_columns The list of columns we will be inserting.
	 * @access private
	 */
	var $_columns;

	/**
	 * @var array $_values This variable is an array of arrays. The outer array
	 * stores all the rows that will be inserted. The inner array stores the field
	 * values of the current row.
	 * @access private
	 */
	var $_values;

	
	/**
	 * This is the constructor for a MySQL INSERT query.
	 * @access public
	 */
	function InsertQuery() {
		$this->reset();
	}
	



	/**
	 * Sets the table to insert into.
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
	 * Sets the columns to insert into the table.
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
	 * Adds one row of values to insert into the table.
	 * 
	 * By calling this method multiple times, you can insert many rows of
	 * information using just one query.
	 * @param array $values One row of values to insert into the table. Must
	 * match the order of columns specified with the setColumns() method.
	 * @access public
	 */
	function addRowOfValues($values) {
		// ** parameter validation
		$arrayRule =& new ArrayValidatorRule();
		ArgumentValidator::validate($values, $arrayRule, true);
		// ** end of parameter validation

		$this->_values[] = $values;
	}

	


	/**
	 * Sets the autoincrement column.
	 * Sets the autoincrement column. This could be useful with Oracle, for example.
	 * @param string $column The autoincrement column.
	 * @access public
	 */ 
	function setAutoIncrementColumn($column) {
		// In MySQL, this is irrelevant. Auto_Increment columns should
		// be defined as such in the table definition.
		
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($column, $stringRule, true);
		// ** end of parameter validation
	}


	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		parent::reset();

		// an UPDATE query
		$this->_type = INSERT;

		// default query configuration:
		
		// no table to insert into
		$this->_table = "";

		// no columns to insert
		$this->_columns = array();

		// no rows of values to add
		$this->_values = array();
	}

}
?>