<?php

/**
 * The LoginState interface defines what methods are required of any LoginState class.
 * 
 * The LoginState holds information about end-user authentication. It is created by
 * a {@link LoginHandlerInterface}-type class and is probably stored in the session
 * so that logins can be valid across page-loads.
 * 
 * @package harmoni.architecture.login
 * @version $Id: LoginState.interface.php,v 1.1 2003/07/22 14:41:40 gabeschine Exp $
 * @copyright 2003 
 **/
class LoginStateInterface {
	/**
	 * Returns the authenticated agent's name. (Probably a username/systemname).
	 * @access public
	 * @return string The Agent's name.
	 **/
	function getAgentName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the {@link AuthenticationResult} object associated with the
	 * agent.
	 * @access public
	 * @return object The {@link AuthenticationResult} object.
	 **/
	function getAuthenticationResult() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns if the agent was authenticated successfully.
	 * @access public
	 * @return boolean TRUE if authenticated, FALSE otherwise.
	 **/
	function isValid() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>