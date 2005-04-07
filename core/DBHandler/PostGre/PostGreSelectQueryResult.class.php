<?php
/**
 * @package harmoni.dbc.postgre
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostGreSelectQueryResult.class.php,v 1.7 2005/04/07 16:33:25 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/SelectQueryResult.interface.php");

/**
 * The PostGreSelectQueryResult interface provides the functionality common to a PostGre SELECT query result.
 * For example, you can fetch associative arrays, advance the current row position, etc.
 *
 * @package harmoni.dbc.postgre
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: PostGreSelectQueryResult.class.php,v 1.7 2005/04/07 16:33:25 adamfranco Exp $
 */
class PostGreSelectQueryResult 
	extends SelectQueryResultInterface 
{


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
	 * Creates a new PostGreSelectQueryResult object.
	 * Creates a new PostGreSelectQueryResult object.
	 * @access public
	 * @param integer $resourceId The resource id for this SELECT query.
	 * @param integer $linkId The link identifier for the database connection.
	 * @return object PostGreSelectQueryResult A new PostGreSelectQueryResult object.
	 */
	function PostGreSelectQueryResult($resourceId, $linkId) {
		// ** parameter validation
		$resourceRule =& ResourceValidatorRule::getRule();
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
			$this->_currentRow[BOTH] = pg_fetch_array($this->_resourceId);
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
	 * by the PostGre_query() function.
	 * @access public
	 * @return integer The resource id for this SELECT query.
	 **/
	function getResourceId() {
		return $this->_resourceId;
	}
	
	/**
	 * Indicates if there are any remaining rows returned by the SELECT query.
	 * Indicates if there are any remaining rows returned by the SELECT query including
	 * the current row.
	 * @access public
	 * @return boolean True, if there are some rows left; False, otherwise.
	 **/
	function hasNext() {
		return $this->hasMoreRows();
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
		$row =& $this->getCurrentRow();
		$this->advanceRow();
		return $row;
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

		$this->_currentRow[BOTH] = pg_fetch_array($this->_resourceId);
		if (!is_array($this->_currentRow[BOTH]))
			return false;
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
			throwError(new Error($str, "DBHandler", true));
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
		return pg_num_fields($this->_resourceId);
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
		$integerRule =& IntegerValidatorRule::getRule();
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
		return pg_num_rows($this->_resourceId);
	}

	

	/**
	 * Moves the internal row pointer to the specified position. The range of
	 * possible values is <code>0 - (getNumberOfRows()-1)</code>.
	 * @param integer rowNumber The number of the row to move to.
	 * @access public
	 * @return boolean <code>true</code>, if operation was successful; <code>false</code>, otherwise.
	 */
	function moveToRow($rowNumber) {
		// ** parameter validation
		$integerRule =& IntegerValidatorRule::getRule();
		ArgumentValidator::validate($rowNumber, $integerRule, true);
		// ** end of parameter validation
		
		
		if (($rowNumber < 0) || ($rowNumber > $this->getNumberOfRows() - 1)) {
			$str = "\$rowNumber must be in the range 0..(getNumberOfRows()-1)";
			throwError(new Error($str, "DBHandler", true));
		}
		    
		$result = pg_result_seek($this->_resourceId, $rowNumber);
		
		if ($result === true)
			$this->_currentRowIndex = $rowNumber;
		    
		return $result;
	}

	
}

?>