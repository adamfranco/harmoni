<?php

	/**
	 * A constant for an UNKNOWN query type.
 	 * @const UNKNOWN A constant for an UNKNOWN query type.
	 * @access public
	 * @package harmoni.dbhandler
	 */
	define("UNKNOWN", 1);

	/**
	 * A constant for a SELECT query type.
 	 * @const SELECT A constant for a SELECT query type.
	 * @access public
	 * @package harmoni.dbhandler
	 */
	define("SELECT", 1);

	/**
	 * A constant for an UPDATE query type.
 	 * @const UPDATE A constant for an UPDATE query type.
	 * @access public
	 * @package harmoni.dbhandler
	 */
	define("UPDATE", 2);

	/**
	 * A constant for an INSERT query type.
 	 * @const INSERT A constant for an INSERT query type.
	 * @access public
	 * @package harmoni.dbhandler
	 */
	define("INSERT", 3);

	/**
	 * A constant for a DELETE query type.
 	 * @const DELETE A constant for a DELETE query type.
	 * @access public
	 * @package harmoni.dbhandler
	 */
	define("DELETE", 4);

/**
 * A generic Query interface to be implemented by all Query objects.
 *
 * @version $Id: Query.interface.php,v 1.2 2003/06/27 13:20:39 gabeschine Exp $
 * @package harmoni.dbhandler
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