<?php 
 
/**
 * Dictionary provides support for adding, removing, and getting entries by
 * Dictionary name and domain and then by tag.  A tag is a String that is used
 * to identify an entry.  This could be welcome_message, xyzDialog, etc.  The
 * entry is a serializable object stored and retrieved with the Dictionary,
 * for example the text of the welcome_message or the dialog resource for
 * xyzDialog.  The domain identifies the context for the Dictionary. This
 * could be java.util.Locale that is a designation that varies by country,
 * language, or other context.
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
interface Dictionary
{
    /**
     * Update the display name for this Dictionary.
     * 
     * @param string $displayName
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
     * @access public
     */
    public function updateDisplayName ( $displayName ); 

    /**
     * Update the description for this Dictionary.
     * 
     * @param string $description
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
     * @access public
     */
    public function updateDescription ( $description ); 

    /**
     * Get the display name for this Dictionary.
     *  
     * @return string
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
     * @access public
     */
    public function getDisplayName (); 

    /**
     * Get the description for this Dictionary.
     *  
     * @return string
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
     * @access public
     */
    public function getDescription (); 

    /**
     * Get the unique Id for this Dictionary.
     *  
     * @return object Id
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
     * @access public
     */
    public function getId (); 

    /**
     * Get the domain of this Dictionary.  The domain identifies the context
     * for the Dictionary. This could be java.util.Locale that is a
     * designation that varies by country, language, or other context.
     *  
     * @return object mixed (original type: java.io.Serializable)
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
     * @access public
     */
    public function getDomain (); 

    /**
     * Add an entry, a string-tag / serializable-value pair, to this
     * Dictionary.  If the tag is already used, the new value overwrites the
     * old or this can be an error.
     * 
     * @param string $tag
     * @param object mixed $value (original type: java.io.Serializable)
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
     *         NULL_ARGUMENT}, {@link
     *         org.osid.dictionary.DictionaryException#ALREADY_ADDED
     *         ALREADY_ADDED}
     * 
     * @access public
     */
    public function addEntry ( $tag, $value ); 

    /**
     * Remove the specified entry, a string-tag / serializable-value pair, from
     * this Dictionary.
     * 
     * @param string $tag
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
     *         NULL_ARGUMENT}, {@link
     *         org.osid.dictionary.DictionaryException#UNKNOWN_TAG
     *         UNKNOWN_TAG}
     * 
     * @access public
     */
    public function removeEntry ( $tag ); 

    /**
     * Get the entry in this Dictionary that corresponds to the specified tag.
     * 
     * @param string $tag
     *  
     * @return object mixed (original type: java.io.Serializable)
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
     *         UNIMPLEMENTED},  {@link
     *         org.osid.dictionary.DictionaryException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.dictionary.DictionaryException#UNKNOWN_TAG
     *         UNKNOWN_TAG}
     * 
     * @access public
     */
    public function getEntry ( $tag ); 

    /**
     * Get all the tags in this Dictionary.  Iterators return a set, one at a
     * time.
     *  
     * @return object StringIterator
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
     * @access public
     */
    public function getTags (); 
}

?>