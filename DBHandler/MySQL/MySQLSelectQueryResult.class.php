<?php

require_once(HARMONI."DBHandler/SelectQueryResult.interface.php");

/**
 * The MySQLSelectQueryResult interface provides the functionality common to a MySQL SELECT query result.
 *
 * The MySQLSelectQueryResult interface provides the functionality common to a MySQL SELECT query result.
 * For example, you can fetch associative arrays, advance the current row position, etc.
 * @version $Id: MySQLSelectQueryResult.class.php,v 1.2 2003/06/24 21:08:45 adamfranco Exp $
 * @package harmoni.dbhandler
 * @access public
 * @copyright 2003 
 */

class MySQLSelectQueryResult extends SelectQueryResultInterface {


	/**
     * The index of the current row in the result.
     * The index of the current row in the result. The first row has an index of 0.
	 * The last row has an index of getNumberOfRows() - 1.
	 * @var integer $_currentRow The index of the current row in the result.
	 */  
	var $_currentRowIndex;
	
	/**
	 * An associative array of the current row in the result.
	 * An associative array of the current row in the result.
	 * @var array $_currentRow An associative array of the current row in the result.
	 */
	var $_currentRow;

	/**
	 * The resource id for this SELECT query.
	 * The resource id for this SELECT query.
	 * @var integer $_resourceId The resource id for this SELECT query.
	 * @access private
	 */
	var $_resourceId;


	/**
	 * The link identifier for the database connection.
	 * The link identifier for the database connection.
	 * @param integer $_linkId The link identifier for the database connection.
	 * @access private
	 */
	var $_linkId;

	
	/**
	 * Creates a new MySQLSelectQueryResult object.
	 * Creates a new MySQLSelectQueryResult object.
	 * @access public
	 * @param integer $resourceId The resource id for this SELECT query.
	 * @param integer $linkId The link identifier for the database connection.
	 * @return object MySQLSelectQueryResult A new MySQLSelectQueryResult object.
	 */
	function MySQLSelectQueryResult($resourceId, $linkId) {
		$this->_resourceId = $resourceId;
		$this->_linkId = $linkId;
		$this->_currentRowIndex = 0;
		
		// if we have at least one row in the result, fetch its array
		if ($this->hasMoreRows())
			$this->_currentRow = mysql_fetch_assoc($this->_resourceId); // first row
	}
		


	/**
	 * Returns the resource id for this SELECT query.
	 * Returns the resource id for this SELECT query. The resource id is returned
	 * by the mysql_query() function.
	 * @access public
	 * @return integer The resource id for this SELECT query.
	 **/
	function getResourceId() {
		return $this->_resourceId;
	}
	


	/**
	 * Advances the current row position.
	 * Advances the current row position. If there are no more rows left, then
	 * it returns <code>false</code>.
	 * @access public
	 * @return boolean True, if successful; False, otherwise.
	 */ 
	function advanceRow() {
		// if no rows left, cannot advance
		if (!$this->hasMoreRows())
			return false;    
		
		// now, advance
		$this->_currentRowIndex++;
		$this->_currentRow = mysql_fetch_assoc($this->_resourceId);	
	}
	

	/**
	 * Indicates if there are any remaining rows returned by the SELECT query.
	 * Indicates if there are any remaining rows returned by the SELECT query. The
	 * current row does count as well.
	 * @access public
	 * @return boolean True, if there are some rows left; False, otherwise.
	 **/
	function hasMoreRows() {
		return ($this->_currentRowIndex < $this->getNumberOfRows());
	}

			
	/**
	 * Returns the specified field value in the current row.
	 * Returns the specified field value in the current row.
	 * @param string $field The name of the field, whose value will be returned.
	 * @access public
	 * @return mixed The value that was requested.
	 **/
	function field($field) {
		return $this->_currentRow[$field];
	}
	
	
	/**
	 * Get the number of fields that were selected by the SELECT query.
	 * Get the number of fields that were selected by the SELECT query.
	 * @access public
	 * @return integer The number of fields.
	 **/
	function getNumberOfFields() {
		return mysql_num_fields($this->_resourceId);
	}
	

	/**
	 * Returns an indexed array of all field names that were selected.
	 * Returns an indexed array of all field names that were selected.
	 * @access public
	 * @return array An array of all field names that were selected.
	 **/
	function getFieldNames() {
		return array_keys($this->getCurrentRow());
	}
	
	
	/**
	 * Returns an associative array of the current row.
	 * Returns an associative array of the current row.
	 * @access public
	 * @return array An associative array of the current row.
	 **/
	function getCurrentRow() {
		return $this->_currentRow;
	}


	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, UPDATE, or
	 * INSERT query, this would be the number of rows that were affected.
	 * @return integer Number of rows that were processed by the query.
	 */ 
	function getNumberOfRows() {
		return mysql_num_rows($this->_resourceId);
	}

}

?>