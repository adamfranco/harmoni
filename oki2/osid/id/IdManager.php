<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * IdManager creates and gets Ids.  Ids are used in many different contexts
 * throughout the OSIDs.  As with other Managers, use the OsidLoader to load
 * an implementation of this interface.
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
 * <p>
 * Unlike most Managers, IdManager does not have methods to return Type
 * information.
 * </p>
 * 
 * <p>
 * Licensed under the {@link org.osid.SidImplementationLicenseMIT MIT
 * O.K.I&#46; OSID Definition License}.
 * </p>
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package org.osid.id
 */
class IdManager
    extends OsidManager
{
    /**
     * Create a new unique identifier.
     *  
     * @return object Id
     * 
     * @throws object IdException An exception with one of the following
     *         messages defined in org.osid.id.IdException:  {@link
     *         org.osid.id.IdException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.id.IdException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.id.IdException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.id.IdException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @public
     */
    function &createId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the unique Id with this String representation or create a new unique
     * Id with this representation.
     * 
     * @param string $idString
     *  
     * @return object Id
     * 
     * @throws object IdException An exception with one of the following
     *         messages defined in org.osid.id.IdException:  {@link
     *         org.osid.id.IdException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.id.IdException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.id.IdException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.id.IdException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
     *         org.osid.id.IdException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @public
     */
    function &getId ( $idString ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>