<?php 
 
/**
 * A Row contains the row contents from a ResultTable.  Its methods provide
 * access to the data returned in a ResultTable.
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
class Row
{
    /**
     * retrieve data from the column specified by index. This method uses the
     * standard sql convention of the first column has an index of 1.
     * 
     * @param int $columnIndex
     *  
     * @return object mixed (original type: java.io.Serializable)
     * 
     * @throws object SqlException An exception with one of the following
     *         messages defined in org.osid.sql.SqlException may be thrown:
     *         {@link org.osid.sql.SqlException#DATA_RETRIEVAL_ERROR}, {@link
     *         org.osid.sql.SqlException#INVALID_COLUMN_INDEX}, {@link
     *         org.osid.sql.SqlException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.sql.SqlException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.sql.SqlException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.sql.SqlException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getColumnByIndex ( $columnIndex ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * retrieve data from the column specified by name
     * 
     * @param string $columnName
     *  
     * @return object mixed (original type: java.io.Serializable)
     * 
     * @throws object SqlException An exception with one of the following
     *         messages defined in org.osid.sql.SqlException may be thrown:
     *         {@link org.osid.sql.SqlException#DATA_RETRIEVAL_ERROR}, {@link
     *         org.osid.sql.SqlException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.sql.SqlException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.sql.SqlException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.sql.SqlException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getColumnByName ( $columnName ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * return the columns associated with this Row.
     *  
     * @return object ObjectIterator
     * 
     * @throws object SqlException An exception with one of the following
     *         messages defined in org.osid.sql.SqlException may be thrown:
     *         {@link org.osid.sql.SqlException#DATA_RETRIEVAL_ERROR}, {@link
     *         org.osid.sql.SqlException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.sql.SqlException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.sql.SqlException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.sql.SqlException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    function &getColumns () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>