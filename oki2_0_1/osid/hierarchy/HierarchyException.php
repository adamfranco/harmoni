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
     * @return string
     * @access public 
     * @static 
     */
    const  UNKNOWN_PARENT_NODE = "Cannot create Node with unknown parent ";

    /**
     * Cannot delete a Hierarchy containing Nodes
     * @return string
     * @access public 
     * @static 
     */
    const  HIERARCHY_NOT_EMPTY = "Cannot delete a Hierarchy containing Nodes ";

    /**
     * Hierarchy does not support allowsMultipleParents is false and
     * allowsRecursion is true
     * @return string
     * @access public 
     * @static 
     */
    const  UNSUPPORTED_CREATION = "Hierarchy does not support allowsMultipleParents is false and allowsRecursion is true ";

    /**
     * Hierarchy does not allow recursion
     * @return string
     * @access public 
     * @static 
     */
    const  ATTEMPTED_RECURSION = "Hierarchy does not allow recursion ";

    /**
     * Hierarchy does not allow multiple parents
     * @return string
     * @access public 
     * @static 
     */
    const  SINGLE_PARENT_HIERARCHY = "Hierarchy does not allow multiple parents ";

    /**
     * Removing parent will result in an inconsistent state
     * @return string
     * @access public 
     * @static 
     */
    const  INCONSISTENT_STATE = "Removing node will result in an inconsistent state ";

    /**
     * Unknown traversal mode
     * @return string
     * @access public 
     * @static 
     */
    const  UNKNOWN_TRAVERSAL_MODE = "Unknown traversal mode ";

    /**
     * Unknown traversal direction
     * @return string
     * @access public 
     * @static 
     */
    const  UNKNOWN_TRAVERSAL_DIRECTION = "Unknown traversal direction ";

    /**
     * NodeType has never been added
     * @return string
     * @access public 
     * @static 
     */
    const  NODE_TYPE_NOT_FOUND = "NodeType has never been added ";

    /**
     * Cannot remove NodeType referenced by a Node
     * @return string
     * @access public 
     * @static 
     */
    const  NODE_TYPE_IN_USE = "Cannot remove NodeType referenced by a Node ";
}

?>