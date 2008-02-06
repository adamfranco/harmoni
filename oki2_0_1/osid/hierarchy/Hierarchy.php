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
interface Hierarchy
{
    /**
     * Constant indicating depth-first traversal.
     * @return int
     * @access public 
     * @static 
     */
    const  TRAVERSE_MODE_DEPTH_FIRST = 223;

    /**
     * Constant indicating breadth-first traversal.
     * @return int
     * @access public 
     * @static 
     */
    const  TRAVERSE_MODE_BREADTH_FIRST = 191;

    /**
     * Constant indicating traversal up the Hierarchy, or traversal of parents.
     * @return int
     * @access public 
     * @static 
     */
    const  TRAVERSE_DIRECTION_UP = 1;

    /**
     * Constant indicating traversal down the Hierarchy, or traversal of
     * children.
     * @return int
     * @access public 
     * @static 
     */
    const  TRAVERSE_DIRECTION_DOWN = 2;

    /**
     * Constant indicating no limit on the depth of traversal.
     * @return int
     * @access public 
     * @static 
     */
    const  TRAVERSE_LEVELS_ALL = -1;

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
    public function getId (); 

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
    public function getDisplayName (); 

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
    public function updateDisplayName ( $displayName ); 

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
    public function getDescription (); 

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
    public function updateDescription ( $description ); 

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
    public function createRootNode ( Id $nodeId, Type $nodeType, $displayName, $description ); 

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
    public function createNode ( Id $nodeId, Id $parentId, Type $type, $displayName, $description ); 

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
    public function deleteNode ( Id $nodeId ); 

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
    public function addNodeType ( Type $type ); 

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
    public function removeNodeType ( Type $type ); 

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
    public function getAllNodes (); 

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
    public function getRootNodes (); 

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
    public function getNode ( Id $nodeId ); 

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
    public function getNodeTypes (); 

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
    public function allowsMultipleParents (); 

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
    public function allowsRecursion (); 

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
    public function traverse ( Id $startId, $mode, $direction, $levels ); 
}

?>