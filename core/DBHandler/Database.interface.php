<?php

/**
 * A Database interface provides generic database functionality: connect(), executeQuery(), etc.
 * The interface can be implemented for different types of databases: MySQL, Oracle, SQLServer, etc.
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Database.interface.php,v 1.11 2007/09/05 21:38:59 adamfranco Exp $
 */
 
interface Database {

	/**
	 * Connects to the database.
	 * Connects to the database.
	 * @access public
	 * @return mixed The connection's link identifier, if successful; False, otherwise.
	 */
	function connect();

	
	/**
	 * Makes a persistent database connection.
	 * Makes a persistent database connection.
	 * @access public
	 * @return mixed The connection's link identifier, if successful; False, otherwise.
	 */
	function pConnect();


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
	function query(Query $query);


	/**
	 * Disconnects from the database.
	 * Disconnects from the database.
	 * @access public
	 * @return boolean True, if successful; False, otherwise.
	 */
	function disconnect();
	
	/**
	 * Indicates whether there is an open connection to the database.
	 * Indicates whether there is an open connection to the database.
	 * @access public
	 * @return boolean True, if there is an open connection to the database; False, otherwise.
	 */
	function isConnected();

	/**
	 * Returns a list of the tables that exist in the currently connected database.
	 * @return array
	 * @access public
	 */
	function getTableList();
	
	/**
	 * Returns the total number of successful queries executed since the last call to connect().
	 * Returns the total number of successful queries executed since the last call to connect().
	 * @access public
	 * @return integer The total number of successful queries executed since the last call to connect().
	 **/
	function getNumberSuccessfulQueries();
	
	
	
	/**
	 * Returns the total number of failed queries executed since the last call to connect().
	 * Returns the total number of failed queries executed since the last call to connect().
	 * @access public
	 * @return integer The total number of failed queries executed since the last call to connect().
	 **/
	function getNumberFailedQueries();
	
	
	/**
	 * This method selects the default database to use in queries.
	 * @access public
	 * @param string database The name of the default database.
	 * @return boolean True, if successful; False, otherwise.
	 */
	function selectDatabase($database);
	
	/**
	 * Converts a DateAndTime object to a proper datetime/timestamp/time representation 
	 * for this Database. This function must return a string including quotes if necessary
	 * for this specific database type.
	 * @access public
	 * @param ref object DateAndTime The DateAndTime object to convert.
	 * @return mixed A proper datetime/timestamp/time representation for this Database.
	 */
	function toDBDate(DateAndTime $dateAndTime);
	
	/**
	 * Converts a database datetime/timestamp/time value (that has been fetched
	 * from the db) to a DateAndTime object.
	 * @access public
	 * @param mixed A database datetime/timestamp/time value (that has been fetched
	 * from the db).
	 * @return ref object The DateAndTime object.
	 */
	function fromDBDate($value);
	
	/**
	 * Return TRUE if this database supports transactions.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/9/05
	 */
	function supportsTransactions ();
	
	/**
	 * Begin a transaction.
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function beginTransaction ();
	
	/**
	 * Commit a transaction. This will roll-back changes if errors occured in the
	 * transaction block.
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function commitTransaction ();
	
	/**
	 * Roll-back a transaction manually instead of committing
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function rollbackTransaction ();
	
	/**
	 * Returns a short string name for this database type. Example: 'MySQL'
	 * @access public
	 * @return string
	 */
	function getStringName();
	
	/**
	 * Answer the info to display to users on a connection error.
	 * 
	 * @return string
	 * @access public
	 * @since 6/1/06
	 */
	function getConnectionErrorInfo ();
}


/**
 * This is the root exception for all database exceptions.
 * 
 * @since 9/5/07
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Database.interface.php,v 1.11 2007/09/05 21:38:59 adamfranco Exp $
 */
class DatabaseException
	extends HarmoniException
{
}

/**
 * This is an exception thrown for connection problems.
 * 
 * @since 9/5/07
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Database.interface.php,v 1.11 2007/09/05 21:38:59 adamfranco Exp $
 */
class ConnectionDatabaseException
	extends DatabaseException
{

}

/**
 * This is an exception thrown in response to errors in transaction usage.
 * 
 * @since 9/5/07
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Database.interface.php,v 1.11 2007/09/05 21:38:59 adamfranco Exp $
 */
class TransactionDatabaseException
	extends DatabaseException
{

}

/**
 * This is an exception thrown in response to an error that occurs in query execution.
 * 
 * @since 9/5/07
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Database.interface.php,v 1.11 2007/09/05 21:38:59 adamfranco Exp $
 */
class QueryDatabaseException
	extends DatabaseException
{

}

/**
 * This is an exception thrown when the query size exceeds the maximum that 
 * can be sent to the server.
 * 
 * @since 9/5/07
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Database.interface.php,v 1.11 2007/09/05 21:38:59 adamfranco Exp $
 */
class QuerySizeDatabaseException
	extends QueryDatabaseException
{

}

/**
 * This exception is thrown when an insert or update query causes a duplicate-key
 * error. As these often to not cause data inconsistancies, they can often be
 * caught and ignored.
 * 
 * @since 9/5/07
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2007, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: Database.interface.php,v 1.11 2007/09/05 21:38:59 adamfranco Exp $
 */
class DuplucateKeyDatabaseException
	extends DatabaseException
{

}

?>