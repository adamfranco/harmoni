<?php 
 
include_once(dirname(__FILE__)."/../agent/Agent.php");
/**
 * Group contains members that are either Agents or other Groups.  There are
 * management methods for adding, removing, and getting members and Groups.
 * There are also methods for testing if a Group or member is contained in a
 * Group, and returning all members in a Group, all Groups in a Group, or all
 * Groups containing a specific member. Many methods include an argument that
 * specifies whether to include all subgroups or not.  This allows for more
 * flexible maintenance and interrogation of the structure. Note that there is
 * no specification for persisting the Group or its content -- this detail is
 * left to the implementation.
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
 * @package org.osid.agent
 */
interface Group
    extends Agent
{
    /**
     * Add an Agent or a Group to this Group.  The Agent or Group will not be
     * added if it already exists in the group.
     * 
     * @param object Agent $memberOrGroup
     * 
     * @throws object AgentException An exception with one of the
     *         following messages defined in org.osid.agent.AgentException may
     *         be thrown:  {@link
     *         org.osid.agent.AgentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.agent.AgentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.agent.AgentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.agent.AgentException#ALREADY_ADDED
     *         ALREADY_ADDED}, {@link
     *         org.osid.agent.AgentException#NULL_ARGUMENT NULL_ARGUMENT}
     * 
     * @access public
     */
    public function add ( Agent $memberOrGroup ); 

    /**
     * Remove an Agent member or a Group from this Group. If the Agent or Group
     * is not in this group no action is taken and no exception is thrown.
     * 
     * @param object Agent $memberOrGroup
     * 
     * @throws object AgentException An exception with one of the
     *         following messages defined in org.osid.agent.AgentException may
     *         be thrown:  {@link
     *         org.osid.agent.AgentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.agent.AgentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.agent.AgentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.agent.AgentException#UNKNOWN_ID UNKNOWN_ID},
     *         {@link org.osid.agent.AgentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function remove ( Agent $memberOrGroup ); 

    /**
     * Get all the Members of this group and optionally all the Members from
     * all subgroups. Duplicates are not returned.
     * 
     * @param boolean $includeSubgroups
     *  
     * @return object AgentIterator
     * 
     * @throws object AgentException An exception with one of the
     *         following messages defined in org.osid.agent.AgentException may
     *         be thrown:  {@link
     *         org.osid.agent.AgentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.agent.AgentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.agent.AgentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getMembers ( $includeSubgroups ); 

    /**
     * Get all the Groups in this group and optionally all the subgroups in
     * this group. Note since Groups subclass Agents, we are returning an
     * AgentIterator and there is no GroupIterator.
     * 
     * @param boolean $includeSubgroups
     *  
     * @return object AgentIterator
     * 
     * @throws object AgentException An exception with one of the
     *         following messages defined in org.osid.agent.AgentException may
     *         be thrown:  {@link
     *         org.osid.agent.AgentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.agent.AgentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.agent.AgentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getGroups ( $includeSubgroups ); 

    /**
     * Return <code>true</code> if the Member or Group is in the Group,
     * optionally including subgroups, <code>false</code> otherwise.
     * 
     * @param object Agent $memberOrGroup
     * @param boolean $searchSubgroups
     *  
     * @return boolean
     * 
     * @throws object AgentException An exception with one of the
     *         following messages defined in org.osid.agent.AgentException may
     *         be thrown:  {@link
     *         org.osid.agent.AgentException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.agent.AgentException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.agent.AgentException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.agent.AgentException#UNIMPLEMENTED UNIMPLEMENTED},
     *         {@link org.osid.agent.AgentException#NULL_ARGUMENT
     *         NULL_ARGUMENT}
     * 
     * @access public
     */
    public function contains ( Agent $memberOrGroup, $searchSubgroups ); 
}

?>