<?php


	/**
	 * AuthorizationManager allows an application to create Authorizations, get Authorizations given selection criterias, ask questions of Authorization such as what Agent can do a Function in a Qualifier context, etc.<p><p>The primary objects in Authorization are Authorization, Function, Agent, and Qualifier. There are also Function and Qualifier types that are understood by the implementation.<p><p>Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. <p><p>There are two methods to create Authorizations. One uses method uses Agent, Function, and Qualifier.  The other adds effective date and expiration date.  For the method without the dates, the effective date is today and there is no expiration date.  <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.authorization
	 */
class AuthorizationManager // :: API interface
	extends OsidManager
{

	/**
	 * Creates a new Authorization for an Agent performing a Function with a Qualifier Id.
	 * @param agentId who is authorized to perform this Function for this Qualifer and its descendants
	 * @param functionId the Id of the Function for this Authorization
	 * @param qualifierId the Id of the Qualifier for this Authorization
	 * @param effectiveDate when the Authorization becomes effective
	 * @param expirationDate when the Authorization stops being effective
	 * @return Authorization
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package osid.authorization
	 */
	function &createDatedAuthorization(& $agentId, & $functionId, & $qualifierId, & $effectiveDate, & $expirationDate) { /* :: interface :: */ }
	// :: full java declaration :: Authorization createDatedAuthorization
	 * Creates a new Authorization for a Agent performing a Function with a Qualifier. Uses current date/time as the effectiveDate and doesn't set an expiration date.
	 * @param agentId who is authorized to perform this Function for this Qualifer and its descendants
	 * @param functionId the Id of the Function for this Authorization
	 * @param qualifierId the Id of the Qualifier for this Authorization
	 * @return Authorization
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function &createAuthorization(& $agentId, & $functionId, & $qualifierId) { /* :: interface :: */ }
	// :: full java declaration :: Authorization createAuthorization
	 * Ids in Authorization are externally defined and their uniqueness is enforced by the implementation.
	 * @param functionId is externally defined
	 * @param displayName the name to display for this Function
	 * @param description the description of this Function
	 * @param functionType the Type of this Function
	 * @param qualifierHierarchyId the Id of the Qualifier Hierarchy associated with this Function
	 * @return Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function &createFunction(& $functionId, $displayName, $description, & $functionType, & $qualifierHierarchyId) { /* :: interface :: */ }
	// :: full java declaration :: Function createFunction
	 * Creates a new Qualifier in the Authorization Service that has no parent.  This is different from making a new instance of a Qualifier object locally as the Qualifier will be inserted into the Authorization Service.
	 * @param qualifierId is externally defined
	 * @param displayName the name to display for this Qualifier
	 * @param description the description of this Qualifier
	 * @param qualifierType the Type of this Qualifier
	 * @param qualifierHierarchyId the Id of the Qualifier Hierarchy associated with this Qualifier
	 * @return Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authorization
	 */
	function &createRootQualifier(& $qualifierId, $displayName, $description, & $qualifierType, & $qualifierHierarchyId) { /* :: interface :: */ }
	// :: full java declaration :: Qualifier createRootQualifier
	 * Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. Creates a new Qualifier in the Authorization Service. This is different than making a new instance of a Qualifier object locally as the Qualifier will be inserted into the Authorization Service.
	 * @param qualifierId is externally defined
	 * @param displayName the name to display for this Qualifier
	 * @param description the description of this Qualifier
	 * @param qualifierType the Type of this Qualifier
	 * @param parentId the parent of this Qualifier
	 * @return Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authorization
	 */
	function &createQualifier(& $qualifierId, $displayName, $description, & $qualifierType, & $parentId) { /* :: interface :: */ }
	// :: full java declaration :: Qualifier createQualifier
	 * Deletes an existing Authorization.
	 * @param authorizationId the Id of an Authorization
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function deleteAuthorization(& $authorizationId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteAuthorization(osid.shared.Id authorizationId)

	/**
	 * Delete a Function by Id.
	 * @param functionId the Id of a Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function deleteFunction(& $functionId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteFunction(osid.shared.Id functionId)

	/**
	 * Delete a Qualifier by Id.  The last root Qualifier cannot be deleted.
	 * @param qualifierId the Id of a Qualifer
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#CANNOT_DELETE_LAST_ROOT_QUALIFIER CANNOT_DELETE_LAST_ROOT_QUALIFIER}
	 * @package osid.authorization
	 */
	function deleteQualifier(& $qualifierId) { /* :: interface :: */ }
	// :: full java declaration :: void deleteQualifier(osid.shared.Id qualifierId)

	/**
	 * Given an agentId, functionId, and qualifierId returns true if the Agent is authorized now to perform the given Function with the given Qualifier.
	 * @param agentId who is being tested if authorized
	 * @param functionId the Id of the Function
	 * @param qualifierId the Id of the Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function isAuthorized(& $agentId, & $functionId, & $qualifierId) { /* :: interface :: */ }
	// :: full java declaration :: boolean isAuthorized
	 * Given a functionId and qualifierId returns true if the user is authorized now to perform the given Function with the given Qualifier.
	 * @param functionId the Id of the Function
	 * @param qualifierId the Id of the Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function isUserAuthorized(& $functionId, & $qualifierId) { /* :: interface :: */ }
	// :: full java declaration :: boolean isUserAuthorized
	 * Get all the FunctionTypes supported by the Authorization implementation.
	 * @return osid.shared.TypeIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getFunctionTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getFunctionTypes()

	/**
	 * Get all the Function of the specified Type.
	 * @param functionType the Type of the Functions to return
	 * @return FunctionIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authorization
	 */
	function &getFunctions(& $functionType) { /* :: interface :: */ }
	// :: full java declaration :: FunctionIterator getFunctions(osid.shared.Type functionType)

	/**
	 * It may or may not exist.
	 * @param functionId the Id of the Function to return
	 * @return Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function &getFunction(& $functionId) { /* :: interface :: */ }
	// :: full java declaration :: Function getFunction(osid.shared.Id functionId)

	/**
	 * Return true if the agent exists in the Authorization Service; false otherwise.  This is not asking if there are any Authorizations that reference this Agent.  This is not asking if the Agent is known to the Agent management Service in the Shared OSID.
	 * @param agentId the Id of an Agent that may be known to the implementation
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function agentExists(& $agentId) { /* :: interface :: */ }
	// :: full java declaration :: boolean agentExists(osid.shared.Id agentId)

	/**
	 * Get all the QualifierTypes supported by the Authorization implementation.
	 * @return osid.shared.TypeIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getQualifierTypes() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.TypeIterator getQualifierTypes()

	/**
	 * Given a QualifierHierarchy Id, returns the Qualifier that is the root of the tree of Qualifiers of this Type.
	 * @param qualifierHierarchyId
	 * @return QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authorization
	 */
	function &getRootQualifiers(& $qualifierHierarchyId) { /* :: interface :: */ }
	// :: full java declaration :: QualifierIterator getRootQualifiers(osid.shared.Id qualifierHierarchyId)

	/**
	 * Given an existing Qualifier returns a list of its child Qualifiers.
	 * @param qualifierId
	 * @return QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	  */
	function &getQualifierChildren(& $qualifierId) { /* :: interface :: */ }
	// :: full java declaration :: QualifierIterator getQualifierChildren(osid.shared.Id qualifierId)

	/**
	 * Given an existing Qualifier returns a list of all descendants including its child Qualifiers.
	 * @param qualifierId
	 * @return QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	  */
	function &getQualifierDescendants(& $qualifierId) { /* :: interface :: */ }
	// :: full java declaration :: QualifierIterator getQualifierDescendants(osid.shared.Id qualifierId)

	/**
	 * The instance may or may not exist.
	 * @param qualifierId
	 * @return Qualifier or null
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function &getQualifier(& $qualifierId) { /* :: interface :: */ }
	// :: full java declaration :: Qualifier getQualifier(osid.shared.Id qualifierId)

	/**
	 * Given a Function and a Qualifier returns an enumeration of all agents allowed to do the Function with the Qualifier.  The Qualifier can be null, in which case any Qualifier is included in what is returned.
	 * @param functionId
	 * @param qualifierId
	 * @param isActiveNow
	 * @return osid.shared.AgentIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	  */
	function &getWhoCanDo(& $functionId, & $qualifierId, $isActiveNow) { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.AgentIterator getWhoCanDo
	 * Given a Function and Qualifier (one must be non-null) returns an enumeration of matching user Authorizations.  Explicit Authorizations can be modified..  Any null argument will be treated as a wildcard.
	 * @param functionId
	 * @param qualifierId
	 * @param isActiveNow
	 * @return AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function &getExplicitUserAZs(& $functionId, & $qualifierId, $isActiveNow) { /* :: interface :: */ }
	// :: full java declaration :: AuthorizationIterator getExplicitUserAZs
	 * Given a FunctionType and Qualifier returns an enumeration of matching user Authorizations. The Authorizations must be for Functions within the given FunctionType. Explicit Authorizations can be modified.  Any null argument will be treated as a wildcard.
	 * @param functionType
	 * @param qualifierId
	 * @param isActiveNow
	 * @return Authorizations
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authorization
	 */
	function &getExplicitUserAZsByFuncType(& $functionType, & $qualifierId, $isActiveNow) { /* :: interface :: */ }
	// :: full java declaration :: AuthorizationIterator getExplicitUserAZsByFuncType
	 * Given a Function and a Qualifier returns an enumeration of all Authorizations that would allow the user to do the Function with the Qualifier. This method differs from the simple form of getAuthorizations in that this method looks for any Authorization that permits doing the Function with the Qualifier even if the Authorization's Qualifier happens to be a parent of this Qualifier argument.
	 * @param functionId
	 * @param qualifierId
	 * @param isActiveNow
	 * @return Authorizations
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function &getAllUserAZs(& $functionId, & $qualifierId, $isActiveNow) { /* :: interface :: */ }
	// :: full java declaration :: AuthorizationIterator getAllUserAZs
	 * Given a FunctionType and a Qualifier returns an enumeration of all Authorizations that would allow the user to do Functions in the FunctionType with the Qualifier. This method differs from getAuthorizations in that this method looks for any Authorization that permits doing the Function with the Qualifier even if the Authorization's Qualifier happens to be a parent of the Qualifier argument.
	 * @param functionType
	 * @param qualifierId
	 * @param isActiveNow
	 * @return Authorizations
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authorization
	 */
	function &getAllUserAZsByFuncType(& $functionType, & $qualifierId, $isActiveNow) { /* :: interface :: */ }
	// :: full java declaration :: AuthorizationIterator getAllUserAZsByFuncType
	 * Given a Agent, a Function, and a Qualifier (at least one of these must be non-null) returns an enumeration of matching Authorizations.  Explicit Authorizations can be modified.  Any null argument will be treated as a wildcard.
	 * @param agentId
	 * @param functionType
	 * @param qualifierId
	 * @param isActiveNow
	 * @return AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function &getExplicitAZs(& $agentId, & $functionType, & $qualifierId, $isActiveNow) { /* :: interface :: */ }
	// :: full java declaration :: AuthorizationIterator getExplicitAZs
	 * Given a Agent, a FunctionType, and a Qualifier (either Agent or Qualifier must be non-null) returns an enumeration of matching Authorizations. The Authorizations must be for Functions within the given FunctionType. Explicit Authorizations can be modified.  Any null argument will be treated as a wildcard.
	 * @param agentId
	 * @param functionType
	 * @param qualifierId
	 * @param isActiveNow
	 * @return AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authorization
	 */
	function &getExplicitAZsByFuncType(& $agentId, & $functionType, & $qualifierId, $isActiveNow) { /* :: interface :: */ }
	// :: full java declaration :: AuthorizationIterator getExplicitAZsByFuncType
	 * Given a Function and a Qualifier returns an enumeration of all Authorizations that would allow agents to do the Function with the Qualifier. This method differs from the simple form of getAuthorizations in that this method looks for any Authorization that permits doing the Function with the Qualifier even if the Authorization's Qualifier happens to be a parent of this Qualifier argument.
	 * @param agentId
	 * @param functionType
	 * @param qualifierId
	 * @param isActiveNow
	 * @return AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function &getAllAZs(& $agentId, & $functionType, & $qualifierId, $isActiveNow) { /* :: interface :: */ }
	// :: full java declaration :: AuthorizationIterator getAllAZs
	 * Given a FunctionType and a Qualifier returns an enumeration of all Authorizations that would allow agents to do Functions in the FunctionType with the Qualifier. This method differs from getAuthorizations in that this method looks for any Authorization that permits doing the Function with the Qualifier even if the Authorization's Qualifier happens to be a parent of the Qualifier argument.
	 * @param agentId
	 * @param functionType
	 * @param qualifierId
	 * @param isActiveNow
	 * @return AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package osid.authorization
	 */
	function &getAllAZsByFuncType(& $agentId, & $functionType, & $qualifierId, $isActiveNow) { /* :: interface :: */ }
	// :: full java declaration :: AuthorizationIterator getAllAZsByFuncType
	 * Returns the Qualifier Hierarchies supported by the Authorization implementation.  Qualifier Hierarchies are referenced by Id and may be known and managed through the Hierarchy OSID.
	 * @return osid.shared.IdIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getQualifierHierarchies() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.IdIterator getQualifierHierarchies()
}


	/**
	 * Authorization indicates what an Agent can do a Function in a Qualifier context. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.authorization
	 */
