<?php 
 
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
 * @package org.osid
 */
class OsidException
    extends Exception
{
    /**
     * Operation failed
     * @return string
     * @access public 
     * @static 
     */
    const  OPERATION_FAILED = "Operation failed ";

    /**
     * Null argument
     * @return string
     * @access public 
     * @static 
     */
    const  NULL_ARGUMENT = "Null argument";

    /**
     * Unimplemented method
     * @return string
     * @access public 
     * @static 
     */
    const  UNIMPLEMENTED = "Unimplemented method ";

    /**
     * OSID Version mismatch
     * @return string
     * @access public 
     * @static 
     */
    const  VERSION_ERROR = "OSID Version mismatch error ";

    /**
     * Transaction already marked
     * @return string
     * @access public 
     * @static 
     */
    const  ALREADY_MARKED = "Transaction already marked ";

    /**
     * No transaction marked
     * @return string
     * @access public 
     * @static 
     */
    const  NOTHING_MARKED = "No transaction marked ";

    /**
     * Interface not found
     * @return string
     * @access public 
     * @static 
     */
    const  INTERFACE_NOT_FOUND = "Interface not found ";

    /**
     * Manager not OSID implementation
     * @return string
     * @access public 
     * @static 
     */
    const  MANAGER_NOT_OSID_IMPLEMENTATION = "Manager not OSID implementation ";

    /**
     * Manager not found
     * @return string
     * @access public 
     * @static 
     */
    const  MANAGER_NOT_FOUND = "Manager not found ";

    /**
     * Manager instantiation error
     * @return string
     * @access public 
     * @static 
     */
    const  MANAGER_INSTANTIATION_ERROR = "Manager instantiation error ";

    /**
     * Error assigning context
     * @return string
     * @access public 
     * @static 
     */
    const  ERROR_ASSIGNING_CONTEXT = "Error assigning context ";

    /**
     * Error assigning configuration
     * @return string
     * @access public 
     * @static 
     */
    const  ERROR_ASSIGNING_CONFIGURATION = "Error assigning configuration ";

    /**
     * Permission denied
     * @return string
     * @access public 
     * @static 
     */
    const  PERMISSION_DENIED = "Permission denied";

    /**
     * Configuration error
     * @return string
     * @access public 
     * @static 
     */
    const  CONFIGURATION_ERROR = "Configuration error";
}

?>