<?php

require_once(HARMONI."architecture/harmoni/login/LoginState.interface.php");
require_once(HARMONI."authenticationHandler/AuthenticationResult.class.php");

/**
 * The LoginState holds information about end-user authentication. It is created by
 * a {@link LoginHandlerInterface}-type class and is probably stored in the session
 * so that logins can be valid across page-loads.
 * 
 * The LoginState is also responsible for keeping track of both an Active user
 * and a Logged-in user. The Active user is given to the program as the user for
 * whom actions are performed. This feature is useful because the Active user can
 * be changed, allowing administrators or similar users to switch between Active users.
 * 
 * @package harmoni.architecture.login
 * @version $Id: LoginState.class.php,v 1.4 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 **/
class LoginState extends LoginStateInterface {
	/**
	 * @access private
	 * @var object $_result An {@link AuthenticationResult} object.
	 **/
	var $_result;
	
	/**
	 * @access private
	 * @var string $_activeAgent The Active agent's system name.
	 **/
	var $_activeAgent;
	
	/**
	 * The constructor.
	 * @param optional string $systemName The system name for whom we are logging in.
	 * @param optional object $result The {@link AuthenticationResult} object acquired from authentication. If
	 * omitted, one is created with a failed authentication status.
	 * @access public
	 * @return void
	 **/
	function LoginState($systemName='', $result=false) {
		if (!$result) {
			$this->_result =& new AuthenticationResult($systemName, array());
		} else {
			$this->_result =& $result;
		}
		$this->_activeAgent = $systemName;
	}

	/**
	 * Returns the authenticated agent's name. (Probably a username/systemname).
	 * @access public
	 * @return string The Agent's name.
	 **/
	function getAgentName() {
		return $this->_activeAgent;
	}
	
	/**
	 * Returns the {@link AuthenticationResult} object associated with the
	 * agent.
	 * @access public
	 * @return object The {@link AuthenticationResult} object.
	 **/
	function &getAuthenticationResult() {
		return $this->_result;
	}
	
	/**
	 * Returns if the agent was authenticated successfully.
	 * @access public
	 * @return boolean TRUE if authenticated, FALSE otherwise.
	 **/
	function isValid() {
		return $this->_result->isValid();
	}
	
	/**
	 * Attempts to change the Active agent to $systemname.
	 * @param string $systemname The system name.
	 * @access public
	 * @return boolean True on success, false on failure.
	 **/
	function changeActiveAgent($systemname) {
		// we need to interface with the AuthenticationHandler for this step.
		// if $systemname exists in any of the authentication methods, then
		// we're going to go ahead.
		Services::requireService("Authentication");
		$auth =& Services::getService("Authentication");
		
		if ($auth->agentExists($systemname)) {
			$this->_activeAgent = $systemname;
			return true;
		}
		return false;
	}
}

?>