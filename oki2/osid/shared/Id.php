<?php 
 
/**
 * Id represents a unique identifier. A String representation of the unique
 * identifier is available with getIdString().  To convert from a String
 * representation of the identifier to the identifier object,
 * org.osid.shared.Id, use getId(String). Id can determine if it is equal to
 * another Id.
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
 * @package org.osid.shared
 */
class Id
{
    /**
     * Return the String representation of this unique Id.
     *  
     * @return string
     * 
     * @throws object SharedException An exception with one of the
     *         following messages defined in org.osid.shared.SharedException
     *         may be thrown:  {@link
     *         org.osid.shared.SharedException#UNKNOWN_TYPE UNKNOWN_TYPE},
     *         {@link org.osid.shared.SharedException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.shared.SharedException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.shared.SharedException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @public
     */
    function getIdString () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Tests if an unique Id equals this unique Id.
     * 
     * @param object Id $id
     *  
     * @return boolean
     * 
     * @throws object SharedException An exception with one of the
     *         following messages defined in org.osid.shared.SharedException
     *         may be thrown:  {@link
     *         org.osid.shared.SharedException#UNKNOWN_TYPE UNKNOWN_TYPE},
     *         {@link org.osid.shared.SharedException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.shared.SharedException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.shared.SharedException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.shared.SharedException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @public
     */
    function isEqual ( &$id ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>