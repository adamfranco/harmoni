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
 * @package org.osid.workflow
 */
class WorkflowException
    extends SharedException
{
    /**
     * Unknown Expression
     * @return string
     * @access public 
     * @static 
     */
    const  UNKNOWN_EXPRESSION = "Unknown Expression ";

    /**
     * Unknown Output State
     * @return string
     * @access public 
     * @static 
     */
    const  UNKNOWN_OUTPUT_STATE = "Unknown Output State ";

    /**
     * Invalid network
     * @return string
     * @access public 
     * @static 
     */
    const  INVALID_NETWORK = "Invalid network ";

    /**
     * Work is not halted
     * @return string
     * @access public 
     * @static 
     */
    const  NOT_HALTED = "Work is not halted ";
}

?>