class Authorization // :: API interface
{

	/**
	 * Get the date when this Authorization starts being effective.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getEffectiveDate() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar getEffectiveDate()

	/**
	 * Get the date when this Authorization stops being effective.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getExpirationDate() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar getExpirationDate()

	/**
	 * Get the Id of the Agent that modified this Authorization.
	 * @return osid.shared.Agent
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getModifiedBy() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Agent getModifiedBy()

	/**
	 * Get the date when this Authorization was modified.
	 * @return java.util.Calendar
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getModifiedDate() { /* :: interface :: */ }
	// :: full java declaration :: java.util.Calendar getModifiedDate()

	/**
	 * It may or may not exist.
	 * @return Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getFunction() { /* :: interface :: */ }
	// :: full java declaration :: Function getFunction()

	/**
	 * The instance may or may not exist.
	 * @return Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getQualifier() { /* :: interface :: */ }
	// :: full java declaration :: Qualifier getQualifier()

	/**
	 * Get the Agent associated with this Authorization.
	 * @return osid.shared.Agent
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getAgent() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Agent getAgent()

	/**
	 * Return true if this Authorization is effective; false otherise;
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function isActiveNow() { /* :: interface :: */ }
	// :: full java declaration :: boolean isActiveNow()

	/**
	 * Some Authorizations are explicitly stored and others are implied, so use this method to determine if the Authorization is explicit and can be modified or deleted.
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function isExplicit() { /* :: interface :: */ }
	// :: full java declaration :: boolean isExplicit()

	/**
	 * Modify the date when this Authorization starts being effective.
	 * @param expirationDate the date when this Authorization stops being effective
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package osid.authorization
	 */
	function updateExpirationDate(& $expirationDate) { /* :: interface :: */ }
	// :: full java declaration :: void updateExpirationDate(java.util.Calendar expirationDate)

	/**
	 * the date when this Authorization stops being effective.
	 * @param effectiveDate the date when this Authorization becomes effective
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package osid.authorization
	 */
	function updateEffectiveDate(& $effectiveDate) { /* :: interface :: */ }
	// :: full java declaration :: void updateEffectiveDate(java.util.Calendar effectiveDate)
}


	/**
	 * AuthorizationIterator is the iterator for a collection of Authorizations. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.authorization
	 */
class AuthorizationIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Authorization ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Authorizations.
	 * @return Authorization
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Authorization next()
}


	/**
	 * QualifierIterator is the iterator for a collection of Qualifiers. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.authorization
	 */
class QualifierIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Qualifier ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Qualifiers.
	 * @return Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Qualifier next()
}


	/**
	 * FunctionIterator is the iterator for a collection of Functions. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.authorization
	 */
class FunctionIterator // :: API interface
{

	/**
	 * Return <code>true</code> if there are additional  Function ; <code>false</code> otherwise.
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function hasNext() { /* :: interface :: */ }
	// :: full java declaration :: boolean hasNext()

	/**
	 * Return the next Functions.
	 * @return Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &next() { /* :: interface :: */ }
	// :: full java declaration :: Function next()
}


	/**
	 * Function is composed of Id, a displayName, a description, a category, and a QualifierType.  Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.authorization
	 */
class Function // :: API interface
{

	/**
	 * Get the Unique Id for this Function.
	 * @return osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getId() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getId()

	/**
	 * Get the name for this Function.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: String getDisplayName()

	/**
	 * Get the description for this Function.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function getDescription() { /* :: interface :: */ }
	// :: full java declaration :: String getDescription()

	/**
	 * Get the FunctionType for this Function.
	 * @return osid.shared.Type
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getFunctionType() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Type getFunctionType()

	/**
	 * Get the QualifierHierarchyId for this Function.
	 * @return osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getQualifierHierarchyId() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getQualifierHierarchyId()

	/**
	 * Update the name for this Function.
	 * @param displayName
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.authorization
	 */
	function updateDisplayName($displayName) { /* :: interface :: */ }
	// :: full java declaration :: void updateDisplayName(String displayName)

	/**
	 * Update the description for this Function.
	 * @param description
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.authorization
	 */
	function updateDescription($description) { /* :: interface :: */ }
	// :: full java declaration :: void updateDescription(String description)
}


	/**
	 * Qualifier is the context in which an Authorization is valid and consists of an Id, a description and a QualifierType.  Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.authorization
	 */
