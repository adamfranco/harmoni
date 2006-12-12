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
class Group
    extends Agent
{
    /**
     * Update the Description of this Group.
     * 
     * @param string $description
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
    function updateDescription ( $description ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Description of this Group.
     *  
     * @return string
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
    function getDescription () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the unique Id of this Group.
     *  
     * @return object Id
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
    function &getId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the DisplayName of this Group.
     *  
     * @return string
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
    function getDisplayName () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Type of this Group.
     *  
     * @return object Type
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
    function &getType () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
    function add ( &$memberOrGroup ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
    function remove ( &$memberOrGroup ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
    function &getMembers ( $includeSubgroups ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
    function &getGroups ( $includeSubgroups ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

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
    function contains ( &$memberOrGroup, $searchSubgroups ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Properties of this Type associated with this Group.
     * 
     * @param object Type $propertiesType
     *  
     * @return object Properties
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
     *         NULL_ARGUMENT}, {@link
     *         org.osid.agent.AgentException#UNKNOWN_TYPE UNKNOWN_TYPE}
     * 
     * @access public
     */
    function &getPropertiesByType ( &$propertiesType ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get all the property Types.  The returned iterator provides access to
     * the property Types from this implementation one at a time.  Iterators
     * have a method hasNext() which returns true if there is another
     * property Type available and a method next() which returns the next
     * property Type. Group.
     *  
     * @return object TypeIterator
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
    function &getPropertyTypes () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Properties associated with this Group.
     *  
     * @return object PropertiesIterator
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
    function &getProperties () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>