<?php

require_once(OKI2."/osid/authorization/AuthorizationIterator.php");
require_once(HARMONI."oki2/shared/HarmoniIterator.class.php");

/**
 * AuthorizationIterator is the iterator for a collection of Authorizations.
 * 
 * <p>
 * OSID Version: 2.0
 * </p>
 * 
 * @package harmoni.osid.authorization
 */
class HarmoniAuthorizationIterator
	extends HarmoniIterator
//	implements AuthorizationIterator
{

	/**
	 * Return true if there is an additional  Authorization ; false otherwise.
	 *	
	 * @return boolean
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function hasNextAuthorization () { 
		return $this->hasNext();
	} 

	/**
	 * Return the next Authorization.
	 *	
	 * @return object Authorization
	 * 
	 * @throws object AuthorizationException An exception with
	 *		   one of the following messages defined in
	 *		   org.osid.authorization.AuthorizationException may be thrown:
	 *		   {@link
	 *		   org.osid.authorization.AuthorizationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authorization.AuthorizationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authorization.AuthorizationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @public
	 */
	function &nextAuthorization () { 
		return $this->next();
	} 
}

?>