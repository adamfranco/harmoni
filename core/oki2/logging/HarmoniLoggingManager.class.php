<?php

/**
 * @since 3/1/06
 * @package harmoni.osid_v2.logging
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniLoggingManager.class.php,v 1.3 2007/09/04 20:25:43 adamfranco Exp $
 */

require_once(OKI2."/osid/logging/LoggingManager.php");
require_once(dirname(__FILE__)."/HarmoniWritableLog.class.php");

/**
 * <p>
 * LoggingManager handles creating, deleting, and getting logs for reading or
 * writing.	 All log Entries have a formatType, a priorityType, and a
 * timestamp.
 * </p>
 * 
 * <p>
 * All implementations of OsidManager (manager) provide methods for accessing
 * and manipulating the various objects defined in the OSID package. A manager
 * defines an implementation of an OSID. All other OSID objects come either
 * directly or indirectly from the manager. New instances of the OSID objects
 * are created either directly or indirectly by the manager.  Because the OSID
 * objects are defined using interfaces, create methods must be used instead
 * of the new operator to create instances of the OSID objects. Create methods
 * are used both to instantiate and persist OSID objects.  Using the
 * OsidManager class to define an OSID's implementation allows the application
 * to change OSID implementations by changing the OsidManager package name
 * used to load an implementation. Applications developed using managers
 * permit OSID implementation substitution without changing the application
 * source code. As with all managers, use the OsidLoader to load an
 * implementation of this interface.
 * </p>
 * 
 * <p></p>
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * <p>
 * Licensed under the {@link org.osid.SidImplementationLicenseMIT MIT
 * O.K.I&#46; OSID Definition License}.
 * </p>
 * 
 * @package harmoni.osid_v2.logging
 */
