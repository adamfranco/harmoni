<?php

class OsidLoader
{ // begin OsidLoader
} // end OsidLoader


class OsidManager
	// extends java.io.Serializable
{ // begin OsidManager
	// public osid.OsidOwner & getOwner();
	function & getOwner() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateOwner(osid.OsidOwner & $owner);
	function updateOwner(& $owner) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateConfiguration(java.util.Map & $configuration);
	function updateConfiguration(& $configuration) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void osidVersion_1_0();
	function osidVersion_1_0() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end OsidManager


class OsidTransactionManager
	extends OsidManager
{ // begin OsidTransactionManager
	// public void mark();
	function mark() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void commit();
	function commit() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void rollback();
	function rollback() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end OsidTransactionManager


class OsidRomiManager
	extends OsidManager
{ // begin OsidRomiManager
	// public java.io.Serializable & invoke();
	function & invoke() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.io.Serializable & object();
	function & object() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String methodname();
	function methodname() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end OsidRomiManager


class OsidOwner
{ // begin OsidOwner
} // end OsidOwner


// public static final String OPERATION_FAILED = "Operation failed "
define("OPERATION_FAILED","Operation failed ");

// public static final String NULL_ARGUMENT = "Null argument"
define("NULL_ARGUMENT","Null argument");

// public static final String ALREADY_ADDED = "Context already added "
define("ALREADY_ADDED","Context already added ");

// public static final String UNKNOWN_CONTEXT = "Unknown Context "
define("UNKNOWN_CONTEXT","Unknown Context ");

// public static final String UNIMPLEMENTED = "Unimplemented method "
define("UNIMPLEMENTED","Unimplemented method ");

// public static final String VERSION_ERROR = "OSID Version mismatch error "
define("VERSION_ERROR","OSID Version mismatch error ");

// public static final String ALREADY_MARKED = "Transaction already marked "
define("ALREADY_MARKED","Transaction already marked ");

// public static final String NOTHING_MARKED = "No transaction marked "
define("NOTHING_MARKED","No transaction marked ");

// public static final String INTERFACE_NOT_FOUND = "Interface not found "
define("INTERFACE_NOT_FOUND","Interface not found ");

// public static final String MANAGER_NOT_FOUND = "Manager not found "
define("MANAGER_NOT_FOUND","Manager not found ");

// public static final String MANAGER_INSTANTIATION_ERROR = "Manager instantiation error "
define("MANAGER_INSTANTIATION_ERROR","Manager instantiation error ");

// public static final String ERROR_UPADTING_OWNER = "Error updating owner "
define("ERROR_UPADTING_OWNER","Error updating owner ");

// public static final String ERROR_UPADTING_CONFIGURATION = "Error updating configuration "
define("ERROR_UPADTING_CONFIGURATION","Error updating configuration ");

class OsidException
	// extends java.lang.Exception
{ // begin OsidException
} // end OsidException


?>
