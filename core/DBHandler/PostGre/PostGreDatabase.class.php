<?php

require_once(HARMONI."DBHandler/Database.interface.php");
require_once(HARMONI."DBHandler/PostGre/PostGreSelectQueryResult.class.php");
require_once(HARMONI."DBHandler/PostGre/PostGreInsertQueryResult.class.php");
require_once(HARMONI."DBHandler/PostGre/PostGreUpdateQueryResult.class.php");
require_once(HARMONI."DBHandler/PostGre/PostGreDeleteQueryResult.class.php");
require_once(HARMONI."DBHandler/PostGre/PostGre_SQLGenerator.class.php");

/**
 * A PostGreDatabase class provides the tools to connect, query, etc., a PostGre database.
 * A PostGreDatabase class provides the tools to connect, query, etc., a PostGre database.
 * @version $Id: PostGreDatabase.class.php,v 1.2 2004/04/21 17:55:27 adamfranco Exp $
 * @copyright 2003 
 * @package harmoni.dbc.postgre
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
		
		// if query is an insert, do it in a transaction (cause you will need
		// to fetch the last inserted id)
		if ($query->getType() == INSERT && $query->_sequence)
			$this->_query("BEGIN");
		
		
		// attempt to run the query
		$resourceId = $this->_query($queryString);

		// if query was unsuccessful, return a null QueryResult object
		if ($resourceId === false)
			return null;

		// create the appropriate QueryResult object
		switch($query->getType()) {
			case INSERT : {
				// we need to fetch the last inserted id
				// this is only possible if the user has specified the sequence
				// object with the setAutoIncrementColumn() method.
				$lastId = null;
				if ($query->_sequence) {
					$lastIdQuery = "SELECT CURRVAL('".$query->_sequence."')";
					$lastIdResourceId = $this->_query($lastIdQuery);
					$this->_query("COMMIT");
					$arr = pg_fetch_row($lastIdResourceId, 0);
					$lastId = intval($arr[0]);
				}
				
				$result =& new PostGreInsertQueryResult($resourceId, $lastId);
				break;
			}
			case UPDATE : 
				$result =& new PostGreUpdateQueryResult($resourceId);
				break;
			case DELETE : 
				$result =& new PostGreDeleteQueryResult($resourceId);
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
	 * @param mixed query Either a string (this would be the case, normally) or 
	 * an array of strings. Each string is corresponding to an SQL query.
	 * @return mixed For a SELECT statement, a resource identifier, if
	 * successful; For INSERT, DELETE, UPDATE statements, TRUE if successful;
	 * for all: FALSE, if not successful. If <code>$query</code> had several
	 * queries, this would be the result for the last one.
	 */
	function _query($query) {
		// do not attempt to query, if not connected
		if (!$this->isConnected()) {
			throwError(new Error("Attempted to query but there was no database connection.", "DBHandler", true));
			return false;
		}
		
		if (is_array($query))
		    $queries = $query;
		else if (is_string($query))
		    $queries = array($query);
		
		$count = count($queries);
		     
		// if more than one queries - do them in a transaction
		if ($count > 1)
			$this->_query("BEGIN");
		
		foreach ($queries as $q) {
			// attempt to execute the query
			$resourceId = pg_query($this->_linkId, $q);
		
			if ($resourceId === false) {
			    $this->_failedQueries++;
				throwError(new Error(pg_last_error($this->_linkId), "DBHandler", false));
			}
			else
			    $this->_successfulQueries++;
		}
		
		if ($count > 1)
			$this->_query("COMMIT");

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

	
	
	/**
	 * Converts a DateTime object to a proper datetime/timestamp/time representation 
	 * for this Database.
	 * @method public toDBDate
	 * @param ref object dateTime The DateTime object to convert.
	 * @return mixed A proper datetime/timestamp/time representation for this Database.
	 */
	function toDBDate(& $dateTime) {
		/**
		 * The easiest way to convert is to create a string in the following 
		 * format: 
		 * 'YYYY-MM-DD HH:MM:SS', i.e. 1999-01-08 04:05:06
		 * You can pass this to a PostGre date or timestamp column types
		 * and it gets parsed automatically by PostGre.
		 */
		$string = sprintf("%s-%02d-%02d %02d:%02d:%02d",$dateTime->getYear(),
							$dateTime->getMonth(), $dateTime->getDay(),
							$dateTime->getHours(), $dateTime->getMinutes(),
							$dateTime->getSeconds());
		return $string;
	}
	
	
	/**
	 * Converts a database datetime/timestamp/time value (that has been fetched
	 * from the db) to a DateTime object.
	 * @method public fromDBDate
	 * @param mixed A database datetime/timestamp/time value (that has been fetched
	 * from the db).
	 * @return ref object The DateTime object.
	 */
	function & fromDBDate($value) {
		/**
		 * Depending on the server configuration PostGre retrieves date/time
		 * types as 4 different formats. (format could be set with SET DateStyle
		 * ). The default formatting is 'ISO'. Note that timestamp column types 
		 * return the full string. Date column types only return the date (no time).
		 *
		 * Style 			Description 						Example 
		 * 'ISO' 			ISO-8601 standard 			1997-12-17 07:37:16-08 
		 * 'SQL' 			Traditional style 		12/17/1997 07:37:16.00 PST 
		 * 'PostgreSQL' 	Original style 			Wed Dec 17 07:37:16 1997 PST 
		 * 'German' 		Regional style 			17.12.1997 07:37:16.00 PST 
		 * 
		 * Parse with regular expressions, create and return the appropriate
		 * DateTime object.
		 */
		if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})-([0-9]{2})",$value,$r))
		 	return new DateTime($r[1],$r[2],$r[3],$r[4],$r[5],$r[6]); // ISO
		if (ereg("([0-9]{2})/([0-9]{2})/([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2}).([0-9]{2}) ...",$value,$r))
		 	return new DateTime($r[3],$r[1],$r[2],$r[4],$r[5],$r[6]); // SQL
		if (ereg("(...) (...) ([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2}) ([0-9]{4})",$value,$r)) {
		 	$months = array("Jan"=>1,"Feb"=>2,"Mar"=>3,"Apr"=>4,"May"=>5,"Jun"=>6,"Jul"=>7,
							"Aug"=>8,"Sep"=>9,"Oct"=>10,"Nov"=>11,"Dec"=>12);
			return new DateTime($r[7],$months[$r[2]],$r[3],$r[4],$r[5],$r[6]); // Postgre
		}
		if (ereg("([0-9]{2})\.([0-9]{2})\.([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2}).([0-9]{2}) ...",$value,$r))
		 	return new DateTime($r[3],$r[2],$r[1],$r[4],$r[5],$r[6]); // German
	}
	
	
}

?>