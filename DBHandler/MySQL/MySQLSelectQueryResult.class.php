<?php

require_once(HARMONI."DBHandler/SelectQueryResult.interface.php");

/**
 * The MySQLSelectQueryResult interface provides the functionality common to a MySQL SELECT query result.
 *
 * The MySQLSelectQueryResult interface provides the functionality common to a MySQL SELECT query result.
 * For example, you can fetch associative arrays, advance the current row position, etc.
 * @version $Id: MySQLSelectQueryResult.class.php,v 1.6 2003/07/10 02:34:20 gabeschine Exp $
 * @package harmoni.dbc
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
	 * An array storing three arrays (associative,
	 * numeric, and both) for the current row in the result.
	 * @variable private array _currentRow
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
		// ** parameter validation
		$resourceRule =& new ResourceValidatorRule();
		ArgumentValidator::validate($resourceId, $resourceRule, true);
		ArgumentValidator::validate($linkId, $resourceRule, true);
		// ** end of parameter validation

		$this->_resourceId = $resourceId;
		$this->_linkId = $linkId;
		$this->_currentRowIndex = 0;
		$this->_currentRow = array();
		$this->_currentRow[BOTH] = array();
		$this->_currentRow[NUMERIC] = array();
		$this->_currentRow[ASSOC] = array();
		
		// if we have at least one row in the result, fetch its array
		if ($this->hasMoreRows()) {
			$this->_currentRow[BOTH] = mysql_fetch_array($this->_resourceId, MYSQL_BOTH);
			foreach ($this->_currentRow[BOTH] as $key => $value)
				if (is_int($key))
				    $this->_currentRow[NUMERIC][$key] = $value;
				else
				    $this->_currentRow[ASSOC][$key] = $value;
		}
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

		$this->_currentRow[BOTH] = mysql_fetch_array($this->_resourceId, MYSQL_BOTH);
		foreach ($this->_currentRow[BOTH] as $key => $value)
			if (is_int($key))
			    $this->_currentRow[NUMERIC][$key] = $value;
			else
			    $this->_currentRow[ASSOC][$key] = $value;
		
		return true;
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
	 * @param mixed $field The name or index of the field, whose value will be returned.
	 * @access public
	 * @return mixed The value that was requested.
	 **/
	function field($field) {
		// ** parameter validation
		if (!array_key_exists($field, $this->_currentRow[BOTH])) {
			$str = "Invalid field to return from a SELECT query result.";
			throw(new Error($str, "DBHandler", true));
		}
		// ** end of parameter validation

		return $this->_currentRow[BOTH][$field];
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
	function getCurrentRow($arrayType = BOTH) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($arrayType, $integerRule, true);
		// ** end of parameter validation
		
		$result = $this->_currentRow[$arrayType];
		if (is_null($result))
		    $result = $this->_currentRow[BOTH];
			
		return $result;
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

	

	/**
	 * Moves the internal row pointer to the specified position. The range of
	 * possible values is <code>0 - (getNumberOfRows()-1)</code>.
	 * @param integer rowNumber The number of the row to move to.
	 * @method public moveToRow
	 * @return boolean <code>true</code>, if operation was successful; <code>false</code>, otherwise.
	 */
	function moveToRow($rowNumber) {
		// ** parameter validation
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($rowNumber, $integerRule, true);
		// ** end of parameter validation
		
		
		if (($rowNumber < 0) || ($rowNumber > $this->getNumberOfRows() - 1)) {
			$str = "\$rowNumber must be in the range 0..(getNumberOfRows()-1)";
			throw(new Error($str, "DBHandler", true));
		}
		    
		$result = mysql_data_seek($this->_resourceId, $rowNumber);
		
		if ($result === true)
			$this->_currentRowIndex = $rowNumber;
		    
		return $result;
		
	}

	
}

?>