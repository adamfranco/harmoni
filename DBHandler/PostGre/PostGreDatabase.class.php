<?php

require_once(HARMONI."DBHandler/Database.interface.php");
//require_once(HARMONI."DBHandler/PostGre/PostGreSelectQueryResult.class.php");
require_once(HARMONI."DBHandler/PostGre/PostGreInsertQueryResult.class.php");
//require_once(HARMONI."DBHandler/PostGre/PostGreUpdateQueryResult.class.php");
//require_once(HARMONI."DBHandler/PostGre/PostGreDeleteQueryResult.class.php");
require_once(HARMONI."DBHandler/PostGre/PostGre_SQLGenerator.class.php");

/**
 * A PostGreDatabase class provides the tools to connect, query, etc., a PostGre database.
 * A PostGreDatabase class provides the tools to connect, query, etc., a PostGre database.
 * @version $Id: PostGreDatabase.class.php,v 1.1 2003/07/16 02:55:58 dobomode Exp $
 * @copyright 2003 
 * @package harmoni.dbc
 * @access public
 **/
 
class PostGreDatabase extends DatabaseInterface {

	/**
	 * The hostname of the database, i.e. myserver.mydomain.edu.
	 * The hostname of the database, i.e. myserver.mydomain.edu.
	 * @var string $_dbHost The hostname of the database, i.e. myserver.mydomain.edu.
	 * @access private
	 */
	var $_dbHost;
	
	/**
	 * The name of the default database to use.
	 * The name of the default database to use.
	 * @var string $_dbName The name of the default database to use.
	 * @access private
	 */
	var $_dbName;
	
	/**
	 * The username with which to connect to the database.
	 * The username with which to connect to the database.
	 * @var string $_dbUser The username with which to connect to the database.
	 * @access private
	 */
	var $_dbUser;
	
	/**
	 * The password for $_dbUser with which to connect to the database.
	 * The password for $_dbUser with which to connect to the database.
	 * @var string $_dbPass The password for $_dbUser with which to connect to the database.
	 * @access private
	 */
	var $_dbPass;
	
	/**
	 * Stores the current connection's link identifier.
	 * If a connection is open, this stores the connection's identifier. Otherwise,
	 * it stores FALSE.
	 * @var mixed $_linkId If a connection is open, this stores the connection's identifier. Otherwise,
	 * it stores FALSE.
	 * @access private
	 */ 
	var $_linkId;
	
	
	/**
	 * The total number of successful queries executed since the last call to connect().
	 * The total number of failed queries executed since the last call to connect().
	 * @var integer $_successfulQueries The total number of failed queries executed since the last call to connect().
	 * @access private
	 */ 
	var $_successfulQueries;
	
	
	/**
	 * The total number of failed queries executed since the last call to connect().
	 * The total number of failed queries executed since the last call to connect().
	 * @var integer $_failedQueries The total number of failed queries executed since the last call to connect().
	 * @access private
	 */ 
	var $_failedQueries;
	

	/**
	 * Creates a new database connection.
	 * @param string $dbHost The hostname for the database, i.e. myserver.mydomain.edu.
	 * @param string $dbName The name of the default database to use.
	 * @param string $dbUser The username with which to connect to the database.
	 * @param string $dbPass The password for $_dbUser with which to connect to the database.
	 * @return integer $dbIndex The index of the new database
	 * @access public
	 */
	function PostGreDatabase($dbHost, $dbName, $dbUser, $dbPass) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($dbHost, $stringRule, true);
		ArgumentValidator::validate($dbName, $stringRule, true);
		ArgumentValidator::validate($dbUser, $stringRule, true);
		ArgumentValidator::validate($dbPass, $stringRule, true);
		// ** end of parameter validation

