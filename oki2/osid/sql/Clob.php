<?php 
 
/**
 * A Clob is a variable length representation of character values.  (Clob
 * stands for <u>C</u>haracter <u>L</u>arge <u>Ob</u>ject.)  The contents of a
 * Clob are returned in a CharValueIterator by the getChars() method.  Its
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
class Clob
{
    /**
     * return this Clobs's chars.
     *  
     * @return object CharValueIterator
     * 
     * @throws object SqlException An exception with one of the following
     *         messages defined in org.osid.sql.SqlException may be thrown:
     *         {@link org.osid.sql.SqlException#CLOB_GETCHARS_FAILED}, {@link
     *         org.osid.sql.SqlException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.sql.SqlException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.sql.SqlException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.sql.SqlException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @public
     */
    function &getChars () { 
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
     * @public
     */
    function length () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>