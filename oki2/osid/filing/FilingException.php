<?php 
 
include_once(dirname(__FILE__)."/../shared/SharedException.php");
/**
 * All methods of all interfaces of the Open Service Interface Definition
 * (OSID) throw a subclass of org.osid.OsidException. This requires the caller
 * of an osid package method handle the OsidException. Since the application
 * using an osid manager can not determine where the manager will ultimately
 * execute, it must assume a worst case scenario and protect itself.
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
class FilingException
    extends SharedException
{
    /**
     * Selected item already exists
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function ITEM_ALREADY_EXISTS () {
        return "Selected item already exists";
    }

    /**
     * Selected item does not exist
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function ITEM_DOES_NOT_EXIST () {
        return "Selected item does not exist";
    }

    /**
     * Unsupported operation
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function UNSUPPORTED_OPERATION () {
        return "Unsupported operation";
    }

    /**
     * IO error
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function IO_ERROR () {
        return "IO error";
    }

    /**
     * Unsupported CabinetEntry Type
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function UNSUPPORTED_TYPE () {
        return "Unsupported CabinetEntry Type";
    }

    /**
     * Cabinet is not empty
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function CABINET_NOT_EMPTY () {
        return "Cabinet is not empty";
    }

    /**
     * Object is not a Cabinet
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function NOT_A_CABINET () {
        return "Object is not a Cabinet";
    }

    /**
     * Object is not a ByteStore
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function NOT_A_BYTESTORE () {
        return "Object is not a ByteStore";
    }

    /**
     * Name contains illegal characters
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function NAME_CONTAINS_ILLEGAL_CHARS () {
        return "Name contains illegal characters";
    }

    /**
     * Owner is null
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function NULL_OWNER () {
        return "Owner is null";
    }

    /**
     * Delete failed
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function DELETE_FAILED () {
        return "Delete failed";
    }

    /**
     * Can't delete root Cabinet
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function CANNOT_DELETE_ROOT_CABINET () {
        return "Cannot delete root Cabinet";
    }


	function FilingException ( $message ) {
        die($message);
    }

}

?>