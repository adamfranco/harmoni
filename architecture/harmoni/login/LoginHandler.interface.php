<?php

/**
 * The LoginHandler interface defines what methods are required of any LoginHandler class.
 * 
 * The LoginHandler essentially creates an interface between the web browser and
 * the {@link AuthenticationHandler}. It expects a session to have been started, 
 * and processes saved session-variables, while interfacing with the {@link ActionHandler} if
 * login fails.
 * 
 * The LoginHandler also handles the process of forwarding a user to the site they
 * were trying to access if they are forwarded to the login page. The action to be
 * executed if login either fails or has not yet occured can be specified.
 * 
 * If no action is specified, the LoginHandler uses standard HTTP clear-text authentication.
 *
 * @package harmoni.interfaces.architecture.login
 * @version $Id: LoginHandler.interface.php,v 1.3 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 **/
class LoginHandlerInterface {
	/**
	 * Executes the LoginHandler. The process followed goes: Check the session
	 * for a saved LoginState and load it if found, otherwise check the HTTP
	 * variables for a login/passwd and execute those with the {@link AuthenticationHandler}. If
	 * this fails, FALSE is returned.
	 * @access public
	 * @return object|false Returns a {@link LoginState} object or FALSE on failure.
	 **/
	function & execute() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Clears all the required session variables so that no login information is
	 * stored any more. Essentially de-authenticates the user from the system.
	 * @access public
	 * @return void
	 **/
	function logout() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Sets what action to forward the user to if login fails or they have not yet
	 * logged in and need to.
	 * @param string $action A dotted-pair module.action.
	 * @access public
	 * @return void
	 **/
	function setFailedLoginAction($action) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Adds actions to the list of actions for which a user is not REQUIRED to be
	 * authenticated. If authentication is required and the user has not yet logged
	 * in, they are forwarded to the failed login action.
	 * @param string $action1,... A list of actions.
	 * @access public
	 * @return void
	 **/
	function addNoAuthActions($action) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Sets the callback function for the LoginHandler to fetch a username/password
	 * pair from the browser. It could, for example, check some $_POST/_GET fields
	 * for the information. The function should either: 1) return FALSE if the user
	 * has not entered anything yet or 2) return a two element array containing first the
	 * username, then the password.
	 * @access public
	 * @return void
	 **/
	function setUsernamePasswordCallbackFunction($functionName) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
}

?>