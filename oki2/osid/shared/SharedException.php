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
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function UNKNOWN_ID () {
        return "Unknown Id ";
    }

    /**
     * Unknown or unsupported Type
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function UNKNOWN_TYPE () {
        return "Unknown Type ";
    }

    /**
     * Iterator has no more elements
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function NO_MORE_ITERATOR_ELEMENTS () {
        return "Iterator has no more elements ";
    }

    /**
     * Object already added
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function ALREADY_ADDED () {
        return "Object already added ";
    }

    /**
     * Circular operation
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function CIRCULAR_OPERATION () {
        return "Circular operation not allowed ";
    }

    /**
     * Unknown key
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    function UNKNOWN_KEY () {
        return "Unknown key ";
    }


	function SharedException ( $message ) {
        die($message);
    }

}

?>