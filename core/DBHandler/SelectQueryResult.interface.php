<?php

require_once("QueryResult.interface.php");


/**
 * A constant indicating an associative array.
 * @const integer ASSOC
 * @package harmoni.dbc
 */
define("ASSOC", 1);


/**
 * A constant indicating a numeric array.
 * @const integer NUMERIC
 * @package harmoni.dbc
 */
define("NUMERIC", 2);


/**
 * A constant indicating an array that has both numeric and associative (string)
 * indices.
 * @const integer BOTH
 * @package harmoni.dbc
 */
define("BOTH", 3);




/**
 * The SelectQueryResult interface provides the functionality common to a SELECT query result.
 *
 * The SelectQueryResult interface provides the functionality common to a SELECT query result.
 * For example, you can fetch associative arrays, advance the current row position, etc.
 * @version $Id: SelectQueryResult.interface.php,v 1.4 2004/12/13 05:06:27 dobomode Exp $
 * @package harmoni.dbc
 * @access public
 * @copyright 2003 
 */

class SelectQueryResultInterface extends QueryResultInterface {

	/**
	 * Returns the resource id for this SELECT query.
	 * Returns the resource id for this SELECT query. The resource id is returned
	 * by the mysql_query() function.
	 * @access public
	 * @return integer The resource id for this SELECT query.
	 **/
	function getResourceId() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Indicates if there are any remaining rows returned by the SELECT query.
	 * Indicates if there are any remaining rows returned by the SELECT query including
	 * the current row.
	 * @access public
	 * @return boolean True, if there are some rows left; False, otherwise.
	 **/
	function hasNext() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Returns an array that stores the current row in the result and advances
	 * to the next row. The data
	 * can be accessed through associative indices <b>as well as</b> numeric indices.
	 * @access public
	 * @param optional integer arrayType Specifies what type of an array to return.
	 * Allowed values are: ASSOC, NUMERIC, and BOTH.
	 * @return array An associative array of the current row.
	 **/
	function next() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Advances the current row position.
	 * Advances the current row position. If there are no more rows left, then
	 * it returns <code>false</code>.
	 * @access public
	 * @return boolean True, if successful; False, otherwise.
	 */ 
	function advanceRow() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	

	/**
	 * Indicates if there are any remaining rows returned by the SELECT query.
	 * Indicates if there are any remaining rows returned by the SELECT query including
	 * the current row.
	 * @access public
	 * @return boolean True, if there are some rows left; False, otherwise.
	 **/
	function hasMoreRows() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

			
	/**
	 * Returns the specified field value in the current row.
	 * Returns the specified field value in the current row.
	 * @param mixed $field The name or index of the field, whose value will be returned.
	 * @access public
	 * @return mixed The value that was requested.
	 **/
	function field($field) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	
	/**
	 * Get the number of fields that were selected by the SELECT query.
	 * Get the number of fields that were selected by the SELECT query.
	 * @access public
	 * @return integer The number of fields.
	 **/
	function getNumberOfFields() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	

	/**
	 * Returns an indexed array of all field names that were selected.
	 * Returns an indexed array of all field names that were selected.
	 * @access public
	 * @return array An array of all field names that were selected.
	 **/
	function getFieldNames() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	
	/**
	 * Returns an array that stores the current row in the result. The data
	 * can be accessed through associative indices <b>as well as</b> numeric indices.
	 * @access public
	 * @param optional integer arrayType Specifies what type of an array to return.
	 * Allowed values are: ASSOC, NUMERIC, and BOTH.
	 * @return array An associative array of the current row.
	 **/
	function getCurrentRow($arrayType = BOTH) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }


	/**
	 * Returns the number of rows that the query processed.
	 * Returns the number of rows that the query processed. For a SELECT query,
	 * this would be the total number of rows selected. For a DELETE, UPDATE, or
	 * INSERT query, this would be the number of rows that were affected.
	 * @access public
	 * @return integer Number of rows that were processed by the query.
	 */ 
	function getNumberOfRows() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	
	
	/**
	 * Moves the internal row pointer to the specified position. The range of
	 * possible values is <code>0 - (getNumberOfRows()-1)</code>.
	 * @param integer rowNumber The number of the row to move to.
	 * @method public moveToRow
	 * @return boolean <code>true</code>, if operation was successful; <code>false</code>, otherwise.
	 */
	function moveToRow($rowNumber) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
	function bindField($field, & $var) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
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
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	

}

?>