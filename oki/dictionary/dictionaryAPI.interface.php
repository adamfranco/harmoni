<?php

class DictionaryManager
	extends OsidManager
{ // begin DictionaryManager
	// public Dictionary & createDictionary(String $description, java.io.Serializable & $domain, String $displayName);
	function & createDictionary($description, & $domain, $displayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void deleteDictionary(osid.shared.Id & $dictionaryId);
	function deleteDictionary(& $dictionaryId) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Dictionary & getDictionary(java.io.Serializable & $domain, String $name);
	function & getDictionary(& $domain, $name) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public DictionaryIterator & getDictionaries();
	function & getDictionaries() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end DictionaryManager


class Dictionary
	// extends java.io.Serializable
{ // begin Dictionary
	// public String getDisplayName();
	function getDisplayName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDisplayName(String $DisplayName);
	function updateDisplayName($DisplayName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public String getDescription();
	function getDescription() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void updateDescription(String $Description);
	function updateDescription($Description) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.Id & getId();
	function & getId() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.io.Serializable & getDomain();
	function & getDomain() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void addEntry(String $tag, java.io.Serializable & $value);
	function addEntry($tag, & $value) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public void removeEntry(String $tag);
	function removeEntry($tag) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public java.io.Serializable & getEntry(String $tag);
	function & getEntry($tag) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public osid.shared.StringIterator & getTags();
	function & getTags() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end Dictionary


class DictionaryIterator
{ // begin DictionaryIterator
	// public boolean hasNext();
	function hasNext() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

	// public Dictionary & next();
	function & next() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface <b> ".__CLASS__."</b> has not been overloaded in a child class.");
	}

} // end DictionaryIterator


// public static final String UNKNOWN_ID = "Unknown Id "
define("UNKNOWN_ID","Unknown Id ");

// public static final String UNKNOWN_TAG = "Unknown Tag "
define("UNKNOWN_TAG","Unknown Tag ");

// public static final String UNKNOWN_DICTIONARY = "Unknown Dictionary "
define("UNKNOWN_DICTIONARY","Unknown Dictionary ");

// public static final String OPERATION_FAILED = "Operation failed "
define("OPERATION_FAILED","Operation failed ");

// public static final String NULL_ARGUMENT = "Null argument"
define("NULL_ARGUMENT","Null argument");

// public static final String PERMISSION_DENIED = "Permission denied "
define("PERMISSION_DENIED","Permission denied ");

// public static final String ALREADY_ADDED = "Tag already added "
define("ALREADY_ADDED","Tag already added ");

// public static final String CONFIGURATION_ERROR = "Configuration error "
define("CONFIGURATION_ERROR","Configuration error ");

// public static final String UNIMPLEMENTED = "Unimplemented method"
define("UNIMPLEMENTED","Unimplemented method");

// public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements"
define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements");

?>
