<?php

/**
 * The AuthenticationHandlerInterface defines the functionallity that all extending classes should have.
 * The AuthenticationHandlerInterface defines the functionallity that all extending classes should have.
 * An implementing class should reference one or several AuthenticationMethod objects and use them
 * to authenticate an agent.
 * @version $Id: AuthenticationHandler.interface.php,v 1.1 2003/06/20 22:44:22 dobomode Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
 **/

class AuthenticationHandlerInterface {

	/**
	 * Attempts to validate the given credentials.
	 * Attempts to validate the given credentials. It steps through the
	 * current set of AuthenticationMethod objects and stops as soon as
	 * it validates the credentials successfully with one.
	 * @param string $systemName The system name, i.e. the username, etc.
	 * @param string $password The password.
	 * @access public
	 * @return object AuthenticationResult The AuthenticationResult object.
	 **/
	function authenticate($systemName, $password) {}
	
	/**
	 * Attempts to validate the given credentials.
	 * Attempts to validate the given credentials. It steps through all of the 
	 * AuthenticationMethod objects and tries to validate with each one.
	 * @param string $systemName The system name, i.e. the username, etc.
	 * @param string $password The password.
	 * @access public
	 * @return object AuthenticationResult The AuthenticationResult object.
	 **/
	function authenticateAllMethods($systemName, $password) {}
	
	
}
	
?>