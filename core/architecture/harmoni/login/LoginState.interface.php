<?php

/**
 * The LoginState interface defines what methods are required of any LoginState class.
 * 
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
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LoginState.interface.php,v 1.3 2005/01/19 21:09:40 adamfranco Exp $
 **/
class LoginStateInterface {
	/**
	 * Returns the active agent's name. (Probably a username/systemname).
	 * @access public
	 * @return string The Agent's name.
	 **/
	function getAgentName() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns the {@link AuthenticationResult} object associated with the
	 * logged-in agent.
	 * @access public
	 * @return object The {@link AuthenticationResult} object.
	 **/
	function &getAuthenticationResult() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns if the logged-in agent was authenticated successfully.
	 * @access public
	 * @return boolean TRUE if authenticated, FALSE otherwise.
	 **/
	function isValid() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Attempts to change the Active agent to $systemname.
	 * @param string $systemname The system name.
	 * @access public
	 * @return boolean True on success, false on failure.
	 **/
	function changeActiveAgent($systemname) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}

?>