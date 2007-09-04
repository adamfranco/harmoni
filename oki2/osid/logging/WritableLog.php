<?php 
 
/**
 * Interface WritableLog allows writing of entry items, format types, priority
 * types to a log.  Two methods are used to write the entryItems:
 * 
 * <p>
 * <code>appendLog(java.io.Serializable entryItem)</code> which writes the
 * entry to the Log,
 * </p>
 * 
 * <p>
 * <code>appendLog(java.io.Serializable entryItem, org.osid.shared.Type
 * formatType, org.osid.shared.Type priorityType)</code> which writes the
 * entryItem to the Log as well as formatType and priorityType.
 * </p>
 * 
 * <p>
 * The implementation sets the timestamp for the for when the entryItem was
 * appended to the log. The format type and the priority type can be set as
 * defaults for subsequent appends.
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
 * @package org.osid.logging
 */
class WritableLog
{
    /**
     * Get the display name for this WritableLog.
     *  
     * @return string
     * 
     * @throws object LoggingException An exception with one of the
     *         following messages defined in org.osid.logging.LoggingException
     *         may be thrown:   {@link
     *         org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.logging.LoggingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.logging.LoggingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.logging.LoggingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}
     * 
     * @access public
     */
    function getDisplayName () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Write the entryItem to the Log. The entryItem is written to the Log
     * using the format type and priority type explicitly set by the
     * application or the implementation default.
     * 
     * @param object mixed $entryItem (original type: java.io.Serializable)
     * 
     * @throws object LoggingException An exception with one of the
     *         following messages defined in org.osid.logging.LoggingException
     *         may be thrown:   {@link
     *         org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.logging.LoggingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.logging.LoggingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.logging.LoggingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.logging.LoggingException#PRIORITY_TYPE_NOT_SET
     *         PRIORITY_TYPE_NOT_SET}, {@link
     *         org.osid.logging.LoggingException#FORMAT_TYPE_NOT_SET
     *         FORMAT_TYPE_NOT_SET}, {@link
     *         org.osid.logging.LoggingException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @access public
     */
    function appendLog ( $entryItem ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Write the entry, the priorityType and formatType to the Log.
     * 
     * @param object mixed $entryItem (original type: java.io.Serializable)
     * @param object Type $formatType
     * @param object Type $priorityType
     * 
     * @throws object LoggingException An exception with one of the
     *         following messages defined in org.osid.logging.LoggingException
     *         may be thrown:   {@link
     *         org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.logging.LoggingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.logging.LoggingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.logging.LoggingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.logging.LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE},
     *         {@link org.osid.logging.LoggingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    function appendLogWithTypes ( $entryItem, $formatType, $priorityType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Assign the priorityType for all subsequent writes during the lifetime of
     * this instance. PriorityType has meaning to the caller of this method.
     * 
     * @param object Type $priorityType
     * 
     * @throws object LoggingException An exception with one of the
     *         following messages defined in org.osid.logging.LoggingException
     *         may be thrown:   {@link
     *         org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.logging.LoggingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.logging.LoggingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.logging.LoggingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.logging.LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE},
     *         {@link org.osid.logging.LoggingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    function assignPriorityType ( $priorityType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Assign the formatType for all subsequent writes during the lifetime of
     * this instance. FormatType has meaning to the caller of this method.
     * 
     * @param object Type $formatType
     * 
     * @throws object LoggingException An exception with one of the
     *         following messages defined in org.osid.logging.LoggingException
     *         may be thrown:   {@link
     *         org.osid.logging.LoggingException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.logging.LoggingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.logging.LoggingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.logging.LoggingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.logging.LoggingException#UNKNOWN_TYPE UNKNOWN_TYPE},
     *         {@link org.osid.logging.LoggingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    function assignFormatType ( $formatType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>