<?php

	/**
	 * A constant for an UNKNOWN query type.
 	 * @const UNKNOWN A constant for an UNKNOWN query type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("UNKNOWN", 1);

	/**
	 * A constant for a SELECT query type.
 	 * @const SELECT A constant for a SELECT query type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("SELECT", 1);

	/**
	 * A constant for an UPDATE query type.
 	 * @const UPDATE A constant for an UPDATE query type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("UPDATE", 2);

	/**
	 * A constant for an INSERT query type.
 	 * @const INSERT A constant for an INSERT query type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("INSERT", 3);

	/**
	 * A constant for a DELETE query type.
 	 * @const DELETE A constant for a DELETE query type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("DELETE", 4);

	/**
	 * A constant for a GENERIC query type.
 	 * @const GENERIC A constant for a GENERIC query type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("GENERIC", 5);
	
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
	 * Defines a constant for 'XOR' operations (used in WHERE and JOIN clauses)
	 * @const integer _XOR
	 * @package harmoni.dbc
	 */
	 define("_XOR",9);

/**
 * A generic Query interface to be implemented by all Query objects.
 *
 * @version $Id: Query.interface.php,v 1.3 2004/05/20 20:45:45 nstamato Exp $
 * @package harmoni.dbc
 * @access public
 * @copyright 2003 
 */

class QueryInterface { 

	/**
	 * Resets the query.
	 * @access public
	 */
	function reset() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Returns the type of this query.
	 * Returns the type of this query: SELECT, INSERT, DELETE,
	 * or UPDATE.
	 * @access public
	 * @return integer The type of this query: SELECT, INSERT, DELETE, or UPDATE.
	 */
	function getType() {
	}
	
}

?>