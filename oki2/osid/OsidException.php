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
{
    /**
     * Operation failed
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function OPERATION_FAILED () {
        return "Operation failed ";
    }

    /**
     * Null argument
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function NULL_ARGUMENT () {
        return "Null argument";
    }

    /**
     * Unimplemented method
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function UNIMPLEMENTED () {
        return "Unimplemented method ";
    }

    /**
     * OSID Version mismatch
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function VERSION_ERROR () {
        return "OSID Version mismatch error ";
    }

    /**
     * Transaction already marked
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function ALREADY_MARKED () {
        return "Transaction already marked ";
    }

    /**
     * No transaction marked
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function NOTHING_MARKED () {
        return "No transaction marked ";
    }

    /**
     * Interface not found
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function INTERFACE_NOT_FOUND () {
        return "Interface not found ";
    }

    /**
     * Manager not OSID implementation
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function MANAGER_NOT_OSID_IMPLEMENTATION () {
        return "Manager not OSID implementation ";
    }

    /**
     * Manager not found
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function MANAGER_NOT_FOUND () {
        return "Manager not found ";
    }

    /**
     * Manager instantiation error
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function MANAGER_INSTANTIATION_ERROR () {
        return "Manager instantiation error ";
    }

    /**
     * Error assigning context
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function ERROR_ASSIGNING_CONTEXT () {
        return "Error assigning context ";
    }

    /**
     * Error assigning configuration
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function ERROR_ASSIGNING_CONFIGURATION () {
        return "Error assigning configuration ";
    }

    /**
     * Permission denied
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function PERMISSION_DENIED () {
        return "Permission denied";
    }

    /**
     * Configuration error
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @public 
     * @static 
     */
    function CONFIGURATION_ERROR () {
        return "Configuration error";
    }


	function OsidException ( $message ) {
        die($message);
    }

}

?>