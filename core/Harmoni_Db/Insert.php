<?php
/**
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Insert.php,v 1.1.2.1 2008/04/03 23:54:50 adamfranco Exp $
 */ 

/**
 * The Harmoni_Db_Update object generates an update query similar to a select query.
 * 
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Insert.php,v 1.1.2.1 2008/04/03 23:54:50 adamfranco Exp $
 */
class Harmoni_Db_Insert
	extends Harmoni_Db_Select
{
	/**
	 * @var array $columns; An array of columns for update. 
	 * @access private
	 * @since 4/3/08
	 */
	private $columns = array();
	
	/**
	 * @var array $values; An array of value-rows for update
	 * @access private
	 * @since 4/3/08
	 */
	private $values = array();

	/*********************************************************
	 * Query-building methods
	 *********************************************************/
	 
	/**
	 * Create a new, empty row. This is used when adding values via the addValue() or
	 * addRawValue() method rather than the setColumns.
	 * 
	 * @return void
	 * @access public
	 * @since 3/8/07
	 */
	function createRow () {
		$this->values[] = array();
		$index = count($this->values) - 1;
		
		// Ensure that rows of values at least have a null value for the column
		for ($i = 0; $i < count($this->columns); $i++) {
			$this->values[$index][] = 'NULL';
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
		$this->columns[] = $this->cleanColumn($column);
		$index = count($this->columns) - 1;
		
		// Ensure that rows of values at least have a null value for the column
		for ($i = 0; $i < count($this->values); $i++) {
			$this->values[$i][] = 'NULL';
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
		if (!count($this->values))
			$this->createRow();
		
		$key = array_search($this->cleanColumn($column), $this->columns);
		
		if ($key === FALSE || !is_int($key)) {
			$key = $this->addColumn($column);
		}
		
		$this->values[count($this->values) - 1][$key] = $value;
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
		
		$this->addRawValue($column, $this->_adapter->quote($value));
	}
	
	/**
	 * Sets the table to update.
	 * @param string $table The table to insert into.
	 * @access public
	 */
	function setTable($table) {
		$this->reset(self::FROM);
		$this->from($table, null);
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
		$this->setTable($table);
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
		throw new UnimplementedException(__METHOD__." is not implemented.");
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
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a comparison where the value is NOT quoted or escaped
	 * 
	 * @param string $column
	 * @param string $value
	 * @param string $comparison
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawComparison ( $column, $value, $comparison, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a comparison where the value is quoted and escaped.
	 * 
	  * @param string $column
	 * @param string $value
	 * @param string $comparison
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereComparison ( $column, $value, $comparison, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a LIKE clause where the value is quoted and escaped.
	 * 
	  * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawLike ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a LIKE clause where the value is quoted and escaped.
	 * 
	  * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereLike ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereEqual ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column!='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNotEqual ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column<'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereLessThan ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column>'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereGreaterThan ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column<='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereLessThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column>='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereGreaterThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawEqual ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column!='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawNotEqual ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column<'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawLessThan ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column>'value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawGreaterThan ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column<='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawLessThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column>='value'.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawGreaterThanOrEqual ( $column, $value, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column IS NULL.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNull ( $column, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column IS NOT NULL.
	 * 
	 * @param string $column
	 * @param string $value
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNotNull ( $column, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereIn ( $column, array $values, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column NOT IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereNotIn ( $column, array $values, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawIn ( $column, array $values, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
	
	/**
	 * Add a where clause of the form column NOT IN ('xxx', 'yyy').
	 * 
	 * @param string $column
	 * @param array $values
	 * @return void
	 * @access public
	 * @since 3/9/07
	 */
	function addWhereRawNotIn ( $column, array $values, $logicalOperation = _AND ) {
		throw new UnimplementedException(__METHOD__." is not implemented.");
	}
		
		
/*********************************************************
 * 
 *********************************************************/
	const VALUES         = 'values';
	const SQL_VALUES        = 'VALUES';
	const SQL_INSERT     = 'INSERT';
	
	/**
     * The initial values for the $_parts array.
     * NOTE: It is important for the 'FOR_UPDATE' part to be last to ensure
     * meximum compatibility with database adapters.
     *
     * @var array
     */
    protected static $_partsInit = array(
        self::FROM         => array(),
        self::COLUMNS      => array()
    );
    
    /**
     * Clear parts of the Select object, or an individual part.
     *
     * @param string $part OPTIONAL
     * @return Zend_Db_Select
     */
    public function reset($part = null)
    {
        if ($part == null) {
            $this->_parts = self::$_partsInit;
            $this->columns = array();
            $this->values = array();
        } else if ($part == self::COLUMNS) {
        	$this->columns = array();
        } else if ($part == self::VALUES) {
        	$this->values = array();
        } else if (array_key_exists($part, self::$_partsInit)) {
            $this->_parts[$part] = self::$_partsInit[$part];
        }
        return $this;
    }
	
	/**
     * Converts this object to an SQL SELECT string.
     *
     * @return string This object as a SELECT string.
     */
    public function __toString()
    {
        $sql = self::SQL_INSERT;
        foreach (array_keys(self::$_partsInit) as $part) {
            $method = '_render' . ucfirst($part);
            if (method_exists($this, $method)) {
                $sql = $this->$method($sql);
            }
        }
        return $sql;
    }
    
    /**
     * Render the COLUMNS clause
     * 
     * @param string $sql SQL query
     * @return string
     * @access protected
     * @since 4/3/08
     */
    protected function _renderColumns ($sql) {
    	if (!count($this->columns)) {
            return null;
        }

        $valueSets = array();
        foreach ($this->values as $valueArray) {
        	$valueSets[] = '('.implode(', ', $valueArray).')';
        }
        
    	return $sql.' ('.implode(', ', $this->columns).') VALUES '.implode(', ', $valueSets);
    }
    
    /**
     * Render FROM clause
     *
     * @param string   $sql SQL query
     * @return string
     */
    protected function _renderFrom($sql)
    {
        /*
         * If no table specified, use RDBMS-dependent solution
         * for table-less query.  e.g. DUAL in Oracle.
         */
        if (empty($this->_parts[self::FROM])) {
            $this->_parts[self::FROM] = $this->_getDummyTable();
        }

        $from = array();
		
		if (count($this->_parts[self::FROM]) > 1)
			throw new DatabaseException("Cannot have multiple tables in an INSERT query");
		
        foreach ($this->_parts[self::FROM] as $correlationName => $table) {
            $tmp = '';

            // Add join clause (if applicable)
            if (! empty($from)) {
                $tmp .= ' ' . strtoupper($table['joinType']) . ' ';
            }

            $tmp .= $this->_getQuotedSchema($table['schema']);
            $tmp .= $this->_getQuotedTable($table['tableName'], $correlationName);

            // Add join conditions (if applicable)
            if (!empty($from) && ! empty($table['joinCondition'])) {
                $tmp .= ' ' . self::SQL_ON . ' ' . $table['joinCondition'];
            }

            // Add the table name and condition add to the list
            $from[] = $tmp;
        }

        // Add the list of all joins
        if (!empty($from)) {
            $sql .=  ' INTO ' . implode("\n", $from);
        }

        return $sql;
    }
	
}

?>