class Qualifier // :: API interface
{

	/**
	 * Get the Unique Id for this Qualifier.
	 * @return osid.shared.Id
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getId() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Id getId()

	/**
	 * Get the name for this Qualifier.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function getDisplayName() { /* :: interface :: */ }
	// :: full java declaration :: String getDisplayName()

	/**
	 * Get the description for this Qualifier.
	 * @return String
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function getDescription() { /* :: interface :: */ }
	// :: full java declaration :: String getDescription()

	/**
	 * Return true if this Qualifier has any children; false otherwise
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function isParent() { /* :: interface :: */ }
	// :: full java declaration :: boolean isParent()

	/**
	 * Get the QualifierType for this Qualifier.
	 * @return osid.shared.Type
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getQualifierType() { /* :: interface :: */ }
	// :: full java declaration :: osid.shared.Type getQualifierType()

	/**
	 * Update the name for this Qualifier.
	 * @param displayName
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.authorization
	 */
	function updateDisplayName($displayName) { /* :: interface :: */ }
	// :: full java declaration :: void updateDisplayName(String displayName)

	/**
	 * Update the description for this Qualifier.
	 * @param description
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}
	 * @package osid.authorization
	 */
	function updateDescription($description) { /* :: interface :: */ }
	// :: full java declaration :: void updateDescription(String description)

	/**
	 * Adds a parent to this Qualifier supported by the Authorization implementation.
	 * @param parentQualifierId a Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function addParent(& $parentQualifierId) { /* :: interface :: */ }
	// :: full java declaration :: void addParent(osid.shared.Id parentQualifierId)

	/**
	 * Removes a parent from this Qualifier.  If this is the last parent the delete will fail and an AuthorizationException will be thrown.  For a non-Root Qualifier there must always be a parent.
	 * @param parentQualifierId a Qualifer
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function removeParent(& $parentQualifierId) { /* :: interface :: */ }
	// :: full java declaration :: void removeParent(osid.shared.Id parentQualifierId)

	/**
	 * Changes the parent of this Qualifier by adding a new parent and removing the old parent.
	 * @param oldParentId a Qualifier
	 * @param newParentId a Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function changeParent(& $oldParentId, & $newParentId) { /* :: interface :: */ }
	// :: full java declaration :: void changeParent(osid.shared.Id oldParentId, osid.shared.Id newParentId)

	/**
	 * Determines if this Qualifier is the child a given parent
	 * @param parentId a Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function isChildOf(& $parentId) { /* :: interface :: */ }
	// :: full java declaration :: boolean isChildOf(osid.shared.Id parentId)

	/**
	 * Determines if this Qualifier is a descendant of the given Qualifier.
	 * @param ancestorId a Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package osid.authorization
	 */
	function isDescendantOf(& $ancestorId) { /* :: interface :: */ }
	// :: full java declaration :: boolean isDescendantOf(osid.shared.Id ancestorId)

	/**
	 * Gets the children of this Qualifier.
	 * @return QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getChildren() { /* :: interface :: */ }
	// :: full java declaration :: QualifierIterator getChildren()

	/**
	 * Gets the parents of this Qualifier.
	 * @return QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package osid.authorization
	 */
	function &getParents() { /* :: interface :: */ }
	// :: full java declaration :: QualifierIterator getParents()
}


	/**
	 * All methods of all interfaces of the Open Service Interface Definition (OSID) throw a subclass of osid.OsidException. This requires the caller of an osid package method to handle the OsidException. Since the application using an osid manager can not determine where the manager will ultimately execute, it must assume a worst case scenario and protect itself. <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
	 * @package osid.authorization
	 */
