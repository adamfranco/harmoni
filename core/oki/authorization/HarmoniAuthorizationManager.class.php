<?php

require_once(OKI."/authorization.interface.php");
require_once(HARMONI.'oki/authorization/AuthorizationCache.class.php');
require_once(HARMONI.'oki/authorization/HarmoniFunction.class.php');
require_once(HARMONI.'oki/authorization/HarmoniAuthorization.class.php');
require_once(HARMONI.'oki/authorization/HarmoniAuthorizationIterator.class.php');
require_once(HARMONI.'oki/authorization/HarmoniQualifier.class.php');
require_once(HARMONI.'oki/shared/HarmoniIdIterator.class.php');

/**
 * AuthorizationManager allows an application to create Authorizations, get Authorizations given selection criterias, ask questions of Authorization such as what Agent can do a Function in a Qualifier context, etc.<p><p>The primary objects in Authorization are Authorization, Function, Agent, and Qualifier. There are also Function and Qualifier types that are understood by the implementation.<p><p>Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. <p><p>There are two methods to create Authorizations. One uses method uses Agent, Function, and Qualifier.  The other adds effective date and expiration date.  For the method without the dates, the effective date is today and there is no expiration date.  <p>SID Version: 1.0 rc6 <p>Licensed under the {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @access public
 * @version $Id: HarmoniAuthorizationManager.class.php,v 1.22 2004/12/13 19:47:14 adamfranco Exp $
 * @author Middlebury College, ETS
 * @copyright 2003 Middlebury College, ETS
 * @package harmoni.osid.authorization
 */
class HarmoniAuthorizationManager extends AuthorizationManager {
	
