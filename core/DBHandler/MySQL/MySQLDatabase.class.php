<?php
/**
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLDatabase.class.php,v 1.22 2005/04/07 16:33:24 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/Database.interface.php");
require_once(HARMONI."DBHandler/MySQL/MySQLSelectQueryResult.class.php");
require_once(HARMONI."DBHandler/MySQL/MySQLInsertQueryResult.class.php");
require_once(HARMONI."DBHandler/MySQL/MySQLUpdateQueryResult.class.php");
require_once(HARMONI."DBHandler/MySQL/MySQLDeleteQueryResult.class.php");
require_once(HARMONI."DBHandler/MySQL/MySQLGenericQueryResult.class.php");
require_once(HARMONI."DBHandler/MySQL/MySQL_SQLGenerator.class.php");

/**
 * A MySQLDatabase class provides the tools to connect, query, etc., a MySQL database.
 * MySQL (at least as of 4.0.17) does not support nested
 * transations. Begining a transaction after one is started will commit the
 * previous transaction. This is pretty stupid behavior, so this class maintains
 * a count of begin and commit calls and only runs the outer begin/commit/rollback
 * statements. This allows applications coded for PostgreSQL/Oracle-style nested
 * transactions to operate in MySQL. 
 *
 *
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLDatabase.class.php,v 1.22 2005/04/07 16:33:24 adamfranco Exp $
 */
 