		$this->_dbHost = $dbHost;
		$this->_dbName = $dbName;
		$this->_dbUser = $dbUser;
		$this->_dbPass = $dbPass;
	    $this->_linkId = false;
	    $this->_successfulQueries = 0;
	    $this->_failedQueries = 0;
	}


	/**
	 * Connects to the database.
	 * Connects to the database.
	 * @access public
	 * @return mixed The connection's link identifier, if successful; False, otherwise.
	 */
	function connect() {
		// if connected, need to disconnect first
		if ($this->isConnected()) 
			return false;
			
		// attempt to connect
		$conStr = "";
		$conStr .= " host = ".$this->_dbHost;
		$conStr .= " user = ".$this->_dbUser;
		$conStr .= " password = ".$this->_dbPass;
		$conStr .= " dbname = ".$this->_dbName;
		
		$linkId = pg_connect($conStr);
		
		// see if successful
		if ($linkId) {
			// reset the query counters
		    $this->_successfulQueries = 0;
		    $this->_failedQueries = 0;
		
		    $this->_linkId = $linkId;
			return $linkId;
		}
		else {
			throwError(new Error("Cannot connect to database.", "DBHandler", false));
		    $this->_linkId = false;
			return false;						
		}
	}

	
	/**
	 * Makes a persistent database connection.
	 * Makes a persistent database connection.
	 * @access public
	 * @return mixed The connection's link identifier, if successful; False, otherwise.
	 */
	function pConnect() {
		// if connected, need to disconnect first
		if ($this->isConnected()) 
			return false;
			
		// attempt to connect
		$conStr = "";
		$conStr .= " host = ".$this->_dbHost;
		$conStr .= " user = ".$this->_dbUser;
		$conStr .= " password = ".$this->_dbPass;
		$conStr .= " dbname = ".$this->_dbName;
		
		$linkId = pg_pconnect($conStr);
		
		// see if successful
		if ($linkId) {
			// reset the query counters
		    $this->_successfulQueries = 0;
		    $this->_failedQueries = 0;
		
		    $this->_linkId = $linkId;
			return $linkId;
		}
		else {
			throwError(new Error("Cannot connect to database.", "DBHandler", false));
		    $this->_linkId = false;
			return false;						
		}

	}


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
	function & query(& $query) {
		// do not attempt, to query, if not connected
		if (!$this->isConnected()) {
			throwError(new Error("Attempted to query but there was no database connection.", "DBHandler", true));
			return false;
		}
			
		// generate the SQL query string
		$queryString = PostGre_SQLGenerator::generateSQLQuery($query);
		
		// attempt to run the query
		$resourceId = $this->_query($queryString);

		// if query was unsuccessful, return a null QueryResult object
		if ($resourceId === false)
			return null;

		// create the appropriate QueryResult object
		switch($query->getType()) {
			case INSERT : 
				$result =& new PostGreInsertQueryResult($this->_resourceId);
				break;
			case UPDATE : 
				$result =& new PostGreUpdateQueryResult($this->_resourceId);
				break;
			case DELETE : 
				$result =& new PostGreDeleteQueryResult($this->_resourceId);
				break;
			case SELECT : 
				$result =& new PostGreSelectQueryResult($resourceId, $this->_linkId);
				break;
			default:
				throwError(new Error("Unsupported query type.", "DBHandler", true));
		} // switch
		
		return $result;
	}
	



	/**
	 * Executes an SQL query.
	 * Executes an SQL query.
	 * @access private
	 * @param string The SQL query string.
	 * @return mixed For a SELECT statement, a resource identifier, if
	 * successful; For INSERT, DELETE, UPDATE statements, TRUE if successful;
	 * for all: FALSE, if not successful.
	 */
	function _query($query) {
		// do not attempt to query, if not connected
		if (!$this->isConnected()) {
			throwError(new Error("Attempted to query but there was no database connection.", "DBHandler", true));
			return false;
		}
			
		// attempt to execute the query
		$resourceId = pg_query($this->_linkId, $query);
		
		if ($resourceId === false) {
		    $this->_failedQueries++;
			throwError(new Error(pg_last_error($this->_linkId), "DBHandler", false));
		}
		else
		    $this->_successfulQueries++;
		
		return $resourceId;
	}



	/**
	 * Disconnects from the database.
	 * Disconnects from the database.
	 * @access public
	 * @return boolean True, if successful; False, otherwise.
	 */
	function disconnect() {
		// do not disconnect, if not connected
		if (!$this->isConnected())
			return false;
			
		// attempt to disconnect
		$isSuccessful = pg_close($this->_linkId);
		if ($isSuccessful)
			$this->_linkId = false;
		
		return $isSuccessful;
	}


	
	/**
	 * Indicates whether there is an open connection to the database.
	 * Indicates whether there is an open connection to the database.
	 * @access public
	 * @return boolean True if there is an open connection to the database; False, otherwise.
	 */
	function isConnected() {
		$isConnected = ($this->_linkId !== false);
		return $isConnected;
	}




	
	/**
	 * Returns the total number of successful queries executed since the last call to connect().
	 * Returns the total number of successful queries executed since the last call to connect().
	 * @access public
	 * @return integer The total number of successful queries executed since the last call to connect().
	 **/
	function getNumberSuccessfulQueries() {
		return $this->_successfulQueries;
	}
	
	
	
	/**
	 * Returns the total number of failed queries executed since the last call to connect().
	 * Returns the total number of failed queries executed since the last call to connect().
	 * @access public
	 * @return integer The total number of failed queries executed since the last call to connect().
	 **/
	function getNumberFailedQueries() {
		return $this->_failedQueries;
	}

	
	
	/**
	 * This method selects the default database to use in queries.
	 * @method public selectDatabase
	 * @param string database The name of the default database.
	 * @return boolean True, if successful; False, otherwise.
	 */
	function selectDatabase($database) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		ArgumentValidator::validate($database, $stringRule, true);
		// ** end of parameter validation
		
		$this->disconnect();
	
		$conStr = "";
		$conStr .= " host = ".$this->_dbHost;
		$conStr .= " user = ".$this->_dbUser;
		$conStr .= " password = ".$this->_dbPass;
		$conStr .= " dbname = ".$database;
		
		$linkId = pg_pconnect($conStr);
		
		// see if successful
		if ($linkId) {
		    $this->_linkId = $linkId;
			return true;
		}
		else {
			throwError(new Error("Cannot connect to database.", "DBHandler", false));
		    $this->_linkId = false;
			return false;						
		}
	}

}

?>