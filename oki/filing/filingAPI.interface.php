<?php

class ByteStore
	extends CabinetEntry
{ // begin ByteStore
	// public long length();
	function length() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean canAppend();
	function canAppend() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateAppendOnly();
	function updateAppendOnly() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getMimeType();
	function getMimeType() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String updateMimeType(String $mimeType);
	function updateMimeType($mimeType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean isReadable();
	function isReadable() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean isWritable();
	function isWritable() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateReadOnly();
	function updateReadOnly() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateWritable();
	function updateWritable() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDigest(osid.shared.Type & $algorithmType);
	function getDigest(& $algorithmType) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.TypeIterator & getDigestAlgorithmTypes();
	function & getDigestAlgorithmTypes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.ByteValueIterator & read(java.util.Calendar & $version);
	function & read(& $version) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void write(byte[] & $b);
	function write(& $b) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void write(byte[] & $b, int $off, int $len);
	function write(& $b, $off, $len) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void write(int $b);
	function write($b) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void commit();
	function commit() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end ByteStore


class Cabinet
	extends CabinetEntry 
{ // begin Cabinet
	// public java.util.Map & getProperties();
	function & getProperties() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public ByteStore & createByteStore(String $name);
	function & createByteStore($name) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Cabinet & createCabinet(String $name);
	function & createCabinet($name) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public ByteStore & copyByteStore(ByteStore & $oldByteStore, String $name);
	function & copyByteStore(& $oldByteStore, $name) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void add(String $name, CabinetEntry & $entry);
	function add($name, & $entry) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void remove(CabinetEntry & $entry);
	function remove(& $entry) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public CabinetEntry & getCabinetEntry(osid.shared.Id & $id);
	function & getCabinetEntry(& $id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public CabinetEntry & getCabinetEntry(String $name);
	function & getCabinetEntry($name) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public CabinetEntryIterator & entries();
	function & entries() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Cabinet & getRootCabinet();
	function & getRootCabinet() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean isRootCabinet();
	function isRootCabinet() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean isListable();
	function isListable() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public boolean isManageable();
	function isManageable() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public long getAvailableBytes();
	function getAvailableBytes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public long getUsedBytes();
	function getUsedBytes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end Cabinet


class CabinetEntry
	// extends java.io.Serializable
{ // begin CabinetEntry
	// public Cabinet & getParent();
	function & getParent() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.util.Calendar & getLastModifiedTime();
	function & getLastModifiedTime() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.CalendarIterator & getAllModifiedTimes();
	function & getAllModifiedTimes() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void touch();
	function touch() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.util.Calendar & getLastAccessedTime();
	function & getLastAccessedTime() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.util.Calendar & getCreatedTime();
	function & getCreatedTime() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Agent & getCabinetEntryAgent();
	function & getCabinetEntryAgent() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDisplayName(String $displayName);
	function updateDisplayName($displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end CabinetEntry


class FilingManager
	extends OsidManager
{ // begin FilingManager
	// public CabinetEntryIterator & listRoots();
	function & listRoots() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public CabinetEntry & getCabinetEntry(osid.shared.Id & $id);
	function & getCabinetEntry(& $id) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void delete(osid.shared.Id & $cabinetEntryId);
	function delete(& $cabinetEntryId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end FilingManager


class CabinetEntryIterator
{ // begin CabinetEntryIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public CabinetEntry & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end CabinetEntryIterator


// public final static String ITEM_ALREADY_EXISTS = "Selected item already exists";
define("ITEM_ALREADY_EXISTS","Selected item already exists";);

// public final static String ITEM_DOES_NOT_EXIST = "Selected item does not exist";
define("ITEM_DOES_NOT_EXIST","Selected item does not exist";);

// public final static String UNSUPPORTED_OPERATION = "Unsupported operation";
define("UNSUPPORTED_OPERATION","Unsupported operation";);

// public final static String IO_ERROR = "IO error";
define("IO_ERROR","IO error";);

// public final static String UNSUPPORTED_TYPE = "Unsupported CabinetEntry Type";
define("UNSUPPORTED_TYPE","Unsupported CabinetEntry Type";);

// public final static String CABINET_NOT_EMPTY = "Cabinet is not empty";
define("CABINET_NOT_EMPTY","Cabinet is not empty";);

// public final static String NOT_A_CABINET = "Object is not a Cabinet";
define("NOT_A_CABINET","Object is not a Cabinet";);

// public final static String NOT_A_BYTESTORE = "Object is not a ByteStore";
define("NOT_A_BYTESTORE","Object is not a ByteStore";);

// public final static String NAME_CONTAINS_ILLEGAL_CHARS = "Name contains illegal characters";
define("NAME_CONTAINS_ILLEGAL_CHARS","Name contains illegal characters";);

// public final static String NULL_OWNER = "Owner is null";
define("NULL_OWNER","Owner is null";);

// public final static String DELETE_FAILED = "Delete failed";
define("DELETE_FAILED","Delete failed";);

// public static final String OPERATION_FAILED = "Operation failed"
define("OPERATION_FAILED","Operation failed");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements"
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements");

// public static final String UNIMPLEMENTED = "Unimplemented method "
define("UNIMPLEMENTED","Unimplemented method ");

// public static final String PERMISSION_DENIED = "Permission denied"
define("PERMISSION_DENIED","Permission denied");

// public static final String NULL_ARGUMENT = "Null argument"
define("NULL_ARGUMENT","Null argument");

// public static final String CONFIGURATION_ERROR = "Configuration error"
define("CONFIGURATION_ERROR","Configuration error");

// public static final String CAN_NOT_DELETE_ROOT = "Can't delete root Cabinet"
define("CAN_NOT_DELETE_ROOT","Can't delete root Cabinet");

class FilingException
	extends OsidException
{ // begin FilingException
} // end FilingException


?>
