<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DBHandler.interface.php,v 1.9 2005/04/07 16:33:23 adamfranco Exp $
 */

	/**
	 * A constant for the MySQL database type.
	 * @const MYSQL A constant for the MySQL database type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("MYSQL", 1);
	

	/**
	 * A constant for the POSTGRE_SQL database type.
	 * @const POSTGRE_SQL A constant for the POSTGRE_SQL database type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("POSTGRE_SQL", 2);
	

	/**
	 * A constant for the ORACLE database type.
	 * @const ORACLE A constant for the ORACLE database type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("ORACLE", 3);
	

	/**
	 * A constant for the SQLSERVER database type.
	 * @const SQLSERVER A constant for the SQLSERVER database type.
	 * @access public
	 * @package harmoni.dbc
	 */
	define("SQLSERVER", 4);
	
/**
 * A Database Handler interface. The DBHandler is to be loaded at the beginning
 * program executution with configuration settings for the database type, name, 
 * server, user, and password.
 *
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DBHandler.interface.php,v 1.9 2005/04/07 16:33:23 adamfranco Exp $
 */
class DBHandlerInterface { 

	/**
	 * *Deprecated* Creates a new database connection.
	 * @param string $dbType The type of database: MYSQL, POSTGRES, ORACLE, OKI, etc.
	 * @param string $dbHost The hostname for the database, i.e. myserver.mydomain.edu.
	 * @param string $dbName The name of the database.
	 * @param string $dbUser The username with which to connect to the database.
	 * @param string $dbPass The password for $_dbUser with which to connect to the database.
	 * @return mixed $dbIndex The index of the new database, if it was created successfully; False, otherwise.
	 * @deprecated July 20, 2003 - Use addDatabase instead.
	 * @access public
	 */
	function createDatabase($dbType, $dbHost, $dbName, $dbUser, $dbPass) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Adds the specified Database object to the list of databases.
	 * @access public
	 * @param ref object database
	 * @return mixed $dbIndex The index of the new database, if it was created successfully; False, otherwise.
	 */
	function addDatabase(& $database) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Run a database query based on the Query object and return a QueryResult object.
	 * @param object QueryInterface A query object which holds the query to run.
	 * @param integer $dbIndex The index of the database on which to run the query. Default is 0, the database created on handler instantiation.
	 * @return object QueryResultInterface Returns a QueryResult object that impliments QueryResultInterface and corresponds to the DB configuration.
	 * @access public
	 */
	function &query(& $query, $dbIndex=0) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Run a database query for each Query in the Queue and return a Queue of QueryResults.
	 * @param object QueueInterface A queue object which holds the queries to run.
	 * @param integer $dbIndex The index of the database on which to run the query. Default is 0, the database created on handler instantiation.
	 * @return object QueInterface Returns a Queue of QueryResults.
	 * @access public
	 */
	function &queryQueue(& $queue, $dbIndex=0) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Gets the total number of queries that have been run so far.
	 * Gets the total number of queries that have been run so far.
	 * @return integer The number of queries that have run so far.
	 * @access public
	 */
	function getTotalNumberOfQueries() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Gets the total number of queries that have been run successfully so far.
	 * Gets the total number of queries that have been run successfully so far.
	 * @return integer The number of queries that have run successfully so far.
	 * @access public
	 */
	function getTotalNumberOfSuccessfulQueries() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * Gets the total number of queries that have failed so far.
	 * Gets the total number of queries that have failed so far.
	 * @return integer The number of queries that have failed so far.
	 * @access public
	 */
	function getTotalNumberOfFailedQueries() { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Connect to the database.
	 * @param integer $dbIndex The index of the database with which to connect. Default is 0, the database created on handler instantiation.
	 * @return boolean True, if successful; False, otherwise.
	 * @access public
	 */
	function connect($dbIndex = 0) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
	/**
	 * Persistantly connect to the database.
	 * @param integer $dbIndex The index of the database with which to pconnect. Default is 0, the database created on handler instantiation.
	 * @return boolean True, if successful; False, otherwise.
	 * @access public
	 */
	function pConnect($dbIndex = 0) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }

	/**
	 * disconnect from the database.
	 * @param integer $dbIndex The index of the database with which to disconnect. Default is 0, the database created on handler instantiation.
	 * @return boolean True, if successful; False, otherwise.
	 * @access public
	 */
	function disconnect($dbIndex = 0) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }
	
		
	/**
	 * Indicates whether there is an open connection to the database.
	 * Indicates whether there is an open connection to the database.
	 * @access public
	 * @return boolean True, if there is an open connection to the database; False, otherwise.
	 */
	function isConnected($dbIndex = 0) { die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); }


	
	/**
	 * Converts a DateTime object to a proper datetime/timestamp/time representation 
	 * for the specified database object.
	 * @access public
	 * @param ref object dateTime The DateTime object to convert.
	 * @return mixed A proper datetime/timestamp/time representation for this Database.
	 */
	function toDBDate(& $dateTime, $dbIndex = 0) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	
	
	/**
	 * Converts a database datetime/timestamp/time value (that has been fetched
	 * from the db) to a DateTime object.
	 * @access public
	 * @param mixed A database datetime/timestamp/time value (that has been fetched
	 * from the db).
	 * @return ref object The DateTime object.
	 */
	function &fromDBDate($value, $dbIndex = 0) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}
	

}

?>
