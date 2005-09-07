<?php

require_once(OKI2."/osid/authorization/AuthorizationManager.php");
require_once(HARMONI.'oki2/authorization/AuthorizationCache.class.php');
require_once(HARMONI.'oki2/authorization/HarmoniFunction.class.php');
require_once(HARMONI.'oki2/authorization/HarmoniAuthorization.class.php');
require_once(HARMONI.'oki2/authorization/HarmoniAuthorizationIterator.class.php');
require_once(HARMONI.'oki2/authorization/HarmoniQualifier.class.php');
require_once(HARMONI.'oki2/shared/HarmoniIdIterator.class.php');

/**
 * AuthorizationManager allows an application to create Authorizations, get
 * Authorizations given selection criterias, ask questions of Authorization
 * such as what agentId can do a Function in a Qualifier context, etc.
 * 
 * <p>
 * The primary objects in Authorization are Authorization, Function, agentId,
 * and Qualifier. There are also Function and Qualifier types that are
 * understood by the implementation.
 * </p>
 * 
 * <p>
 * Ids in Authorization are externally defined and their uniqueness is enforced
 * by the implementation.
 * </p>
 * 
 * <p>
 * There are two methods to create Authorizations. One method uses agentId,
 * Function, and Qualifier.	 The other adds effective date and expiration
 * date.  For the method without the dates, the effective date is today and
 * there is no expiration date.
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
 * @package harmoni.osid_v2.authorization
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniAuthorizationManager.class.php,v 1.18 2005/09/07 21:41:04 adamfranco Exp $
 */
