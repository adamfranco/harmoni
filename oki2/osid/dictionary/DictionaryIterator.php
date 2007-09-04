<?php 
 
/**
 * DictionaryIterator provides access to these objects sequentially, one at a
 * time.  The purpose of all Iterators is to to offer a way for OSID methods
 * to return multiple values of a common type and not use an array.  Returning
 * an array may not be appropriate if the number of values returned is large
 * or is fetched remotely.  Iterators do not allow access to values by index,
 * rather you must access values in sequence. Similarly, there is no way to go
 * backwards through the sequence unless you place the values in a data
 * structure, such as an array, that allows for access by index.
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
class DictionaryIterator
{
    /**
     * Return true if there is an additional  Dictionary ; false otherwise.
     *  
     * @return boolean
     * 
     * @throws object DictionaryException An exception with one of
     *         the following messages defined in
     *         org.osid.dictionary.DiictionaryException may be thrown:
     *         OPERATION_FAILED, PERMISSION_DENIED
     * 
     * @access public
     */
    function hasNextDictionary () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Return the next Dictionary.
     *  
     * @return object Dictionary
     * 
     * @throws object DictionaryException An exception with one of
     *         the following messages defined in
     *         org.osid.dictionary.DiictionaryException may be thrown:
     *         OPERATION_FAILED, PERMISSION_DENIED, NO_MORE_ITERATOR_ELEMENTS
     * 
     * @access public
     */
    function nextDictionary () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>