<?php

require_once(OKI."/authentication.interface.php");

/**
 * The AuthenticationManager identifies the authentication Types supported by the implementation, authenticates the user using a particular authentication Type, determines if the user is authenticated for a particular authentication Type, destroys the user's authentication, and returns the id of the Agent that represents the user. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package osid.authentication
 */
class HarmoniAuthenticationManager 
	extends AuthenticationManager // :: API interface
{

	/**
	 * Get the authentication Types that are supported by the implementation.
	 * @return osid.shared.TypeIterator
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:   {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authentication
	 */
	function & getAuthenticationTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getAuthenticationTypes()

	/**
	 * Invoke the authentication process of the specified Type to identify the user.  It may be necessary to call isUserAuthenticated to check the status of authentication.  The standard authentication technique of limiting the time an user's authentication is valid requires explicit queries of the authentication status. It is likely that checking the status of authentication will occur more frequently than invoking the mechanism to authenticate the user.  Separation of the authentication process from checking the status of the authentication process is made explicit by having the authenticateUser and isUserAuthenticated methods.
	 * @param authenticationType
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:   {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authentication
	 */
	function authenticateUser(& $authenticationType) { /* :: interface :: */ }
	// :: full java declaration :: void authenticateUser(osid.shared.Type authenticationType)

	/**
	 * Check the current authentication status of the user. If the method returns true, the user is authenticated.  If the method returns false, the user is not authenticated.  This can indicate that the user could not be authenticated or that the user's authentication has timed out.  The intent is to use the method authenticateUser to invoke the authentication process.  The standard authentication technique of limiting the time an user's authentication is valid requires explicit queries of the authentication status. It is likely that checking the status of authentication will occur more frequently than invoking the mechanism to authenticate the user.  Separation of the authentication process from checking the status of the authentication process is made explicit by having the authenticateUser and isUserAuthenticated methods.
	 * @param authenticationType
	 * @return boolean
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:   {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authentication
	 */
	function isUserAuthenticated(& $authenticationType) { /* :: interface :: */ }
	// :: full java declaration :: boolean isUserAuthenticated(osid.shared.Type authenticationType)

	/**
	 * Get the Unique Id of the Agent that represents the user for the specified AuthenticationType.  Agents are managed in the Shared OSID.
	 * @param authenticationType
	 * @return osid.shared.Id
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:   {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authentication
	 */
	function & getUserId(& $authenticationType) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getUserId(osid.shared.Type authenticationType)

	/**
	 * Destroy authentication for all authentication types.
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:   {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authentication
	 */
	function destroyAuthentication() { /* :: interface :: */ }
	// :: full java declaration :: void destroyAuthentication()

	/**
	 * Destroy authentication for the specified authentication type.
	 * @param authenticationType
	 * @throws osid.shared.SharedException An exception with one of the following messages defined in osid.shared.SharedException:   {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authentication
	 */
	function destroyAuthenticationForType(& $authenticationType) { /* :: interface :: */ }
	// :: full java declaration :: void destroyAuthenticationForType(osid.shared.Type authenticationType)
}

?>