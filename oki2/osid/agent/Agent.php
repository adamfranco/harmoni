<?php 
 
/**
 * Agent is an abstraction that includes Id, display name, type, and
 * Properties.  Agents are created using implementations of
 * org.osid.agent.AgentManager.
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
class Agent
{
    /**
     * Get the name of this Agent.
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
     * Get the id of this Agent.
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
     * Get the type of this Agent.
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
     * Get the Properties of this Type associated with this Agent.
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
     * Get the Properties Types supported by this Agent.
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
     * Get the Properties associated with this Agent.
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