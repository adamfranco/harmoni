<?php 
 
/**
 * CabinetEntryIterator is the iterator for a collection of CabinetEntries.
 * 
 * <p>
 * OSID provides a set of iterator interfaces for base types.  The purpose of
 * these iterators is to offer a way for SID methods to return multiple values
 * of a common type while avoiding the use arrays.  Returning an array may not
 * be appropriate if the number of values returned is large or if the array is
 * fetched remotely.
 * </p>
 * 
 * <p>
 * Note that iterators do not allow access to values by index; you must access
 * values sequentially. There is no way to go backwards through the sequence.
 * </p>
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
 * @see CabinetEntry
 * @see org.osid.OsidManager
 * 
 * @package org.osid.filing
 */
class CabinetEntryIterator
{
    /**
     * Method hasNextCabinetEntry
     *  
     * @return boolean
     * 
     * @throws object FilingException 
     * 
     * @public
     */
    function hasNextCabinetEntry () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Returns the next CabinetEntry in the collection.
     *  
     * @return object CabinetEntry
     * 
     * @throws object FilingException 
     * 
     * @public
     */
    function &nextCabinetEntry () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>