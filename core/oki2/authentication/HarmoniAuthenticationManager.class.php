<?php

require_once(OKI2."/osid/authentication/AuthenticationManager.php");
require_once(OKI2."/osid/authentication/AuthenticationException.php");

require_once(HARMONI.'/oki2/shared/HarmoniType.class.php');
require_once(HARMONI.'/oki2/shared/HarmoniTypeIterator.class.php');
require_once(HARMONI."oki2/shared/HarmoniProperties.class.php");

require_once(dirname(__FILE__)."/HTTPAuthNamePassTokenCollector.class.php");
require_once(dirname(__FILE__)."/BasicFormNamePassTokenCollector.class.php");
require_once(dirname(__FILE__)."/FormActionNamePassTokenCollector.class.php");
require_once(dirname(__FILE__)."/TokensAndTypeTokenCollector.class.php");

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
 * @package harmoni.osid_v2.authentication
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: HarmoniAuthenticationManager.class.php,v 1.33 2008/04/25 20:18:01 adamfranco Exp $
 */
class HarmoniAuthenticationManager 
	implements AuthenticationManager
{
	
	/**
	 * Constructor. Ititializes the availible AuthenticationTypes and results.
	 * @return void
	 */
	function HarmoniAuthenticationManager () {
		if (!isset($_SESSION['__AuthenticatedAgents']) || !is_array($_SESSION['__AuthenticatedAgents'])) {
			$_SESSION['__AuthenticatedAgents'] = array();
		}
		
		$this->_tokenCollectors = array();
		$this->_defaultTokenCollector = new HTTPAuthNamePassTokenCollector;
		$this->_adminActAsType = new Type("Authentication", "edu.middlebury", "Change User");
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
	function getOsidContext () { 
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
	function assignOsidContext ( OsidContext $context ) { 
		$this->_osidContext = $context;
	} 

	/**
	 * Assign the configuration of this Manager. Valid configuration options are as
	 * follows:
	 *	token_collectors (array) 	An array in which the keys are the serialized
	 *								Type objects that correspond to 
	 *								AuthenticationTypes and the values are the
	 *								TokenCollector objects to be used fot that
	 *								AuthenticationType.
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
	function assignConfiguration ( Properties $configuration ) { 
		$this->_configuration =$configuration;
		
		$configKeys =$this->_configuration->getKeys();
		while ($configKeys->hasNextObject()) {
			$key = $configKeys->nextObject();
			if ($key == 'token_collectors') {
		
				$tokenCollectors =$this->_configuration->getProperty('token_collectors');
				ArgumentValidator::validate($tokenCollectors,
					ArrayValidatorRuleWithRule::getRule(
						ExtendsValidatorRule::getRule("TokenCollector")));
					
				foreach (array_keys($tokenCollectors) as $key) {
					$authType = unserialize($key);
					$authTypeString = $this->_getTypeString($authType);
					$this->_tokenCollectors[$authTypeString] =$tokenCollectors[$key];
				}
			}
		}
	}

	/**
	 * Get the authentication Types that are supported by the implementation.
	 *	
	 * @return object TypeIterator
	 * 
	 * @throws object AuthenticationException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.authentication.AuthenticationException may be thrown:
	 *		   {@link
	 *		   org.osid.authentication.AuthenticationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authentication.AuthenticationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function getAuthenticationTypes () {
		$authNMethodManager = Services::getService("AuthNMethods");
		$types = new MultiIteratorIterator;
		$adminTypes = array();
		$adminTypes[] =$this->_adminActAsType;
		$types->addIterator(new HarmoniIterator($adminTypes));
		$types->addIterator($authNMethodManager->getAuthNTypes());
		return $types;
	}

	/**
	 * Invoke the authentication process of the specified Type to identify the
	 * user.  It may be necessary to call isUserAuthenticated to check the
	 * status of authentication.  The standard authentication technique of
	 * limiting the time an user's authentication is valid requires explicit
	 * queries of the authentication status. It is likely that checking the
	 * status of authentication will occur more frequently than invoking the
	 * mechanism to authenticate the user.	Separation of the authentication
	 * process from checking the status of the authentication process is made
	 * explicit by having the authenticateUser and isUserAuthenticated
	 * methods.
	 * 
	 * @param object Type $authenticationType
	 * 
	 * @throws object AuthenticationException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.authentication.AuthenticationException may be thrown:
	 *		   {@link
	 *		   org.osid.authentication.AuthenticationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authentication.AuthenticationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authentication.AuthenticationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function authenticateUser ( Type $authenticationType ) {
		if ($authenticationType->isEqual($this->_adminActAsType)) {
			$this->_authenticateAdminActAsUser();
		} else {
			$this->_checkType($authenticationType);
			$this->destroyAuthenticationForType($authenticationType);
			
			$authNTokens =$this->_getAuthNTokensFromUser($authenticationType);
			
			if ($authNTokens) {
				$this->_authenticateTokensWithType($authNTokens, $authenticationType);
			}
		}
	}
	
	/**
	 * Check the current authentication status of the user. If the method
	 * returns true, the user is authenticated.	 If the method returns false,
	 * the user is not authenticated.  This can indicate that the user could
	 * not be authenticated or that the user's authentication has timed out.
	 * The intent is to use the method authenticateUser to invoke the
	 * authentication process.	The standard authentication technique of
	 * limiting the time an user's authentication is valid requires explicit
	 * queries of the authentication status. It is likely that checking the
	 * status of authentication will occur more frequently than invoking the
	 * mechanism to authenticate the user.	Separation of the authentication
	 * process from checking the status of the authentication process is made
	 * explicit by having the authenticateUser and isUserAuthenticated
	 * methods.
	 * 
	 * @param object Type $authenticationType
	 *	
	 * @return boolean
	 * 
	 * @throws object AuthenticationException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.authentication.AuthenticationException may be thrown:
	 *		   {@link
	 *		   org.osid.authentication.AuthenticationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authentication.AuthenticationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authentication.AuthenticationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function isUserAuthenticated ( Type $authenticationType ) { 
		$this->_checkType($authenticationType);
		
		if(isset($_SESSION['__AuthenticatedAgents']
			[$this->_getTypeString($authenticationType)]))
		{
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Get the unique Id of the Agent that represents the user for the
	 * specified AuthenticationType.  Agents are managed using the Agent OSID.
	 * 
	 * @param object Type $authenticationType
	 *	
	 * @return object Id
	 * 
	 * @throws object AuthenticationException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.authentication.AuthenticationException may be thrown:
	 *		   {@link
	 *		   org.osid.authentication.AuthenticationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authentication.AuthenticationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authentication.AuthenticationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function getUserId ( Type $authenticationType ) { 
		$this->_checkType($authenticationType);
		
		$idManager = Services::getService("Id");
		// If the user is authenticated, look up their Agent Id
		if ($this->isUserAuthenticated($authenticationType)) {
		
			return $_SESSION['__AuthenticatedAgents']
					[$this->_getTypeString($authenticationType)];
		
		// Otherwise return Id == 0 for the "anonymous user"
		} else {
			return $idManager->getId("edu.middlebury.agents.anonymous");
		}
	}
	
	/**
	 * Answer true if the current user is authenticated with any authentication
	 * type.
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @return boolean
	 * @access public
	 * @since 7/26/07
	 */
	function isUserAuthenticatedWithAnyType () {
		$authTypes =$this->getAuthenticationTypes();
		while ($authTypes->hasNext()) {
			if ($this->isUserAuthenticated($authTypes->next()))
				return true;
		}
		
		return false;
	}
	/**
	 * Answer the first authenticated Id found for the current user or anonymous
	 * if none is found. 
	 *
	 * WARNING: NOT IN OSID
	 * 
	 * @return object Id.
	 * @access public
	 * @since 7/26/07
	 */
	function getFirstUserId () {
		$authTypes =$this->getAuthenticationTypes();
		while ($authTypes->hasNext()) {
			$authType =$authTypes->next();
			if ($this->isUserAuthenticated($authType)) {
				$id =$this->getUserId($authType);
				return $id;
			}
		}
		
		$idManager = Services::getService("Id");
		return $idManager->getId("edu.middlebury.agents.anonymous");
	}

	/**
	 * Destroy authentication for all authentication types.
	 * 
	 * @throws object AuthenticationException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.authentication.AuthenticationException may be thrown:
	 *		   {@link
	 *		   org.osid.authentication.AuthenticationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authentication.AuthenticationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}
	 * 
	 * @access public
	 */
	function destroyAuthentication () { 
		$_SESSION['__AuthenticatedAgents'] = array();
		unset(	$_SESSION['__ADMIN_IDS_ACTING_AS_OTHER'],	
				$_SESSION['__ADMIN_NAMES_ACTING_AS_OTHER']);
	}

	/**
	 * Destroy authentication for the specified authentication type.
	 * 
	 * @param object Type $authenticationType
	 * 
	 * @throws object AuthenticationException An exception
	 *		   with one of the following messages defined in
	 *		   org.osid.authentication.AuthenticationException may be thrown:
	 *		   {@link
	 *		   org.osid.authentication.AuthenticationException#OPERATION_FAILED
	 *		   OPERATION_FAILED}, {@link
	 *		   org.osid.authentication.AuthenticationException#PERMISSION_DENIED
	 *		   PERMISSION_DENIED}, {@link
	 *		   org.osid.authentication.AuthenticationException#CONFIGURATION_ERROR
	 *		   CONFIGURATION_ERROR}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNIMPLEMENTED
	 *		   UNIMPLEMENTED}, {@link
	 *		   org.osid.authentication.AuthenticationException#NULL_ARGUMENT
	 *		   NULL_ARGUMENT}, {@link
	 *		   org.osid.authentication.AuthenticationException#UNKNOWN_TYPE
	 *		   UNKNOWN_TYPE}
	 * 
	 * @access public
	 */
	function destroyAuthenticationForType ( Type $authenticationType ) { 
		$this->_checkType($authenticationType);
		
		unset($_SESSION['__AuthenticatedAgents']
			[$this->_getTypeString($authenticationType)]);
			
		if ($authenticationType->isEqual($this->_adminActAsType))
			unset(	$_SESSION['__ADMIN_IDS_ACTING_AS_OTHER'],	
					$_SESSION['__ADMIN_NAMES_ACTING_AS_OTHER']);
	}
	
	/**
	 * Validate the type passed to ensure that it is one of our supported ones.
	 * An error will be thrown if the type is invalid.
	 * 
	 * @param object Type $type
	 * @return void
	 * @access private
	 * @since 3/15/05
	 */
	function _checkType ( Type $type ) {
		$typeValid = FALSE;
		$authNTypes =$this->getAuthenticationTypes();
		while ($authNTypes->hasNext()) {
			if ($type->isEqual($authNTypes->next())) {
				$typeValid = TRUE;
				break;
			}
		}
		if (!$typeValid)
			throwError(new Error(AuthenticationException::UNKNOWN_TYPE()
				.": ".$this->_getTypeString($type), "AuthenticationManager", 1));
	}
	
	/**
	 * Validate the tokens for the authentication type given
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @param object Type $authenticationType
	 * @return void
	 * @access public
	 * @since 10/24/08
	 */
	public function _authenticateTokensWithType (AuthNTokens $authNTokens, Type $authenticationType) {
		$this->_checkType($authenticationType);
		$this->destroyAuthenticationForType($authenticationType);
		
		$authNMethodManager = Services::getService("AuthNMethods");
		$authNMethod =$authNMethodManager->getAuthNMethodForType($authenticationType);
		$isValid = $authNMethod->authenticateTokens($authNTokens);
		
		// If the authentication was successful, get the AgentId from the mapping
		// system and record the result.
		if ($isValid) {
			$agentId =$this->_getAgentIdForAuthNTokens($authNTokens, $authenticationType);
			
			// Update any stale info that was previously loaded
			$properties =$authNMethod->getPropertiesForTokens($authNTokens);
			$displayName = $authNMethod->getDisplayNameForTokens($authNTokens);
			$agentManager = Services::getService("Agent");
			$agent = $agentManager->getAgent($agentId);
			$agent->updateDisplayName($displayName);
			$propertyManager = Services::getService("Property");
			$propertyManager->storeProperties($agentId->getIdString(), $properties);
			
			$authenticationTypeString = $this->_getTypeString($authenticationType);
			$_SESSION['__AuthenticatedAgents'][$authenticationTypeString]
				=$agentId;
			
			// Ensure that the Authorization Cache gets the new users
			$authZ = Services::getService("AuthZ");
			$isAuthorizedCache = $authZ->getIsAuthorizedCache();
			$isAuthorizedCache->dirtyUser();
		}
		
		// Log the success
		if (Services::serviceRunning("Logging") && $isValid) {
			$loggingManager = Services::getService("Logging");
			$log =$loggingManager->getLogForWriting("Authentication");
			$formatType = new Type("logging", "edu.middlebury", "AgentsAndNodes",
							"A format in which the acting Agent[s] and the target nodes affected are specified.");
			$priorityType = new Type("logging", "edu.middlebury", "Event_Notice",
							"Normal events.");
			
			$item = new AgentNodeEntryItem("Authentication Sucess", "Authentication Success: <br/>&nbsp;&nbsp;&nbsp;&nbsp;".htmlspecialchars($authenticationType->getKeyword())." <br/>&nbsp;&nbsp;&nbsp;&nbsp;".htmlspecialchars($authNTokens->getIdentifier()));
				$item->addAgentId($agentId);
				
			$log->appendLogWithTypes($item,	$formatType, $priorityType);
		}
	}
	
	/**
	 * Return a string version of a type.
	 * 
	 * @param object Type $type
	 * @return string
	 * @access private
	 * @since 3/15/05
	 */
	function _getTypeString (Type $type) {
		return $type->getDomain()
			."::".$type->getAuthority()
			."::".$type->getKeyword();
			
	}
	
	/**
	 * Get the AgentId that corresponds to the AuthNTokens passed and AuthNType.
	 * If no Agent is currently mapped to the AuthNTokens, create a new Agent
	 * and map it to the tokens.
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @param object Type $authenticationType
	 * @return object Id
	 * @access protected
	 * @since 3/15/05
	 */
	function _getAgentIdForAuthNTokens ( AuthNTokens $authNTokens, Type $authenticationType ) {
		$mappingManager = Services::getService("AgentTokenMapping");
		$mapping =$mappingManager->getMappingForTokens($authNTokens, $authenticationType);
		
		// Create a new agent if we don't have one mapped.
		if (!$mapping) {
		
			// Get some properties to populate the Agent with:
			$authNMethodManager = Services::getService("AuthNMethods");
			$authNMethod =$authNMethodManager->getAuthNMethodForType($authenticationType);
			$properties =$authNMethod->getPropertiesForTokens($authNTokens);
			$dname = $authNMethod->getDisplayNameForTokens($authNTokens);
			// Create the agent.
			$agentManager = Services::getService("Agent");
			$agent =$agentManager->createAgent(
				$dname,
				new Type ("Authentication", "edu.middlebury.harmoni", "User"),
				$properties);
				
			// Create the mapping
			$mapping =$mappingManager->createMapping(
				$agent->getId(), $authNTokens, $authenticationType);
		}
		
		return $mapping->getAgentId();
	}
	

	
	/**
	 * Prompt the user for their authentication tokens and recieve the responce.
	 * 
	 * @param object Type $authenticationType
	 * @return object AuthNTokens
	 * @access private
	 * @since 3/15/05
	 */
	function _getAuthNTokensFromUser( Type $authenticationType ) {
		if (isset($this->_tokenCollectors[
			$this->_getTypeString($authenticationType)]))
		{
			$tokenCollector =$this->_tokenCollectors[
				$this->_getTypeString($authenticationType)];
		} else {
			$tokenCollector =$this->_defaultTokenCollector;
		}
		
		$tokens = $tokenCollector->collectTokens($authenticationType->asString());
		
		
		// if we have tokens, create an AuthNTokens object for them.
		if ($tokens) {
			$authNMethodManager = Services::getService("AuthNMethods");
			$authNMethod =$authNMethodManager->getAuthNMethodForType($authenticationType);
			$authNTokens =$authNMethod->createTokens($tokens);		
		}	
		// Otherwise return FALSE. Maybe they will come in during the next
		// execution cycle
		else {
			$authNTokens = FALSE;
		}
			
		return $authNTokens;
	}
	
	/**
	 * Log out the current user if they have authorization to act as other users,
	 * and log them in as the new user, setting a session identifier to add to the
	 * logs.
	 * 
	 * @param <##>
	 * @return <##>
	 * @access public
	 * @since 12/11/06
	 */
	function _authenticateAdminActAsUser () {
		$this->jqueryUrl = $this->_configuration->getProperty('jquery_src');
		if (is_null($this->jqueryUrl))
			throw new ConfigurationErrorException('To use Admin-Act-As-User, the AuthenticationManager must be configured with a jquery_src');
		$this->jqueryAutocompleteUrl = $this->_configuration->getProperty('jquery_autocomplete_src');
		if (is_null($this->jqueryAutocompleteUrl))
			throw new ConfigurationErrorException('To use Admin-Act-As-User, the AuthenticationManager must be configured with a jquery_autocomplete_src');
		$this->jqueryAutocompleteCss = $this->_configuration->getProperty('jquery_autocomplete_css');
		if (is_null($this->jqueryAutocompleteCss))
			throw new ConfigurationErrorException('To use Admin-Act-As-User, the AuthenticationManager must be configured with a jquery_autocomplete_css');
			
		
		// Check authorization. If the current user is not authorized to act as
		// others, stop.
		$authZ = Services::getService("AuthZ");
		$idManager = Services::getService("Id");
		$agentManager = Services::getService("Agent");
		
		if (!$authZ->isUserAuthorized(
			$idManager->getId('edu.middlebury.authorization.change_user'),
			$idManager->getId('edu.middlebury.authorization.root')))
		{
			return false;
		} else {
			// Record the current Agents into the session for logging purposes
			$_SESSION['__ADMIN_IDS_ACTING_AS_OTHER'] = array();
			$_SESSION['__ADMIN_NAMES_ACTING_AS_OTHER'] = array();
			
			$anonymousId =$idManager->getId('edu.middlebury.agents.anonymous');
			$authNTypes =$this->getAuthenticationTypes();
			while ($authNTypes->hasNext()) {
				$authenticationType =$authNTypes->next();
				$id =$this->getUserId($authenticationType);
				if (!$id->isEqual($anonymousId)) {
					$agent =$agentManager->getAgent($id);
					$_SESSION['__ADMIN_IDS_ACTING_AS_OTHER'][] = $id;
					$_SESSION['__ADMIN_NAMES_ACTING_AS_OTHER'][] = $agent->getDisplayName();
				}
			}
			
			$tokenCollector = new TokensAndTypeTokenCollector($this->jqueryUrl, $this->jqueryAutocompleteUrl, $this->jqueryAutocompleteCss);
			$tokens = $tokenCollector->collectTokens();
			$newAuthNType = $tokenCollector->getAuthNType();
			if ($this->_authenticateAdminActAsUserForType($tokens, $newAuthNType)) {
				// If we've successfully logged in with the Admin-act-as type, destroy other authentications.
				$authNTypes =$this->getAuthenticationTypes();
				while ($authNTypes->hasNext()) {
					$authenticationType = $authNTypes->next();
					if (!$authenticationType->isEqual($this->_adminActAsType)) {
						$this->destroyAuthenticationForType($authenticationType);
					}
				}
			}
		}
	}
	
	/**
	 * Log in a user if the username matches, but without checking the password,
	 * as part of the admin-act-as process
	 * 
	 * @param <##>
	 * @return boolean TRUE if tokens are valid.
	 * @access public
	 * @since 12/11/06
	 */
	function _authenticateAdminActAsUserForType (AuthNTokens $authNTokens, Type $authenticationType ) {
		$this->_checkType($authenticationType);
// 		$this->destroyAuthenticationForType($authenticationType);
				
		if ($authNTokens) {
			$authNMethodManager = Services::getService("AuthNMethods");
			$authNMethod =$authNMethodManager->getAuthNMethodForType($authenticationType);
			// just check if the tokens exist, not if there is a correct password.
			$isValid = $authNMethod->tokensExist($authNTokens);
			
			// If the authentication was successful, get the AgentId from the mapping
			// system and record the result.
			if ($isValid) {
				$agentId =$this->_getAgentIdForAuthNTokens($authNTokens, $authenticationType);
				$authenticationTypeString = $this->_getTypeString($this->_adminActAsType);
				$_SESSION['__AuthenticatedAgents'][$authenticationTypeString]
					=$agentId;
				
				// Update any stale info that was previously loaded
				$properties =$authNMethod->getPropertiesForTokens($authNTokens);
				$displayName = $authNMethod->getDisplayNameForTokens($authNTokens);
				$agentManager = Services::getService("Agent");
				$agent = $agentManager->getAgent($agentId);
				$agent->updateDisplayName($displayName);
				$propertyManager = Services::getService("Property");
				$propertyManager->storeProperties($agentId->getIdString(), $properties);
				
				// Ensure that the Authorization Cache gets the new users
				$authorizationMgr = Services::getService("AuthZ");
				$isAuthorizedCache = $authorizationMgr->getIsAuthorizedCache();
				$isAuthorizedCache->dirtyUser();
			}
			
			// Log the success or failure
			if (Services::serviceRunning("Logging")) {
				$loggingManager = Services::getService("Logging");
				$log =$loggingManager->getLogForWriting("Authentication");
				$formatType = new Type("logging", "edu.middlebury", "AgentsAndNodes",
								"A format in which the acting Agent[s] and the target nodes affected are specified.");
				$priorityType = new Type("logging", "edu.middlebury", "Event_Notice",
								"Normal events.");
				
				if ($isValid) {
					$item = new AgentNodeEntryItem("Admin Acting As", 
						"Admin users: <br/>&nbsp;&nbsp;&nbsp;&nbsp;"
						.implode(", ", $_SESSION['__ADMIN_NAMES_ACTING_AS_OTHER'])
						."<br/>Successfully authenticated as: <br/>&nbsp;&nbsp;&nbsp;&nbsp;"
						.htmlspecialchars($authenticationType->getKeyword())
						." <br/>&nbsp;&nbsp;&nbsp;&nbsp;".htmlspecialchars($authNTokens->getIdentifier()));
					$item->addAgentId($agentId);
					$item->addUserIds();
					
					$log->appendLogWithTypes($item,	$formatType, $priorityType);
				}
			}
			
			return $isValid;
		} else {
			return false;
		}
	}
	
	/**
     * Verify to OsidLoader that it is loading
     * 
     * <p>
     * OSID Version: 2.0
     * </p>
     * .
     * 
     * @throws object OsidException 
     * 
     * @access public
     */
    public function osidVersion_2_0 () {}
}
