<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * <p>
 * DictionaryManager handles creating, deleting, and getting Dictionaries.
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
 * @package org.osid.dictionary
 */
class DictionaryManager
    extends OsidManager
{
    /**
     * Create a dictionary with the specified name and domain.
     * 
     * @param string $displayName
     * @param string $description
     * @param object mixed $domain (original type: java.io.Serializable)
     *  
     * @return object Dictionary
     * 
     * @throws object DictionaryException An exception with one of
     *         the following messages defined in
     *         org.osid.dictionary.DiictionaryException may be thrown:  {@link
     *         org.osid.dictionary.DictionaryException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.dictionary.DictionaryException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.dictionary.DictionaryException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.dictionary.DictionaryException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.dictionary.DictionaryException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @public
     */
    function &createDictionary ( $displayName, $description, &$domain ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Delete the dictionary with the specified unique Id.
     * 
     * @param object Id $dictionaryId
     * 
     * @throws object DictionaryException An exception with one of
     *         the following messages defined in
     *         org.osid.dictionary.DiictionaryException may be thrown:  {@link
     *         org.osid.dictionary.DictionaryException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.dictionary.DictionaryException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.dictionary.DictionaryException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.dictionary.DictionaryException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.dictionary.DictionaryException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.dictionary.DictionaryException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @public
     */
    function deleteDictionary ( &$dictionaryId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the dictionary with the specified unique Id.
     * 
     * @param object Id $dictionaryId
     *  
     * @return object Dictionary
     * 
     * @throws object DictionaryException An exception with one of
     *         the following messages defined in
     *         org.osid.dictionary.DiictionaryException may be thrown:  {@link
     *         org.osid.dictionary.DictionaryException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.dictionary.DictionaryException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.dictionary.DictionaryException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.dictionary.DictionaryException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.dictionary.DictionaryException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @public
     */
    function &getDictionary ( &$dictionaryId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get all the Dictionaries.  Iterators return a set, one at a time.
     *  
     * @return object DictionaryIterator
     * 
     * @throws object DictionaryException An exception with one of
     *         the following messages defined in
     *         org.osid.dictionary.DiictionaryException may be thrown:  {@link
     *         org.osid.dictionary.DictionaryException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.dictionary.DictionaryException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.dictionary.DictionaryException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.dictionary.DictionaryException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @public
     */
    function &getDictionaries () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>