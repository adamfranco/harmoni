<?php

require_once(OKI."/authorization.interface.php");
require_once(HARMONI."utilities/DateTime.class.php");

/**
 * Authorization indicates what an Agent can do a Function in a Qualifier context. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package harmoni.osid.authorization
 */
class HarmoniAuthorization extends Authorization {

	/**
	 * The date when this Authorization starts being effective.
	 * @attribute private object _effectiveDate
	 */
	var $_effectiveDate;
	
	/**
	 * The Id of the agent.
	 * @attribute private object _agentId
	 */
	var $_agentId;
	
	
	/**
	 * The Id of the function.
	 * @attribute private object _functionId
	 */
	var $_functionId;
	
	
	/**
	 * The Id of the qualifier.
	 * @attribute private object _qualifierId
	 */
	var $_qualifierId;
	
	
	/**
	 * The date when the authorization becomes effective.
	 * @attribute private object _effectiveDate
	 */
	var $_effectiveDate;
	
	
	/**
	 * The date when the authorization expires.
	 * @attribute private object _expirationDate
	 */
	var $_expirationDate;
	
	
	/**
	 * The constructor.
	 * @param ref object agentId The Id of the agent.
	 * @param ref object functionId The Id of the function.
	 * @param ref object qualifierId The Id of the qualifier.
	 * @param ref object effectiveDate The date when the authorization becomes effective.
	 * @param ref object expirationDate The date when the authorization expires.
	 * @access public
	 */
	function HarmoniAuthorization(& $agentId, & $functionId, & $qualifierId, 
							      & $effectiveDate, & $expirationDate) {
		// ** parameter validation
		ArgumentValidator::validate($agentId, new ExtendsValidatorRule("Agent"), true);
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Function"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Qualifier"), true);
		ArgumentValidator::validate($effectiveDate, new ExtendsValidatorRule("DateTime"), true);
		ArgumentValidator::validate($expirationDate, new ExtendsValidatorRule("DateTime"), true);
		// ** end of parameter validation

		
		$this->_agentId =& $agentId;
		$this->_functionId =& $functionId;
		$this->_qualifierId =& $qualifierId;
		$this->_effectiveDate =& $effectiveDate;
		$this->_expirationDate =& $expirationDate;
	}	
	
	
	
	
	/**
	 * Get the date when this Authorization starts being effective.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getEffectiveDate() { /* :: interface :: */ }



	/* :: full java declaration :: java.util.Calendar getEffectiveDate()
	/**
	 * Get the date when this Authorization stops being effective.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getExpirationDate() { /* :: interface :: */ }



	/* :: full java declaration :: java.util.Calendar getExpirationDate()
	/**
	 * Get the Id of the Agent that modified this Authorization.
	 * @return object osid.shared.Agent
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getModifiedBy() { /* :: interface :: */ }



	/* :: full java declaration :: osid.shared.Agent getModifiedBy()
	/**
	 * Get the date when this Authorization was modified.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getModifiedDate() { /* :: interface :: */ }



	/* :: full java declaration :: java.util.Calendar getModifiedDate()
	/**
	 * It may or may not exist.
	 * @return Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getFunction() { /* :: interface :: */ }



	/* :: full java declaration :: Function getFunction()
	/**
	 * The instance may or may not exist.
	 * @return Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getQualifier() { /* :: interface :: */ }



	/* :: full java declaration :: Qualifier getQualifier()
	/**
	 * Get the Agent associated with this Authorization.
	 * @return object osid.shared.Agent
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function & getAgent() { /* :: interface :: */ }



	/* :: full java declaration :: osid.shared.Agent getAgent()
	/**
	 * Return true if this Authorization is effective; false otherise;
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function isActiveNow() { /* :: interface :: */ }



	/* :: full java declaration :: boolean isActiveNow()
	/**
	 * Some Authorizations are explicitly stored and others are implied, so use this method to determine if the Authorization is explicit and can be modified or deleted.
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function isExplicit() { /* :: interface :: */ }



	/* :: full java declaration :: boolean isExplicit()
	/**
	 * Modify the date when this Authorization starts being effective.
	 * @param expirationDate the date when this Authorization stops being effective
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package harmoni.osid.authorization
	 */
	function updateExpirationDate(& $expirationDate) { /* :: interface :: */ }



	/* :: full java declaration :: void updateExpirationDate(java.util.Calendar expirationDate)
	/**
	 * the date when this Authorization stops being effective.
	 * @param effectiveDate the date when this Authorization becomes effective
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package harmoni.osid.authorization
	 */
	function updateEffectiveDate(& $effectiveDate) { /* :: interface :: */ }



}

?>