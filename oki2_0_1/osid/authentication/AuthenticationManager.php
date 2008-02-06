<?php 
 
include_once(dirname(__FILE__)."/../OsidManager.php");
/**
 * <p>
 * AuthenticationManager:
 * 
 * <ul>
 * <li>
 * gets authentication Types supported by the implementation,
 * </li>
 * <li>
 * authenticates the user using a particular authentication Type,
 * </li>
 * <li>
 * determines if the user is authenticated for a particular authentication
 * Type,
 * </li>
 * <li>
 * destroys the user's authentication,
 * </li>
 * <li>
 * returns the Id of the Agent that represents the user.
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
 * @package org.osid.authentication
 */
interface AuthenticationManager
    extends OsidManager
{
    /**
     * Get the authentication Types that are supported by the implementation.
     *  
     * @return object TypeIterator
     * 
     * @throws object AuthenticationException An exception
     *         with one of the following messages defined in
     *         org.osid.authentication.AuthenticationException may be thrown:
     *         {@link
     *         org.osid.authentication.AuthenticationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authentication.AuthenticationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authentication.AuthenticationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function getAuthenticationTypes (); 

    /**
     * Invoke the authentication process of the specified Type to identify the
     * user.  It may be necessary to call isUserAuthenticated to check the
     * status of authentication.  The standard authentication technique of
     * limiting the time an user's authentication is valid requires explicit
     * queries of the authentication status. It is likely that checking the
     * status of authentication will occur more frequently than invoking the
     * mechanism to authenticate the user.  Separation of the authentication
     * process from checking the status of the authentication process is made
     * explicit by having the authenticateUser and isUserAuthenticated
     * methods.
     * 
     * @param object Type $authenticationType
     * 
     * @throws object AuthenticationException An exception
     *         with one of the following messages defined in
     *         org.osid.authentication.AuthenticationException may be thrown:
     *         {@link
     *         org.osid.authentication.AuthenticationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authentication.AuthenticationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authentication.AuthenticationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.authentication.AuthenticationException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.authentication.AuthenticationException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function authenticateUser ( Type $authenticationType ); 

    /**
     * Check the current authentication status of the user. If the method
     * returns true, the user is authenticated.  If the method returns false,
     * the user is not authenticated.  This can indicate that the user could
     * not be authenticated or that the user's authentication has timed out.
     * The intent is to use the method authenticateUser to invoke the
     * authentication process.  The standard authentication technique of
     * limiting the time an user's authentication is valid requires explicit
     * queries of the authentication status. It is likely that checking the
     * status of authentication will occur more frequently than invoking the
     * mechanism to authenticate the user.  Separation of the authentication
     * process from checking the status of the authentication process is made
     * explicit by having the authenticateUser and isUserAuthenticated
     * methods.
     * 
     * @param object Type $authenticationType
     *  
     * @return boolean
     * 
     * @throws object AuthenticationException An exception
     *         with one of the following messages defined in
     *         org.osid.authentication.AuthenticationException may be thrown:
     *         {@link
     *         org.osid.authentication.AuthenticationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authentication.AuthenticationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authentication.AuthenticationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.authentication.AuthenticationException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.authentication.AuthenticationException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function isUserAuthenticated ( Type $authenticationType ); 

    /**
     * Get the unique Id of the Agent that represents the user for the
     * specified AuthenticationType.  Agents are managed using the Agent OSID.
     * 
     * @param object Type $authenticationType
     *  
     * @return object Id
     * 
     * @throws object AuthenticationException An exception
     *         with one of the following messages defined in
     *         org.osid.authentication.AuthenticationException may be thrown:
     *         {@link
     *         org.osid.authentication.AuthenticationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authentication.AuthenticationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authentication.AuthenticationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.authentication.AuthenticationException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.authentication.AuthenticationException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function getUserId ( Type $authenticationType ); 

    /**
     * Destroy authentication for all authentication types.
     * 
     * @throws object AuthenticationException An exception
     *         with one of the following messages defined in
     *         org.osid.authentication.AuthenticationException may be thrown:
     *         {@link
     *         org.osid.authentication.AuthenticationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authentication.AuthenticationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authentication.AuthenticationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}
     * 
     * @access public
     */
    public function destroyAuthentication (); 

    /**
     * Destroy authentication for the specified authentication type.
     * 
     * @param object Type $authenticationType
     * 
     * @throws object AuthenticationException An exception
     *         with one of the following messages defined in
     *         org.osid.authentication.AuthenticationException may be thrown:
     *         {@link
     *         org.osid.authentication.AuthenticationException#OPERATION_FAILED
     *         OPERATION_FAILED}, {@link
     *         org.osid.authentication.AuthenticationException#PERMISSION_DENIED
     *         PERMISSION_DENIED}, {@link
     *         org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
     *         CONFIGURATION_ERROR}, {@link
     *         org.osid.authentication.AuthenticationException#UNIMPLEMENTED
     *         UNIMPLEMENTED}, {@link
     *         org.osid.authentication.AuthenticationException#NULL_ARGUMENT
     *         NULL_ARGUMENT}, {@link
     *         org.osid.authentication.AuthenticationException#UNKNOWN_TYPE
     *         UNKNOWN_TYPE}
     * 
     * @access public
     */
    public function destroyAuthenticationForType ( Type $authenticationType ); 
}

?>