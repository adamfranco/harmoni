<?php

require_once(OKI."/osid.interface.php");

	 /**
	 * LoggingManager allows the application developer to create, delete, and get logs for reading or writing.  All log Entries have a formatType, a priorityType, and a timestamp. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.logging
	   */
class LoggingManager // :: API interface
	extends OsidManager
{

	  /**
	 * Return the format types available with this implementation.
	 * @return object osid.shared.TypeIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:  {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function &getFormatTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getFormatTypes()

	  /**
	 * Return the priority types available with this implementation.
	 * @return object osid.shared.TypeIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:  {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function &getPriorityTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getPriorityTypes()

	  /**
	 * Return the names of writable Logs.
	 * @return object osid.shared.StringIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:  {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function &getLogNamesForWriting() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.StringIterator getLogNamesForWriting()

	  /**
	 * Get an existing log for writing.
	 * @param object logName logName Represents the unique logical name of the Log.
	 * @return object WritableLog
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:  {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#UNKNOWN_NAME UNKNOWN_NAME}
	 * @package osid.logging
	  */
	function &getLogForWriting($logName) { /* :: interface :: */ }
	// :: full java declaration :: WritableLog getLogForWriting
	 * Return the names of readable Logs.
	 * @return object osid.shared.StringIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:  {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function &getLogNamesForReading() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.StringIterator getLogNamesForReading()

	  /**
	 * Get an existing log for reading.
	 * @param object logName logName Represents the unique logical name of the Log.
	 * @return object ReadableLog
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:  {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#UNKNOWN_NAME UNKNOWN_NAME}
	 * @package osid.logging
	  */
	function &getLogForReading($logName) { /* :: interface :: */ }
	// :: full java declaration :: ReadableLog getLogForReading
	 * Create a Writable Log.
	 * @param object logName logName Represents the unique logical name of the Log.
	 * @return object WritableLog
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:  {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#DUPLICATE_NAME DUPLICATE_NAME}
	 * @package osid.logging
	  */
	function &createLog($logName) { /* :: interface :: */ }
	// :: full java declaration :: WritableLog createLog(String logName)

	  /**
	 * Delete the log with the specified name.
	 * @param object logName logName Represents the unique logical name of the Log.
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:  {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#UNKNOWN_NAME UNKNOWN_NAME}
	 * @package osid.logging
	  */
	function deleteLog($logName) { /* :: interface :: */ }
	// :: full java declaration :: void deleteLog(String logName)
}


	  /**
	 * ReadableLog allows reading of its entries.  <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.logging
	   */
class ReadableLog // :: API interface
{

	  /**
	 * Get the name for this ReadableLog.
	 * @return string the name
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: String getDisplayName()

	  /**
	 * Return the ReadableLog Entries in a last-in, first-out (LIFO) order.
	 * @param object formatType formatType filters log entries so that only entries with this formatType appear in the EntryIterator; may be null.
	 * @param object priorityType filters log entries so that only entries with this priorityType appear in the EntryIterator; may be null.
	 * @return object EntryIterator  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#NULL_ARGUMENT NULL_ARGUMENT}, {@link LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.logging
	  */
	function &getEntries(& $formatType, & $priorityType) { /* :: interface :: */ }
	// :: full java declaration :: EntryIterator getEntries

	/**
	 * EntryIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.logging
	 */
class EntryIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  entries Description_IteratorHasNext2]
	 * @return object boolean
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Entry.
	 * @return object Entry.
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#NO_MORE_ITERATOR_ELEMENTS NO_MORE_ITERATOR_ELEMENTS}
	 * @package osid.logging
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Entry next()
}


	  /**
	 * Contains the logged item, its format type, its priority type, and the time the item was logged.   <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.logging
	   */
class Entry // :: API interface
{

	  /**
	 * Return the logged item.
	 * @return object java.io.Serializable item
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function &getItem() { /* :: interface :: */ }
	// :: full java declaration :: java.io.Serializable getItem()

	  /**
	 * Return the format type of logged item.
	 * @return object osid.shared.Type
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function &getFormatType() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Type getFormatType()

	  /**
	 * Return the format type of logged item.
	 * @return object osid.shared.Type
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function &getPriorityType() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Type getPriorityType()

	  /**
	 * Return the time that the item was logged.
	 * @return object java.util.Calendar
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function &getTimestamp() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar getTimestamp()
}


	  /**
	 * Interface WritableLog allows writing of entry items, format types, priority types to a log.  Two methods are used to write the entryItems: <p> <code>appendLog(java.io.Serializable entryItem)</code> which writes the entry to the Log, <p> <code>appendLog(java.io.Serializable entryItem, osid.shared.Type formatType, osid.shared.Type priorityType)</code> which writes the entryItem to the Log as well as formatType and priorityType. <p> The implementation sets the timestamp for the for when the entryItem was appended to the log. The format type and the priority type can be set as defaults for subsequent appends.  <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.logging
	   */
class WritableLog // :: API interface
{

	  /**
	 * Get the name for this WritableLog.
	 * @return string the name
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}
	 * @package osid.logging
	  */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: String getDisplayName()

	  /**
	 * Write the entryItem to the Log. The entryItem is written to the Log using the format type and priority type explicitly set by the application or the implementation default.
	 * @param object entryItem
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#PRIORITY_TYPE_NOT_SET PRIORITY_TYPE_NOT_SET}, {@link LoggingException#FORMAT_TYPE_NOT_SET FORMAT_TYPE_NOT_SET}, {@link LoggingException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.logging
	  */
	function appendLog(& $entryItem) { /* :: interface :: */ }
	// :: full java declaration :: void appendLog(java.io.Serializable entryItem)

	  /**
	 * Write the entry, the priorityType and formatType to the Log.
	 * @param object entryItem
	 * @param object formatType
	 * @param object priorityType
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link LoggingException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.logging
	  */
	function appendLogWithTypes(& $entryItem, & $formatType, & $priorityType) { /* :: interface :: */ }
	// :: full java declaration :: void appendLogWithTypes(java.io.Serializable entryItem, osid.shared.Type formatType, osid.shared.Type priorityType)

	  /**
	 * Set the priorityType for all subsequent writes during the lifetime of this instance. PriorityType has meaning to the caller of this method.
	 * @param object priorityType
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link LoggingException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.logging
	   */
	function setPriorityType(& $priorityType) { /* :: interface :: */ }
	// :: full java declaration :: void setPriorityType(osid.shared.Type priorityType)

	  /**
	 * Set the priorityType for all subsequent writes during the lifetime of this instance. PriorityType has meaning to the caller of this method.
	 * @param object formatType
	 * @throws osid.logging.LoggingException An exception with one of the following messages defined in osid.logging.LoggingException:   {@link LoggingException#UNIMPLEMENTED UNIMPLEMENTED}, {@link LoggingException#OPERATION_FAILED OPERATION_FAILED}, {@link LoggingException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link LoggingException#PERMISSION_DENIED PERMISSION_DENIED}, {@link LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE}, {@link LoggingException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.logging
	   */
	function setFormatType(& $formatType) { /* :: interface :: */ }
	// :: full java declaration :: void setFormatType(osid.shared.Type formatType)
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.logging
	 */
class LoggingException // :: normal class
	extends OsidException
{

	/**
	 * Unknown or unsupported Type
	 * @package osid.logging
	 */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown Type ");

	/**
	 * Unknown name
	 * @package osid.logging
	 */
	// :: defined globally :: define("UNKNOWN_NAME","Unknown log name ");

	/**
	 * Duplicate name
	 * @package osid.logging
	 */
	// :: defined globally :: define("DUPLICATE_NAME","Duplicate log name ");

	/**
	 * Operation failed
	 * @package osid.logging
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * Iterator has no more elements
	 * @package osid.logging
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	/**
	 * Null argument
	 * @package osid.logging
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument ");

	/**
	 * Permission denied
	 * @package osid.logging
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Configuration error
	 * @package osid.logging
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Unimplemented method
	 * @package osid.logging
	 */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method ");

	/**
	 * Default priority Type not set
	 * @package osid.logging
	 */
	// :: defined globally :: define("PRIORITY_TYPE_NOT_SET","PriorityType not set ");

	/**
	 * Default format Type not set
	 * @package osid.logging
	 */
	// :: defined globally :: define("FORMAT_TYPE_NOT_SET","FormatType not set ");
}

// :: post-declaration code ::
/**
 * @const string UNKNOWN_TYPE public static final String UNKNOWN_TYPE = "Unknown Type "
 * @package osid.logging
 */
define("UNKNOWN_TYPE", "Unknown Type ");

/**
 * @const string UNKNOWN_NAME public static final String UNKNOWN_NAME = "Unknown log name "
 * @package osid.logging
 */
define("UNKNOWN_NAME", "Unknown log name ");

/**
 * @const string DUPLICATE_NAME public static final String DUPLICATE_NAME = "Duplicate log name "
 * @package osid.logging
 */
define("DUPLICATE_NAME", "Duplicate log name ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid.logging
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
 * @package osid.logging
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument "
 * @package osid.logging
 */
define("NULL_ARGUMENT", "Null argument ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied "
 * @package osid.logging
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error "
 * @package osid.logging
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * @const string UNIMPLEMENTED public static final String UNIMPLEMENTED = "Unimplemented method "
 * @package osid.logging
 */
define("UNIMPLEMENTED", "Unimplemented method ");

/**
 * @const string PRIORITY_TYPE_NOT_SET public static final String PRIORITY_TYPE_NOT_SET = "PriorityType not set "
 * @package osid.logging
 */
define("PRIORITY_TYPE_NOT_SET", "PriorityType not set ");

/**
 * @const string FORMAT_TYPE_NOT_SET public static final String FORMAT_TYPE_NOT_SET = "FormatType not set "
 * @package osid.logging
 */
define("FORMAT_TYPE_NOT_SET", "FormatType not set ");

?>
