<?php
/**
 * @package harmoni.dbc.mysql
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: MySQLDatabase.class.php,v 1.38 2008/01/04 19:57:09 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/Database.abstract.php");
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
 * @version $Id: MySQLDatabase.class.php,v 1.38 2008/01/04 19:57:09 adamfranco Exp $
 */
 
class MySQLDatabase 
	extends DatabaseAbstract 
{

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
	 * Persistant connections can not be closed or have a new link forced, so
	 * this property is necessary for determining whether or not a mysql_select_db()
	 * is needed before queries to ensure that the proper database is selected.
	 * 
	 * @var boolean $_isConnectionPersistant; 
	 * @access private
	 * @since 8/18/05
	 */
	var $_isConnectionPersistant;
	
	
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
	 * TRUE if this database supports transactions.
	 * @var boolean $_supportsTransactions
	 * @access private
	 */
	var $_supportsTransactions = null;

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
		$stringRule = StringValidatorRule::getRule();
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
	    $this->_isConnectionPersistant = NULL;
	    $this->_successfulQueries = 0;
	    $this->_failedQueries = 0;
	    $this->_startedTransactions = 0;
	}
	
	/**
	 * Returns a short string name for this database type. Example: 'MySQL'
	 * @access public
	 * @return string
	 */
	function getStringName() {
		return "MySQL";
	}

	/**
	 * Returns a list of the tables that exist in the currently connected database.
	 * @return array
	 * @access public
	 */
	function getTableList() {
		$query = new GenericSQLQuery();
		$query->addSQLQuery("SHOW TABLES");
		$r =$this->query($query);
		$res =$r->returnAsSelectQueryResult();
		
		$list = array();
		while($res->hasMoreRows()) {
			$list[] = $res->field(0);
			$res->advanceRow();
		}
		
		$res->free();

		return $list;
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
		// The final TRUE parameter forces a new connection, preventing the need
		// for calling mysql_select_db() before every query to ensure the proper
		// database is selected
		$linkId = mysql_connect($this->_dbHost, $this->_dbUser, $this->_dbPass, true);
		$this->_isConnectionPersistant = false;
		
		// see if successful
		if ($linkId) {
			// reset the query counters
		    $this->_successfulQueries = 0;
		    $this->_failedQueries = 0;
		
			// attempt to select the default database;
			// if failure, not a big deal, because at this point we are connected
			if (!mysql_select_db($this->_dbName, $linkId))
				throw new ConnectionDatabaseException($this->getConnectionErrorInfo()."Cannot select database, ".$this->_dbName." : ".mysql_error($linkId));

		    $this->_linkId = $linkId;
			return $linkId;
		}
		else {
			$this->_linkId = false;
			
			throw new ConnectionDatabaseException($this->getConnectionErrorInfo()."Cannot connect to database.");

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
		$this->_isConnectionPersistant = true;
		
		// see if successful
		if ($linkId) {
			// reset the query counters
		    $this->_successfulQueries = 0;
		    $this->_failedQueries = 0;

			// attempt to select the default database;
			// if failure, not a big deal, because at this point we are connected
			if (!mysql_select_db($this->_dbName, $linkId))
				throw new ConnectionDatabaseException($this->getConnectionErrorInfo()."Cannot select database, ".$this->_dbName." : ".mysql_error($linkId));

		    $this->_linkId = $linkId;
			return $linkId;
		}
		else {
			$this->_linkId = false;
			
			throw new ConnectionDatabaseException($this->getConnectionErrorInfo()."Cannot connect to database: ".mysql_error());
		    
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
	function query(Query $query) {
//		static $time = 0;
	
		// do not attempt, to query, if not connected
		if (!$this->isConnected()) {
			throw new ConnectionDatabaseException("Attempted to query but there was no database connection.");
			return false;
		}
			
		// generate the SQL query string
//		$t = new Timer();
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
//			throwError( new HarmoniError("The query had errors: \n".$queryString, "DBHandler", true));
//
		// create the appropriate QueryResult object
		switch($query->getType()) {
			case INSERT : 
				$result = new MySQLInsertQueryResult($this->_linkId);
				break;
			case UPDATE : 
				$result = new MySQLUpdateQueryResult($this->_linkId);
				break;
			case DELETE : 
				$result = new MySQLDeleteQueryResult($this->_linkId);
				break;
			case SELECT : 
				$result = new MySQLSelectQueryResult($resourceId, $this->_linkId);
				break;
			case GENERIC : 
				$result = new MySQLGenericQueryResult($resourceId, $this->_linkId);
				break;
			default:
				throw new DatabaseException("Unsupported query type.");
		} // switch

		return $result;
	}
	
	/**
	 * Answer the string SQL for the query
	 * 
	 * @param object $query
	 * @return string
	 * @access public
	 * @since 11/14/06
	 */
	function generateSQL ($query) {
		return MySQL_SQLGenerator::generateSQLQuery($query);
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
			throw new ConnectionDatabaseException("Attempted to query but there was no database connection.");
			return false;
		}
		
		if (is_array($query))
		    $queries = $query;
		else if (is_string($query))
		    $queries = array($query);
		
		// If we have a persistant connection, it might be shared with other
		// databases, so make sure our database is selected.
		if ($this->_isConnectionPersistant == true) {
			if (!mysql_select_db($this->_dbName, $this->_linkId))
				throw new ConnectionDatabaseException("Cannot select database, ".$this->_dbName." : ".mysql_error($this->_linkId));
		}
		
		foreach ($queries as $q) {
			// attempt to execute the query
			$resourceId = mysql_query($q, $this->_linkId);
			
			debug::output("<pre>Query: <div>".$query."</div>Result: $resourceId</pre>", 1, "DBHandler");
		
			if ($resourceId === false) {
				$this->_failedQueries++;
				
				switch (mysql_errno($this->_linkId)) {
					// No Such Table
					case 1146:
					case 1177:
						throw new NoSuchTableDatabaseException("MySQL Error: ".mysql_error($this->_linkId), mysql_errno($this->_linkId));
					
					// Duplicate Key
					case 1022:
					case 1062:
						throw new DuplicateKeyDatabaseException("MySQL Error: ".mysql_error($this->_linkId), mysql_errno($this->_linkId));
					
					// max_allowed_packet
					case 1153: // Got a packet bigger than 'max_allowed_packet' bytes
					case 1162: // Result string is longer than 'max_allowed_packet' bytes
					case 1301: // Result of %s() was larger than max_allowed_packet (%ld) - truncated
						$size = ByteSize::withValue(strlen($query));
						throw new QuerySizeDatabaseException("MySQL Error: ".mysql_error($this->_linkId)." (Query Size: ".$size->asString().")", mysql_errno($this->_linkId));
					
					
					default:
						throw new QueryDatabaseException("MySQL Error: ".mysql_error($this->_linkId), mysql_errno($this->_linkId));	
				}
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
		if ($isSuccessful) {
			$this->_linkId = false;
			$this->_isConnectionPersistant = NULL;
		}
		
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
		$stringRule = StringValidatorRule::getRule();
		ArgumentValidator::validate($database, $stringRule, true);
		// ** end of parameter validation
	
		$this->_dbName = $database;
		return mysql_select_db($database, $this->_linkId);
	}


	
	
	/**
	 * Converts a DateAndTime object to a proper datetime/timestamp/time representation 
	 * for this Database.
	 *
	 * The easiest way to convert is to create an integer (or a string,
	 * choose which one you think is better, MySQL accepts both, but make
	 * sure to document) in the following format: YYYYMMDDHHMMSS.
	 * You can pass this to a MySQL datetime or timestamp column types
	 * and it gets parsed automatically by MySQL.
	 *
	 * @access public
	 * @param ref object DateAndTime The DateAndTime object to convert.
	 * @return mixed A proper datetime/timestamp/time representation for this Database.
	 */
	function toDBDate(DateAndTime $dateAndTime) {
		$dt =$dateAndTime->asDateAndTime();
		$string = sprintf("%s%02d%02d%02d%02d%02d", $dt->year(),
							$dt->month(), $dt->dayOfMonth(),
							$dt->hour24(), $dt->minute(),
							$dt->second());
		return "'".$string."'";
	}
	
	
	/**
	 * Converts a database datetime/timestamp/time value (that has been fetched
	 * from the db) to a DateAndTime object.
	 *
	 * Depending whether the value was fecthed from a datetime, date or 
	 * timestamp column, $value could have the following two formats:
	 * 'YYYY-MM-DD HH:MM:SS' for datetime
	 * 'YYYY-MM-DD' for date
	 * For a timestamp, $value could be any of the following depending on
	 * the column size.
	 * TIMESTAMP(14)  YYYYMMDDHHMMSS  
	 * TIMESTAMP(12)  YYMMDDHHMMSS  	- NOT SUPPORTED
	 * TIMESTAMP(10)  YYMMDDHHMM  		- NOT SUPPORTED
	 * TIMESTAMP(8)  YYYYMMDD  
	 * TIMESTAMP(6)  YYMMDD  			- NOT SUPPORTED
	 * TIMESTAMP(4)  YYMM  				- NOT SUPPORTED
	 * TIMESTAMP(2)  YY  				- NOT SUPPORTED
	 *
	 * From MySQL version 4.1, TIMESTAMP is returned as 
	 * a string with the format 'YYYY-MM-DD HH:MM:SS' and different timestamp 
	 * lengths are no longer supported.
	 *
	 * WARNING: Due to the ambiguity of 2-digit years, timestamp formats that
	 * use 2-digit years are not supported.
	 *
	 * @access public
	 * @param mixed A database datetime/timestamp/time value (that has been fetched
	 * from the db).
	 * @return ref object The DateAndTime object.
	 */
	function fromDBDate($value) {
		if (in_array($value, array(NULL, '', '0000-00-00 00:00:00')))
			$obj = null;
		else
			$obj = DateAndTime::fromString($value);
		
		return $obj;
	}
	
	/**
	 * Return TRUE if this database supports transactions.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/9/05
	 */
	function supportsTransactions () {
		if ($this->_supportsTransactions == NULL) {
			$versionString = mysql_get_server_info($this->_linkId);
			if(!preg_match("/^([0-9]+).([0-9]+).([0-9]+)/", $versionString, $matches))
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
			throw new TransactionDatabaseException("Error: Negative number of BEGIN statements.");

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
			throw new TransactionDatabaseException("Error: More COMMIT/ROLLBACK statements than BEGIN statements.");
		
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
			throw new TransactionDatabaseException("Error: More COMMIT/ROLLBACK statements than BEGIN statements.");
		
		if ($this->supportsTransactions()) {
		
			// Roll-back first, to undo changes.
			$this->_query("ROLLBACK");
						
			// If rollback is called inside a nested set of transactions, then the
			// resulting state of the the database is undefined. 
			if ($this->_startedTransactions > 1) {
				throw new TransactionDatabaseException("Error: Unsuported attempt to roll-back a nested transaction. Nested transaction support for MySQL removes all but the outside begin/commit/rollback statements. Rolling-back from an interior transaction would leave the database in an undefined state.");
			}
		}
		
		$this->_startedTransactions--;
	}
}
