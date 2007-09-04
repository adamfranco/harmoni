<?php 
 
/**
 * Authorization indicates what an agentId can do a Function in a Qualifier
 * context.
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
 * @package org.osid.authorization
 */
class Authorization
{
    /**
     * Get the date when this Authorization starts being effective.
     *  
     * @return int
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getEffectiveDate () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the date when this Authorization stops being effective.
     *  
     * @return int
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getExpirationDate () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the Id of the agent that modified this Authorization.
     *  
     * @return object Id
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getModifiedBy () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the date when this Authorization was modified.
     *  
     * @return int
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getModifiedDate () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * 
     *  
     * @return object Function
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getFunction () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * 
     *  
     * @return object Qualifier
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getQualifier () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Get the agentid associated with this Authorization.
     *  
     * @return object Id
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function getAgentId () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Return true if this Authorization is effective; false otherise;
     *  
     * @return boolean
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function isActiveNow () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Some Authorizations are explicitly stored and others are implied, so use
     * this method to determine if the Authorization is explicit and can be
     * modified or deleted.
     *  
     * @return boolean
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    function isExplicit () { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * Modify the date when this Authorization starts being effective.
     * 
     * @param int $expirationDate
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.authorization.AuthorizationException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.authorization.AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
     * 
     * @access public
     */
    function updateExpirationDate ( $expirationDate ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 

    /**
     * the date when this Authorization stops being effective.
     * 
     * @param int $effectiveDate
     * 
     * @throws object AuthorizationException An exception with
     *         one of the following messages defined in
     *         org.osid.authorization.AuthorizationException may be thrown:
     *         {@link
     *         org.osid.authorization.AuthorizationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authorization.AuthorizationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authorization.AuthorizationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.authorization.AuthorizationException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.authorization.AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
     * 
     * @access public
     */
    function updateEffectiveDate ( $effectiveDate ) { 
        die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
    } 
}

?>