class AuthorizationException // :: normal class
	extends OsidException
{

	/**
	 * Unknown or unsupported Type
	 * @package osid.authorization
	 */
	// :: defined globally :: define("UNKNOWN_TYPE","Unknown Type ");

	/**
	 * Unknown Id
	 * @package osid.authorization
	 */
	// :: defined globally :: define("UNKNOWN_ID","Unknown Id ");

	/**
	 * Iterator has no more elements
	 * @package osid.authorization
	 */
	// :: defined globally :: define("NO_MORE_ITERATOR_ELEMENTS","Iterator has no more elements ");

	/**
	 * Permission denied
	 * @package osid.authorization
	 */
	// :: defined globally :: define("PERMISSION_DENIED","Permission denied ");

	/**
	 * Null argument
	 * @package osid.authorization
	 */
	// :: defined globally :: define("NULL_ARGUMENT","Null argument ");

	/**
	 * Configuration error
	 * @package osid.authorization
	 */
	// :: defined globally :: define("CONFIGURATION_ERROR","Configuration error ");

	/**
	 * Effective date must precede expiration date
	 * @package osid.authorization
	 */
	// :: defined globally :: define("EFFECTIVE_PRECEDE_EXPIRATION","Effective date must precede expiration date ");

	/**
	 * Operation failed
	 * @package osid.authorization
	 */
	// :: defined globally :: define("OPERATION_FAILED","Operation failed");

	/**
	 * Cannot delete last root Qualifier
	 * @package osid.authorization
	 */
	// :: defined globally :: define("CANNOT_DELETE_LAST_ROOT_QUALIFIER","Cannot delete last root Qualifier ");
}

