<?php 
 
include_once(dirname(__FILE__)."/OsidManager.php");
/**
 * OsidRomiManager is the key binding for accessing remote computing
 * environments either by the application or by an OSID implementation.
 * Applications usually are unaware of whether a resource being used is remote
 * or local.  The OSID implementation used by an application can be
 * implemented as a local service, a remote service, or both.  Applications
 * using only OSIDs and their implementations can leave issues associated with
 * remote resources to the implementation.  Although implementations are
 * expected to handle accessing most remote resources, there are cases where a
 * special implementation, designed for this purpose, is needed.  An
 * application should not handle remote access on its own and in an ad hoc
 * way, because the application will no longer be interoperable across the
 * org.osid community.  If the application can find no way to a resource
 * through OSID implementations supporting OsidManager, the application should
 * load an implementation of the OsidRomiManager interface.  This interface
 * provides extra support for access to remote resources.
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
 * @package org.osid
 */
class OsidRomiManager
    extends OsidManager
{
    /**
     * Invokes a method remotely.
     * 
     * @param object mixed $object (original type: java.io.Serializable)
     * @param string $methodname
     * @param string $argTypes
     * @param array $args (original type: java.io.Serializable[])
     *  
     * @return object mixed (original type: java.io.Serializable)
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.OsidException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.OsidException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @public
     */
    function &invoke ( &$object, $methodname, $argTypes, $args ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>