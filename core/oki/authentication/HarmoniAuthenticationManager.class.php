<?php

require_once(OKI."/authentication.interface.php");
require_once(HARMONI.'/oki/shared/HarmoniType.class.php');
require_once(HARMONI.'/oki/shared/HarmoniTypeIterator.class.php');

/**
 * The AuthenticationManager identifies the authentication Types supported by 
 * the implementation, authenticates the user using a particular authentication
 * Type, determines if the user is authenticated for a particular authentication 
 * Type, destroys the user's authentication, and returns the id of the Agent 
 * that represents the user. <p>SID Version: 1.0 rc6 <p>Licensed under the 
 * {@link SidLicense MIT O.K.I&#46; SID Definition License}.
 * @package harmoni.osid.authentication
 */
class HarmoniAuthenticationManager 
	extends AuthenticationManager // :: API interface
{
	
	/**
	 * The database connection as returned by the DBHandler.
	 * @attribute private integer _dbIndex
	 */
	var $_dbIndex;

	/**
	 * The name of the Authentication database.
	 * @attribute private string _authNDB
	 */
	var $_authNDB;
	
	/**
	 * The Authentication Types availible.
	 * @attribute private array _authTypes
	 */
	var $_authTypes;
	
	/**
	 * The Agent Ids already looked up.
	 * @attribute private array _agentIds
	 */
	var $_agentIds;
	
	/**
	 * The Harmoni object that will handle Authentication.
	 * @attribute private object _harmoni
	 */
	var $_harmoni;
	
	/**
	 * Constructor. Ititializes the availible AuthenticationTypes and results.
	 * @return void
	 */
	function HarmoniAuthenticationManager (& $harmoniObj, $dbIndex, $databaseName) {
		// ** parameter validation
		ArgumentValidator::validate($harmoniObj, new ExtendsValidatorRule('Harmoni'), true);
		ArgumentValidator::validate($dbIndex, new IntegerValidatorRule(), true);
		ArgumentValidator::validate($databaseName, new StringValidatorRule(), true);
		// ** end of parameter validation
		
		$this->_harmoni =& $harmoniObj;
		$this->_dbIndex = $dbIndex;
		$this->_authNDB = $databaseName;
		
		$this->_agentIds = array();
		
		// Go through the Harmoni Authentication Methods and create types
		// for them.
		$this->_authTypes = array();		
		$this->_authTypes[] =& new HarmoniType("Authentication", 
										"Harmoni", "Login", 
										"Authenticate using the Harmoni 
										LoginHandler.");
	}

	/**
	 * Get the authentication Types that are supported by the implementation.
	 * @return object osid.shared.TypeIterator
	 * @throws osid.shared.SharedException An exception with one of the 
	 * following messages defined in osid.shared.SharedException:   
	 * {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authentication
	 */
	function & getAuthenticationTypes() {
		$iterator =& new HarmoniIterator($this->_authTypes);
		return $iterator;
	}

	/**
	 * Invoke the authentication process of the specified Type to identify 
	 * the user.  It may be necessary to call isUserAuthenticated to check 
	 * the status of authentication.  The standard authentication technique 
	 * of limiting the time an user's authentication is valid requires 
	 * explicit queries of the authentication status. It is likely that 
	 * checking the status of authentication will occur more frequently than 
	 * invoking the mechanism to authenticate the user.  Separation of the 
	 * authentication process from checking the status of the authentication 
	 * process is made explicit by having the authenticateUser and 
	 * isUserAuthenticated methods.
	 * @param object Type $authenticationType 
	 * @throws osid.shared.SharedException An exception with one of the 
	 * following messages defined in osid.shared.SharedException:   
	 * {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authentication
	 */
	function authenticateUser(& $authenticationType) {
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		$typeValid = FALSE;
		foreach (array_keys($this->_authTypes) as $key) {
			if ($this->authTypes[$key]->isEqual($authenticationType)) {
				$typeValid = TRUE;
				break();
			}
		}
		if (!$typeValid)
			throwError(new Error(UNKNOWN_TYPE, "AuthenticationManager", 1));
		
		// Assuming that we only have the LoginHandler as our authentication type,
		// just use that to authenticate.
		$loginState =& $this->_harmoni->LoginHandler->execute();
	}

	/**
	 * Check the current authentication status of the user. If the method 
	 * returns true, the user is authenticated.  If the method returns false, 
	 * the user is not authenticated.  This can indicate that the user could 
	 * not be authenticated or that the user's authentication has timed out.  
	 * The intent is to use the method authenticateUser to invoke the 
	 * authentication process.  The standard authentication technique of 
	 * limiting the time an user's authentication is valid requires explicit 
	 * queries of the authentication status. It is likely that checking the 
	 * status of authentication will occur more frequently than invoking the 
	 * mechanism to authenticate the user.  Separation of the authentication 
	 * process from checking the status of the authentication process is made 
	 * explicit by having the authenticateUser and isUserAuthenticated methods.
	 * @param object Type $authenticationType
	 * @return boolean
	 * @throws osid.shared.SharedException An exception with one of the 
	 * following messages defined in osid.shared.SharedException:   
	 * {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authentication
	 */
	function isUserAuthenticated(& $authenticationType) {
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		$typeValid = FALSE;
		foreach (array_keys($this->_authTypes) as $key) {
			if ($this->authTypes[$key]->isEqual($authenticationType)) {
				$typeValid = TRUE;
				break();
			}
		}
		if (!$typeValid)
			throwError(new Error(UNKNOWN_TYPE, "AuthenticationManager", 1));
			
		
		if($this->_harmoni->LoginState 
			&& $this->_harmoni->LoginState->isValid()) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Get the Unique Id of the Agent that represents the user for the 
	 * specified AuthenticationType.  Agents are managed in the Shared OSID.
	 * @param object Type $authenticationType
	 * @return object osid.shared.Id
	 * @throws osid.shared.SharedException An exception with one of the 
	 * following messages defined in osid.shared.SharedException:   
	 * {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authentication
	 */
	function & getUserId(& $authenticationType) {
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		$typeValid = FALSE;
		foreach (array_keys($this->_authTypes) as $key) {
			if ($this->authTypes[$key]->isEqual($authenticationType)) {
				$typeValid = TRUE;
				break();
			}
		}
		if (!$typeValid)
			throwError(new Error(UNKNOWN_TYPE, "AuthenticationManager", 1));
		
		
		// If the user is authenticated, look up their Agent Id or create a
		// new Agent if they don't have one.
		if ($this->isUserAuthenticated($authenticationType)) {
			$name =& $this->_harmoni->LoginState->getAgentName();
			
			// If we have cached this mapping, use that
			if ($this->_agentIds[$name]) {
				return $this->_agentIds[$name];
			
			// otherwise, look up the id in the database.
			} else {
				$dbHandler =& Services::getService("DBHandler");
				$query =& new SelectQuery;
				$query->addColumn($this->_authNDB.".authn_mapping.agent_id", "agent_id");
				$query->addTable($this->_authNDB.".authn_mapping");
				$query->addWhere($this->_authNDB.".authn_mapping.system_name='".$name."'");
				$result =& $dbHandler->query($query, $this->_dbIndex);
				
				$sharedManager =& Services::getService('Shared');
				
				// If an agent Id can be mapped to the name, return the id.
				if ($result->getNumberOfRows() == 1) {
					$id =& sharedManager->getId($result->field('agent_id'));
				
				// If no AgentId can be mapped to the Id, create a new Agent
				// then populate its properties.
				} else if ($result->getNumberOfRows() == 0) {
					$type =& new HarmoniType ('Authentication', 'Harmoni', 'User',
												'A generic user agent created
												during login.');
					$agent =& $sharedManager->createAgent($name, $type);
					$id =& $agent->getId();
					
					// Store a mapping in our table.
					$query =& new InsertQuery;
					$columns = array($this->_authNDB.".authn_mapping.agent_id", 
									$this->_authNDB.".authn_mapping.system_name");
					$query->setColumns($columns);
					$values = array($id->getIdString(), $name);
					$query->setValues($values);
					$query->setTable($this->_authNDB.".authn_mapping");
					$result =& $dbHandler->query($query, $this->_dbIndex);
					
				
				// If we have more than one row, we have problems.
				} else {
					throwError(new Error(OPERATION_FAILED, "AuthenticationManager", 1));
				}
				
				// Cache the id, then return it.
				$this->_agentIds[$name] =& $id;
				return $id;
			}
			
		} else {
			throwError(new Error(OPERATION_FAILED, "AuthenticationManager", 1));
		}
	}

	/**
	 * Destroy authentication for all authentication types.
	 * @throws osid.shared.SharedException An exception with one of the 
	 * following messages defined in osid.shared.SharedException:   
	 * {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}
	 * @package harmoni.osid.authentication
	 */
	function destroyAuthentication() {
		$this->_harmoni->LoginHandler->logout();
	}

	/**
	 * Destroy authentication for the specified authentication type.
	 * @param object Type $authenticationType
	 * @throws osid.shared.SharedException An exception with one of the 
	 * following messages defined in osid.shared.SharedException:   
	 * {@link SharedException#OPERATION_FAILED OPERATION_FAILED}, 
	 * {@link SharedException#PERMISSION_DENIED PERMISSION_DENIED}, 
	 * {@link SharedException#CONFIGURATION_ERROR CONFIGURATION_ERROR}, 
	 * {@link SharedException#UNIMPLEMENTED UNIMPLEMENTED}, 
	 * {@link SharedException#NULL_ARGUMENT NULL_ARGUMENT}, 
	 * {@link SharedException#UNKNOWN_TYPE UNKNOWN_TYPE}
	 * @package harmoni.osid.authentication
	 */
	function destroyAuthenticationForType(& $authenticationType) {
		// Check that we have a valid AuthenticationType.
		ArgumentValidator::validate($authenticationType, new ExtendsValidatorRule("Type"));
		$typeValid = FALSE;
		foreach (array_keys($this->_authTypes) as $key) {
			if ($this->authTypes[$key]->isEqual($authenticationType)) {
				$typeValid = TRUE;
				break();
			}
		}
		if (!$typeValid)
			throwError(new Error(UNKNOWN_TYPE, "AuthenticationManager", 1));
		
		// Assuming that we only have the LoginHandler as our authentication type,
		// just destroy that Authentication.
		$this->_harmoni->LoginHandler->logout();
	}
}

?>