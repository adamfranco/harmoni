<?php 
 
include_once(dirname(__FILE__)."/OsidManager.php");
/**
 * OsidTransactionManager is the key binding for controlling persistent store
 * transactions from an application or an implementation of an OSID.
 * Operations involved with these methods have the following characteristics:
 * 
 * <p>
 * either the entire set of actions occurs or nothing happens;
 * </p>
 * 
 * <p>
 * actions occurring within a transaction are hidden from other concurrent
 * transactions;
 * </p>
 * 
 * <p>
 * successfully committed transactions result in a consistent persisted data
 * store.
 * </p>
 * 
 * <p>
 * mark() identifies a point in processing.  After mark(), at any point up
 * until commit() is called, a call to rollback() causes all processing after
 * mark() to be ignored.  The system is the same state it was at the time
 * mark() was called.  If instead commit() is called after mark(), all
 * processing since mark() was called is made permanent.  Once committed,
 * these actions cannot be rolled back.
 * </p>
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
interface OsidTransactionManager
    extends OsidManager
{
    /**
     * Marks the beginning of a transaction.
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.OsidException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.OsidException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
     *         org.osid.OsidException#ALREADY_MARKED ALREADY_MARKED}
     * 
     * @access public
     */
    public function mark (); 

    /**
     * Commits a transaction, persisting its operations since a call to mark().
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.OsidException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.OsidException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
     *         org.osid.OsidException#NOTHING_MARKED NOTHING_MARKED}
     * 
     * @access public
     */
    public function commit (); 

    /**
     * Rolls back a transaction's operations since a call to mark().
     * 
     * @throws object OsidException An exception with one of the following
     *         messages defined in org.osid.OsidException:  {@link
     *         org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
     *         {@link org.osid.OsidException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.OsidException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
     *         org.osid.OsidException#NOTHING_MARKED NOTHING_MARKED}
     * 
     * @access public
     */
    public function rollback (); 
}

?>