class MySQLDatabase extends DatabaseInterface {

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
	function MySQLDatabase($dbHost, $dbName, $dbUser, $dbPass) {
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
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
	    $this->_startedTransactions = 0;
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
		$linkId = mysql_connect($this->_dbHost, $this->_dbUser, $this->_dbPass);
		
		// see if successful
		if ($linkId) {
			// reset the query counters
		    $this->_successfulQueries = 0;
		    $this->_failedQueries = 0;
		
			// attempt to select the default database;
			// if failure, not a big deal, because at this point we are connected
			mysql_select_db($this->_dbName, $linkId)  || throwError(new Error("Cannot select database, ".$this->_dbName." : ".mysql_error($this->_linkId), "DBHandler", true));

		    $this->_linkId = $linkId;
			return $linkId;
		}
		else {
			throwError(new Error("Cannot connect to database.", "DBHandler", true));
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
		// if connected, attempt to reconnect
		if ($this->isConnected()) $this->disconnect();
		
		// attempt to connect
		$linkId = mysql_pconnect($this->_dbHost, $this->_dbUser, $this->_dbPass);
		
		// see if successful
		if ($linkId) {
			// reset the query counters
		    $this->_successfulQueries = 0;
		    $this->_failedQueries = 0;

			// attempt to select the default database;
			// if failure, not a big deal, because at this point we are connected
			mysql_select_db($this->_dbName, $linkId) || throwError(new Error("Cannot select database, ".$this->_dbName." : ".mysql_error($this->_linkId), "DBHandler", true));

		    $this->_linkId = $linkId;
			return $linkId;
		}
		else {
			throwError(new Error("Cannot connect to database: ".mysql_error($this->_linkId), "DBHandler", true));
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
	function &query(& $query) {
//		static $time = 0;
	
		// do not attempt, to query, if not connected
		if (!$this->isConnected()) {
			throwError(new Error("Attempted to query but there was no database connection.", "DBHandler", true));
			return false;
		}
			
		// generate the SQL query string
//		$t =& new Timer();
//		$t->start();
		$queryString = MySQL_SQLGenerator::generateSQLQuery($query);
//		$t->end();
//		$time += $t->printTime();
//		echo $time;
//		echo "<br /> : ";

		// attempt to run the query
		$resourceId = $this->_query($queryString);

		// if query was unsuccessful, return a null QueryResult object
//		if ($resourceId === false)
//			throwError( new Error("The query had errors: \n".$queryString, "DBHandler", true));
//
		// create the appropriate QueryResult object
		switch($query->getType()) {
			case INSERT : 
				$result =& new MySQLInsertQueryResult($this->_linkId);
				break;
			case UPDATE : 
				$result =& new MySQLUpdateQueryResult($this->_linkId);
				break;
			case DELETE : 
				$result =& new MySQLDeleteQueryResult($this->_linkId);
				break;
			case SELECT : 
				$result =& new MySQLSelectQueryResult($resourceId, $this->_linkId);
				break;
			case GENERIC : 
				$result =& new MySQLGenericQueryResult($resourceId, $this->_linkId);
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
		
		if (is_array($query))
		    $queries = $query;
		else if (is_string($query))
		    $queries = array($query);
		     
		foreach ($queries as $q) {
			// attempt to execute the query
			$resourceId = mysql_query($q, $this->_linkId);
			
			debug::output("<pre>Query: <div>".$query."</div>Result: $resourceId</pre>", 1, "DBHandler");
		
			if ($resourceId === false) {
			    $this->_failedQueries++;
				throwError(new Error("MySQL Error: ".mysql_error($this->_linkId), "DBHandler", true));
			}
			else
			    $this->_successfulQueries++;
		}
		
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
		$isSuccessful = mysql_close($this->_linkId);
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
	 * @access public
	 * @param string database The name of the default database.
	 * @return boolean True, if successful; False, otherwise.
	 */
	function selectDatabase($database) {
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
		ArgumentValidator::validate($database, $stringRule, true);
		// ** end of parameter validation
	
		$this->_dbName = $database;
		return mysql_select_db($database, $this->_linkId);
	}


	
	
	/**
	 * Converts a DateTime object to a proper datetime/timestamp/time representation 
	 * for this Database.
	 * @access public
	 * @param ref object dateTime The DateTime object to convert.
	 * @return mixed A proper datetime/timestamp/time representation for this Database.
	 */
	function toDBDate(& $dateTime) {
		/**
		 * The easiest way to convert is to create an integer (or a string,
		 * choose which one you think is better, MySQL accepts both, but make
		 * sure to document) in the following format: YYYYMMDDHHMMSS.
		 * You can pass this to a MySQL datetime or timestamp column types
		 * and it gets parsed automatically by MySQL.
		 */
		$string = sprintf("%s%02d%02d%02d%02d%02d",$dateTime->getYear(),
							$dateTime->getMonth(), $dateTime->getDay(),
							$dateTime->getHours(), $dateTime->getMinutes(),
							$dateTime->getSeconds());
		return $string;
	}
	
	
	/**
	 * Converts a database datetime/timestamp/time value (that has been fetched
	 * from the db) to a DateTime object.
	 * @access public
	 * @param mixed A database datetime/timestamp/time value (that has been fetched
	 * from the db).
	 * @return ref object The DateTime object.
	 */
	function &fromDBDate($value) {
		/**
		 * Depending whether the value was fecthed from a datetime, date or 
		 * timestamp column, $value could have the following two formats:
		 * 'YYYY-MM-DD HH:MM:SS' for datetime
		 * 'YYYY-MM-DD' for date
		 * For a timestamp, $value could be any of the following depending on
		 * the column size.
		 * TIMESTAMP(14)  YYYYMMDDHHMMSS  
		 * TIMESTAMP(12)  YYMMDDHHMMSS  
		 * TIMESTAMP(10)  YYMMDDHHMM  
		 * TIMESTAMP(8)  YYYYMMDD  
		 * TIMESTAMP(6)  YYMMDD  
		 * TIMESTAMP(4)  YYMM  
		 * TIMESTAMP(2)  YY  
		 * (Warning: From MySQL version 4.1, TIMESTAMP is returned as 
		 * a string with the format 'YYYY-MM-DD HH:MM:SS' and different timestamp 
		 * lengths are no longer supported.)
		 *
		 * Parse with regular expressions, create and return the appropriate
		 * DateTime object.
		 */
		if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})",$value,$r))
		 	return new DateTime($r[1],$r[2],$r[3],$r[4],$r[5],$r[6]);
		if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})",$value,$r))
		 	return new DateTime($r[1],$r[2],$r[3]);
		if (ereg("([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})",$value,$r))
		 	return new DateTime($r[1],$r[2],$r[3],$r[4],$r[5],$r[6]);
		if (ereg("([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})",$value,$r))
		 	return new DateTime($r[1],$r[2],$r[3],$r[4],$r[5],$r[6]);
		if (ereg("([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})",$value,$r))
		 	return new DateTime($r[1],$r[2],$r[3],$r[4],$r[5]);
		if (ereg("([0-9]{4})([0-9]{2})([0-9]{2})",$value,$r))
		 	return new DateTime($r[1],$r[2],$r[3]);
		if (ereg("([0-9]{2})([0-9]{2})([0-9]{2})",$value,$r))
		 	return new DateTime($r[1],$r[2],$r[3]);
		if (ereg("([0-9]{2})([0-9]{2})",$value,$r))
		 	return new DateTime($r[1],$r[2]);
		if (ereg("([0-9]{2})",$value,$r))
		 	return new DateTime($r[1]);
	}
	
	/**
	 * Return TRUE if this database supports transactions.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/9/05
	 */
	function supportsTransactions () {
		if ($this->_supportsTransactions === NULL) {
			$versionString = mysql_get_server_info($this->_linkId);
			if(!preg_match("^([0-9]+).([0-9]+).([0-9]+)", $versionString, $matches))
				$this->_supportsTransactions = FALSE;
			else {
				$primaryVersion = $matches[1];
				$secondaryVersion = $matches[2];
				$terciaryVersion = $matches[3];
				
				if ($primaryVersion >= 4
					&& ($secondaryVersion > 0
						|| $terciaryVersion >= 11))
				{
					$this->_supportsTransactions = TRUE;
				} else {
					$this->_supportsTransactions = FALSE;
				}
			}
		}
		
		return $this->_supportsTransactions;
	}
	
	/**
	 * Begin a transaction. 
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function beginTransaction () {
		if ($this->_startedTransactions < 0 )
			throwError(new Error("Error: Negative number of BEGIN statements.", "DBHandler", true));

		if ($this->supportsTransactions()
			&& $this->_startedTransactions == 0) 
		{
			$this->_query("START TRANSACTION");
		}
		
		$this->_startedTransactions++;
	}
	
	/**
	 * Commit a transaction. This will roll-back changes if errors occured in the
	 * transaction block.
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function commitTransaction () {
		if ($this->_startedTransactions < 1 )
			throwError(new Error("Error: More COMMIT/ROLLBACK statements than BEGIN statements.", "DBHandler", true));
		
		if ($this->supportsTransactions()
			&& $this->_startedTransactions == 1) 
		{
			$this->_query("COMMIT");
		}
		
		$this->_startedTransactions--;
	}
	
	/**
	 * Roll-back a transaction manually instead of committing
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function rollbackTransaction () {
		if ($this->_startedTransactions < 1 )
			throwError(new Error("Error: More COMMIT/ROLLBACK statements than BEGIN statements.", "DBHandler", true));
		
		if ($this->supportsTransactions()) {
		
			// Roll-back first, to undo changes.
			$this->_query("ROLLBACK");
						
			// If rollback is called inside a nested set of transactions, then the
			// resulting state of the the database is undefined. 
			if ($this->_startedTransactions > 1) {
				throwError(new Error("Error: Unsuported attempt to roll-back a nested transaction. Nested transaction support for MySQL removes all but the outside begin/commit/rollback statements. Rolling-back from an interior transaction would leave the database in an undefined state.", "DBHandler", true));
			}
		}
		
		$this->_startedTransactions--;
	}
}

?>