<?php
/**
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DBHandler.class.php,v 1.16 2005/04/07 16:33:23 adamfranco Exp $
 */

require_once(HARMONI.'DBHandler/DBHandler.interface.php');
require_once(HARMONI."DBHandler/SelectQuery.class.php");
require_once(HARMONI."DBHandler/UpdateQuery.class.php");
require_once(HARMONI."DBHandler/DeleteQuery.class.php");
require_once(HARMONI."DBHandler/InsertQuery.class.php");
require_once(HARMONI."DBHandler/GenericSQLQuery.class.php");
require_once(HARMONI.'DBHandler/MySQL/MySQLDatabase.class.php');
require_once(HARMONI.'DBHandler/PostGre/PostGreDatabase.class.php');
require_once(HARMONI.'DBHandler/Oracle/OracleDatabase.class.php');
require_once(HARMONI.'DBHandler/SQLUtils.static.php');
require_once(HARMONI.'utilities/Queue.class.php');

require_once(HARMONI."utilities/DateTime.class.php");


/**
 * A Database Handler. The DBHandler is to be loaded at the beginning
 * program executution with configuration settings for the database type, name, 
 * server, user, and password. 
 *
 *
 * @package harmoni.dbc
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: DBHandler.class.php,v 1.16 2005/04/07 16:33:23 adamfranco Exp $
 */

class DBHandler extends DBHandlerInterface { 
	
	/**
	 * An array of all databases.
	 * An array of all databases.
	 * @var array $_databases An array of all databases.
	 * @access private
	 */
	var $_databases;



