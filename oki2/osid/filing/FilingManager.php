<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * <p>
 * FilingManager:
 * 
 * <ul>
 * <li>
 * creates root Cabinets,
 * </li>
 * <li>
 * deletes CabinetEntries,
 * </li>
 * <li>
 * gets root Cabinets and CabinetEntries.
 * </li>
 * </ul>
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
 * @package org.osid.filing
 */
class FilingManager
    extends OsidManager
{
    /**
     * Get all the root Cabinets currently available in this Manager.
     *  
     * @return object CabinetEntryIterator
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}
     * 
     * @public
     */
    function &getRoots () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get a CabinetEntry by ID.
     * 
     * @param object Id $id
     *  
     * @return object CabinetEntry
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}, {@link
     *         org.osid.filing.FilingException#ITEM_DOES_NOT_EXIST
     *         ITEM_DOES_NOT_EXIST}
     * 
     * @public
     */
    function &getCabinetEntry ( &$id ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Create a new root Cabinet with the given name. The name must not include
     * this Cabinet's separationCharacter.
     * 
     * @param string $displayName
     *  
     * @return object Cabinet
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}, {@link
     *         org.osid.filing.FilingException#ITEM_ALREADY_EXISTS
     *         ITEM_ALREADY_EXISTS}, {@link
     *         org.osid.filing.FilingException#NAME_CONTAINS_ILLEGAL_CHARS
     *         NAME_CONTAINS_ILLEGAL_CHARS}
     * 
     * @public
     */
    function &createRootCabinet ( $displayName ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Deletes this CabinetEntry. If the CabinetEntry is a Cabinet it must be
     * empty, and the Owner of the Manager must have sufficient permissions to
     * perform this action.
     * 
     * @param object Id $cabinetEntryId
     * 
     * @throws object FilingException An exception with one of the
     *         following messages defined in org.osid.filing.FilingException
     *         may be thrown: {@link
     *         org.osid.filing.FilingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.filing.FilingException#IO_ERROR IO_ERROR}, {@link
     *         org.osid.filing.FilingException#DELETE_FAILED DELETE_FAILED},
     *         {@link org.osid.filing.FilingException#CABINET_NOT_EMPTY
     *         CABINET_NOT_EMPTY}, {@link
     *         org.osid.filing.FilingException#ITEM_DOES_NOT_EXIST
     *         ITEM_DOES_NOT_EXIST}
     * 
     * @public
     */
    function delete ( &$cabinetEntryId ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>