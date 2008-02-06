<?php 
 
/**
 * Node is a Hierarchy's representation of an external object that is one of a
 * number of similar objects to be organized. Nodes must be connected to a
 * Hierarchy.
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
interface Node
{
    /**
     * Get the unique Id for this Node.
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
     * Get the display name for this Node.
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
     * Get the description for this Node.
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
     * Get the parents of this Node.  To get other ancestors use the Hierarchy
     * traverse method.
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
    public function getParents (); 

    /**
     * Get the children of this Node.  To get other descendants use the
     * Hierarchy traverse method.
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
    public function getChildren (); 

    /**
     * Get the Type for this Node.
     *  
     * @return object Type
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
    public function getType (); 

    /**
     * Update the description of this Node.
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
     * Update the name of this Node. Node name changes are permitted since the
     * Hierarchy's integrity is based on the Node's unique Id.
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
     *         UNIMPLEMENTED}, {@link
     *         org.osid.hierarchy.HierarchyException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function updateDisplayName ( $displayName ); 

    /**
     * Return true if this Node is a leaf; false otherwise.  A Node is a leaf
     * if it has no children.
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
    public function isLeaf (); 

    /**
     * Return true if this Node is a root; false otherwise.
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
    public function isRoot (); 

    /**
     * Link a parent to this Node.
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
     *         org.osid.hierarchy.HierarchyException#SINGLE_PARENT_HIERARCHY
     *         SINGLE_PARENT_HIERARCHY}, {@link
     *         org.osid.hierarchy.HierarchyException#ALREADY_ADDED
     *         ALREADY_ADDED}, {@link
     *         org.osid.hierarchy.HierarchyException#ATTEMPTED_RECURSION
     *         ATTEMPTED_RECURSION}
     * 
     * @access public
     */
    public function addParent ( Id $nodeId ); 

    /**
     * Unlink a parent from this Node.
     * 
     * @param object Id $parentId
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
     *         org.osid.hierarchy.HierarchyException#SINGLE_PARENT_HIERARCHY
     *         SINGLE_PARENT_HIERARCHY}, {@link
     *         org.osid.hierarchy.HierarchyException#INCONSISTENT_STATE
     *         INCONSISTENT_STATE}
     * 
     * @access public
     */
    public function removeParent ( Id $parentId ); 

    /**
     * Changes the parent of this Node by adding a new parent and removing the
     * old parent.
     * 
     * @param object Id $oldParentId
     * @param object Id $newParentId
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
     *         org.osid.hierarchy.HierarchyException#ATTEMPTED_RECURSION
     *         ATTEMPTED_RECURSION}
     * 
     * @access public
     */
    public function changeParent ( Id $oldParentId, Id $newParentId ); 
}

?>