class HarmoniAuthorizationManager 
	extends AuthorizationManager 
{
	
	/**
	 * The AuthorizationCache object.
	 * @var object _cache 
	 * @access private
	 */
	var $_cache;
	var $_groupAncestorsCache;
	
	
	/**
	 * Constructor
	 * manager.
	 * @access public
	 */
	function HarmoniAuthorizationManager() {
		$this->_groupAncestorsCache = array();
	}
	
	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	database_index			integer
	 *	database_name			string
	 * 
	 * @param object Properties $configuration (original type: java.util.Properties)
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#OPERATION_FAILED OPERATION_FAILED},
	 *		   {@link org.osid.OsidException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.OsidException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.OsidException#UNIMPLEMENTED UNIMPLEMENTED}, {@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
		
		$dbIndex =& $configuration->getProperty('database_index');
		$authzDB =& $configuration->getProperty('database_name');
		
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, IntegerValidatorRule::getRule(), true);
		ArgumentValidator::validate($authzDB, StringValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$this->_cache =& new AuthorizationCache($dbIndex, $authzDB);
	}

	/**
	 * Return context of this OsidManager.
	 *	
	 * @return object OsidContext
	 * 
	 * @throws object OsidException 
	 * 
	 * @access public
	 */
	function &getOsidContext () { 
		return $this->_osidContext;
	} 

	/**
	 * Assign the context of this OsidManager.
	 * 
	 * @param object OsidContext $context
	 * 
	 * @throws object OsidException An exception with one of the following
	 *		   messages defined in org.osid.OsidException:	{@link
	 *		   org.osid.OsidException#NULL_ARGUMENT NULL_ARGUMENT}
	 * 
	 * @access public
	 */
	function assignOsidContext ( &$context ) { 
		$this->_osidContext =& $context;
	} 

	/**
	 * Creates a new Authorization for an Agent performing a Function with a
	 * Qualifier.
	 * 
	 * @param object Id $agentId
	 * @param object Id $functionId
	 * @param object Id $qualifierId
	 * @param int $effectiveDate
	 * @param int $expirationDate
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}, {@link
	 *		   org.osid.authorization.AuthorizationException#EFFECTIVE_PRECEDE_EXPIRATION}
	 * 
	 * @access public
	 */
	function &createDatedAuthorization ( &$agentId, &$functionId, &$qualifierId, $effectiveDate, $expirationDate ) { 
		$authorization =& $this->_cache->createAuthorization($agentId, $functionId, $qualifierId, $effectiveDate, $expirationDate);
		return $authorization;
	}

	/**
	 * Creates a new Authorization for a Agent performing a Function with a
	 * Qualifier. Uses current date/time as the effectiveDate and doesn't set
	 * an expiration date.
	 * 
	 * @param object Id $agentId
	 * @param object Id $functionId
	 * @param object Id $qualifierId
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &createAuthorization ( &$agentId, &$functionId, &$qualifierId ) { 
		$authorization =& $this->_cache->createAuthorization($agentId, $functionId, $qualifierId);
		return $authorization;
	}

	/**
	 * Ids in Authorization are externally defined and their uniqueness is
	 * enforced by the implementation.
	 * 
	 * @param object Id $functionId
	 * @param string $displayName
	 * @param string $description
	 * @param object Type $functionType
	 * @param object Id $qualifierHierarchyId
	 *	
	 * @return object Function
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &createFunction ( &$functionId, $displayName, $description, &$functionType, &$qualifierHierarchyId ) { 
		$function =& $this->_cache->createFunction($functionId, $displayName, $description, $functionType, $qualifierHierarchyId);
		return $function;
	}

	/**
	 * Creates a new Qualifier in the Authorization Service that has no parent.
	 * This is different from making a new instance of a Qualifier object
	 * locally as the Qualifier will be inserted into the Authorization
	 * Service.
	 * 
	 * @param object Id $qualifierId
	 * @param string $displayName
	 * @param string $description
	 * @param object Type $qualifierType
	 * @param object Id $qualifierHierarchyId
	 *	
	 * @return object Qualifier
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &createRootQualifier ( &$qualifierId, $displayName, $description, &$qualifierType, &$qualifierHierarchyId ) { 
		$qualifier =& $this->_cache->createRootQualifier($qualifierId, $displayName, $description, $qualifierType, $qualifierHierarchyId);
		return $qualifier;
	}

	/**
	 * Ids in Authorization are externally defined and their uniqueness is
	 * enforced by the implementation. Creates a new Qualifier in the
	 * Authorization Service. This is different than making a new instance of
	 * a Qualifier object locally as the Qualifier will be inserted into the
	 * Authorization Service.
	 * 
	 * @param object Id $qualifierId
	 * @param string $displayName
	 * @param string $description
	 * @param object Type $qualifierType
	 * @param object Id $parentId
	 *	
	 * @return object Qualifier
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &createQualifier ( &$qualifierId, $displayName, $description, &$qualifierType, &$parentId ) { 
		$qualifier =& $this->_cache->createQualifier($qualifierId, $displayName, $description, $qualifierType, $parentId);
		return $qualifier;
	}

	/**
	 * Deletes an existing Authorization.
	 * 
	 * @param object Authorization $authorization
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteAuthorization ( &$authorization ) { 
		$this->_cache->deleteAuthorization($authorization);
	}

	/**
	 * Delete a Function by Id.
	 * 
	 * @param object Id $functionId
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function deleteFunction ( &$functionId ) { 
		$this->_cache->deleteFunction($functionId);
	}

	/**
	 * Delete a Qualifier by Id.  The last root Qualifier cannot be deleted.
	 * 
	 * @param object Id $qualifierId
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}, {@link
	 *		   org.osid.authorization.AuthorizationException#CANNOT_DELETE_LAST_ROOT_QUALIFIER
	 *		   CANNOT_DELETE_LAST_ROOT_QUALIFIER}
	 * 
	 * @access public
	 */
	function deleteQualifier ( &$qualifierId ) { 
		$this->_cache->deleteQualifier($qualifierId);
	}

	/**
	 * Given an agentId, functionId, and qualifierId returns true if the Agent
	 * is authorized now to perform the Function with the Qualifier.
	 * 
	 * @param object Id $agentId
	 * @param object Id $functionId
	 * @param object Id $qualifierId
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function isAuthorized ( &$agentId, &$functionId, &$qualifierId ) { 
		$authorizations =& $this->getAllAZs($agentId, $functionId, $qualifierId, true);
		
		return ($authorizations->hasNext());
	}

	/**
	 * Given a functionId and qualifierId returns true if the user is
	 * authorized now to perform the Function with the Qualifier.
	 * 
	 * @param object Id $functionId
	 * @param object Id $qualifierId
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function isUserAuthorized ( &$functionId, &$qualifierId ) { 
		$authorizations =& $this->getAllUserAZs($functionId, $qualifierId, true);
		
		return ($authorizations->hasNext());
	}

	/**
	 * Get all the FunctionTypes supported by the Authorization implementation.
	 *	
	 * @return object TypeIterator
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
	 * @access public
	 */
	function &getFunctionTypes () { 
		return $this->_cache->getFunctionTypes();
	}

	/**
	 * Get all the Functions of the specified Type.
	 * 
	 * @param object Type $functionType
	 *	
	 * @return object FunctionIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getFunctions ( &$functionType ) { 
		return $this->_cache->getFunctions($functionType);
	}

	/**
	 * 
	 * 
	 * @param object Id $functionId
	 *	
	 * @return object Function
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getFunction ( &$functionId ) { 
		// ** parameter validation
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
	
		$idValue = $functionId->getIdString();
		$result =& $this->_cache->getFunction($idValue);
		
		return $result;
	}

	/**
	 * Return true if the agentId exists in the Authorization Service; false
	 * otherwise.  This is not asking if there are any Authorizations that
	 * reference this agentId.	This is not asking if the agentId is known to
	 * the Agent OSID.
	 * 
	 * @param object Id $agentId
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function agentExists ( &$agentId ) { 
		die(UNIMPLEMENTED);
	}

	/**
	 * Get all the QualifierTypes supported by the Authorization
	 * implementation.
	 *	
	 * @return object TypeIterator
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
	 * @access public
	 */
	function &getQualifierTypes () { 
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

	/**
	 * Given a hierarchyId, returns the Qualifiers at the root of the specified
	 * Hierarchy.
	 * 
	 * @param object Id $qualifierHierarchyId
	 *	
	 * @return object QualifierIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getRootQualifiers ( &$qualifierHierarchyId ) { 
		return $this->_cache->getRootQualifiers($qualifierHierarchyId);
	}

	/**
	 * Given an existing qualifierId returns the Ids of its child Qualifiers.
	 * 
	 * @param object Id $qualifierId
	 *	
	 * @return object QualifierIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getQualifierChildren ( &$qualifierId ) { 
		// get the qualifier
		$qualifier =& $this->getQualifier($qualifierId);
		return $qualifier->getChildren();
	}

	/**
	 * Given an existing qualifierId returns the Ids of all descendants
	 * including its child Qualifiers.
	 * 
	 * @param object Id $qualifierId
	 *	
	 * @return object QualifierIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getQualifierDescendants ( &$qualifierId ) { 
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
	
		$result =& $this->_cache->getQualifierDescendants($qualifierId);
		
		return $result;
	}

	/**
	 * 
	 * 
	 * @param object Id $qualifierId
	 *	
	 * @return object Qualifier
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getQualifier ( &$qualifierId ) { 
		// ** parameter validation
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		// ** end of parameter validation
	
		$result =& $this->_cache->getQualifier($qualifierId);
		
		return $result;
	}

	/**
	 * Given a functionId and a qualifierId returns the Ids of all Agents
	 * allowed to do the Function with the Qualifier.  A null qualifierId is
	 * treated as a wildcard.
	 * 
	 * @param object Id $functionId
	 * @param object Id $qualifierId
	 *	
	 * @return object IdIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getWhoCanDo ( &$functionId, &$qualifierId ) { 
		// ** parameter validation
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($qualifierId, OptionalRule::getRule(ExtendsValidatorRule::getRule("Id")), true);
		// Removed as of version 2 of the OSID
		// ArgumentValidator::validate($isActiveNow, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$authorizations =& $this->_cache->getAZs(null,
												 $functionId->getIdString(),
												 (isset($qualifierId)) ? $qualifierId->getIdString() : null,
												 null, 
												 true, 
												 true);
											
		$agentIds = array();
		foreach (array_keys($authorizations) as $i => $key) {
			$authorization =& $authorizations[$key];
			$agentId =& $authorization->getAgentId();
			if (!isset($agentIds[$agentId->getIdString()]))
				$agentIds[$agentId->getIdString()] =& $agentId;
		}
		
		return new HarmoniIdIterator($agentIds);
	}

	/**
	 * Given a functionId and qualifierId (one must be non-null) returns the
	 * matching user Authorizations.  Explicit Authorizations can be
	 * modified..  Any null argument will be treated as a wildcard.
	 * 
	 * @param object Id $functionId
	 * @param object Id $qualifierId
	 * @param boolean $isActiveNowOnly
	 *	
	 * @return object AuthorizationIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getExplicitUserAZs ( &$functionId, &$qualifierId, $isActiveNowOnly ) { 
		// ** parameter validation
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($isActiveNowOnly, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$userIds =& $this->_getUserIds();
		$authorizations = array();
		foreach (array_keys($userIds) as $key) {
			$userId =& $userIds[$key];
			$userAZs =& $this->_cache->getAZs($userId->getIdString(),
												 $functionId->getIdString(),
												 $qualifierId->getIdString(),
												 null, 
												 true, 
												 $isActiveNowOnly);
			$authorizations =& array_merge($authorizations, $userAZs);
		}
		
		return new HarmoniAuthorizationIterator($authorizations);
	}

	/**
	 * Given a FunctionType and qualifierId returns the matching user
	 * Authorizations. The Authorizations must be for Functions within the
	 * given FunctionType. Explicit Authorizations can be modified.	 Any null
	 * argument will be treated as a wildcard.
	 * 
	 * @param object Type $functionType
	 * @param object Id $qualifierId
	 * @param boolean $isActiveNowOnly
	 *	
	 * @return object AuthorizationIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getExplicitUserAZsByFuncType ( &$functionType, &$qualifierId, $isActiveNowOnly ) { 
		// ** parameter validation
		ArgumentValidator::validate($functionType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($isActiveNowOnly, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$userIds =& $this->_getUserIds();
		$authorizations = array();
		foreach (array_keys($userIds) as $key) {
			$userId =& $userIds[$key];
			$userAZs =& $this->_cache->getAZs($userId->getIdString(),
												 null,
												 $qualifierId->getIdString(),
												 $functionType, 
												 true, 
												 $isActiveNowOnly);
			$authorizations =& array_merge($authorizations, $userAZs);
		}
		
		return new HarmoniAuthorizationIterator($authorizations);
	}

	/**
	 * Given a functionId and a qualifierId returns all Authorizations that
	 * would allow the user to do the Function with the Qualifier. This method
	 * differs from the simple form of getAuthorizations in that this method
	 * looks for any Authorization that permits doing the Function with the
	 * Qualifier even if the Authorization's Qualifier happens to be a parent
	 * of this Qualifier argument.
	 * 
	 * @param object Id $functionId
	 * @param object Id $qualifierId
	 * @param boolean $isActiveNowOnly
	 *	
	 * @return object AuthorizationIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getAllUserAZs ( &$functionId, &$qualifierId, $isActiveNowOnly ) { 
		// ** parameter validation
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($isActiveNowOnly, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$userIds =& $this->_getUserIds();
		$authorizations = array();
		foreach (array_keys($userIds) as $key) {
			$userId =& $userIds[$key];
			$userAZs =& $this->_cache->getAZs($userId->getIdString(),
									 $functionId->getIdString(),
									 $qualifierId->getIdString(),
									 null, 
									 false, 
									 $isActiveNowOnly,
									 $this->_getContainingGroupIdStrings($userId));
			$authorizations =& array_merge($authorizations, $userAZs);
		}
		
		return new HarmoniAuthorizationIterator($authorizations);
	}

	/**
	 * Given a FunctionType and a qualifierId returns all Authorizations that
	 * would allow the user to do Functions in the FunctionType with the
	 * Qualifier. This method differs from getAuthorizations in that this
	 * method looks for any Authorization that permits doing the Function with
	 * the Qualifier even if the Authorization's Qualifier happens to be a
	 * parent of the Qualifier argument.
	 * 
	 * @param object Type $functionType
	 * @param object Id $qualifierId
	 * @param boolean $isActiveNowOnly
	 *	
	 * @return object AuthorizationIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getAllUserAZsByFuncType ( &$functionType, &$qualifierId, $isActiveNowOnly ) { 
		// ** parameter validation
		ArgumentValidator::validate($functionType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($isActiveNowOnly, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$userIds =& $this->_getUserIds();
		$authorizations = array();
		foreach (array_keys($userIds) as $key) {
			$userId =& $userIds[$key];
			$userAZs =& $this->_cache->getAZs($userId->getIdString(),
									 null,
									 $qualifierId->getIdString(),
									 $functionType, 
									 false, 
									 $isActiveNowOnly,
									 $this->_getContainingGroupIdStrings($userId));
			$authorizations =& array_merge($authorizations, $userAZs);
		}
		
		return new HarmoniAuthorizationIterator($authorizations);
	}

	/**
	 * Given a agentId, a functionId, and a qualifierId (at least one of these
	 * must be non-null) returns the matching Authorizations.  Explicit
	 * Authorizations can be modified.	Any null argument will be treated as a
	 * wildcard.
	 * 
	 * @param object Id $agentId
	 * @param object Id $functionId
	 * @param object Id $qualifierId
	 * @param boolean $isActiveNowOnly
	 *	
	 * @return object AuthorizationIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getExplicitAZs ( &$agentId, &$functionId, &$qualifierId, $isActiveNowOnly ) { 
		// ** parameter validation
		ArgumentValidator::validate($agentId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($isActiveNowOnly, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$authorizations =& $this->_cache->getAZs($agentId->getIdString(),
												 $functionId->getIdString(),
												 $qualifierId->getIdString(),
												 null, 
												 true, 
												 $isActiveNowOnly);
		
		return new HarmoniAuthorizationIterator($authorizations);	
	}

	/**
	 * Given a agentId, a FunctionType, and a qualifierId (either agentId or
	 * qualifierId must be non-null) returns the matching Authorizations. The
	 * Authorizations must be for Functions within the given FunctionType.
	 * Explicit Authorizations can be modified.	 Any null argument will be
	 * treated as a wildcard.
	 * 
	 * @param object Id $agentId
	 * @param object Type $functionType
	 * @param object Id $qualifierId
	 * @param boolean $isActiveNowOnly
	 *	
	 * @return object AuthorizationIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getExplicitAZsByFuncType ( &$agentId, &$functionType, &$qualifierId, $isActiveNowOnly ) { 
		// ** parameter validation
		ArgumentValidator::validate($agentId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($functionType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($isActiveNowOnly, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$authorizations =& $this->_cache->getAZs($agentId->getIdString(),
												 null,
												 $qualifierId->getIdString(),
												 $functionType, 
												 true, 
												 $isActiveNowOnly);
		
		return new HarmoniAuthorizationIterator($authorizations);
	}

	/**
	 * Given a functionId and a qualifierId returns all Authorizations that
	 * would allow agents to do the Function with the Qualifier. This method
	 * differs from the simple form of getAuthorizations in that this method
	 * looks for any Authorization that permits doing the Function with the
	 * Qualifier even if the Authorization's Qualifier happens to be a parent
	 * of this Qualifier argument.
	 * 
	 * @param object Id $agentId
	 * @param object Id $functionId
	 * @param object Id $qualifierId
	 * @param boolean $isActiveNowOnly
	 *	
	 * @return object AuthorizationIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}
	 * 
	 * @access public
	 */
	function &getAllAZs ( &$agentId, &$functionId, &$qualifierId, $isActiveNowOnly ) { 
		// ** parameter validation
		ArgumentValidator::validate($agentId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($functionId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($isActiveNowOnly, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		
		// We need to check all of the groups that may contain $aId as well as
		// aId itsself.
		$authorizations =& $this->_cache->getAZs($agentId->getIdString(),
									 $functionId->getIdString(),
									 $qualifierId->getIdString(),
									 null, 
									 false, 
									 $isActiveNowOnly,
									 $this->_getContainingGroupIdStrings($agentId));
		
		return new HarmoniAuthorizationIterator($authorizations);
	}

	/**
	 * Given a FunctionType and a qualifierId returns all Authorizations that
	 * would allow Agents to do Functions in the FunctionType with the
	 * Qualifier. This method differs from getAuthorizations in that this
	 * method looks for any Authorization that permits doing the Function with
	 * the Qualifier even if the Authorization's Qualifier happens to be a
	 * parent of the Qualifier argument.
	 * 
	 * @param object Id $agentId
	 * @param object Type $functionType
	 * @param object Id $qualifierId
	 * @param boolean $isActiveNowOnly
	 *	
	 * @return object AuthorizationIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getAllAZsByFuncType ( &$agentId, &$functionType, &$qualifierId, $isActiveNowOnly ) { 
		// ** parameter validation
		ArgumentValidator::validate($agentId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($functionType, ExtendsValidatorRule::getRule("Type"), true);
		ArgumentValidator::validate($qualifierId, ExtendsValidatorRule::getRule("Id"), true);
		ArgumentValidator::validate($isActiveNowOnly, BooleanValidatorRule::getRule(), true);
		// ** end of parameter validation
		
		$authorizations =& $this->_cache->getAZs($agentId->getIdString(),
									 null,
									 $qualifierId->getIdString(),
									 $functionType, 
									 false, 
									 $isActiveNowOnly,
									 $this->_getContainingGroupIdStrings($agentId));
		
		return new HarmoniAuthorizationIterator($authorizations);
	}
	
	/**
	 * Given an implicit returns the matching explicit user Authorizations.
	 * Explicit Authorizations can be modified.	 A null argument will be
	 * treated as a wildcard.
	 * 
	 * @param object Authorization $implicitAuthorization
	 *	
	 * @return object AuthorizationIterator
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
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authorization.AuthorizationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_ID
	 *		   UNKNOWN_ID}, {@link
	 *		   org.osid.authorization.AuthorizationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function &getExplicitUserAZsForImplicitAZ (& $implicitAuthorization ) { 
		
		// ** parameter validation
		ArgumentValidator::validate($implicitAuthorization, ExtendsValidatorRule::getRule("Authorization"), true);
		// ** end of parameter validation
		
		if ($implicitAuthorization->isExplicit()) {
			// "The Authorization must be implicit."
			throwError(new Error(AuthorizationExeption::OPERATION_FAILED(), "AuthorizationManager", true));
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
	
	/**
	 * Returns the Qualifier Hierarchies supported by the Authorization
	 * implementation.	Qualifier Hierarchies are referenced by Id and may be
	 * known and managed through the Hierarchy OSID.
	 *	
	 * @return object IdIterator
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
	 * @access public
	 */
	function &getQualifierHierarchies () { 
		$hierarchyManager =& Services::getService("Hierarchy");
		$hierarchies =& $hierarchyManager->getHierarchies();
		$array = array();
		while ($hierarchies->hasNext()) {
			$hierarchy =& $hierarchies->next();
			$array[] =& $hierarchy->getId();
		}
		return new HarmoniIterator($array);
	}
	
	/**
	 * This method indicates whether this implementation supports
	 * AuthorizationManager methods: createFunction, deleteFunction. Function
	 * methods: updateDescription, updateDisplayName.
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
	 * @access public
	 */
	function supportsDesign () { 
		return TRUE;
	} 

	/**
	 * This method indicates whether this implementation supports
	 * AuthorizationManager methods: createAuthorization,
	 * createDatedAuthorization, createQualifier, createRootQualifier,
	 * deleteAuthorization, deleteQualifier, getFunctionTypes, getQualifier,
	 * getQualifierChildren, getQualifierDescendents, getQualifierHierarchies,
	 * getQualifierTypes, getRootQualifiers, getWhoCanDo. Function methods:
	 * getDescription, getDisplayName, getFunctionType, getId,
	 * getQualifierHierarchy. Qualifier methods: addParent, changeParent,
	 * getChildren, getDescription, getDisplayName, isParent, getId,
	 * getParents, getQualifierType, isChildOf, isDescendentOf, removeParent,
	 * updateDescription, updateDisplayName.
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
	 * @access public
	 */
	function supportsMaintenance () { 
		return TRUE;
	} 

	/**
	 * Get an array of the string Ids of the groups that contain the particular
	 * Id.
	 * 
	 * @param object Id $agentOrGroupId
	 * @return array
	 * @access private
	 * @since 11/29/04
	 */
	function _getContainingGroupIdStrings ( & $agentOrGroupId ) {
		$agentOrGroupIdString = $agentOrGroupId->getIdString();
		
		// Check our cache first and only do the search if we don't have
		// the ancestors yet.
		if (!isset($this->_groupAncestorsCache[$agentOrGroupIdString]) 
			|| !is_array($this->_groupAncestorsCache[$agentOrGroupIdString])) 
		{
			$groupIds = array();
			
			$agentManager =& Services::getService("Agent");
			$ancestorSearchType =& new HarmoniType("Agent & Group Search",
													"edu.middlebury.harmoni","AncestorGroups");
			$containingGroups =& $agentManager->getGroupsBySearch(
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
	 * Get the Ids of the current user. The user may be authenticated in multiple
	 * ways which each have a different Id.
	 * 
	 * @return array
	 * @access private
	 * @since 3/16/05
	 */
	function _getUserIds () {
		$authentication =& Services::getService("AuthN");
		$authNTypes =& $authentication->getAuthenticationTypes();
		$ids = array();
		$isAuthenticated = FALSE;
		while ($authNTypes->hasNextType()) {
			$authNType =& $authNTypes->nextType();
			if ($authentication->isUserAuthenticated($authNType)) {
				$ids[] =& $authentication->getUserId($authNType);
				$isAuthenticated = TRUE;
			}
		}
		
		// Otherwise return the "anonymous user"
		if (!$isAuthenticated) {
			$idManager =& Services::getService("Id");
			$ids[] =& $idManager->getId("edu.middlebury.agents.anonymous");
		}
		
		return $ids;
	}
}


?>