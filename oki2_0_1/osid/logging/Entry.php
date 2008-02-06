<?php 
 
/**
 * Contains the logged item, its format type, its priority type, and the time
 * the item was logged.
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
interface Entry
{
    /**
     * Return the logged item.
     *  
     * @return object mixed (original type: java.io.Serializable)
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
    public function getItem (); 

    /**
     * Return the format type of logged item.
     *  
     * @return object Type
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
    public function getFormatType (); 

    /**
     * Return the format type of logged item.
     *  
     * @return object Type
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
    public function getPriorityType (); 

    /**
     * Return the time that the item was logged.
     *  
     * @return int
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
    public function getTimestamp (); 
}

?>