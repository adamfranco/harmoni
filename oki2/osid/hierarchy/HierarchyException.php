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
 * @package org.osid.hierarchy
 */
class HierarchyException
    extends SharedException
{
    /**
     * Cannot create Node without unknown parent
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function UNKNOWN_PARENT_NODE () {
        return "Cannot create Node with unknown parent ";
    }

    /**
     * Cannot delete a Hierarchy containing Nodes
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function HIERARCHY_NOT_EMPTY () {
        return "Cannot delete a Hierarchy containing Nodes ";
    }

    /**
     * Hierarchy does not support allowsMultipleParents is false and
     * allowsRecursion is true
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function UNSUPPORTED_CREATION () {
        return "Hierarchy does not support allowsMultipleParents is false and allowsRecursion is true ";
    }

    /**
     * Hierarchy does not allow recursion
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function ATTEMPTED_RECURSION () {
        return "Hierarchy does not allow recursion ";
    }

    /**
     * Hierarchy does not allow multiple parents
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function SINGLE_PARENT_HIERARCHY () {
        return "Hierarchy does not allow multiple parents ";
    }

    /**
     * Removing parent will result in an inconsistent state
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function INCONSISTENT_STATE () {
        return "Removing node will result in an inconsistent state ";
    }

    /**
     * Unknown traversal mode
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function UNKNOWN_TRAVERSAL_MODE () {
        return "Unknown traversal mode ";
    }

    /**
     * Unknown traversal direction
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function UNKNOWN_TRAVERSAL_DIRECTION () {
        return "Unknown traversal direction ";
    }

    /**
     * NodeType has never been added
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function NODE_TYPE_NOT_FOUND () {
        return "NodeType has never been added ";
    }

    /**
     * Cannot remove NodeType referenced by a Node
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return string
     * @access public 
     * @static 
     */
    static static function NODE_TYPE_IN_USE () {
        return "Cannot remove NodeType referenced by a Node ";
    }


	function HierarchyException ( $message ) {
        die($message);
    }

}

?>