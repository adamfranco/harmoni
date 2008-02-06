<?php 
 
include_once(dirname(__FILE__)."/../OsidException.php");
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
 * @package org.osid.shared
 */
class SharedException
    extends OsidException
{
    /**
     * Unknown Id
     * @return string
     * @access public 
     * @static 
     */
    const  UNKNOWN_ID = "Unknown Id ";

    /**
     * Unknown or unsupported Type
     * @return string
     * @access public 
     * @static 
     */
    const  UNKNOWN_TYPE = "Unknown Type ";

    /**
     * Iterator has no more elements
     * @return string
     * @access public 
     * @static 
     */
    const  NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements ";

    /**
     * Object already added
     * @return string
     * @access public 
     * @static 
     */
    const  ALREADY_ADDED = "Object already added ";

    /**
     * Circular operation
     * @return string
     * @access public 
     * @static 
     */
    const  CIRCULAR_OPERATION = "Circular operation not allowed ";

    /**
     * Unknown key
     * @return string
     * @access public 
     * @static 
     */
    const  UNKNOWN_KEY = "Unknown key ";
}

?>