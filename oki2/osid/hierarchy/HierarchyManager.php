<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * <p>
 * HierarchyManager handles creating, deleting, and getting Hierarchies.
 * </p>
 * 
 * <p>
 * All implementations of OsidManager (manager) provide methods for accessing
 * and manipulating the various objects defined in the OSID package. A manager
 * defines an implementation of an OSID. All other OSID objects come either
 * directly or indirectly from the manager. New instances of the OSID objects
 * are created either directly or indirectly by the manager.  Because the OSID
 * objects are defined using interfaces, create methods must be used instead
 * of the new operator to create instances of the OSID objects. Create methods
 * are used both to instantiate and persist OSID objects.  Using the
 * OsidManager class to define an OSID's implementation allows the application
 * to change OSID implementations by changing the OsidManager package name
 * used to load an implementation. Applications developed using managers
 * permit OSID implementation substitution without changing the application
 * source code. As with all managers, use the OsidLoader to load an
 * implementation of this interface.
 * </p>
 * 
 * <p></p>
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
class HierarchyManager
    extends OsidManager
{
    /**
     * Create a Hierarchy.
     * 
     * @param string $displayName
     * @param object Type[] $nodeTypes
     * @param string $description
     * @param boolean $allowsMultipleParents
     * @param boolean $allowsRecursion
     *  
     * @return object Hierarchy
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
     *         org.osid.hierarchy.HierarchyException#UNSUPPORTED_CREATION
     *         UNSUPPORTED_CREATION}
     * 
     * @access public
     */
    function &createHierarchy ( $displayName, &$nodeTypes, $description, $allowsMultipleParents, $allowsRecursion ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get a Hierarchy by unique Id.
     * 
     * @param object Id $hierarchyId
     *  
     * @return object Hierarchy
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
    function &getHierarchy ( &$hierarchyId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get all Hierarchies.
     *  
     * @return object HierarchyIterator
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
    function &getHierarchies () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Delete a Hierarchy by unique Id. All Nodes must be removed from the
     * Hierarchy before this method is called.
     * 
     * @param object Id $hierarchyId
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
     *         org.osid.hierarchy.HierarchyException#HIERARCHY_NOT_EMPTY
     *         HIERARCHY_NOT_EMPTY}
     * 
     * @access public
     */
    function deleteHierarchy ( &$hierarchyId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * This method indicates whether this implementation supports
     * HierarchyManager methods: createHierarchy, deleteHierarchy, updateName,
     * updateDescription, createRootNode, createNode, deleteNode, addNodeType,
     * removeNodeType. Note methods: nodeUpdateDescription,
     * noteUpdateDisplayName, addParent, removeParent, changeParent.
     *  
     * @return boolean
     * 
     * @throws object HierarchyException An exception with one of
     *         the following messages defined in
     *         org.osid.hierarchy.HierarchyException may be thrown: {@link
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
    function supportsMaintenance () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>