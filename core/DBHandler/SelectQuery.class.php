<?php

require_once(HARMONI."DBHandler/SelectQuery.interface.php");

/**
 * A SelectQuery class provides the tools to build a SELECT query.
 * 
 * A SelectQuery class provides the tools to build a SELECT query.
 * 
 * @version $Id: SelectQuery.class.php,v 1.6 2005/02/04 15:58:40 adamfranco Exp $
 * @package harmoni.dbc
 * @copyright 2003 
 */

class SelectQuery extends SelectQueryInterface {


	/**
	 * This array stores the tables in the FROM clause of the SELECT query.
	 *
	 * This array stores the tables in the FROM clause of the SELECT query along
	 * with the join types, join conditions, and table alias.
	 * @var string $_tables The tables in the FROM clause of the SELECT query.
	 * @see SelectQuery::addTable()
	 * @access private
	 */
	var $_tables;


	/**
	 * The list of columns we will be selecting.
	 * The list of columns we will be selecting. This is an array of arrays.
	 * Each element in the outer array specifies one column. The first element
	 * of each inner array is the column name itself. The second element is
	 * the alias of that column and is optional. The third and last element
	 * is the name of the table where the column resides.
	 * @var array $_columns The list of columns we will be selecting.
	 * @access private
	 */
	var $_columns;


	/**
	 * This will store the condition in the WHERE clause. Each element of this
	 * array stores 2 things: the condition itself, and the logical operator
	 * to use to join with the previous condition.
	 * @var array $_condition The condition in the WHERE clause.
	 * @access private
	 */
	var $_condition;


	/**
	 * Will store the columns in the GROUP BY clause.
	 * 
	 * Will store the columns in the GROUP BY clause.
	 * @var array $_groupBy The columns in the GROUP BY clause.
	 */
	var $_groupBy;


	/**
	 * Will store the condition in the HAVING clause.
	 * 
	 * Will store the condition in the HAVING clause.
	 * @var array $_having The condition in the HAVING clause.
	 */
	var $_having;


	/**
	 * Will store the columns in the ORDER BY clause.
	 * 
	 * Will store the columns in the OREDER BY clause. This is an array of arrays.
	 * Each element in the outer arrays stores one entry in the ORDER BY clause.
	 * Each inner array holds two elements. The first one is the name of the column
	 * to order by. The second one specifies whether it is a ASCENDING or DESCENDING
	 * order.
	 * @var array $_orderBy The columns in the ORDER BY clause.
	 */
	var $_orderBy;


	/**
	 * Specifies whether distinct rows will be returned or not.
	 * 
	 * Specifies whether distinct rows will be returned or not. If TRUE, only
	 * unique rows will be returned by the query.
	 * @var boolean $_distinct If true, then only unique rows will be returned.
	 */
	var $_distinct;

	/**
	 * Stores the number of rows to return.
	 * 
	 * Stores the number of rows to return.
	 * @var integer $_numberOfRows The number of rows to return.
	 */
	var $_numberOfRows;

	/**
	 * Stores the number of the row to start from.
	 * 
	 * Stores the number of the row to start from.
	 * @var integer $_startFromRow The number of the row to start from.
	 */
	var $_startFromRow;


	/**
	 * The constructor initializes the query object.
	 * 
	 * The constructor initializes the query object.
	 * @access public
	 */
	function SelectQuery() {
		$this->reset();
	}


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
	function addTable($table, $joinType = NO_JOIN, $joinCondition = "", $alias = "") {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($table, $stringRule, true);
		ArgumentValidator::validate($joinType, $integerRule, true);
		ArgumentValidator::validate($joinCondition, $stringRule, true);
		ArgumentValidator::validate($alias, $stringRule, true);
		// ** end of parameter validation
		
		$newTable = array($table, $joinType, $joinCondition, $alias);
		$this->_tables[] = $newTable;
	}


	/**
	 * *Deprecated* Sets the columns to select.
	 * Sets the columns to select.
	 * Note: addColumn() and setColumns() can be used together in any order.
	 * However, calling setColumns() after addColumn() resets the list of columns.
	 * @param array $column The columns to select. This is a one-dimensional array
	 * of the column names. If you want aliases you have to include the alias
	 * in the column name itself. For example: array("user_id AS id", "user_name AS name")
	 * For a better approach, see addColumn().
	 * @access public
	 * @deprecated June 24, 2003 - Use addColumn() instead.
	 * @see SelectQuery::addColumn()
	 */
	function setColumns($columns) {
		// ** parameter validation
		$arrayRule =& new ArrayValidatorRule();
		ArgumentValidator::validate($columns, $arrayRule, true);
		// ** end of parameter validation
		
		// convert each string in the array to a 2-dimensional array
		// (for compatibility with addColumn) and store in $this->_columns
		$this->_columns = array();
		foreach ($columns as $column) {
			$arr = array();
			$arr[] = $column;
			$arr[] = null;
			$arr[] = null;
			$this->_columns[] = $arr;
		}
	}

	
	
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
	 * @see SelectQueryInterface::setColumns()
	 */ 
	function addColumn($column, $alias = "", $table = "") {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		$optionalRule =& new OptionalRule($stringRule);
		ArgumentValidator::validate($column, $stringRule, true);
		ArgumentValidator::validate($alias, $optionalRule, true);
		ArgumentValidator::validate($table, $optionalRule, true);
		// ** end of parameter validation
		
		$arr = array();
		$arr[] = $column;
		$arr[] = $alias;
		$arr[] = $table;
		
		$this->_columns[] = $arr;
	}



