<?php


/**
 * Authorization indicates what an Agent can do a Function in a Qualifier context. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package osid.authorization
 */
class HarmoniAuthorization /* :: API interface */
{

	/**
	 * The date when this Authorization starts being effective.
	 * @attribute private  _effectiveDate
	 */
	var $_effectiveDate;
	
	
	/**
	 * Get the date when this Authorization starts being effective.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getEffectiveDate() { /* :: interface :: */ }



	/* :: full java declaration :: java.util.Calendar getEffectiveDate()
	/**
	 * Get the date when this Authorization stops being effective.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getExpirationDate() { /* :: interface :: */ }



	/* :: full java declaration :: java.util.Calendar getExpirationDate()
	/**
	 * Get the Id of the Agent that modified this Authorization.
	 * @return osid.shared.Agent
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getModifiedBy() { /* :: interface :: */ }



	/* :: full java declaration :: osid.shared.Agent getModifiedBy()
	/**
	 * Get the date when this Authorization was modified.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getModifiedDate() { /* :: interface :: */ }



	/* :: full java declaration :: java.util.Calendar getModifiedDate()
	/**
	 * It may or may not exist.
	 * @return Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getFunction() { /* :: interface :: */ }



	/* :: full java declaration :: Function getFunction()
	/**
	 * The instance may or may not exist.
	 * @return Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getQualifier() { /* :: interface :: */ }



	/* :: full java declaration :: Qualifier getQualifier()
	/**
	 * Get the Agent associated with this Authorization.
	 * @return osid.shared.Agent
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function & getAgent() { /* :: interface :: */ }



	/* :: full java declaration :: osid.shared.Agent getAgent()
	/**
	 * Return true if this Authorization is effective; false otherise;
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function isActiveNow() { /* :: interface :: */ }



	/* :: full java declaration :: boolean isActiveNow()
	/**
	 * Some Authorizations are explicitly stored and others are implied, so use this method to determine if the Authorization is explicit and can be modified or deleted.
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function isExplicit() { /* :: interface :: */ }



	/* :: full java declaration :: boolean isExplicit()
	/**
	 * Modify the date when this Authorization starts being effective.
	 * @param expirationDate the date when this Authorization stops being effective
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package osid.authorization
	 */
	function updateExpirationDate(& $expirationDate) { /* :: interface :: */ }



	/* :: full java declaration :: void updateExpirationDate(java.util.Calendar expirationDate)
	/**
	 * the date when this Authorization stops being effective.
	 * @param effectiveDate the date when this Authorization becomes effective
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package osid.authorization
	 */
	function updateEffectiveDate(& $effectiveDate) { /* :: interface :: */ }



}

?>