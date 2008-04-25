<?php
/**
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Select.php,v 1.4 2008/04/25 14:24:56 adamfranco Exp $
 */ 

/**
 * The Harmoni_Db_Select object adds HarmoniDatabase-syntax to the Zend_Db_Select object.
 * 
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Select.php,v 1.4 2008/04/25 14:24:56 adamfranco Exp $
 */
class Harmoni_Db_Select
	extends Zend_Db_Select
{
		
/*********************************************************
 * Methods from Query.abstract.php
 *********************************************************/
 	
 	/**
 	 * @var array $placeholdValues; An array of the values to insert into placeholders 
 	 * @access private
 	 * @since 4/3/08
 	 */
 	private $placeholderValues = array();

	/**
	 * Answer a safe SQL column string
	 * 
	 * @param string $column
	 * @return string
	 * @access public
	 * @since 3/9/07
	 */
	function cleanColumn ( $column ) {
		if (!preg_match('/^[a-z0-9_\.]+$/i', $column))
			throw new DatabaseException("Invalid SQL column, '".$column."'");
		return $this->_adapter->quoteIdentifier($column);
	}
	
	/**
	 * Add a comparison where the value is NOT quoted or escaped
	 * 
	 * @param string $column
	 * @param string $value
	 * @param string $comparison
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawComparison ( $column, $value, $comparison, $logicalOperation = _AND ) {
		if (!preg_match('/[!=><]{1,3}/', $comparison))
			throw new DatabaseException("Invalid SQL comparison, '".$comparison."'");
		
		$this->placeholderValues[] = $value;
		$this->addWhere(
			$this->cleanColumn($column)
				.$comparison
				.'?', 
			$logicalOperation);
		
		return count($this->placeholderValues);
	}
	
	/**
	 * Add a comparison where the value is quoted and escaped.
	 * 
	  * @param string $column
	 * @param string $value
	 * @param string $comparison
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereComparison ( $column, $value, $comparison, $logicalOperation = _AND ) {
		return $this->addWhereRawComparison(
			$column, 
			$value,
			$comparison, 
			$logicalOperation);
	}
	
	/**
	 * Add a LIKE clause where the value is quoted and escaped.
	 * 
	  * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawLike ( $column, $value, $logicalOperation = _AND ) {
		$this->placeholderValues[] = $value;
		$this->addWhere(
			$this->cleanColumn($column).' LIKE ?', 
			$logicalOperation);

		return count($this->placeholderValues);
	}
	
	/**
	 * Add a LIKE clause where the value is quoted and escaped.
	 * 
	  * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereLike ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereRawLike(
			$column, 
			$value,
			$logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereEqual ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereComparison($column, $value, '=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column!='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNotEqual ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereComparison($column, $value, '!=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column<'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereLessThan ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereComparison($column, $value, '<', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column>'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereGreaterThan ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereComparison($column, $value, '>', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column<='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereLessThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereComparison($column, $value, '<=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column>='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereGreaterThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereComparison($column, $value, '>=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawEqual ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereRawComparison($column, $value, '=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column!='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawNotEqual ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereRawComparison($column, $value, '!=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column<'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawLessThan ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereRawComparison($column, $value, '<', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column>'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawGreaterThan ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereRawComparison($column, $value, '>', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column<='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawLessThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereRawComparison($column, $value, '<=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column>='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawGreaterThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		return $this->addWhereRawComparison($column, $value, '>=', $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column IS NULL.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNull ( $column, $logicalOperation = _AND ) {
		return $this->addWhere(
			$this->cleanColumn($column)." IS NULL",
			$logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column IS NOT NULL.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNotNull ( $column, $logicalOperation = _AND ) {
		return $this->addWhere(
			$this->cleanColumn($column)." IS NOT NULL", 
			$logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column IN ('xxx', 'yyy').
	 *
	 * 
	 * 
	 * @param string $column
	 * @param array $values
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereIn ( $column, array $values, $logicalOperation = _AND ) {
		foreach ($values as $key => $value)
			$values[$key] = $this->_adapter->quote($value);
		$string = $this->cleanColumn($column)." IN (".implode(', ', $values).")";
		$this->addWhere($string, $logicalOperation);

	}
	
	/**
	 * Add a where clause of the form column NOT IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNotIn ( $column, array $values, $logicalOperation = _AND ) {
		foreach ($values as $key => $value)
			$values[$key] = $this->_adapter->quote($value);
		$string = $this->cleanColumn($column)." NOT IN (".implode(', ', $values).")";
		$this->addWhere($string, $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawIn ( $column, array $values, $logicalOperation = _AND ) {
		$string = $this->cleanColumn($column)." IN (".implode(', ', $values).")";
		$this->addWhere($string, $logicalOperation);
	}
	
	/**
	 * Add a where clause of the form column NOT IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return mixed string or int The placeholder key for the value.
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawNotIn ( $column, array $values, $logicalOperation = _AND ) {
		$string = $this->cleanColumn($column)." NOT IN (".implode(', ', $values).")";
		$this->addWhere($string, $logicalOperation);
	}
	
	
/*********************************************************
 * Methods from SelectQuery.class.php
 *********************************************************/
	
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
// 		ArgumentValidator::validate($table, StringValidatorRule::getRule());
		ArgumentValidator::validate($joinType,  IntegerValidatorRule::getRule());
		ArgumentValidator::validate($joinCondition, StringValidatorRule::getRule());
		ArgumentValidator::validate($alias, StringValidatorRule::getRule());
		// ** end of parameter validation
		
		if ($alias)
			$table = array($alias => $table);
		
		switch ($joinType) {
			case NO_JOIN:
				$this->from($table, null);
				break;
			case LEFT_JOIN:
				$this->joinLeft($table, $joinCondition, null);
				break;
			case INNER_JOIN:
				$this->joinInner($table, $joinCondition, null);
				break;
			case RIGHT_JOIN:
				$this->joinRight($table, $joinCondition, null);
				break;
			default:
				throw new DatabaseException ("Unknown JOIN type");
		}
	}
	
	 /**
     * Adds to the internal table-to-column mapping array.
     *
     * @param  string $tbl The table/join the columns come from.
     * @param  array|string $cols The list of columns; preferably as
     * an array, but possibly as a string containing one column.
     * @return void
     */
    protected function _tableCols($correlationName, $cols) {
    	// allow us to pass empty columns in joining so that we can add columns later.
    	if (!is_null($cols)) {
    		parent::_tableCols($correlationName, $cols);
    	}
    }
	
	/**
	 * Adds a sub-select table to the FROM clause of the SELECT query.
	 * 
	 * Adds a table to the FROM clause of the SELECT statement. At any moment,
	 * a current set of tables is maintained in the object, so when a new one
	 * is added, it is combined with the current set.
	 * @param object SelectQueryInterface $subQuery
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
	function addDerivedTable(Zend_Db_Select $subQuery, $joinType = NO_JOIN, $joinCondition = "", $alias = "") {
		ArgumentValidator::validate($joinType, IntegerValidatorRule::getRule());
		ArgumentValidator::validate($joinCondition, StringValidatorRule::getRule());
		ArgumentValidator::validate($alias, StringValidatorRule::getRule());
		
		
		$this->addTable(new Zend_Db_Expr('(' . $subQuery->__toString() . ')'), $joinType, $joinCondition, $alias);
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
		$arrayRule = ArrayValidatorRule::getRule();
		ArgumentValidator::validate($columns, $arrayRule, true);
		// ** end of parameter validation
		
		throw new UnimplementedException(__METHOD__." is not implemented.");
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
		$stringRule = StringValidatorRule::getRule();
		$optionalRule = OptionalRule::getRule($stringRule);
		ArgumentValidator::validate($column, $stringRule, true);
		ArgumentValidator::validate($alias, $optionalRule, true);
		ArgumentValidator::validate($table, $optionalRule, true);
		// ** end of parameter validation
		
		if ($table)
			$correlationName = $table;
		else
			$correlationName = null;
		
		if ($alias)
			$cols = array($column." AS ".$alias);
		else
			$cols = array($column);
			
		$this->_tableCols($correlationName, $cols);
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
		throw new UnimplementedException(__METHOD__." is not implemented.");
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
		ArgumentValidator::validate($condition, StringValidatorRule::getRule(), true);
		ArgumentValidator::validate($logicalOperation, IntegerValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		if ($logicalOperation == _AND)
			$this->where($condition);
		else if ($logicalOperation == _OR)
			$this->orWhere($condition);
		else
			throw new InvalidArgumentException("Unknown logicial operation, '$logicalOperation'.");
	}
	

	
	/**
	 * Resets the WHERE clause.
	 * @access public
	 **/
	function resetWhere() {
		throw new UnimplementedException(__METHOD__." is not implemented.");
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
		$arrayRule = ArrayValidatorRule::getRule();
		$stringRule = StringValidatorRule::getRule();
		ArgumentValidator::validate($columns, $arrayRule, true);
		ArgumentValidator::validate($condition, $stringRule, true);
		// ** end of parameter validation
		
		$this->group($columns);
		if ($conditition)
			$this->having($condition);
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
		$stringRule = StringValidatorRule::getRule();
		$integerRule = IntegerValidatorRule::getRule();
		ArgumentValidator::validate($column, $stringRule, true);
		ArgumentValidator::validate($direction, $integerRule, true);
		// ** end of parameter validation

		if ($direction == ASCENDING)
			$this->order($column.' ASC');
		else
			$this->order($column.' DESC');
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
		$booleanRule = BooleanValidatorRule::getRule();
		ArgumentValidator::validate($distinct, $booleanRule, true);
		// ** end of parameter validation

		$this->distinct($distinct);
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
		$integerRule = IntegerValidatorRule::getRule();
		ArgumentValidator::validate($numberOfRows, $integerRule, true);
		// ** end of parameter validation

		$this->limit($numberOfRows);
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
		$integerRule = IntegerValidatorRule::getRule();
		ArgumentValidator::validate($startFromRow, $integerRule, true);
		// ** end of parameter validation

		$this->limit($this->_parts[self::LIMIT_COUNT], $startFromRow);
	}
	
	
	/**
	 * Prepare the statement and return a PDOStatement-like object.
	 *
	 * @return Zend_Db_Statment|PDOStatement
	 * @access public
	 * @since 4/3/08
	 */
	public function prepare ($caller = null) {
		if (is_null($caller) && isset($this->_adapter->recordQueryCallers) && $this->_adapter->recordQueryCallers) 
		{
			$backtrace = debug_backtrace();
			if (isset($backtrace[1]['class']))
				$caller = $backtrace[1]['class'].$backtrace[1]['type'].$backtrace[1]['function']."()";
			else
				$caller = $backtrace[1]['function']."()";
		}
		
		$stmt = $this->_adapter->prepare($this->__toString(), $caller);
		foreach ($this->placeholderValues as $i => $value)
			$stmt->bindValue($i + 1, $value);
		return $stmt;
	}
	
	/**
     * Executes the current select object and returns the result
     *
     * @param integer $fetchMode OPTIONAL
     * @return PDO_Statement|Zend_Db_Statement
     */
    public function query($fetchMode = null)
    {
        $stmt = $this->_adapter->query($this, $this->placeholderValues);
        if ($fetchMode == null) {
            $fetchMode = $this->_adapter->getFetchMode();
        }
        $stmt->setFetchMode($fetchMode);
        return $stmt;
    }
    
    /**
     * Answer the string version of the query.
     * 
     * @return string
     * @access public
     * @since 4/22/08
     */
    public function asString () {
    	return $this->__toString();
    }
}

?>