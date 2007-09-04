<?php 
 
/**
 * A Blob is a variable length representation of binary (byte) values.  (Blob
 * stands for <u>B</u>inary <u>L</u>arge <u>Ob</u>ject.)  The contents of a
 * Blob are returned in a ByteValueIterator by the getBytes() method.  Its
 * length is returned by the method length().
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
 * @package org.osid.sql
 */
class Blob
{
    /**
     * return this Blob's bytes.
     *  
     * @return object ByteValueIterator
     * 
     * @throws object SqlException An exception with one of the following
     *         messages defined in org.osid.sql.SqlException may be thrown:
     *         {@link org.osid.sql.SqlException#BLOB_GETBYTES_FAILED}, {@link
     *         org.osid.sql.SqlException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.sql.SqlException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.sql.SqlException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.sql.SqlException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function getBytes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * return the length of the object
     *  
     * @return int
     * 
     * @throws object SqlException An exception with one of the following
     *         messages defined in org.osid.sql.SqlException may be thrown:
     *         {@link org.osid.sql.SqlException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.sql.SqlException#PERMISSION_DENIED PERMISSION_DENIED},
     *         {@link org.osid.sql.SqlException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.sql.SqlException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function length () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>