<?php

require_once(HARMONI.'DBHandler/DBHandler.interface.php');
require_once(HARMONI."DBHandler/SelectQuery.class.php");
require_once(HARMONI."DBHandler/UpdateQuery.class.php");
require_once(HARMONI."DBHandler/DeleteQuery.class.php");
require_once(HARMONI."DBHandler/InsertQuery.class.php");
require_once(HARMONI.'DBHandler/MySQL/MySQLDatabase.class.php');
require_once(HARMONI.'utilities/Queue.class.php');


/**
 * A Database Handler. The DBHandler is to be loaded at the beginning
 * program executution with configuration settings for the database type, name, 
 * server, user, and password. 
 *
 * @version $Id: DBHandler.class.php,v 1.7 2003/07/01 01:55:22 dobomode Exp $
 * @package harmoni.dbhandler
 * @copyright 2003 
 * @access public
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
	 * Creates a new database connection.
	 * @param string $dbType The type of database: MYSQL, POSTGRES, ORACLE, OKI, etc.
	 * @param string $dbHost The hostname for the database, i.e. myserver.mydomain.edu.
	 * @param string $dbName The name of the database.
	 * @param string $dbUser The username with which to connect to the database.
	 * @param string $dbPass The password for $_dbUser with which to connect to the database.
	 * @return mixed $dbIndex The index of the new database, if it was created successfully; False, otherwise.
	 * @access public
	 */
	function createDatabase($dbType, $dbHost, $dbName, $dbUser, $dbPass) {
		// ** parameter validation
		$stringRule =& new StringValidatorRule();
		$integerRule =& new IntegerValidatorRule();
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
				;
				break;
			case SQLSERVER :
				;
				break;
			case OKI :
				;
				break;
			default : {
			    // unsupported database type
				throw(new Error("Unknown database type.", "DBHandler", true));
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
	function & query(& $query, $dbIndex=0) {
		// ** parameter validation
		$queryRule =& new ExtendsValidatorRule("QueryInterface");
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($query, $queryRule, true);
		ArgumentValidator::validate($dbIndex, $integerRule, true);
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
	function & queryQueue(& $queue, $dbIndex=0) {
		// ** parameter validation
		$queueRule =& new ExtendsValidatorRule("QueueInterface");
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($queue, $queueRule, true);
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation

		// check that the index is valid
		if (!is_object($this->_databases[$dbIndex])) {
			throw(new Error("Invalid database index.", "DBHandler", false));
			return false;
		}

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
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation

		// check that the index is valid
		if (!is_object($this->_databases[$dbIndex])) {
			throw(new Error("Invalid database index.", "DBHandler", false));
			return false;
		}
		
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
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation

		// check that the index is valid
		if (!is_object($this->_databases[$dbIndex])) {
			throw(new Error("Invalid database index.", "DBHandler", false));
			return false;
		}
			
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
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation

		// check that the index is valid
		if (!is_object($this->_databases[$dbIndex])) {
			throw(new Error("Invalid database index.", "DBHandler", false));
			return false;
		}
			
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
		$integerRule =& new IntegerValidatorRule();
		ArgumentValidator::validate($dbIndex, $integerRule, true);
		// ** end of parameter validation

		// check that the index is valid
		if (!is_object($this->_databases[$dbIndex])) {
			throw(new Error("Invalid database index.", "DBHandler", false));
			return false;
		}
			
		// see if the specified database is connected
		$isConnected = $this->_databases[$dbIndex]->isConnected();

		return $isConnected;
	}


	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
	}
	
	
}
?>