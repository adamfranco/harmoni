<?php

require_once(HARMONI."architecture/harmoni/login/LoginState.interface.php");
require_once(HARMONI."authenticationHandler/AuthenticationResult.class.php");

/**
 * The LoginState holds information about end-user authentication. It is created by
 * a {@link LoginHandlerInterface}-type class and is probably stored in the session
 * so that logins can be valid across page-loads.
 * 
 * @package harmoni.architecture.login
 * @version $Id: LoginState.class.php,v 1.1 2003/07/22 22:05:47 gabeschine Exp $
 * @copyright 2003 
 **/
class LoginState extends LoginStateInterface {
	/**
	 * @access private
	 * @var object $_result An {@link AuthenticationResult} object.
	 **/
	var $_result;
	
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
			$this->_result =& AuthenticationResult($systemName, array());
		} else {
			$this->_result =& $result;
		}
	}

	/**
	 * Returns the authenticated agent's name. (Probably a username/systemname).
	 * @access public
	 * @return string The Agent's name.
	 **/
	function getAgentName() {
		return $this->_result->getSystemName();
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
}

?>