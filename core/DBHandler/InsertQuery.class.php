<?php

require_once(HARMONI."DBHandler/InsertQuery.interface.php");

/**
 * An InsertQuery object provides the tools to build an INSERT query.
 *
 * This is an abstract class that simply provides all the accessor methods,
 * initialization steps, etc. What is left to be implemented is the
 * generateSQLQuery() method.
 * 
 * @version $Id: InsertQuery.class.php,v 1.2 2005/01/19 23:21:34 adamfranco Exp $
 * @package harmoni.dbc
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
	 * The autoincrement column.
	 * @var string _autoIncrementColumn 
	 * @access private
	 */
	var $_autoIncrementColumn;
	

	/**
	 * The sequence to use for generating new ids for the autoincrement column.
	 * @var string _sequence 
	 * @access private
	 */
	var $_sequence;
	
	
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
	 * This is an alias for addRowOfValues for compatability with the UpdateQuery class.
	 * Adds one row of values to insert into the table. 
	 * By calling this method multiple times, you can insert many rows of
	 * information using just one query.
	 * @see {@link InsertQueryInterface::addRowOfValues }
	 * @param array $values One row of values to insert into the table. Must
	 * match the order of columns specified with the setColumns() method.
	 * @access public
	 */
	function setValues($values) { 
		$this->addRowOfValues($values);
	}	

	/**
	 * Sets the autoincrement column.
	 * Sets the autoincrement column. This could be useful with Oracle, for example.
	 * @param string $column The autoincrement column.
	 * @param string $sequence The sequence to use for generating new ids.
	 * @access public
	 */ 
	function setAutoIncrementColumn($column, $sequence) {
		// In MySQL, this is irrelevant. Auto_Increment columns should
		// be defined as such in the table definition.
		
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($column, $stringRule, true);
		ArgumentValidator::validate($sequence, $stringRule, true);
		// ** end of parameter validation
		
		$this->_autoIncrementColumn = $column;
		$this->_sequence = $sequence;
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

		$this->_column = "";
		$this->_sequence = "";
	}

}
?>