	/**
	 * The AuthorizationCache object.
	 * @attribute private object _cache
	 */
	var $_cache;
	
	
	/**
	 * Constructor
	 * @param integer dbIndex The database connection as returned by the DBHandler.
	 * @param string sharedDB The name of the shared database.
	 * manager.
	 * @access public
	 */
	function HarmoniAuthorizationManager($dbIndex, $authzDB) {
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($authzDB, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		$this->_cache =& new AuthorizationCache($dbIndex, $authzDB);
		
		$this->_groupAncestorsCache = array();
	}	


	/**
	 * Creates a new Authorization for an Agent performing a Function with a Qualifier Id.
	 * @param ref object agentId who is authorized to perform this Function for this Qualifer and its descendants
	 * @param ref object functionId the Id of the Function for this Authorization
	 * @param ref object qualifierId the Id of the Qualifier for this Authorization
	 * @param ref object effectiveDate when the Authorization becomes effective
	 * @param ref object expirationDate when the Authorization stops being effective
	 * @return ref object Authorization
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * @package harmoni.osid.authorization
	 */
	function &createDatedAuthorization(& $agentId, & $functionId, & $qualifierId, & $effectiveDate, & $expirationDate) {
		$authorization =& $this->_cache->createAuthorization($agentId, $functionId, $qualifierId, $effectiveDate, $expirationDate);
		return $authorization;
	}



	/* :: full java declaration :: Authorization createDatedAuthorization
	 * Creates a new Authorization for a Agent performing a Function with a Qualifier. Uses current date/time as the effectiveDate and doesn't set an expiration date.
	 * @param object agentId who is authorized to perform this Function for this Qualifer and its descendants
	 * @param object functionId the Id of the Function for this Authorization
	 * @param object qualifierId the Id of the Qualifier for this Authorization
	 * @return object Authorization
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function &createAuthorization(& $agentId, & $functionId, & $qualifierId) {
		$authorization =& $this->_cache->createAuthorization($agentId, $functionId, $qualifierId);
		return $authorization;
	}



	/* :: full java declaration :: Authorization createAuthorization
	 * Ids in Authorization are externally defined and their uniqueness is enforced by the implementation.
	 * @param object functionId is externally defined
	 * @param string displayName the name to display for this Function
	 * @param string description the description of this Function
	 * @param object functionType the Type of this Function
	 * @param object qualifierHierarchyId the Id of the Qualifier Hierarchy associated with this Function
	 * @return object Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function &createFunction(& $functionId, $displayName, $description, & $functionType, & $qualifierHierarchyId) {
		$function =& $this->_cache->createFunction($functionId, $displayName, $description, $functionType, $qualifierHierarchyId);
		return $function;
	}



	/* :: full java declaration :: Function createFunction
	 * Creates a new Qualifier in the Authorization Service that has no parent.  This is different from making a new instance of a Qualifier object locally as the Qualifier will be inserted into the Authorization Service.
	 * @param object qualifierId is externally defined
	 * @param string displayName the name to display for this Qualifier
	 * @param string description the description of this Qualifier
	 * @param object qualifierType the Type of this Qualifier
	 * @param object qualifierHierarchyId the Id of the Qualifier Hierarchy associated with this Qualifier
	 * @return object Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authorization
	 */
	function &createRootQualifier(& $qualifierId, $displayName, $description, & $qualifierType, & $qualifierHierarchyId) {
		$qualifier =& $this->_cache->createRootQualifier($qualifierId, $displayName, 
								$description, $qualifierType, $qualifierHierarchyId);
		return $qualifier;
	}


	/* :: full java declaration :: Qualifier createRootQualifier
	 * Ids in Authorization are externally defined and their uniqueness is enforced by the implementation. Creates a new Qualifier in the Authorization Service. This is different than making a new instance of a Qualifier object locally as the Qualifier will be inserted into the Authorization Service.
	 * @param object qualifierId is externally defined
	 * @param string displayName the name to display for this Qualifier
	 * @param string description the description of this Qualifier
	 * @param object qualifierType the Type of this Qualifier
	 * @param object parentId the parent of this Qualifier
	 * @return Qualifier
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authorization
	 */
	function &createQualifier(& $qualifierId, $displayName, $description, & $qualifierType, & $parentId) {
		$qualifier =& $this->_cache->createQualifier($qualifierId, $displayName, $description, $qualifierType, $parentId);
		return $qualifier;
	}



	/* :: full java declaration :: Qualifier createQualifier
	 * Deletes an existing Authorization.
	 * @param object authorization the Authorization
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function deleteAuthorization(& $authorization) {
		$this->_cache->deleteAuthorization($authorization);
	}


	/* :: full java declaration :: void deleteAuthorization(osid.shared.Id authorizationId)
	/**
	 * Delete a Function by Id.
	 * @param object functionId the Id of a Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function deleteFunction(& $functionId) { 
		$this->_cache->deleteFunction($functionId);
	}



	/* :: full java declaration :: void deleteFunction(osid.shared.Id functionId)
	/**
	 * Delete a Qualifier by Id.  The last root Qualifier cannot be deleted.
	 * @param ref object qualifierId the Id of a Qualifer
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#CANNOT_DELETE_LAST_ROOT_QUALIFIER CANNOT_DELETE_LAST_ROOT_QUALIFIER}
	 * @package harmoni.osid.authorization
	 */
	function deleteQualifier(& $qualifierId) {
		$this->_cache->deleteQualifier($qualifierId);
	}



	/* :: full java declaration :: void deleteQualifier(osid.shared.Id qualifierId)
	/**
	 * Given an agentId, functionId, and qualifierId returns true if the Agent is authorized now to perform the given Function with the given Qualifier.
	 * @param object agentId who is being tested if authorized
	 * @param object functionId the Id of the Function
	 * @param object qualifierId the Id of the Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function isAuthorized(& $agentId, & $functionId, & $qualifierId) {
		$authorizations =& $this->getAllAZs($agentId, $functionId, $qualifierId, true);
		
		return ($authorizations->hasNext());
	}



	/* :: full java declaration :: boolean isAuthorized
	 * Given a functionId and qualifierId returns true if the user is authorized now to perform the given Function with the given Qualifier.
	 * @param object functionId the Id of the Function
	 * @param object qualifierId the Id of the Qualifer
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function isUserAuthorized(& $functionId, & $qualifierId) {
		$authorizations =& $this->getAllUserAZs($functionId, $qualifierId, true);
		
		return ($authorizations->hasNext());
	}

	/* :: full java declaration :: boolean isUserAuthorized
	 * Get all the FunctionTypes supported by the Authorization implementation.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function &getFunctionTypes() {
		return $this->_cache->getFunctionTypes();
	}



	/* :: full java declaration :: osid.shared.TypeIterator getFunctionTypes()
	/**
	 * Get all the Function of the specified Type.
	 * @param object functionType the Type of the Functions to return
	 * @return object FunctionIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authorization
	 */
	function &getFunctions(& $functionType) {
		return $this->_cache->getFunctions($functionType);
	}



	/* :: full java declaration :: FunctionIterator getFunctions(osid.shared.Type functionType)
	/**
	 * It may or may not exist.
	 * @param object functionId the Id of the Function to return
	 * @return object Function
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function &getFunction(& $functionId) {
		// ** parameter validation
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
	
		$idValue = $functionId->getIdString();
		$result =& $this->_cache->getFunction($idValue);
		
		return $result;
	}



	/* :: full java declaration :: Function getFunction(osid.shared.Id functionId)
	/**
	 * Return true if the agent exists in the Authorization Service; false otherwise.  This is not asking if there are any Authorizations that reference this Agent.  This is not asking if the Agent is known to the Agent management Service in the Shared OSID.
	 * @param object agentId the Id of an Agent that may be known to the implementation
	 * @return boolean
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function agentExists(& $agentId) {
		die(UNIMPLEMENTED);
	}



	/* :: full java declaration :: boolean agentExists(osid.shared.Id agentId)
	/**
	 * Get all the QualifierTypes supported by the Authorization implementation.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function &getQualifierTypes() {
		$hierarchyManager =& Services::getService("Hierarchy");
		$hierarchies =& $hierarchyManager->getHierarchies();
		
		$types = array();
		while ($hierarchies->hasNext()) {
			$hierarchy =& $hierarchies->next();
			$nodeTypes =& $hierarchy->getNodeTypes();
			while ($nodeTypes->hasNext()) {
				$type =& $nodeTypes->next();
				$typeString = $type->getDomain()
							."::".$type->getAuthority()
							."::".$type->getKeyword();
				if (!$types[$typeString])
					$types[$typeString] =& $type;
			}
		}
		
		return new HarmoniIterator($types);
	}


	/* :: full java declaration :: osid.shared.TypeIterator getQualifierTypes()
	/**
	 * Given a QualifierHierarchy Id, returns the Qualifier that is the root of the tree of Qualifiers of this Type.
	 * @param object qualifierHierarchyId
	 * @return object QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authorization
	 */
	function &getRootQualifiers(& $qualifierHierarchyId) {
		return $this->_cache->getRootQualifiers($qualifierHierarchyId);
	}



	/* :: full java declaration :: QualifierIterator getRootQualifiers(osid.shared.Id qualifierHierarchyId)
	/**
	 * Given an existing Qualifier returns a list of its child Qualifiers.
	 * @param object qualifierId
	 * @return object QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	  */
	function &getQualifierChildren(& $qualifierId) {
		// get the qualifier
		$qualifier =& $this->getQualifier($qualifierId);
		return $qualifier->getChildren();
	}



	/* :: full java declaration :: QualifierIterator getQualifierChildren(osid.shared.Id qualifierId)
	/**
	 * Given an existing Qualifier returns a list of all descendants including its child Qualifiers.
	 * @param object qualifierId
	 * @return object QualifierIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	  */
	function &getQualifierDescendants(& $qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
	
		$result =& $this->_cache->getQualifierDescendants($qualifierId);
		
		return $result;
	}



	/* :: full java declaration :: QualifierIterator getQualifierDescendants(osid.shared.Id qualifierId)
	/**
	 * The instance may or may not exist.
	 * @param object qualifierId
	 * @return object Qualifier or null
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function &getQualifier(& $qualifierId) {
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		// ** end of parameter validation
	
		$result =& $this->_cache->getQualifier($qualifierId);
		
		return $result;
	}



	/* :: full java declaration :: Qualifier getQualifier(osid.shared.Id qualifierId)
	/**
	 * Given a Function and a Qualifier returns an enumeration of all agents allowed to do the Function with the Qualifier.  The Qualifier can be null, in which case any Qualifier is included in what is returned.
	 * @param object functionId
	 * @param object qualifierId
	 * @param boolean isActiveNow
	 * @return object osid.shared.AgentIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	  */
	function &getWhoCanDo(& $functionId, & $qualifierId, $isActiveNow) {
		// ** parameter validation
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($qualifierId, new OptionalRule(new ExtendsValidatorRule("Id")), true);
		ArgumentValidator::validate($isActiveNow, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$authorizations =& $this->_cache->getAZs(null,
												 $functionId->getIdString(),
												 (isset($qualifierId)) ? $qualifierId->getIdString() : null,
												 null, 
												 true, 
												 $isActiveNow);
											
		$agentIds = array();
		foreach (array_keys($authorizations) as $i => $key) {
			$authorization =& $authorizations[$key];
			$agentId =& $authorization->getAgentId();
			if (!isset($agentIds[$agentId->getIdString()]))
				$agentIds[$agentId->getIdString()] =& $agentId;
		}
		
		return new HarmoniIdIterator($agentIds);
	}



	/* :: full java declaration :: osid.shared.AgentIterator getWhoCanDo
	 * Given a Function and Qualifier (one must be non-null) returns an enumeration of matching user Authorizations.  Explicit Authorizations can be modified..  Any null argument will be treated as a wildcard.
	 * @param object functionId
	 * @param object qualifierId
	 * @param boolean isActiveNow
	 * @return object AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function &getExplicitUserAZs(& $functionId, & $qualifierId, $isActiveNow) {
		// ** parameter validation
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($isActiveNow, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$authentication =& Services::requireService("AuthN", true);
		$userId =& $authentication->getUserId(new HarmoniAuthenticationType());
		
		$authorizations =& $this->_cache->getAZs($userId,
												 $functionId->getIdString(),
												 $qualifierId->getIdString(),
												 null, 
												 true, 
												 $isActiveNow);
		
		return new HarmoniAuthorizationIterator($authorizations);
	}



	/* :: full java declaration :: AuthorizationIterator getExplicitUserAZs
	 * Given a FunctionType and Qualifier returns an enumeration of matching user Authorizations. The Authorizations must be for Functions within the given FunctionType. Explicit Authorizations can be modified.  Any null argument will be treated as a wildcard.
	 * @param object functionType
	 * @param object qualifierId
	 * @param boolean isActiveNow
	 * @return object Authorizations
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authorization
	 */
	function &getExplicitUserAZsByFuncType(& $functionType, & $qualifierId, $isActiveNow) {
		// ** parameter validation
		ArgumentValidator::validate($functionType, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($isActiveNow, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$authentication =& Services::requireService("AuthN", true);
		$userId =& $authentication->getUserId(new HarmoniAuthenticationType());
		
		$authorizations =& $this->_cache->getAZs($userId,
												 null,
												 $qualifierId->getIdString(),
												 $functionType, 
												 true, 
												 $isActiveNow);
		
		return new HarmoniAuthorizationIterator($authorizations);
	}



	/* :: full java declaration :: AuthorizationIterator getExplicitUserAZsByFuncType
	 * Given a Function and a Qualifier returns an enumeration of all Authorizations that would allow the user to do the Function with the Qualifier. This method differs from the simple form of getAuthorizations in that this method looks for any Authorization that permits doing the Function with the Qualifier even if the Authorization's Qualifier happens to be a parent of this Qualifier argument.
	 * @param object functionId
	 * @param object qualifierId
	 * @param boolean isActiveNow
	 * @return object Authorizations
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function &getAllUserAZs(& $functionId, & $qualifierId, $isActiveNow) {
		// ** parameter validation
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($isActiveNow, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$authentication =& Services::requireService("AuthN", true);
		$userId =& $authentication->getUserId(new HarmoniAuthenticationType());
		
		$authorizations =& $this->_cache->getAZs($userId,
									 $functionId->getIdString(),
									 $qualifierId->getIdString(),
									 null, 
									 false, 
									 $isActiveNow,
									 $this->_getContainingGroupIdStrings($userId));
		
		return new HarmoniAuthorizationIterator($authorizations);
	}



	/* :: full java declaration :: AuthorizationIterator getAllUserAZs
	 * Given a FunctionType and a Qualifier returns an enumeration of all Authorizations that would allow the user to do Functions in the FunctionType with the Qualifier. This method differs from getAuthorizations in that this method looks for any Authorization that permits doing the Function with the Qualifier even if the Authorization's Qualifier happens to be a parent of the Qualifier argument.
	 * @param object functionType
	 * @param object qualifierId
	 * @param boolean isActiveNow
	 * @return object Authorizations
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authorization
	 */
	function &getAllUserAZsByFuncType(& $functionType, & $qualifierId, $isActiveNow) {
		// ** parameter validation
		ArgumentValidator::validate($functionType, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($isActiveNow, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$authentication =& Services::requireService("AuthN", true);
		$userId =& $authentication->getUserId(new HarmoniAuthenticationType());
		
		$authorizations =& $this->_cache->getAZs($userId,
									 null,
									 $qualifierId->getIdString(),
									 $functionType, 
									 false, 
									 $isActiveNow,
									 $this->_getContainingGroupIdStrings($userId));
		
		return new HarmoniAuthorizationIterator($authorizations);
	}



	/* :: full java declaration :: AuthorizationIterator getAllUserAZsByFuncType
	 * Given a Agent, a Function, and a Qualifier (at least one of these must be non-null) returns an enumeration of matching Authorizations.  Explicit Authorizations can be modified.  Any null argument will be treated as a wildcard.
	 * @param object agentId
	 * @param object functionId
	 * @param object qualifierId
	 * @param boolean isActiveNow
	 * @return object AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function &getExplicitAZs(& $agentId, & $functionId, & $qualifierId, $isActiveNow) {
		// ** parameter validation
		ArgumentValidator::validate($agentId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($isActiveNow, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$authorizations =& $this->_cache->getAZs($agentId->getIdString(),
												 $functionId->getIdString(),
												 $qualifierId->getIdString(),
												 null, 
												 true, 
												 $isActiveNow);
		
		return new HarmoniAuthorizationIterator($authorizations);	
	}



	/* :: full java declaration :: AuthorizationIterator getExplicitAZs
	 * Given a Agent, a FunctionType, and a Qualifier (either Agent or Qualifier must be non-null) returns an enumeration of matching Authorizations. The Authorizations must be for Functions within the given FunctionType. Explicit Authorizations can be modified.  Any null argument will be treated as a wildcard.
	 * @param object agentId
	 * @param object functionType
	 * @param object qualifierId
	 * @param boolean isActiveNow
	 * @return object AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authorization
	 */
	function &getExplicitAZsByFuncType(& $agentId, & $functionType, & $qualifierId, $isActiveNow) {
		// ** parameter validation
		ArgumentValidator::validate($agentId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($functionType, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($isActiveNow, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$authorizations =& $this->_cache->getAZs($agentId->getIdString(),
												 null,
												 $qualifierId->getIdString(),
												 $functionType, 
												 true, 
												 $isActiveNow);
		
		return new HarmoniAuthorizationIterator($authorizations);
	}



	/* :: full java declaration :: AuthorizationIterator getExplicitAZsByFuncType
	 * Given a Function and a Qualifier returns an enumeration of all Authorizations that would allow agents to do the Function with the Qualifier. This method differs from the simple form of getAuthorizations in that this method looks for any Authorization that permits doing the Function with the Qualifier even if the Authorization's Qualifier happens to be a parent of this Qualifier argument.
	 * @param object agentId
	 * @param object functionId
	 * @param object qualifierId
	 * @param boolean isActiveNow
	 * @return object AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}
	 * @package harmoni.osid.authorization
	 */
	function &getAllAZs(& $agentId, & $functionId, & $qualifierId, $isActiveNow) {
		// ** parameter validation
		ArgumentValidator::validate($agentId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($functionId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($isActiveNow, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		
		// We need to check all of the groups that may contain $aId as well as
		// aId itsself.
		$authorizations =& $this->_cache->getAZs($agentId->getIdString(),
									 $functionId->getIdString(),
									 $qualifierId->getIdString(),
									 null, 
									 false, 
									 $isActiveNow,
									 $this->_getContainingGroupIdStrings($agentId));
		
		return new HarmoniAuthorizationIterator($authorizations);
	}



	/* :: full java declaration :: AuthorizationIterator getAllAZs
	 * Given a FunctionType and a Qualifier returns an enumeration of all Authorizations that would allow agents to do Functions in the FunctionType with the Qualifier. This method differs from getAuthorizations in that this method looks for any Authorization that permits doing the Function with the Qualifier even if the Authorization's Qualifier happens to be a parent of the Qualifier argument.
	 * @param object agentId
	 * @param object functionType
	 * @param object qualifierId
	 * @param boolean isActiveNow
	 * @return object AuthorizationIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}, {@link AuthorizationException#NULL_ARGUMENT NULL_ARGUMENT}, {@link AuthorizationException#UNKNOWN_ID UNKNOWN_ID}, {@link AuthorizationException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authorization
	 */
	function &getAllAZsByFuncType(& $agentId, & $functionType, & $qualifierId, $isActiveNow) {
		// ** parameter validation
		ArgumentValidator::validate($agentId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($functionType, new ExtendsValidatorRule("TypeInterface"), true);
		ArgumentValidator::validate($qualifierId, new ExtendsValidatorRule("Id"), true);
		ArgumentValidator::validate($isActiveNow, new BooleanValidatorRule(), true);
		// ** end of parameter validation
		
		$authorizations =& $this->_cache->getAZs($agentId->getIdString(),
									 null,
									 $qualifierId->getIdString(),
									 $functionType, 
									 false, 
									 $isActiveNow,
									 $this->_getContainingGroupIdStrings($agentId));
		
		return new HarmoniAuthorizationIterator($authorizations);
	}
	
	
	/**
	 * Given an implicit returns an enumeration of matching explicit user Authorizations. 
	 * Explicit Authorizations can be modified. A null argument will be treated as a wildcard. 
	 * @access public
	 * @param ref object implicitAuthorization -
	 * @return ref object AuthorizationIterator
	 **/
	function &getExplicitUserAZsForImplicitAZ(& $implicitAuthorization) {
		// ** parameter validation
		ArgumentValidator::validate($implicitAuthorization, new ExtendsValidatorRule("Authorization"), true);
		// ** end of parameter validation
		
		if ($implicitAuthorization->isExplicit()) {
			$str = "The Authorization must be implicit.";
			throwError(new Error($str, "Authorization", true));
		}
		
		$agentId =& $implicitAuthorization->getAgentId();
		$function =& $implicitAuthorization->getFunction();
		$functionId =& $function->getId();
		$qualifier =& $implicitAuthorization->getQualifier();
		$qualifierId =& $qualifier->getId();
				
		$authorizations =& $this->_cache->getAZs($agentId->getIdString(),
												 $functionId->getIdString(),
												 $qualifierId->getIdString(),
												 null, 
												 true, 
												 $implicitAuthorization->isActiveNow());
												 
		return new HarmoniAuthorizationIterator($authorizations);
	}
	
	



	/* :: full java declaration :: AuthorizationIterator getAllAZsByFuncType
	 * Returns the Qualifier Hierarchies supported by the Authorization implementation.  Qualifier Hierarchies are referenced by Id and may be known and managed through the Hierarchy OSID.
	 * @return object osid.shared.IdIterator
	 * @throws osid.authorization.AuthorizationException An exception with one of the following messages defined in osid.authorization.AuthorizationException may be thrown:  {@link AuthorizationException#OPERATION_FAILED OPERATION_FAILED}, {@link AuthorizationException#PERMISSION_DENIED PERMISSION_DENIED}, {@link AuthorizationException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, {@link AuthorizationException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authorization
	 */
	function &getQualifierHierarchies() {
		$hierarchyManager =& Services::requireService("Hierarchy", true);
		$hierarchies =& $hierarchyManager->getHierarchies();
		$array = array();
		while ($hierarchies->hasNext()) {
			$hierarchy =& $hierarchies->next();
			$array[] =& $hierarchy->getId();
		}
		return new HarmoniIterator($array);
	}

	/**
	 * Get an array of the string Ids of the groups that contain the particular
	 * Id.
	 * 
	 * @param object Id $agentOrGroupId
	 * @return array
	 * @access public
	 * @date 11/29/04
	 */
	function _getContainingGroupIdStrings ( & $agentOrGroupId ) {
		$agentOrGroupIdString = $agentOrGroupId->getIdString();
		
		// Check our cache first and only do the search if we don't have
		// the ancestors yet.
		if (!is_array($this->_groupAncestorsCache[$agentOrGroupIdString])) {
			$groupIds = array();
			
			$sharedManager =& Services::getService("Shared");
			$ancestorSearchType =& new HarmoniType("Agent & Group Search",
													"Middlebury","AncestorGroups");
			$containingGroups =& $sharedManager->getGroupsBySearch(
										$agentOrGroupId, $ancestorSearchType);
			while ($containingGroups->hasNext()) {
				$group =& $containingGroups->next();
				$groupId =& $group->getId();
				$groupIds[] = $groupId->getIdString();
			}
			
			$this->_groupAncestorsCache[$agentOrGroupIdString] = $groupIds;
		}
		return $this->_groupAncestorsCache[$agentOrGroupIdString];
	}
	
	

	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being 
	 * destroyed.
	 * Services may want to do post-processing such as content output or 
	 * committing changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
	}

}


?>