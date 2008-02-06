<?php 
 
/**
 * A ResultTable is tabular data returned by a query.  You access the returned
 * data by calling the method getRows() which returns a RowIterator.
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
interface ResultTable
{
    /**
     * return the number of columns in this ResultTable.
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
    public function getColumnCount (); 

    /**
     * return the columnar metadata of this ResultTable.
     *  
     * @return object ResultMetaDataIterator
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
    public function getResultMetaData (); 

    /**
     * return the rows of this ResultTable.
     *  
     * @return object RowIterator
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
    public function getRows (); 
}

?>