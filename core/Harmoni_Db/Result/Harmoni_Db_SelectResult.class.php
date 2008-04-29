<?php

require_once(HARMONI."/DBHandler/QueryResult.interface.php");

/**
 * The SelectQueryResult interface provides the functionality common to a SELECT query result.
 *
 * The SelectQueryResult interface provides the functionality common to a SELECT query result.
 * For example, you can fetch associative arrays, advance the current row position, etc.
 * @version $Id: Harmoni_Db_SelectResult.class.php,v 1.3 2008/04/24 13:44:52 adamfranco Exp $
 * @package harmoni.dbc
 * @access public
 * @copyright 2003 
 */

class Harmoni_Db_SelectResult 
	implements SelectQueryResultInterface 
{
	/**
	 * @var Zend_Db_Statement $stmt;  The statement that returned this result
	 * @access private
	 * @since 4/4/08
	 */
	private $stmt;
	
	/**
	 * @var int $currentRowIndex;  
	 * @access private
	 * @since 4/4/08
	 */
	private $currentRowIndex = 0;
	
	/**
	 * @var array $currentRow; The values in the current row. 
	 * @access private
	 * @since 4/4/08
	 */
	private $currentRow = null;
	
	/**
	 * @var object Zend_Db_Adapter $adapter;  
	 * @access private
	 * @since 4/23/08
	 */
	private $adapter;
	
	/**
	 * Constructor
	 * 
	 * @param Zend_Db_Statement $stmt
	 * @return void
	 * @access public
	 * @since 4/4/08
	 */
	public function __construct (Zend_Db_Statement $stmt, $adapter) {
		$this->stmt = $stmt;
		$this->adapter = $adapter;
	}
	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, UPDATE, or
	 * INSERT query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 * @access public
	 */ 
	function getNumberOfRows() {
		throw new UnimplementedException("Currently cannot get number of selected rows from a PDO SELECT statment.");
		// The rowCount is only good for update and delete queries.
		return $this->stmt->rowCount();
	}
	
	/**
	 * Returns the resource id for this SELECT query.
	 * Returns the resource id for this SELECT query. The resource id is returned
	 * by the mysql_query() function.
	 * @access public
	 * @return integer The resource id for this SELECT query.
	 **/
	function getResourceId() {
		throw new UnimplementedException();
	}
	
	/**
	 * Indicates if there are any remaining rows returned by the SELECT query.
	 * Indicates if there are any remaining rows returned by the SELECT query including
	 * the current row.
	 * @access public
	 * @return boolean True, if there are some rows left; False, otherwise.
	 **/
	function hasNext() {
		return ($this->currentRowIndex < $this->getNumberOfRows());
	}

	/**
	 * Returns an array that stores the current row in the result and advances
	 * to the next row. The data
	 * can be accessed through associative indices <b>as well as</b> numeric indices.
	 * @access public
	 * @param optional integer arrayType Specifies what type of an array to return.
	 * Allowed values are: ASSOC, NUMERIC, and BOTH.
	 * @return array An associative array of the current row.
	 **/
	function next() {
		try {
			$this->currentRow = $this->stmt->fetch();
			$this->currentRowIndex++;
		} catch (Zend_Db_Statement_Exception $e) {
			$this->currentRow = null;
			throw $e;
		}
		return $this->currentRow;
	}
	
	/**
	 * Advances the current row position.
	 * Advances the current row position. If there are no more rows left, then
	 * it returns <code>false</code>.
	 * @access public
	 * @return boolean True, if successful; False, otherwise.
	 */ 
	function advanceRow() {
		try {
			$this->currentRow = $this->stmt->fetch();
			$this->currentRowIndex++;
		} catch (Zend_Db_Statement_Exception $e) {
			$this->currentRow = null;
			throw $e;
		}
		return (is_array($this->currentRow));
	}
	

	/**
	 * Indicates if there are any remaining rows returned by the SELECT query including
	 * the current row.
	 * @access public
	 * @return boolean True, if there are some rows left; False, otherwise.
	 **/
	function hasMoreRows() {
		return ((is_array($this->currentRow)) || $this->hasNext());
	}

			
	/**
	 * Returns the specified field value in the current row.
	 * Returns the specified field value in the current row.
	 * @param mixed $field The name or index of the field, whose value will be returned.
	 * @access public
	 * @return mixed The value that was requested.
	 **/
	function field($field) {
		if (!is_array($this->currentRow)) {
			if ($this->hasNext()) {
				$this->next();
			} else {
				throw new DatabaseException("No more rows.");
			}
		}
		if (!array_key_exists($field, $this->currentRow))
			throw new DatabaseException("Unknown field, '$field'.");
		return $this->currentRow[$field];
	}
	
	
	/**
	 * Get the number of fields that were selected by the SELECT query.
	 * Get the number of fields that were selected by the SELECT query.
	 * @access public
	 * @return integer The number of fields.
	 **/
	function getNumberOfFields() {
		throw new UnimplementedException();
	}
	

	/**
	 * Returns an indexed array of all field names that were selected.
	 * Returns an indexed array of all field names that were selected.
	 * @access public
	 * @return array An array of all field names that were selected.
	 **/
	function getFieldNames() {
		return array_keys($this->getCurrentRow(ASSOC));
	}
	
	
	/**
	 * Returns an array that stores the current row in the result. The data
	 * can be accessed through associative indices <b>as well as</b> numeric indices.
	 * @access public
	 * @param optional integer arrayType Specifies what type of an array to return.
	 * Allowed values are: ASSOC, NUMERIC, and BOTH.
	 * @return array An associative array of the current row.
	 **/
	function getCurrentRow($arrayType = ASSOC) {
		if ($arrayType != ASSOC)
			throw new InvalidArgumentException("Not allowing setting of fetch mode here.");
		
		if (!$this->currentRow) {
			$this->currentRow = $this->stmt->fetch();
			$this->currentRowIndex++;
		}
		return $this->currentRow;
	}
	
	
	
	/**
	 * Moves the internal row pointer to the specified position. The range of
	 * possible values is <code>0 - (getNumberOfRows()-1)</code>.
	 * @param integer rowNumber The number of the row to move to.
	 * @access public
	 * @return boolean <code>true</code>, if operation was successful; <code>false</code>, otherwise.
	 */
	function moveToRow($rowNumber) {
		throw new UnimplementedException();
	}
	
	
	/**
	 * Binds the field specified by the first argument to the variable given as
	 * the second argument. The method stores a reference to the variable represented
	 * by the second argument; whenever a new row is fetched, the value of the field
	 * in the new row will be updated in the referenced variable. This enables the
	 * user to avoid unnecessary calls to <code>getCurrentRow()</code> or
	 * <code>field()</code>.
	 * @access public
	 * @param string field The field to bind. This could be either
	 * a string value that would correspond to the field as returned by 
	 * <code>getFieldNames()</code>, or an integer (less than <code>getNumberOfFields()</code>)
	 * corresponding to the index of the field.
	 * @param ref mixed var The variable to be bound to the value of the field in
	 * the current row.
	 **/
	function bindField($field, $var) {
		throw new UnimplementedException();
	}
	
	/**
	 * Unbinds the field that has been bound by <code>bindField()</code>.
	 * @access public
	 * @param string field The field to unbind. This could be either
	 * a string value that would correspond to the field as returned by 
	 * <code>getFieldNames()</code>, or an integer (less than <code>getNumberOfFields()</code>)
	 * corresponding to the index of the field.
	 **/
	function unbindField($field) {
		throw new UnimplementedException();
	}
	
	/**
	 * Frees the memory for this result.
	 * @access public
	 * @return void
	 */
	function free() {
		$this->stmt->closeCursor();
	}
	
	/**
	 * Gets the last auto increment value that was generated by the INSERT query.
	 * Gets the last auto increment value that was generated by the INSERT query.
	 * @access public
	 * @return integer The last auto increment value that was generated by the INSERT query.
	 */ 
	function getLastAutoIncrementValue() {
		return $this->adapter->lastInsertId($this->stmt->autoIncrementTable, $this->stmt->autoIncrementKey);
	}

}

?>