<?php


	/**
	 * All implementors of OsidManager provide create, delete, and get methods for the various objects defined in the package.  Most managers also include methods for returning Types.  We use create methods in place of the new operator.  Create method implementations should both instantiate and persist objects.  The reason we avoid the new operator is that it makes the name of the implementing package explicit and requires a source code change in order to use a different package name. In combination with OsidLoader, applications developed using managers permit implementation substitution without source code changes. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dictionary
	 */
class DictionaryManager // :: API interface
	extends OsidManager
{

	/**
	 * Create a dictionary with the specified name and domain.
	 * @param displayName
	 * @param description
	 * @param domain
	 * @return Dictionary with its name, description, and Unique Id set
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DictionaryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function &createDictionary($displayName, $description, & $domain) { /* :: interface :: */ }
	// :: full java declaration :: Dictionary createDictionary(String displayName, String description, java.io.Serializable domain)

	/**
	 * Delete the dictionary with the specified Unique Id.
	 * @param dictionaryId
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DictionaryException#UNKNOWN_ID UNKNOWN_ID}, {@link DictionaryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function deleteDictionary(& $dictionaryId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteDictionary(osid.shared.Id dictionaryId)

	/**
	 * Get the dictionary with the specified name and domain.
	 * @param displayName
	 * @param domain
	 * @return Dictionary
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DictionaryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function &getDictionary($displayName, & $domain) { /* :: interface :: */ }
	// :: full java declaration :: Dictionary getDictionary(String displayName, java.io.Serializable domain)

	/**
	 * Get all the Dictionaries.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return DictionaryIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getDictionaries() { /* :: interface :: */ }
	// :: full java declaration :: DictionaryIterator getDictionaries()
}


	/**
	 * Dictionary provides support for adding, removing, and getting entries by Dictionary name and domain and then by tag.  A tag is a String that is used to identify an entry.  This could be welcome_message, xyzDialog, etc.  The entry is a serializable object stored and retrieved with the Dictionary, for example the text of the welcome_message or the dialog resource for xyzDialog.  The domain identifies the context for the Dictionary. This could be java.util.Locale that is a designation that varies by country, language, or other context. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dictionary
	 */
class Dictionary // :: API interface
//	extends java.io.Serializable
{

	/**
	 * Get the name for this Dictionary.
	 * @return String
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDisplayName() { /* :: interface :: */ }

	/**
	 * Update the name for this Dictionary.
	 * @param displayName
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DictionaryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDisplayName($DisplayName) { /* :: interface :: */ }

	/**
	 * Get the description for this Dictionary.
	 * @return String the name
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function getDescription() { /* :: interface :: */ }

	/**
	 * Update the description for this Dictionary.
	 * @param description
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DictionaryException#NULL_ARGUMENT NULL_ARGUMENT}
	 */
	function updateDescription($Description) { /* :: interface :: */ }

	/**
	 * Get the Unique Id for this Dictionary.
	 * @return osid.shared.Id Unique Id this is usually set by a create method's implementation
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getId() { /* :: interface :: */ }

	/**
	 * Get the domain of this Dictionary.  The domain identifies the context for the Dictionary. This could be java.util.Locale that is a designation that varies by country, language, or other context.
	 * @return java.io.Serializable
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getDomain() { /* :: interface :: */ }

	/**
	 * Add an entry, a string-tag / serializable-value pair, to this Dictionary.  If the tag is already used, the new value overwrites the old or this can be an error.
	 * @param tag
	 * @param value
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DictionaryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DictionaryException#ALREADY_ADDED ALREADY_ADDED}
	 */
	function addEntry($tag, & $value) { /* :: interface :: */ }
	// :: full java declaration :: void addEntry(String tag, java.io.Serializable value)

	/**
	 * Remove the specified entry, a string-tag / serializable-value pair, from this Dictionary.
	 * @param tag
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}, {@link DictionaryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DictionaryException#UNKNOWN_TAG UNKNOWN_TAG}
	 */
	function removeEntry($tag) { /* :: interface :: */ }
	// :: full java declaration :: void removeEntry(String tag)

	/**
	 * Get the entry in this Dictionary that corresponds to the specified tag.
	 * @param tag
	 * @return java.io.Serializable
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED},  {@link DictionaryException#NULL_ARGUMENT NULL_ARGUMENT}, {@link DictionaryException#UNKNOWN_TAG UNKNOWN_TAG}
	 */
	function &getEntry($tag) { /* :: interface :: */ }
	// :: full java declaration :: java.io.Serializable getEntry(String tag)

	/**
	 * Get all the tags in this Dictionary.  Iterators return a group of items, one item at a time.  The Iterator's hasNext method returns <code>true</code> if there are additional objects available; <code>false</code> otherwise.  The Iterator's next method returns the next object.
	 * @return osid.shared.StringIterator  The order of the objects returned by the Iterator is not guaranteed.
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  {@link DictionaryException#OPERATION_FAILED OPERATION_FAILED}, {@link DictionaryException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link DictionaryException#PERMISSION_DENIED PERMISSION_DENIED}, {@link DictionaryException#UNIMPLEMENTED UNIMPLEMENTED}
	 */
	function &getTags() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.StringIterator getTags()
}


	/**
	 * DictionaryIterator provides access to these objects sequentially, one at a time.  The purpose of all Iterators is to to offer a way for OSID methods to return multiple values of a common type and not use an array.  Returning an array may not be appropriate if the number of values returned is large or is fetched remotely.  Iterators do not allow access to values by index, rather you must access values in sequence. Similarly, there is no way to go backwards through the sequence unless you place the values in a data structure, such as an array, that allows for access by index.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dictionary
	 */
class DictionaryIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Dictionaries ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  OPERATION_FAILED, PERMISSION_DENIED
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Dictionaries.
	 * @return Dictoinary
	 * @throws osid.dictionary.DiictionaryException An exception with one of the following messages defined in osid.dictionary.DiictionaryException may be thrown:  OPERATION_FAILED, PERMISSION_DENIED, NO_MORE_ITERATOR_ELEMENTS
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Dictionary next()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method handle the OsidException. Since the application using an OsidManager can not determine where the implementation will ultimately execute, it must assume a worst case scenario and protect itself.
	<p>SID Version: 1.0 rc6<p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.dictionary
	 */
class DictionaryException // :: normal class
	extends OsidException
{

	/**
	 * Unknown Id
	 * @package osid.dictionary
	 */
	// :: defined globally :: define("UNKNOWN_ID","Unknown Id ");

	/**
	 * Unknown Tag
	 * @package osid.dictionary
	 */
	// :: defined globally :: define("UNKNOWN_TAG","Unknown Tag ");

	/**
	 * Operation failed
	 * @package osid.dictionary
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed ");

	/**
	 * Null argument
	 * @package osid.dictionary
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument");

	/**
	 * Permission denied
	 * @package osid.dictionary
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Object already added
	 * @package osid.dictionary
	 */
	// :: defined globally :: define("ALREADY_ADDED","Object already added ");

	/**
	 * Configuration error
	 * @package osid.dictionary
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Unimplemented method
	 * @package osid.dictionary
	 */
	// :: defined globally :: define("UNIMPLEMENTED","Unimplemented method");

	/**
	 * Iterator has no more elements
	 * @package osid.dictionary
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements");
}

// :: post-declaration code ::
/**
 * @const string UNKNOWN_ID public static final String UNKNOWN_ID = "Unknown Id "
 * @package osid.dictionary
 */
define("UNKNOWN_ID", "Unknown Id ");

/**
 * @const string UNKNOWN_TAG public static final String UNKNOWN_TAG = "Unknown Tag "
 * @package osid.dictionary
 */
define("UNKNOWN_TAG", "Unknown Tag ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed "
 * @package osid.dictionary
 */
define("OPERATION_FAILED", "Operation failed ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument"
 * @package osid.dictionary
 */
define("NULL_ARGUMENT", "Null argument");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied "
 * @package osid.dictionary
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * @const string ALREADY_ADDED public static final String ALREADY_ADDED = "Object already added "
 * @package osid.dictionary
 */
define("ALREADY_ADDED", "Object already added ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error "
 * @package osid.dictionary
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * @const string UNIMPLEMENTED public static final String UNIMPLEMENTED = "Unimplemented method"
 * @package osid.dictionary
 */
define("UNIMPLEMENTED", "Unimplemented method");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements"
 * @package osid.dictionary
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements");

?>
