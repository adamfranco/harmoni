<?php 
 
include_once(dirname(__FILE__)."/../shared/SharedException.php");
/**
 * OsidException or one of its subclasses is thrown by all methods of all
 * interfaces of an Open Service Interface Definition (OSID). This requires
 * the caller of an OSID package method handle the OsidException. Since the
 * application using an OSID can not determine where an implementation method
 * will ultimately execute, it must assume a worst case scenerio and protect
 * itself. OSID Implementations should throw their own subclasses of
 * OsidException and limit exception messages to those predefined by their own
 * OsidException or its superclasses. This approach to exception messages
 * allows Applications and OSID implementations using an OsidException's
 * predefined messages to handle exceptions in an interoperable way.
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
class SqlException
    extends SharedException
{
    /**
     * Blob get bytes failed
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function BLOB_GETBYTES_FAILED () {
        return "Blob get bytes failed ";
    }

    /**
     * Clob get chars failed
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function CLOB_GETCHARS_FAILED () {
        return "Clob get chars failed ";
    }

    /**
     * Connection failed
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function CONNECTION_FAILED () {
        return "Connection failed ";
    }

    /**
     * Invalid arguments
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function INVALID_ARGUMENTS () {
        return "Invalid arguments ";
    }

    /**
     * Invalid column index.  Note that column numbering begins with one, not
     * zero.
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function INVALID_COLUMN_INDEX () {
        return "Invalid column index ";
    }

    /**
     * Data retrieval error
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function DATA_RETRIEVAL_ERROR () {
        return "Data retrieval error ";
    }


	function SqlException ( $message ) {
        die($message);
    }

}

?>