	/**
	 * Constructor.
	 * @access public
	 */
	function DBHandler() {
		$this->_databases = array();
	}
	
	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	database_index			integer
	 *	database_name			string
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.OsidException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.OsidException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
	}

	/**
	 * Return context of this OsidManager.
	 *	
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function &getOsidContext () { 
		return $this->_osidContext;
	} 

	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( &$context ) { 
		$this->_osidContext =& $context;
	} 
	
	/**
	 * Adds the specified Database object to the list of databases.
	 * @access public
	 * @param ref object database
	 * @return mixed $dbIndex The index of the new database, if it was created successfully; False, otherwise.
	 */
	function addDatabase(& $database) {
		// ** parameter validation
		$extendsRule =& ExtendsValidatorRule::getRule("DatabaseInterface");
		ArgumentValidator::validate($database, $extendsRule, true);
		// ** end of parameter validation

		$this->_databases[] =& $database;
		
		// return the index of the database we just created
		return (count($this->_databases) - 1);
	}
	
	

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
	function createDatabase($dbType, $dbHost, $dbName, $dbUser, $dbPass) {
		// ** parameter validation
		$stringRule =& StringValidatorRule::getRule();
		$integerRule =& IntegerValidatorRule::getRule();
		ArgumentValidator::validate($dbType, $integerRule, true);
		ArgumentValidator::validate($dbHost, $stringRule, true);
		ArgumentValidator::validate($dbName, $stringRule, true);
		ArgumentValidator::validate($dbUser, $stringRule, true);
		ArgumentValidator::validate($dbPass, $stringRule, true);
		// ** end of parameter validation

	
		// depending on $dbType, instantiate the corresponding Database object.
		switch ($dbType) {
			case MYSQL : 
				$this->_databases[] =& new MySQLDatabase($dbHost, $dbName, $dbUser, $dbPass);
				break;
			case ORACLE :
				;
				break;
			case POSTGRESQL :
				$this->_databases[] =& new PostGreDatabase($dbHost, $dbName, $dbUser, $dbPass);
				break;
			case SQLSERVER :
				;
				break;
			case OKI :
				;
				break;
			default : {
			    // unsupported database type
				throwError(new Error("Unknown database type.", "DBHandler", true));
				return false;
			}
		}
		
		// return the index of the database we just created
		return (count($this->_databases) - 1);
	}

	/**
	 * Run a database query based on the Query object and return a QueryResult object.
	 * @param object QueryInterface A query object which holds the query to run.
	 * @param integer $dbIndex The index of the database on which to run the query. Default is 0, the database created on handler instantiation.
	 * @return object QueryResultInterface Returns a QueryResult object that impliments QueryResultInterface and corresponds to the DB configuration.
	 * @access public
	 */
	function &query(& $query, $dbIndex=0) {
		// ** parameter validation
		$queryRule =& ExtendsValidatorRule::getRule("QueryInterface");
		ArgumentValidator::validate($query, $queryRule, true);
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
		
		// run the query on the appropriate database.
		$result =& $this->_databases[$dbIndex]->query($query);
		
		return $result;
	}

	
	/**
	 * Run a database query for each Query in the Queue and return a Queue of QueryResults.
	 * @param object QueueInterface A queue object which holds the queries to run.
	 * @param integer $dbIndex The index of the database on which to run the query. Default is 0, the database created on handler instantiation.
	 * @return object QueInterface Returns a Queue of QueryResults.
	 * @access public
	 */
	function &queryQueue(& $queue, $dbIndex=0) {
		// ** parameter validation
		$queueRule =& ExtendsValidatorRule::getRule("Queue");
		ArgumentValidator::validate($queue, $queueRule, true);
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation

		$resultQueue =& new Queue();
		while ($queue->hasNext()) {
			$result =& $this->_databases[$dbIndex]->query($queue->next());
			$resultQueue->add($result);
		}
		return $resultQueue;
	}
	
	
	/**
	 * Gets the total number of queries that have been run so far.
	 * Gets the total number of queries that have been run so far.
	 * @return integer The number of queries that have run so far.
	 * @access public
	 */
	function getTotalNumberOfQueries() {
		$numberOfQueries = 0;
		foreach (array_keys($this->_databases) as $key) {
			$numberOfQueries += $this->_databases[$key]->getNumberSuccessfulQueries();
			$numberOfQueries += $this->_databases[$key]->getNumberFailedQueries();
		}
		return $numberOfQueries;
	}
	
	
	/**
	 * Gets the total number of queries that have been run successfully so far.
	 * Gets the total number of queries that have been run successfully so far.
	 * @return integer The number of queries that have run successfully so far.
	 * @access public
	 */
	function getTotalNumberOfSuccessfulQueries() {
		$numberOfQueries = 0;
		foreach (array_keys($this->_databases) as $key) {
			$numberOfQueries += $this->_databases[$key]->getNumberSuccessfulQueries();
		}
		return $numberOfQueries;
	}

	/**
	 * Gets the total number of queries that have failed so far.
	 * Gets the total number of queries that have failed so far.
	 * @return integer The number of queries that have failed so far.
	 * @access public
	 */
	function getTotalNumberOfFailedQueries() {
		$numberOfQueries = 0;
		foreach (array_keys($this->_databases) as $key) {
			$numberOfQueries += $this->_databases[$key]->getNumberFailedQueries();
		}
		return $numberOfQueries;
	}
	
	/**
	 * Connect to the database.
	 * @param integer $dbIndex The index of the database with which to connect. Default is 0, the database created on handler instantiation.
	 * @return boolean True, if successful; False, otherwise.
	 * @access public
	 */
	function connect($dbIndex = 0) {
		// ** parameter validation
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
		
		// attempt to connect to the specified database
		$result = $this->_databases[$dbIndex]->connect();
		
		// see, if we were successful
		$isSuccessful = ($result !== false);
		
		return $isSuccessful;
	}
	
	/**
	 * Persistantly connect to the database.
	 * @param integer $dbIndex The index of the database with which to pconnect. Default is 0, the database created on handler instantiation.
	 * @return boolean True, if successful; False, otherwise.
	 * @access public
	 */
	function pConnect($dbIndex = 0) {
		// ** parameter validation
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
			
		// attempt to connect to the specified database
		$result = $this->_databases[$dbIndex]->pConnect();
		
		// see, if we were successful
		$isSuccessful = ($result !== false);
		
		return $isSuccessful;
	}

	/**
	 * disconnect from the database.
	 * @param integer $dbIndex The index of the database with which to disconnect. Default is 0, the database created on handler instantiation.
	 * @return boolean True, if successful; False, otherwise.
	 * @access public
	 */
	function disconnect($dbIndex = 0) {
		// ** parameter validation
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
			
		// attempt to disconnect from the specified database
		$result = $this->_databases[$dbIndex]->disconnect();
		
		// see, if we were successful
		$isSuccessful = ($result !== false);
		
		return $isSuccessful;	
	}
	
		
	/**
	 * Indicates whether there is an open connection to the database.
	 * Indicates whether there is an open connection to the database.
	 * @access public
	 * @return boolean True, if there is an open connection to the database; False, otherwise.
	 */
	function isConnected($dbIndex = 0) {
		// ** parameter validation
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
			
		// see if the specified database is connected
		$isConnected = $this->_databases[$dbIndex]->isConnected();

		return $isConnected;
	}



	
	/**
	 * Converts a DateTime object to a proper datetime/timestamp/time representation 
	 * for the specified database object.
	 * @access public
	 * @param ref object dateTime The DateTime object to convert.
	 * @param integer dbIndex The index of the database to use (0 by default).
	 * @return mixed A proper datetime/timestamp/time representation for this Database.
	 */
	function toDBDate(& $dateTime, $dbIndex = 0) {
		// ** parameter validation
		$extendsRule =& ExtendsValidatorRule::getRule("DateTime");
		ArgumentValidator::validate($dateTime, $extendsRule, true);
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
			
		return $this->_databases[$dbIndex]->toDBDate($dateTime);
	}
	
	
	/**
	 * Converts a database datetime/timestamp/time value (that has been fetched
	 * from the db) to a DateTime object.
	 * @access public
	 * @param mixed A database datetime/timestamp/time value (that has been fetched
	 * from the db).
	 * @param integer dbIndex The index of the database to use (0 by default).
	 * @return ref object The DateTime object.
	 */
	function &fromDBDate($value, $dbIndex = 0) {
		// ** parameter validation
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
		
		return $this->_databases[$dbIndex]->fromDBDate($value);
	}
	
		
	/**
	 * Return TRUE if this database supports transactions.
	 * 
	 * @return boolean
	 * @access public
	 * @since 3/9/05
	 */
	function supportsTransactions ( $dbIndex = 0 ) {
		// ** parameter validation
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
		
		return $this->_databases[$dbIndex]->supportsTransactions();
	}
	
	/**
	 * Begin a transaction.
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function beginTransaction ( $dbIndex = 0 ) {
		// ** parameter validation
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
		
		$this->_databases[$dbIndex]->beginTransaction();
	}
	
	/**
	 * Commit a transaction. This will roll-back changes if errors occured in the
	 * transaction block.
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function commitTransaction ( $dbIndex = 0 ) {
		// ** parameter validation
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
		
		$this->_databases[$dbIndex]->commitTransaction();
	}
	
	/**
	 * Roll-back a transaction manually instead of committing
	 * 
	 * @return void
	 * @access public
	 * @since 3/9/05
	 */
	function rollbackTransaction ( $dbIndex = 0 ) {
		// ** parameter validation
		$this->_validateDBIndex($dbIndex);
		// ** end of parameter validation
		
		$this->_databases[$dbIndex]->rollbackTransaction();
	}
	
	/**
	 * Private method for validating the dbIndex passed.
	 * 
	 * @param integer $dbIndex
	 * @return void
	 * @access private
	 * @since 3/9/05
	 */
	function _validateDBIndex ($dbIndex) {
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		// check that the index is valid
		if (!is_object($this->_databases[$dbIndex])) {
			throwError(new Error("Invalid database index.", "DBHandler", true));
			return false;
		}
	}
}
?>