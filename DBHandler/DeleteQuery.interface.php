<?php

require_once("Query.abstract.php");

	/**
	 * Defines a constant for 'AND' operations (used in WHERE and JOIN clauses)
	 * @const integer _AND
	 * @package harmoni.dbc
	 */
	define("_AND", 7);
	
	
	/**
	 * Defines a constant for 'OR' operations (used in WHERE and JOIN clauses)
	 * @const integer _OR
	 * @package harmoni.dbc
	 */
	define("_OR", 8);
	
	/**
	 * Defines a constant for 'OR' operations (used in WHERE and JOIN clauses)
	 * @const integer _XOR
	 * @package harmoni.dbc
	 */
	define("_XOR", 9);


/**
 * A DeleteQuery interface provides the tools to build an SQL DELETE query.
 *
 * @version $Id: DeleteQuery.interface.php,v 1.3 2003/07/10 23:04:49 dobomode Exp $
 * @package harmoni.dbc
 * @copyright 2003 
 */

class DeleteQueryInterface extends Query {

	/**
	 * Sets the table to delete from.
	 * @param string $table The table to delete from.
	 * @access public
	 */
	function setTable($table) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Specifies the condition in the WHERE clause.
	 *
	 * The query will execute only on rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string The WHERE clause condition.
	 * @access public
	 * @deprecated July 09, 2003 - Use addWhere() instead.
	 */
	function setWhere($condition) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	
	/**
	 * Adds a new condition in the WHERE clause.
	 * 
	 * The query will execute only on rows that fulfil the condition. If this method
	 * is never called, then the WHERE clause will not be included.
	 * @param string condition The WHERE clause condition to add.
	 * @param integer logicalOperation The logical operation to use to connect
	 * this WHERE condition with the previous WHERE conditions. Allowed values:
	 * <code>_AND</code> , <code>_OR</code> , and <code>_XOR</code>. 
	 * @method public addWhere
	 * @return void 
	 */
	function addWhere($condition, $logicalOperation = _AND) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}


}
?>