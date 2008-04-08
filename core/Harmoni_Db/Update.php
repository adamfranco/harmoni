<?php
/**
 * @since 4/3/08
 * @package harmoni.Harmoni_Db
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Update.php,v 1.2 2008/04/08 20:02:27 adamfranco Exp $
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
 * @version $Id: Update.php,v 1.2 2008/04/08 20:02:27 adamfranco Exp $
 */
class Harmoni_Db_Update
	extends Harmoni_Db_Select
{
	/*********************************************************
	 * Query-building methods
	 *********************************************************/
	
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
		throw new UnimplementedException(__METHOD__." is not implemented.");
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
	 * Add a column/value pair, if a value for the column exists, it will be
	 * overwritten. The value will not have any new escaping or quotes added to it.
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
		
		$key = array_search($column, $this->columns);
		if ($key !== FALSE && is_int($key)) {
			$this->values[$key] = $value;
		} else {
			$this->columns[] = $column;
			$this->values[] = $value;
		}
	}
	
	/**
	 * Add a value, escaping it and surrounding it with quotes.
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
	
	
	
	const VALUES         = 'values';
	
	const SQL_UPDATE     = 'UPDATE';
	const SQL_VALUES        = 'VALUES';
	
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
     * The initial values for the $_parts array.
     * NOTE: It is important for the 'FOR_UPDATE' part to be last to ensure
     * meximum compatibility with database adapters.
     *
     * @var array
     */
    protected static $_partsInit = array(
        self::FROM         => array(),
        self::COLUMNS      => array(),
        self::WHERE        => array(),
        self::ORDER        => array(),
        self::LIMIT_COUNT  => null,
        self::LIMIT_OFFSET => null
    );
	
	/**
     * Converts this object to an SQL SELECT string.
     *
     * @return string This object as a SELECT string.
     */
    public function __toString()
    {
        $sql = self::SQL_UPDATE;
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

        $entries = array();
        foreach ($this->columns as $key => $column) {
           $entries[] = $this->_adapter->quoteIdentifier($column).' = '.$this->values[$key];
        }
        
    	return $sql.' SET '.implode(', ', $entries);
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
			throw new DatabaseException("Cannot have multiple tables in an UPDATE query");
		
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
            $sql .=  ' ' . implode("\n", $from);
        }

        return $sql;
    }
	
}

?>