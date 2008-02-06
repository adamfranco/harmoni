<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * <p>
 * SchedulingManager creates, deletes, and gets ScheduleItems.  Items include
 * Agent Commitments (e.g. Calendar events).  The Manager also enumerates the
 * commitment Status Types supported by the implementation.
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
 * @package org.osid.scheduling
 */
interface SchedulingManager
    extends OsidManager
{
    /**
     * Create a ScheduleItem.  The masterIdentifier argument is optional.    A
     * Master Identifier is a key, rule, or function that can be used to
     * associated more than one ScheduleItem together.  An example can be
     * recurring items where each recurring item has the same Master
     * Identifier.   An unique Id is generated for this ScheduleItem by the
     * implementation.
     * 
     * @param string $displayName
     * @param string $description
     * @param object array $agents
     * @param int $start
     * @param int $end
     * @param string $masterIdentifier
     *  
     * @return object ScheduleItem
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.scheduling.SchedulingException#END_BEFORE_START
     *         END_BEFORE_START}
     * 
     * @access public
     */
    public function createScheduleItem ( $displayName, $description, array $agents, $start, $end, $masterIdentifier ); 

    /**
     * Delete a ScheduleItem by unique Id.
     * 
     * @param object Id $scheduleItemId
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function deleteScheduleItem ( Id $scheduleItemId ); 

    /**
     * Get the Timespans during which all Agents are uncommitted.
     * 
     * @param object array $agents
     * @param int $start
     * @param int $end
     *  
     * @return object TimespanIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.scheduling.SchedulingException#END_BEFORE_START
     *         END_BEFORE_START}
     * 
     * @access public
     */
    public function getAvailableTimes ( array $agents, $start, $end ); 

    /**
     * Get a ScheduleItem by unique Id.
     * 
     * @param object Id $scheduleItemId
     *  
     * @return object ScheduleItem
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function getScheduleItem ( Id $scheduleItemId ); 

    /**
     * Get all the ScheduleItems for any Agent, with the specified Item Status
     * and that start or end between the start and end specified, inclusive.
     * 
     * @param int $start
     * @param int $end
     * @param object Type $status
     *  
     * @return object ScheduleItemIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}, {@link
     *         org.osid.scheduling.SchedulingException#END_BEFORE_START
     *         END_BEFORE_START}
     * 
     * @access public
     */
    public function getScheduleItems ( $start, $end, Type $status ); 

    /**
     * Get all the ScheduleItems for the specified Agents, with the specified
     * Item Status and that start or end between the start and end specified,
     * inclusive.
     * 
     * @param int $start
     * @param int $end
     * @param object Type $status
     * @param object array $agents
     *  
     * @return object ScheduleItemIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}, {@link
     *         org.osid.scheduling.SchedulingException#END_BEFORE_START
     *         END_BEFORE_START}, {@link
     *         org.osid.scheduling.SchedulingException#UNKNOWN_ID UNKNOWN_ID}
     * 
     * @access public
     */
    public function getScheduleItemsForAgents ( $start, $end, Type $status, array $agents ); 

    /**
     * Get all ScheduleItems with the specified master identifier reference.  A
     * Master Identifier is a key, rule, or function that can be used to
     * associated more than one ScheduleItem together.  An example can be
     * recurring items where each recurring item has the same Master
     * Identifier.
     * 
     * @param string $masterIdentifier
     *  
     * @return object ScheduleItemIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.scheduling.SchedulingException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function getScheduleItemsByMasterId ( $masterIdentifier ); 

    /**
     * Get the Status Types for ScheduleItem supported by the implementation.
     *  
     * @return object TypeIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getItemStatusTypes (); 

    /**
     * Get the Status Types for Agents' Commitment supported by the
     * implementation.
     *  
     * @return object TypeIterator
     * 
     * @throws object SchedulingException An exception with one of
     *         the following messages defined in
     *         org.osid.scheduling.SchedulingException may be thrown:   {@link
     *         org.osid.scheduling.SchedulingException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.scheduling.SchedulingException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.scheduling.SchedulingException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.scheduling.SchedulingException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getCommitmentStatusTypes (); 
}

?>