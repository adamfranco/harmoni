<?php

class LoggingManager
	extends OsidManager
{ // begin LoggingManager
	// public osid.shared.TypeIterator & getFormatTypes();
	function & getFormatTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.TypeIterator & getPriorityTypes();
	function & getPriorityTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.StringIterator & getLogNamesForWriting();
	function & getLogNamesForWriting() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public WritableLog & getLogForWriting();
	function & getLogForWriting() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String logName();
	function logName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.StringIterator & getLogNamesForReading();
	function & getLogNamesForReading() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public ReadableLog & getLogForReading();
	function & getLogForReading() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String logName();
	function logName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end LoggingManager


class ReadableLog
{ // begin ReadableLog
	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public EntryIterator & getEntries();
	function & getEntries() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & formatType();
	function & formatType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & priorityType();
	function & priorityType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end ReadableLog


class EntryIterator
{ // begin EntryIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Entry & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end EntryIterator


class Entry
{ // begin Entry
	// public java.io.Serializable & getItem();
	function & getItem() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & getFormatType();
	function & getFormatType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Type & getPriorityType();
	function & getPriorityType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.util.Calendar & getTimestamp();
	function & getTimestamp() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end Entry


class WritableLog
{ // begin WritableLog
	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void appendLog(java.io.Serializable & $entryItem);
	function appendLog(& $entryItem) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void appendLog(java.io.Serializable & $entryItem, osid.shared.Type & $priorityType, osid.shared.Type & $formatType);
	function appendLog(& $entryItem, & $priorityType, & $formatType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void setPriorityType(osid.shared.Type & $priorityType);
	function setPriorityType(& $priorityType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void setFormatType(osid.shared.Type & $formatType);
	function setFormatType(& $formatType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end WritableLog


// public static final String UNKNOWN_ID = "Unknown Id "
define("UNKNOWN_ID","Unknown Id ");

// public static final String UNKNOWN_TYPE = "Unknown or unsupported Type "
define("UNKNOWN_TYPE","Unknown or unsupported Type ");

// public static final String OPERATION_FAILED = "Operation failed "
define("OPERATION_FAILED","Operation failed ");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

// public static final String NULL_ARGUMENT = "Null argument"
define("NULL_ARGUMENT","Null argument");

// public static final String PERMISSION_DENIED = "Permission denied "
define("PERMISSION_DENIED","Permission denied ");

// public static final String CONFIGURATION_ERROR = "Configuration error "
define("CONFIGURATION_ERROR","Configuration error ");

// public static final String UNIMPLEMENTED = "Unimplemented method "
define("UNIMPLEMENTED","Unimplemented method ");

// public static final String PRIORITY_TYPE_NOT_SET = "Default priority Type not set "
define("PRIORITY_TYPE_NOT_SET","Default priority Type not set ");

// public static final String FORMAT_TYPE_NOT_SET = "Default format Type not set "
define("FORMAT_TYPE_NOT_SET","Default format Type not set ");

// public static final String FILE_NOT_FOUND = "File not found "
define("FILE_NOT_FOUND","File not found ");

// public static final String CANNOT_APPEND = "Cannot append "
define("CANNOT_APPEND","Cannot append ");

?>
