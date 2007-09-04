<?php 
 
/**
 * The Connection represents the channel of communication with the database.
 * It is the means of submitting a query or update for execution.  A
 * ResultTable is returned by the executeQuery() methods.  The executeUpdate()
 * methods are used to execute commands that do not return resultsets such as
 * inserts, deletes, and other data management commands.
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
class Connection
{
    /**
     * execute the SQL statement
     * 
     * @param string $sql
     *  
     * @return object ResultTable
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
    function executeQuery ( $sql ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * execute the SQL statement replacing '?'s sequentially with the args.
     * 
     * @param string $sql
     * @param string $args
     *  
     * @return object ResultTable
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
    function executeQueryWithArgs ( $sql, $args ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * update the database using the SQL statement.
     * 
     * @param string $sql
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
    function executeUpdate ( $sql ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * update the database using the SQL statement replacing '?'s sequentially
     * with the args.
     * 
     * @param string $sql
     * @param string $args
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
    function executeUpdateWithArgs ( $sql, $args ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * return the SQL data types supported by this implementation
     *  
     * @return object TypeIterator
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
    function getSqlTypes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>