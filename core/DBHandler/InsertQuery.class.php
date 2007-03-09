<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: InsertQuery.class.php,v 1.7 2007/03/09 19:06:06 adamfranco Exp $
 */
require_once(HARMONI."DBHandler/InsertQuery.interface.php");

/**
 * An InsertQuery object provides the tools to build an INSERT query.
 *
 * This is an abstract class that simply provides all the accessor methods,
 * initialization steps, etc. What is left to be implemented is the
 * generateSQLQuery() method.
 * 
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: InsertQuery.class.php,v 1.7 2007/03/09 19:06:06 adamfranco Exp $ 
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
		$stringRule =& StringValidatorRule::getRule();
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
		$arrayRule =& ArrayValidatorRule::getRule();
		ArgumentValidator::validate($columns, $arrayRule, true);
		// ** end of parameter validation

		$this->_columns = $columns;
	}
	
	/**
	 * Create a new, empty row. This is used when adding values via the addValue() or
	 * addRawValue() method rather than the setColumns.
	 * 
	 * @return void
	 * @access public
	 * @since 3/8/07
	 */
	function createRow () {
		$this->_values[] = array();
		$index = count($this->_values) - 1;
		
		// Ensure that rows of values at least have a null value for the column
		for ($i = 0; $i < count($this->_columns); $i++) {
			$this->_values[$index][] = 'NULL';
		}
	}
	
	/**
	 * Add a new column and populate all rows of values with a null value. Return
	 * the array index of the new column.
	 * 
	 * @param string $column
	 * @return integer
	 * @access public
	 * @since 3/8/07
	 */
	function addColumn ( $column ) {
		$this->_columns[] = $this->cleanColumn($column);
		$index = count($this->_columns) - 1;
		
		// Ensure that rows of values at least have a null value for the column
		for ($i = 0; $i < count($this->_values); $i++) {
			$this->_values[$i][] = 'NULL';
		}
		
		return $index;
	}
	
	/**
	 * Add a column/value pair to the latest row, if a value for the column exists, 
	 * it will be overwritten. The value will not have any new escaping or quotes 
	 * added to it. All rows of values MUST have the same number and order of
	 * columns.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/8/07
	 */
	function addRawValue ( $column, $value ) {
		ArgumentValidator::validate($column, NonzeroLengthStringValidatorRule::getRule());
		ArgumentValidator::validate($value, NonzeroLengthStringValidatorRule::getRule());
		
		// Make sure that we have a row
		if (!count($this->_values))
			$this->createRow();
		
		$key = array_search($column, $this->_columns);
		
		if ($key === FALSE || !is_int($key)) {
			$key = $this->addColumn($column);
		}
		
		$this->_values[count($this->_values) - 1][$key] = $value;
	}
	
	/**
	 * Add a value to the latest row, escaping it and surrounding it with quotes.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/8/07
	 */
	function addValue ( $column, $value ) {
		ArgumentValidator::validate($column, NonzeroLengthStringValidatorRule::getRule());
		ArgumentValidator::validate($value, StringValidatorRule::getRule());
		
		$this->addRawValue($column, "'".addslashes($value)."'");
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
		$arrayRule =& ArrayValidatorRule::getRule();
		ArgumentValidator::validate($values, $arrayRule, true);
		// ** end of parameter validation

		$this->_values[] = $values;
	}

	/**
	 * This is an alias for addRowOfValues for compatability with the UpdateQuery class.
	 * Adds one row of values to insert into the table. 
	 * By calling this method multiple times, you can insert many rows of
	 * information using just one query.
	 * @see InsertQueryInterface::addRowOfValues 
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
		$stringRule =& StringValidatorRule::getRule();
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