	/**
	 * *Deprecated* Specifies the condition in the WHERE clause.
	 *
	 * The query will return only rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string condition The WHERE clause condition.
	 * @deprecated July 07, 2003 - Use addWhere() instead.
	 * @access public
	 */
	function setWhere($condition) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($condition, $stringRule, true);
		// ** end of parameter validation

		$this->_condition = array();

		$arr = array();
		$arr[] = $condition;
		$arr[] = null;
		
		$this->_condition[] = $arr;
	}


	/**
	 * Adds a new condition in the WHERE clause.
	 * 
	 * The query will return only rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string condition The WHERE clause condition to add.
	 * @param integer logicalOperation The logical operation to use to connect
	 * this WHERE condition with the previous WHERE conditions. Allowed values:
	 * <code>_AND</code> and <code>_OR</code>. 
	 * @access public
	 * @return void 
	 */
	function addWhere($condition, $logicalOperation = _AND) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		$integerRule =& new IntegerValidatorRule();
		$optionalRule =& new OptionalRule($integerRule);
		ArgumentValidator::validate($condition, $stringRule, true);
		ArgumentValidator::validate($logicalOperation, $optionalRule, true);
		// ** end of parameter validation

		$arr = array();
		$arr[] = $condition;
		$arr[] = $logicalOperation;
		
		$this->_condition[] = $arr;
	}
	

	
	/**
	 * Resets the WHERE clause.
	 * @access public
	 **/
	function resetWhere() {
		unset($this->_condition);
		$this->_condition = array();
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
	function setGroupBy($columns, $condition = "") {
		// ** parameter validation
		$arrayRule =& new ArrayValidatorRule();
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($columns, $arrayRule, true);
		ArgumentValidator::validate($condition, $stringRule, true);
		// ** end of parameter validation
		
		$this->_groupBy = $columns;
		$this->_having = $condition;
	}



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
	function addOrderBy($column, $direction = ASCENDING) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($column, $stringRule, true);
		ArgumentValidator::validate($direction, $integerRule, true);
		// ** end of parameter validation

		$this->_orderBy[] = array($column, $direction);
	}
	
	
	/**
	 * Specifies whether distinct rows will be returned.
	 * 
	 * Use this method to specify whether the rows returned by the SELECT query
	 * have to be distinct (i.e. only unique rows) or not. If the method is never 
	 * called, then the default value is not distinct.
	 * @param boolean $distinct If true, then only unique rows will be returned.
	 * @access public
	 */
	function setDistinct($distinct) {
		// ** parameter validation
		$booleanRule =& new BooleanValidatorRule();
		ArgumentValidator::validate($distinct, $booleanRule, true);
		// ** end of parameter validation

		$this->_distinct = $distinct;
	}

	
	
	
	/**
	 * Limits the number of rows to the specified number.
	 * 
	 * Limits the number of rows returned by the SELECT query to the specified 
	 * number.
	 * @param integer $numberOfRows The number of rows to return
	 * @access public
	 */
	function limitNumberOfRows($numberOfRows) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($numberOfRows, $integerRule, true);
		// ** end of parameter validation

		$this->_numberOfRows = $numberOfRows;
	}
	
	
	
	/**
	 * Starts the results from the specified row.
	 * 
	 * Starts the results of the SELECT query from the specified row.
	 * @param integer $startingRow The number of the starting row. Numbers
	 * start with 1 for the first row, 2 for the second row, and so forth.
	 * @access public
	 */
	function startFromRow($startFromRow) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($startFromRow, $integerRule, true);
		// ** end of parameter validation

		$this->_startFromRow = $startFromRow;
	}
	
	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		parent::reset();

		// an UPDATE query
		$this->_type = SELECT;
		
		// default query configuration:
		
		// no tables to select from
		$this->_tables = array();

		// no columns to select
		$this->_columns = array();

		// no WHERE condition, by default
		$this->_condition = array();

		// no GROUP BY clause
		$this->_groupBy = array();
		$this->_having = "";
		
		// no ORDER BY clause
		$this->_orderBy = array();
	
		// no LIMIT clause
		$this->_numberOfRows = 0;
		$this->_startFromRow = 0;
	}
	
}
?>