<?php

require_once(OKI2."/osid/authentication/AuthenticationManager.php");
require_once(OKI2."/osid/authentication/AuthenticationException.php");

require_once(HARMONI.'/oki2/authentication/HarmoniAuthenticationType.class.php');
require_once(HARMONI.'/oki2/shared/HarmoniType.class.php');
require_once(HARMONI.'/oki2/shared/HarmoniTypeIterator.class.php');
require_once(HARMONI."oki2/shared/HarmoniProperties.class.php");

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
 * @version $Id: HarmoniAuthenticationManager.class.php,v 1.11 2005/02/16 15:23:49 thebravecowboy Exp $
 */
class HarmoniAuthenticationManager 
	extends AuthenticationManager
{
	
	/**
	 * The database connection as returned by the DBHandler.
	 * @var integer _dbIndex 
	 * @access private
	 */
	var $_dbIndex;

	/**
	 * The name of the Authentication database.
	 * @var string _authNDB 
	 * @access private
	 */
	var $_authNDB;
	
	/**
	 * The Authentication Types availible.
	 * @var array _authTypes 
	 * @access private
	 */
	var $_authTypes;
	
	/**
	 * The Agent Ids already looked up.
	 * @var array _agentIds 
	 * @access private
	 */
	var $_agentIds;
	
	/**
	 * The Harmoni object that will handle Authentication.
	 * @var object _harmoni 
	 * @access private
	 */
	var $_harmoni;
	
	/**
	 * Constructor. Ititializes the availible AuthenticationTypes and results.
	 * @return void
	 */
	function HarmoniAuthenticationManager ($dbIndex, $databaseName) {
		// ** parameter validation
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($databaseName, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		$this->_harmoni =& $GLOBALS['harmoni'];
		$this->_dbIndex = $dbIndex;
		$this->_authNDB = $databaseName;
		
		$this->_agentIds = array();
		
		// Go through the Harmoni Authentication Methods and create types
		// for them.
		$this->_authTypes = array();		
		$this->_authTypes[] =& new HarmoniAuthenticationType();
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
		$iterator =& new HarmoniIterator($this->_authTypes);
		return $iterator;
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
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));

		$typeValid = FALSE;
		foreach (array_keys($this->_authTypes) as $key) {
			if ($this->_authTypes[$key]->isEqual($authenticationType)) {
				$typeValid = TRUE;
				break;
			}
		}
		if (!$typeValid)
			throwError(new Error(AuthenticationException::UNKNOWN_TYPE(), "AuthenticationManager", 1));
		
		// Assuming that we only have the LoginHandler as our authentication type,
		// just use that to authenticate.
		debug::output("AuthN->authenticateUser(LoginHandler)", 8, "AuthN");
		$loginState =& $this->_harmoni->LoginHandler->execute(TRUE);
		
		// Run our _getAgentId function to store a mapping of this user
		// to an Agent if it doesn't exist.
		if ($this->isUserAuthenticated($authenticationType))
			$this->getUserId($authenticationType);
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
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		$typeValid = FALSE;
		foreach (array_keys($this->_authTypes) as $key) {
			if ($this->_authTypes[$key]->isEqual($authenticationType)) {
				$typeValid = TRUE;
				break;
			}
		}
		if (!$typeValid)
			throwError(new Error(AuthenticationException::UNKNOWN_TYPE(), "AuthenticationManager", 1));
			
		if($this->_harmoni->LoginState 
			&& $this->_harmoni->LoginState->isValid()) {
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
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		$typeValid = FALSE;
		foreach (array_keys($this->_authTypes) as $key) {
			if ($this->_authTypes[$key]->isEqual($authenticationType)) {
				$typeValid = TRUE;
				break;
			}
		}
		if (!$typeValid)
			throwError(new Error(AuthenticationException::UNKNOWN_TYPE(), "AuthenticationManager", 1));
		
		
		// If the user is authenticated, look up their Agent Id or create a
		// new Agent if they don't have one.
		if ($this->isUserAuthenticated($authenticationType)) {
			$name = $this->_harmoni->LoginState->getAgentName();
			
			return $this->_getAgentId($name, $authenticationType);
		
		// Otherwise return Id == 0 for the "anonymous user"
		} else {
			$idManager =& Services::getService("Id");
			return $idManager->getId("0");
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
		$this->_harmoni->LoginHandler->logout();
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
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		$typeValid = FALSE;
		foreach (array_keys($this->_authTypes) as $key) {
			if ($this->authTypes[$key]->isEqual($authenticationType)) {
				$typeValid = TRUE;
				break;
			}
		}
		if (!$typeValid)
			throwError(new Error(AuthenticationException::UNKNOWN_TYPE(), "AuthenticationManager", 1));
		
		// Assuming that we only have the LoginHandler as our authentication type,
		// just destroy that Authentication.
		$this->_harmoni->LoginHandler->logout();
	}
	
	/**
	 * Get the unique Id of the Agent that represents the agent with the
	 * specified authentication tokens for the specified AuthenticationType.  
	 * Agents are managed using the Agent OSID.
	 *
	 * WARNING: NOT IN OSID - This method is not in the OSID.
	 * 
	 * @param mixed $tokens The authentication tokens used to represent the agent
	 *		in the specified authentication Type.
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
	function &getAgentId ( &$tokens, &$authenticationType ) {
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		
		$typeValid = FALSE;
		foreach (array_keys($this->_authTypes) as $key) {
			if ($this->_authTypes[$key]->isEqual($authenticationType)) {
				$typeValid = TRUE;
				break;
			}
		}
		if (!$typeValid)
			throwError(new Error(AuthenticationException::UNKNOWN_TYPE(), "AuthenticationManager", 1));
		
		
		// Look up their Agent Id or create a
		// new Agent if they don't have one.
		return $this->_getAgentId($tokens, $authenticationType);
	}
	
	function &createMapping(&$tokens, &$authenticationType, &$id){
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		ArgumentValidator::validate($id, new ExtendsvalidatorRule("Id"));
		
		$dbHandler =& Services::getService("DBHandler");

		if ($this->_agentIds[$tokens]) {
			throwError(new Error("Agent Id already exists","AuthenticationManager", 1));
		}
				
		// Store a mapping in our table.
						
		$query =& new InsertQuery;
		$columns = array($this->_authNDB.".authn_mapping.agent_id", 
						$this->_authNDB.".authn_mapping.system_name",
						$this->_authNDB.".authn_mapping.type_domain",
						$this->_authNDB.".authn_mapping.type_authority",
						$this->_authNDB.".authn_mapping.type_keyword");
		$query->setColumns($columns);
		$values = array("'".addslashes($id->getIdString())."'", "'".addslashes($tokens)."'",
						"'".addslashes($authenticationType->getDomain())."'", 
						"'".addslashes($authenticationType->getAuthority())."'", 
						"'".addslashes($authenticationType->getKeyword())."'");
		$query->setValues($values);
		$query->setTable($this->_authNDB.".authn_mapping");
		$result =& $dbHandler->query($query, $this->_dbIndex);
		
		//$id =& $this->getAgentId($tokens, $authenticationType);
		
		return;
	
	}
	
	/**
	 * Delete the mapping between an Agent and their Authentication tokens.
	 *
	 * WARNING: NOT IN OSID - This method is not in the OSID.
	 * 
	 * @param object Id $agentId
	 * @return void
	 * @access public
	 * @since 11/22/04
	 */
	function deleteMapping ( &$id ) {
		$dbHandler =& Services::getService("DBHandler");
		$query =& new DeleteQuery;
		$query->setTable($this->_authNDB.".authn_mapping");
		$query->addWhere($this->_authNDB.".authn_mapping.agent_id='".addslashes($id->getIdString())."'");
//		$query->addWhere($this->_authNDB.".authn_mapping.type_domain='".addslashes($authenticationType->getDomain())."'");
//		$query->addWhere($this->_authNDB.".authn_mapping.type_authority='".addslashes($authenticationType->getAuthority())."'");
//		$query->addWhere($this->_authNDB.".authn_mapping.type_keyword='".addslashes($authenticationType->getKeyword())."'");
		$result =& $dbHandler->query($query, $this->_dbIndex);
	}
	
	/**
	 * Get the agent Id for the given tokens from our mapping or store a new
	 * one if it doesn't exist.
	 * 
	 * @param mixed $tokens
	 * @param object $authori
	 * @return object Id
	 * @access private
	 * @since 11/18/04
	 */
	function _getAgentId ($tokens, & $authenticationType) {
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		
		// If we have cached this mapping, use that
		if ($this->_agentIds[$tokens]) {
			return $this->_agentIds[$tokens];
		
		// otherwise, look up the id in the database.
		} else {
			$dbHandler =& Services::getService("DBHandler");
			$query =& new SelectQuery;
			$query->addColumn($this->_authNDB.".authn_mapping.agent_id", "agent_id");
			$query->addTable($this->_authNDB.".authn_mapping");
			$query->addWhere($this->_authNDB.".authn_mapping.system_name='".addslashes($tokens)."'");
			$query->addWhere($this->_authNDB.".authn_mapping.type_domain='".addslashes($authenticationType->getDomain())."'");
			$query->addWhere($this->_authNDB.".authn_mapping.type_authority='".addslashes($authenticationType->getAuthority())."'");
			$query->addWhere($this->_authNDB.".authn_mapping.type_keyword='".addslashes($authenticationType->getKeyword())."'");
			$result =& $dbHandler->query($query, $this->_dbIndex);
			
			$idManager =& Services::getService('Id');
			$agentManager =& Services::getService('Agent');
			
			// If an agent Id can be mapped to the name, return the id.
			if ($result->getNumberOfRows() == 1) {
				$id =& $idManager->getId($result->field('agent_id'));
			
			// If no AgentId can be mapped to the Id, create a new Agent
			// then populate its properties.
			} else if ($result->getNumberOfRows() == 0) {
				$type =& new HarmoniType ('Authentication', 'Harmoni', 'User',
											'A generic user agent created during login.');
								
				
				$propertiesType = new HarmoniType('Agents', 'Harmoni', 'Auth Properties',
						'Properties known to the Harmoni Authentication System.');
				$properties =& new HarmoniProperties($propertiesType);
				
				// Populate its properties if we can find any.
				$agentInfoHandler =& Services::getService("AgentInformation");
				$info =& $agentInfoHandler->getAgentInformation($tokens, FALSE);
				
				foreach (array_keys($info) as $key) {
					$properties->addProperty($key, $info[$key]);
				}
				
				
				// Create the Agent
				$agent =& $agentManager->createAgent($tokens, $type, $properties);
				
				// Store a mapping in our table.
				$id =& $agent->getId();
				
				$query =& new InsertQuery;
				$columns = array($this->_authNDB.".authn_mapping.agent_id", 
								$this->_authNDB.".authn_mapping.system_name",
								$this->_authNDB.".authn_mapping.type_domain",
								$this->_authNDB.".authn_mapping.type_authority",
								$this->_authNDB.".authn_mapping.type_keyword");
				$query->setColumns($columns);
				$values = array("'".addslashes($id->getIdString())."'", "'".addslashes($tokens)."'",
								"'".addslashes($authenticationType->getDomain())."'", 
								"'".addslashes($authenticationType->getAuthority())."'", 
								"'".addslashes($authenticationType->getKeyword())."'");
				$query->setValues($values);
				$query->setTable($this->_authNDB.".authn_mapping");
				$result =& $dbHandler->query($query, $this->_dbIndex);
				
			
			// If we have more than one row, we have problems.
			} else {
				throwError(new Error(AuthenticationException::OPERATION_FAILED(), "AuthenticationManager", 1));
			}
			
			// Cache the id, then return it.
			$this->_agentIds[$tokens] =& $id;
			return $id;
		}
	}
	
	
	/**
	 * Functions required for the services interface.
	 *
	 * WARNING: NOT IN OSID - This method is not in the OSID.
	 * 
	 * @return void
	 * @access public
	 */
	function start() {}
	
	/**
	 * Functions required for the services interface.
	 *
	 * WARNING: NOT IN OSID - This method is not in the OSID.
	 * 
	 * @return void
	 * @access public
	 */
	function stop() {}
}

?>