<?php 
 
/**
 * An entry in a Cabinet, a CabinetEntry is either a ByteStore or a Cabinet.
 * CabinetEntry contains information common to both Cabinets and Bytestores
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
 * @package org.osid.filing
 */
class CabinetEntry
{
    /**
     * Get all the Property Types for  CabinetEntry.
     *  
     * @return object TypeIterator
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.filing.FilingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @public
     */
    function &getPropertyTypes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Returns true or false depending on whether this CabinetEntry exists in
     * the file system.
     *  
     * @return boolean
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}
     * 
     * @public
     */
    function exists () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Returns the Cabinet in which this CabinetEntry is an entry, or null if
     * it has no parent (for example is the root Cabinet).
     *  
     * @return object Cabinet
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}
     * 
     * @public
     */
    function &getParent () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Properties of this Type associated with this CabinetEntry.
     * 
     * @param object Type $propertiesType
     *  
     * @return object Properties
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.filing.FilingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.filing.FilingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.filing.FilingException#UNKNOWN_TYPE UNKNOWN_TYPE}
     * 
     * @public
     */
    function &getPropertiesByType ( &$propertiesType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Properties associated with this CabinetEntry.
     *  
     * @return object PropertiesIterator
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.filing.FilingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @public
     */
    function &getProperties () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Return the name of this CabinetEntry in its parent Cabinet.
     *  
     * @return string
     * 
     * @throws object FilingException 
     * 
     * @public
     */
    function getDisplayName () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get Id of this CabinetEntry
     *  
     * @return object Id
     * 
     * @throws object FilingException 
     * 
     * @public
     */
    function &getId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Returns when this Cabinet was last modified.
     *  
     * @return int
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link org.osid.filing.FilingException#IO_ERROR
     *         IO_ERROR}, {@link org.osid.filing.FilingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @public
     */
    function getLastModifiedTime () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Returns all the times that this Cabinet was modified.
     *  
     * @return object LongValueIterator
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link org.osid.filing.FilingException#IO_ERROR
     *         IO_ERROR}, {@link org.osid.filing.FilingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @public
     */
    function &getAllModifiedTimes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Sets the last-modified time to the current time for this CabinetEntry.
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}, {@link
     *         org.osid.filing.FilingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @public
     */
    function touch () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Returns when this Cabinet was last accessed. Not all implementations
     * will record last access times accurately, due to caching and
     * performance.  The value returned will be at least the last modified
     * time, the actual time when a read was performed may be later.
     *  
     * @return int
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link org.osid.filing.FilingException#IO_ERROR
     *         IO_ERROR}, {@link org.osid.filing.FilingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @public
     */
    function getLastAccessedTime () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Returns when this CabinetEntry was created. Not all implementations will
     * record the time of creation accurately.  The value returned will be at
     * least the last modified time, the actual creation time may be earlier.
     *  
     * @return int
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link org.osid.filing.FilingException#IO_ERROR
     *         IO_ERROR}, {@link org.osid.filing.FilingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @public
     */
    function getCreatedTime () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Return the Id of the Agent that owns this CabinetEntry.
     *  
     * @return object Id
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}, {@link
     *         org.osid.filing.FilingException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @public
     */
    function &getCabinetEntryAgentId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Change the name of this CabinetEntry to <code>displayName</code>
     * 
     * @param string $displayName
     * 
     * @throws object FilingException 
     * 
     * @public
     */
    function updateDisplayName ( $displayName ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>