class HarmoniLoggingManager
	extends LoggingManager
{
	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access private
	 */
	var $_dbIndex;
	
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
	function assignConfiguration ( $configuration ) { 
		$this->_configuration =$configuration;
		
		$dbIndex = $configuration->getProperty('database_index');
		
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$this->_dbIndex = $dbIndex;
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
	function getOsidContext () { 
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
	function assignOsidContext ( $context ) { 
		$this->_osidContext =$context;
	}
	
	/**
	 * Return the format types available with this implementation.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:  {@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}
	 * 
	 * @access public
	 */
	function getFormatTypes () { 
// 		$dbc = Services::getService("DatabaseManager");
// 		
// 		$query = new SelectQuery;
// 		$query->addColumn("domain", "domain", "log_type");
// 		$query->addColumn("authority", "authority", "log_type");
// 		$query->addColumn("keyword", "keyword", "log_type");
// 		$query->addColumn("description", "description", "log_type");
// 		
// 		$query->addTable("log_entry");
// 		$query->addTable("log_type", INNER_JOIN, "log_entry.fk_format_type = log_type.id");
// 		$query->addGroupBy("log_type.id");
// 		
// 		$results =$dbc->query($query, $this->_dbIndex);
// 		$types = array();
// 		while ($results->hasNext()) {
// 			$types[] = new Type(	$results->field("domain"),
// 									$results->field("authority"), 
// 									$results->field("keyword"), 
// 									$results->field("description"));
// 			$results->advanceRow();
// 		}
// 		$results->free();
		
		$types = array();
		$types[] = new Type("logging", "edu.middlebury", "AgentsAndNodes",
						"A format in which the acting Agent[s] and the target nodes affected are specified.");
		
		$iterator = new HarmoniIterator($types);
		return $iterator;
	} 

	/**
	 * Return the priority types available with this implementation.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:  {@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}
	 * 
	 * @access public
	 */
	function getPriorityTypes () { 
		$dbc = Services::getService("DatabaseManager");
		
		$query = new SelectQuery;
		$query->addColumn("domain", "domain", "log_type");
		$query->addColumn("authority", "authority", "log_type");
		$query->addColumn("keyword", "keyword", "log_type");
		$query->addColumn("description", "description", "log_type");
		
		$query->addTable("log_entry");
		$query->addTable("log_type", INNER_JOIN, "log_entry.fk_priority_type = log_type.id");
		$query->setGroupBy(array("log_type.id"));
		$query->addOrderBy("keyword");
		
		$results =$dbc->query($query, $this->_dbIndex);
		$types = array();
		while ($results->hasNext()) {
			$types[] = new Type(	$results->field("domain"),
									$results->field("authority"), 
									$results->field("keyword"), 
									$results->field("description"));
			$results->advanceRow();
		}
		$results->free();
		
		$iterator = new HarmoniIterator($types);
		return $iterator;
	} 

	/**
	 * Return the names of writable Logs.
	 *	
	 * @return object StringIterator
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:  {@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}
	 * 
	 * @access public
	 */
	function getLogNamesForWriting () { 
		$dbc = Services::getService("DatabaseManager");
		
		$query = new SelectQuery;
		$query->addColumn("log_name");		
		$query->addTable("log_entry");
		$query->setDistinct(true);
		$query->addOrderBy("log_name");
		
		$results =$dbc->query($query, $this->_dbIndex);
		$names = array();
		while ($results->hasNext()) {
			$names[] = $results->field("log_name");
			$results->advanceRow();
		}
		$results->free();
		
		$iterator = new HarmoniIterator($names);
		return $iterator;
	} 

	/**
	 * Get an existing log for writing.
	 * 
	 * @param string $logName
	 *	
	 * @return object WritableLog
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:  {@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.logging.LoggingException#UNKNOWN_NAME UNKNOWN_NAME}
	 * 
	 * @access public
	 */
	function getLogForWriting ( $logName ) { 
		if (!isset($this->_logs[$logName]))
			$this->_logs[$logName] = new HarmoniWritableLog($logName, $this->_dbIndex);
		
		return $this->_logs[$logName];
	} 

	/**
	 * Return the names of readable Logs.
	 *	
	 * @return object StringIterator
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:  {@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}
	 * 
	 * @access public
	 */
	function getLogNamesForReading () { 
		return $this->getLogNamesForWriting();
	} 

	/**
	 * Get an existing log for reading.
	 * 
	 * @param string $logName
	 *	
	 * @return object ReadableLog
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:  {@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.logging.LoggingException#UNKNOWN_NAME UNKNOWN_NAME}
	 * 
	 * @access public
	 */
	function getLogForReading ( $logName ) { 
		return $this->getLogForWriting($logName);
	} 

	/**
	 * Create a Writable Log.
	 * 
	 * @param string $logName
	 *	
	 * @return object WritableLog
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:  {@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.logging.LoggingException#DUPLICATE_NAME
	 *		   DUPLICATE_NAME}
	 * 
	 * @access public
	 */
	function createLog ( $logName ) { 
		return $this->getLogForWriting($logName);
	} 

	/**
	 * Delete the log with the specified name.
	 * 
	 * @param string $logName
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:  {@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.logging.LoggingException#UNKNOWN_NAME UNKNOWN_NAME}
	 * 
	 * @access public
	 */
	function deleteLog ( $logName ) { 
		$log =$this->getLogForWriting($logName);
		$log = null;
		
		$dbc = Services::getService("DatabaseManager");
		
		// get the entry Ids
		$query = new SelectQuery;
		$query->addColumn("id");
		$query->addTable("log_entry");
		$query->addWhere("log_name = '".addslashes($logName)."'");
		$result =$dbc->query($query, $this->_dbIndex);
		$entryIds = array();
		while ($result->hasMoreRows()) {
			$entryIds[] = "'".addslashes($result->field("id"))."'";
			$result->advanceRow();
		}
		$result->free();
		
		// delete the agent keys
		$query = new DeleteQuery;
		$query->setTable("log_agent");
		$query->addWhere("fk_entry IN (".implode(", ", $entryIds).")");
		$dbc->query($query, $this->_dbIndex);
		
		// delete the node keys
		$query->setTable("log_node");
		$dbc->query($query, $this->_dbIndex);
		
		// delete the entries
		$query = new DeleteQuery;
		$query->setTable("log_entry");
		$query->addWhere("log_name = '".addslashes($logName)."'");
		$dbc->query($query, $this->_dbIndex);
	} 

	/**
	 * This method indicates whether this implementation supports the
	 * ReadableLog interface and the LoggingManager methods: getLogForReading
	 * and getLogNamesForReading.
	 *	
	 * @return boolean
	 * 
	 * @throws object LoggingException An exception with one of the
	 *		   following messages defined in org.osid.logging.LoggingException
	 *		   may be thrown:  {@link
	 *		   org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
	 *		   {@link org.osid.logging.LoggingException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.logging.LoggingException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.logging.LoggingException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}
	 * 
	 * @access public
	 */
	function supportsReading () { 
		return true;
	} 
}

?>