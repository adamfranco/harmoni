<?php

require_once(HARMONI."DBHandler/DeleteQuery.interface.php");

/**
 * A DeleteQuery class provides the tools to build a DELETE query.
 * 
 * A DeleteQuery class provides the tools to build a DELETE query.
 * @version $Id: DeleteQuery.class.php,v 1.4 2003/07/10 02:34:19 gabeschine Exp $
 * @package harmoni.dbc
 * @copyright 2003 
 */

class DeleteQuery extends DeleteQueryInterface {


	/**
	 * @var string $_table The name of the table to update.
	 * @access private
	 */
	var $_table;


	/**
	 * @var string $_condition This will store the condition in the WHERE clause.
	 * @access private
	 */
	var $_condition;


	/**
	 * This is the constructor for a DELETE query.
	 * This is the constructor for a DELETE query.
	 * @access public
	 */
	function DeleteQuery() {
		$this->reset();
	}


	/**
	 * Sets the table to delete from.
	 * @param string $table The table to delete from.
	 * @access public
	 */
	function setTable($table) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($table, $stringRule, true);
		// ** end of parameter validation

		$this->_table = $table;
	}


	/**
	 * Specifies the condition in the WHERE clause.
	 *
	 * The query will execute only on rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string $condition The WHERE clause condition.
	 * @access public
	 */
	function setWhere($condition) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($condition, $stringRule, true);
		// ** end of parameter validation

		$this->_condition = $condition;
	}


	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() {
		parent::reset();

		// a DELETE query
		$this->_type = DELETE;
		
		// default query configuration:
		
		// no table to delete from
		$this->_table = "";

		// no WHERE condition, by default
		$this->_condition = "";
	}

}
?>