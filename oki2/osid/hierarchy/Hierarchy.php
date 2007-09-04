<?php 
 
/**
 * Hierarchy is a structure composed of nodes arranged in root, parent, and
 * child form.  The Hierarchy can be traversed in several ways to determine
 * the arrangement of nodes. A Hierarchy can allow multiple parents.  A
 * Hierarchy can allow recursion.  The implementation is responsible for
 * ensuring that the integrity of the Hierarchy is always maintained.
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
class Hierarchy
{
    /**
     * Constant indicating depth-first traversal.
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return int
     * @access public 
     * @static 
     */
    function TRAVERSE_MODE_DEPTH_FIRST () {
        return 223;
    }

    /**
     * Constant indicating breadth-first traversal.
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return int
     * @access public 
     * @static 
     */
    function TRAVERSE_MODE_BREADTH_FIRST () {
        return 191;
    }

    /**
     * Constant indicating traversal up the Hierarchy, or traversal of parents.
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return int
     * @access public 
     * @static 
     */
    function TRAVERSE_DIRECTION_UP () {
        return 1;
    }

    /**
     * Constant indicating traversal down the Hierarchy, or traversal of
     * children.
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return int
     * @access public 
     * @static 
     */
    function TRAVERSE_DIRECTION_DOWN () {
        return 2;
    }

    /**
     * Constant indicating no limit on the depth of traversal.
     * Note: This method is PHP's equivalent of a static field.
     * 
     * @return int
     * @access public 
     * @static 
     */
    function TRAVERSE_LEVELS_ALL () {
        return -1;
    }

    /**
     * Get the unique Id for this Hierarchy.
     *  
     * @return object Id
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the display name for this Hierarchy.
     *  
     * @return string
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getDisplayName () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Update the display name for this Hierarchy.
     * 
     * @param string $displayName
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function updateDisplayName ( $displayName ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the description for this Hierarchy.
     *  
     * @return string
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getDescription () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Update the description for this Hierarchy.
     * 
     * @param string $description
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    function updateDescription ( $description ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Create a root Node. The Node is created with the specified unique Id,
     * and, unlike Nodes created with createNode, initially has no parents or
     * children.
     * 
     * @param object Id $nodeId
     * @param object Type $nodeType
     * @param string $displayName
     * @param string $description
     *  
     * @return object Node
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}{@link
     *         org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.hierarchy.HierarchyException#SINGLE_PARENT_HIERARCHY
     *         SINGLE_PARENT_HIERARCHY}
     * 
     * @access public
     */
    function createRootNode ( $nodeId, $nodeType, $displayName, $description ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Create a Node. The Node is created with the specified unique Id and
     * initially has only the specified parent.
     * 
     * @param object Id $nodeId
     * @param object Id $parentId
     * @param object Type $type
     * @param string $displayName
     * @param string $description
     *  
     * @return object Node
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.hierarchy.HierarchyException#UNKNOWN_PARENT_NODE
     *         UNKNOWN_PARENT_NODE}, {@link
     *         org.osid.hierarchy.HierarchyException#ATTEMPTED_RECURSION
     *         ATTEMPTED_RECURSION}
     * 
     * @access public
     */
    function createNode ( $nodeId, $parentId, $type, $displayName, $description ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Delete a Node by Id.  Only leaf Nodes can be deleted.
     * 
     * @param object Id $nodeId
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
     *         NODE_TYPE_NOT_FOUND}, {@link
     *         org.osid.hierarchy.HierarchyException#INCONSISTENT_STATE
     *         INCONSISTENT_STATE}
     * 
     * @access public
     */
    function deleteNode ( $nodeId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Add a NodeType to this Hierarchy.
     * 
     * @param object Type $type
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.hierarchy.HierarchyException#ALREADY_ADDED
     *         ALREADY_ADDED}
     * 
     * @access public
     */
    function addNodeType ( $type ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Remove a NodeType from this Hierarchy.  Note that no Nodes can have this
     * NodeType.
     * 
     * @param object Type $type
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.hierarchy.HierarchyException#NODE_TYPE_IN_USE
     *         NODE_TYPE_IN_USE}, {@link
     *         org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
     *         NODE_TYPE_NOT_FOUND}
     * 
     * @access public
     */
    function removeNodeType ( $type ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get all the Nodes in this Hierarchy.
     *  
     * @return object NodeIterator
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getAllNodes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the root Nodes in this Hierarchy.
     *  
     * @return object NodeIterator
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getRootNodes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get a Node by unique Id.
     * 
     * @param object Id $nodeId
     *  
     * @return object Node
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
     *         NODE_TYPE_NOT_FOUND}
     * 
     * @access public
     */
    function getNode ( $nodeId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get all NodeTypes used in this Hierarchy.
     *  
     * @return object TypeIterator
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getNodeTypes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Returns true if multiple parents are allowed; false otherwise.
     *  
     * @return boolean
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function allowsMultipleParents () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Returns true if recursion allowed; false otherwise.
     *  
     * @return boolean
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function allowsRecursion () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Traverse a Hierarchy returning information about each Node encountered.
     * 
     * @param object Id $startId
     * @param int $mode
     * @param int $direction
     * @param int $levels
     *  
     * @return object TraversalInfoIterator
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown:  {@link
     *         org.osid.hierarchy.HierarchyException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.hierarchy.HierarchyException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.hierarchy.HierarchyException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.hierarchy.HierarchyException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.hierarchy.HierarchyException#NODE_TYPE_NOT_FOUND
     *         NODE_TYPE_NOT_FOUND}, {@link
     *         org.osid.hierarchy.HierarchyException#UNKNOWN_TRAVERSAL_MODE
     *         UNKNOWN_TRAVERSAL_MODE}, {@link
     *         org.osid.hierarchy.HierarchyException#UNKNOWN_TRAVERSAL_DIRECTION
     *         UNKNOWN_TRAVERSAL_DIRECTION}
     * 
     * @access public
     */
    function traverse ( $startId, $mode, $direction, $levels ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>