<?php
/**
 * @package harmoni.dbc.oracle
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OracleDatabase.class.php,v 1.15 2007/09/05 21:39:00 adamfranco Exp $
 */
 
require_once(HARMONI."DBHandler/Database.abstract.php");
require_once(HARMONI."DBHandler/Oracle/OracleSelectQueryResult.class.php");
require_once(HARMONI."DBHandler/Oracle/OracleInsertQueryResult.class.php");
require_once(HARMONI."DBHandler/Oracle/OracleUpdateQueryResult.class.php");
require_once(HARMONI."DBHandler/Oracle/OracleDeleteQueryResult.class.php");
require_once(HARMONI."DBHandler/Oracle/Oracle_SQLGenerator.class.php");

/**
 * A OracleDatabase class provides the tools to connect, query, etc., a Oracle database.
 *
 * @package harmoni.dbc.oracle
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: OracleDatabase.class.php,v 1.15 2007/09/05 21:39:00 adamfranco Exp $
 */
class OracleDatabase 
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
	 * @param string $dbName The TNS name of the database to use (found in tnsnames.ora file).
	 * @param string $dbUser The username with which to connect to the database.
	 * @param string $dbPass The password for $_dbUser with which to connect to the database.
	 * @return integer $dbIndex The index of the new database
	 * @access public
	 */
	function __construct($dbName, $dbUser, $dbPass) {
		// ** parameter validation
		$stringRule = StringValidatorRule::getRule();
		//ArgumentValidator::validate($dbHost, $stringRule, true);
		ArgumentValidator::validate($dbName, $stringRule, true);
		ArgumentValidator::validate($dbUser, $stringRule, true);
		ArgumentValidator::validate($dbPass, $stringRule, true);
		// ** end of parameter validation

		//$this->_dbHost = $dbHost;
		$this->_dbName = $dbName;
		$this->_dbUser = $dbUser;
		$this->_dbPass = $dbPass;
	    $this->_linkId = false;
	    $this->_successfulQueries = 0;
	    $this->_failedQueries = 0;
	}
	
	/**
	 * Returns a short string name for this database type. Example: 'MySQL'
	 * @access public
	 * @return string
	 */
	function getStringName() {
		return "Oracle";
	}

	/**
	 * Returns a list of the tables that exist in the currently connected database.
	 * @return array
	 * @access public
	 */
	function getTableList() {
		$query = new SelectQuery();
		$query->addTable("all_tables");
		$query->addColumn("table_name");
		$res =$this->query($query);
		
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
		
		$linkId = ocilogon($this->_dbUser, $this->_dbPass, $this->_dbName);
		
		// see if successful
		if ($linkId) {
			// reset the query counters
		    $this->_successfulQueries = 0;
		    $this->_failedQueries = 0;
		
		    $this->_linkId = $linkId;
			return $linkId;
		}
		else {
			throw new ConnectionDatabaseException($this->getConnectionErrorInfo()."Cannot connect to database.");
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

		
		$linkId = ociplogon($this->_dbUser, $this->_dbPass, $this->_dbName);
		
		// see if successful
		if ($linkId) {
			// reset the query counters
		    $this->_successfulQueries = 0;
		    $this->_failedQueries = 0;
		
		    $this->_linkId = $linkId;
			return $linkId;
		}
		else {
			throw new ConnectionDatabaseException($this->getConnectionErrorInfo()."Cannot connect to database.");
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
	function query(Query $query) {
		// do not attempt, to query, if not connected
		if (!$this->isConnected()) {
			throw new ConnectionDatabaseException("Attempted to query but there was no database connection.");
			return false;
		}
			
		// generate the SQL query string
		$queryString = Oracle_SQLGenerator::generateSQLQuery($query);
		
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
					$lastIdQuery = "SELECT ".$query->_sequence.".CURRVAL";
					$lastIdResourceId = $this->_query($lastIdQuery);
					$this->_query("COMMIT");
					$arr = pg_fetch_row($lastIdResourceId, 0);
					$lastId = intval($arr[0]);
				}
				
				$result = new OracleInsertQueryResult($resourceId, $lastId);
				break;
			}
			case UPDATE : 
				$result = new OracleUpdateQueryResult($resourceId);
				break;
			case DELETE : 
				$result = new OracleDeleteQueryResult($resourceId);
				break;
			case SELECT : 
				$result = new OracleSelectQueryResult($resourceId, $this->_linkId);
				break;
			case GENERIC : 
				$result = new OracleGenericQueryResult($resourceId, $this->_linkId);
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
		return Oracle_SQLGenerator::generateSQLQuery($query);
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
			throw new ConnectionDatabaseException("Attempted to query but there was no database connection.");
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
			$resourceId = ociparse($this->_linkId, $q);
		
			if ($resourceId === false) {
			    $this->_failedQueries++;
				throw new QueryDatabaseException(pg_last_error($this->_linkId));
			}
			else {
			    $this->_successfulQueries++;
			    ociexecute($resourceId);
			}
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
		$isSuccessful = ocilogoff($this->_linkId);
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
		return ($this->_linkId !== false);
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
		throw new ConnectionDatabaseException("Oracle database connections cannot change the database once connected!");
			
		return false;
	}

	
	
	/**
	 * Converts a DateAndTime object to a proper datetime/timestamp/time representation 
	 * for this Database.
	 *
	 * @access public
	 * @param ref object dateAndTime The DateAndTime object to convert.
	 * @return mixed A proper datetime/timestamp/time representation for this Database.
	 */
	function toDBDate(DateAndTime $dateAndTime) {
		$dt =$dateAndTime->asDateAndTime();
		$string = sprintf("%s/%02d/%02d %02d:%02d:%02d", $dt->year(),
							$dt->month(), $dt->dayOfMonth(),
							$dt->hour24(), $dt->minute(),
							$dt->second());
		return "to_date('$string', 'yyyy/mm/dd hh24:mi:ss')";
	}
	
	
	/**
	 * Converts a database datetime/timestamp/time value (that has been fetched
	 * from the db) to a DateAndTime object.
	 *
	 * @access public
	 * @param mixed A database datetime/timestamp/time value (that has been fetched
	 * from the db).
	 * @return ref object The DateAndTime object.
	 */
	function fromDBDate($value) {
		/*
		 * NOT SURE HOW TO DO THIS FOR ORACLE
		 */
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
		return TRUE;
	}
	
	/**
	 * Begin a transaction.
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function beginTransaction () {
		$this->_query("BEGIN");
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
		$this->_query("COMMIT");
	}
	
	/**
	 * Roll-back a transaction manually instead of committing
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function rollbackTransaction () {
		$this->_query("ROLLBACK");
	}
}

?>