// :: post-declaration code ::
/**
 * @const string UNKNOWN_TYPE public static final String UNKNOWN_TYPE = "Unknown Type "
 * @package osid.authorization
 */
define("UNKNOWN_TYPE", "Unknown Type ");

/**
 * @const string UNKNOWN_ID public static final String UNKNOWN_ID = "Unknown Id "
 * @package osid.authorization
 */
define("UNKNOWN_ID", "Unknown Id ");

/**
 * @const string NO_MORE_ITERATOR_ELEMENTS public static final String NO_MORE_ITERATOR_ELEMENTS = "Iterator has no more elements "
 * @package osid.authorization
 */
define("NO_MORE_ITERATOR_ELEMENTS", "Iterator has no more elements ");

/**
 * @const string PERMISSION_DENIED public static final String PERMISSION_DENIED = "Permission denied "
 * @package osid.authorization
 */
define("PERMISSION_DENIED", "Permission denied ");

/**
 * @const string NULL_ARGUMENT public static final String NULL_ARGUMENT = "Null argument "
 * @package osid.authorization
 */
define("NULL_ARGUMENT", "Null argument ");

/**
 * @const string CONFIGURATION_ERROR public static final String CONFIGURATION_ERROR = "Configuration error "
 * @package osid.authorization
 */
define("CONFIGURATION_ERROR", "Configuration error ");

/**
 * @const string EFFECTIVE_PRECEDE_EXPIRATION public static final String EFFECTIVE_PRECEDE_EXPIRATION = "Effective date must precede expiration date "
 * @package osid.authorization
 */
define("EFFECTIVE_PRECEDE_EXPIRATION", "Effective date must precede expiration date ");

/**
 * @const string OPERATION_FAILED public static final String OPERATION_FAILED = "Operation failed"
 * @package osid.authorization
 */
define("OPERATION_FAILED", "Operation failed");

/**
 * @const string CANNOT_DELETE_LAST_ROOT_QUALIFIER public static final String CANNOT_DELETE_LAST_ROOT_QUALIFIER = "Cannot delete last root Qualifier "
 * @package osid.authorization
 */
define("CANNOT_DELETE_LAST_ROOT_QUALIFIER", "Cannot delete last root Qualifier ");

?>
