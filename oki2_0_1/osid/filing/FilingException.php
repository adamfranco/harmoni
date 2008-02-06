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
     * @return string
     * @access public 
     * @static 
     */
    const  ITEM_ALREADY_EXISTS = "Selected item already exists";

    /**
     * Selected item does not exist
     * @return string
     * @access public 
     * @static 
     */
    const  ITEM_DOES_NOT_EXIST = "Selected item does not exist";

    /**
     * Unsupported operation
     * @return string
     * @access public 
     * @static 
     */
    const  UNSUPPORTED_OPERATION = "Unsupported operation";

    /**
     * IO error
     * @return string
     * @access public 
     * @static 
     */
    const  IO_ERROR = "IO error";

    /**
     * Unsupported CabinetEntry Type
     * @return string
     * @access public 
     * @static 
     */
    const  UNSUPPORTED_TYPE = "Unsupported CabinetEntry Type";

    /**
     * Cabinet is not empty
     * @return string
     * @access public 
     * @static 
     */
    const  CABINET_NOT_EMPTY = "Cabinet is not empty";

    /**
     * Object is not a Cabinet
     * @return string
     * @access public 
     * @static 
     */
    const  NOT_A_CABINET = "Object is not a Cabinet";

    /**
     * Object is not a ByteStore
     * @return string
     * @access public 
     * @static 
     */
    const  NOT_A_BYTESTORE = "Object is not a ByteStore";

    /**
     * Name contains illegal characters
     * @return string
     * @access public 
     * @static 
     */
    const  NAME_CONTAINS_ILLEGAL_CHARS = "Name contains illegal characters";

    /**
     * Owner is null
     * @return string
     * @access public 
     * @static 
     */
    const  NULL_OWNER = "Owner is null";

    /**
     * Delete failed
     * @return string
     * @access public 
     * @static 
     */
    const  DELETE_FAILED = "Delete failed";

    /**
     * Can't delete root Cabinet
     * @return string
     * @access public 
     * @static 
     */
    const  CANNOT_DELETE_ROOT_CABINET = "Cannot delete root Cabinet";
}

?>