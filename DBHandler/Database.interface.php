<?php

/**
 * A Database interface provides generic database functionality: connect(), executeQuery(), etc.
 * A Database interface provides generic database functionality: connect(), executeQuery(), etc.
 * The interface can be implemented for different types of databases: MySQL, Oracle, SQLServer, etc.
 * @version $Id: Database.interface.php,v 1.5 2003/07/16 02:55:57 dobomode Exp $
 * @copyright 2003 
 * @package harmoni.dbc
 * @access public
 **/
 
class DatabaseInterface {

	/**
	 * Connects to the database.
	 * Connects to the database.
	 * @access public
	 * @return mixed The connection's link identifier, if successful; False, otherwise.
	 */
	function connect() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	
	/**
	 * Makes a persistent database connection.
	 * Makes a persistent database connection.
	 * @access public
	 * @return mixed The connection's link identifier, if successful; False, otherwise.
	 */
	function pConnect() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }


	/**
	 * Executes an SQL query.
	 * Executes an SQL query. The method is passed a query object, which it
	 * converts to a SQL query string using the appropriate SQLGenerator
	 * object.
	 * @access public
	 * @param object Query $query A Query object from which the SQL query will be constructed.
	 * @return mixed The appropriate QueryResult object. If the query failed, it would
	 * return NULL.
	 */
	function query($query) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }


	/**
	 * Executes an SQL query.
	 * Executes an SQL query.
	 * @access private
	 * @param string The SQL query string.
	 * @return mixed For a SELECT statement, a resource identifier, if
	 * successful; For INSERT, DELETE, UPDATE statements, TRUE if successful;
	 * for all: FALSE, if not successful. FALSE will be returned if not
	 * connected to the database.
	 */
	function _query($query) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	

	/**
	 * Disconnects from the database.
	 * Disconnects from the database.
	 * @access public
	 * @return boolean True, if successful; False, otherwise.
	 */
	function disconnect() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Indicates whether there is an open connection to the database.
	 * Indicates whether there is an open connection to the database.
	 * @access public
	 * @return boolean True, if there is an open connection to the database; False, otherwise.
	 */
	function isConnected() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }


	
	/**
	 * Returns the total number of successful queries executed since the last call to connect().
	 * Returns the total number of successful queries executed since the last call to connect().
	 * @access public
	 * @return integer The total number of successful queries executed since the last call to connect().
	 **/
	function getNumberSuccessfulQueries() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	
	
	/**
	 * Returns the total number of failed queries executed since the last call to connect().
	 * Returns the total number of failed queries executed since the last call to connect().
	 * @access public
	 * @return integer The total number of failed queries executed since the last call to connect().
	 **/
	function getNumberFailedQueries() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	
	/**
	 * This method selects the default database to use in queries.
	 * @method public selectDatabase
	 * @param string database The name of the default database.
	 * @return boolean True, if successful; False, otherwise.
	 */
	function selectDatabase($database) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
}

?>