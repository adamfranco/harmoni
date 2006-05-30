<?php

require_once(OKI2."/osid/authentication/AuthenticationManager.php");
require_once(OKI2."/osid/authentication/AuthenticationException.php");

require_once(HARMONI.'/oki2/authentication/HarmoniAuthenticationType.class.php');
require_once(HARMONI.'/oki2/shared/HarmoniType.class.php');
require_once(HARMONI.'/oki2/shared/HarmoniTypeIterator.class.php');
require_once(HARMONI."oki2/shared/HarmoniProperties.class.php");

require_once(dirname(__FILE__)."/HTTPAuthNamePassTokenCollector.class.php");
require_once(dirname(__FILE__)."/BasicFormNamePassTokenCollector.class.php");
require_once(dirname(__FILE__)."/FormActionNamePassTokenCollector.class.php");

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
 * @version $Id: HarmoniAuthenticationManager.class.php,v 1.22 2006/05/30 20:18:24 adamfranco Exp $
 */
class HarmoniAuthenticationManager 
	extends AuthenticationManager
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
		$this->_defaultTokenCollector =& new HTTPAuthNamePassTokenCollector;
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
	function assignConfiguration ( &$configuration ) { 
		$this->_configuration =& $configuration;
		
		$configKeys =& $this->_configuration->getKeys();
		while ($configKeys->hasNextObject()) {
			$key = $configKeys->nextObject();
			if ($key == 'token_collectors') {
		
				$tokenCollectors =& $this->_configuration->getProperty('token_collectors');
				ArgumentValidator::validate($tokenCollectors,
					ArrayValidatorRuleWithRule::getRule(
						ExtendsValidatorRule::getRule("TokenCollector")));
					
				foreach (array_keys($tokenCollectors) as $key) {
					$authType = unserialize($key);
					$authTypeString = $this->_getTypeString($authType);
					$this->_tokenCollectors[$authTypeString] =& $tokenCollectors[$key];
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
	function &getAuthenticationTypes () {
		$authNMethodManager =& Services::getService("AuthNMethods");
		return $authNMethodManager->getAuthNTypes();
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
	function authenticateUser ( &$authenticationType ) {
		$this->_checkType($authenticationType);
		$this->destroyAuthenticationForType($authenticationType);
		
		$authNTokens =& $this->_getAuthNTokensFromUser($authenticationType);
		
		if ($authNTokens) {
			$authNMethodManager =& Services::getService("AuthNMethods");
			$authNMethod =& $authNMethodManager->getAuthNMethodForType($authenticationType);
			$isValid = $authNMethod->authenticateTokens($authNTokens);
			
			// If the authentication was successful, get the AgentId from the mapping
			// system and record the result.
			if ($isValid) {
				$agentId =& $this->_getAgentIdForAuthNTokens($authNTokens, $authenticationType);
				$authenticationTypeString = $this->_getTypeString($authenticationType);
				$_SESSION['__AuthenticatedAgents'][$authenticationTypeString]
					=& $agentId;
			}
			
			// Log the success or failure
			if (Services::serviceRunning("Logging")) {
				$loggingManager =& Services::getService("Logging");
				$log =& $loggingManager->getLogForWriting("Authentication");
				$formatType =& new Type("logging", "edu.middlebury", "AgentsAndNodes",
								"A format in which the acting Agent[s] and the target nodes affected are specified.");
				$priorityType =& new Type("logging", "edu.middlebury", "Event_Notice",
								"Normal events.");
				
				if ($isValid) {
					$item =& new AgentNodeEntryItem("Authentication Sucess", "Authentication Success: <br/>&nbsp;&nbsp;&nbsp;&nbsp;".$authenticationType->getKeyword()." <br/>&nbsp;&nbsp;&nbsp;&nbsp;".$authNTokens->getIdentifier());
					$item->addAgentId($agentId);
				} else {
					$item =& new AgentNodeEntryItem("Authentication Failure", "Authentication Failure: <br/>&nbsp;&nbsp;&nbsp;&nbsp;".$authenticationType->getKeyword()." <br/>&nbsp;&nbsp;&nbsp;&nbsp;".$authNTokens->getIdentifier());
				}
				
				$log->appendLogWithTypes($item,	$formatType, $priorityType);
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
	function isUserAuthenticated ( &$authenticationType ) { 
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
	function &getUserId ( &$authenticationType ) { 
		$this->_checkType($authenticationType);
		
		$idManager =& Services::getService("Id");
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
	function destroyAuthenticationForType ( &$authenticationType ) { 
		$this->_checkType($authenticationType);
		
		unset($_SESSION['__AuthenticatedAgents']
			[$this->_getTypeString($authenticationType)]);
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
	function _checkType ( &$type ) {
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($type, ExtendsValidatorRule::getRule("Type"));

		$typeValid = FALSE;
		$authNTypes =& $this->getAuthenticationTypes();
		while ($authNTypes->hasNextType()) {
			if ($type->isEqual($authNTypes->nextType())) {
				$typeValid = TRUE;
				break;
			}
		}
		if (!$typeValid)
			throwError(new Error(AuthenticationException::UNKNOWN_TYPE()
				.": ".$this->_getTypeString($type), "AuthenticationManager", 1));
	}
	
	/**
	 * Return a string version of a type.
	 * 
	 * @param object Type $type
	 * @return string
	 * @access private
	 * @since 3/15/05
	 */
	function _getTypeString (&$type) {
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
	function &_getAgentIdForAuthNTokens ( &$authNTokens, &$authenticationType ) {
		$mappingManager =& Services::getService("AgentTokenMapping");
		$mapping =& $mappingManager->getMappingForTokens($authNTokens, $authenticationType);
		
		// Create a new agent if we don't have one mapped.
		if (!$mapping) {
		
			// Get some properties to populate the Agent with:
			$authNMethodManager =& Services::getService("AuthNMethods");
			$authNMethod =& $authNMethodManager->getAuthNMethodForType($authenticationType);
			$properties =& $authNMethod->getPropertiesForTokens($authNTokens);
			$dname = $authNMethod->getDisplayNameForTokens($authNTokens);
			// Create the agent.
			$agentManager =& Services::getService("Agent");
			$agent =& $agentManager->createAgent(
				$dname,
				new Type ("Authentication", "edu.middlebury.harmoni", "User"),
				$properties);
				
			// Create the mapping
			$mapping =& $mappingManager->createMapping(
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
	function &_getAuthNTokensFromUser( &$authenticationType ) {
		if (isset($this->_tokenCollectors[
			$this->_getTypeString($authenticationType)]))
		{
			$tokenCollector =& $this->_tokenCollectors[
				$this->_getTypeString($authenticationType)];
		} else {
			$tokenCollector =& $this->_defaultTokenCollector;
		}
		
		$tokens = $tokenCollector->collectTokens();
		
		
		// if we have tokens, create an AuthNTokens object for them.
		if ($tokens) {
			$authNMethodManager =& Services::getService("AuthNMethods");
			$authNMethod =& $authNMethodManager->getAuthNMethodForType($authenticationType);
			$authNTokens =& $authNMethod->createTokens($tokens);		
		}	
		// Otherwise return FALSE. Maybe they will come in during the next
		// execution cycle
		else {
			$authNTokens = FALSE;
		}
			
		return $authNTokens;
	}
}

?>
