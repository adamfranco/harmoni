<?php

/**
 * The AuthenticationHandlerInterface defines the functionallity that all extending classes should have.
 * The AuthenticationHandlerInterface defines the functionallity that all extending classes should have.
 * An implementing class should reference one or several AuthenticationMethod objects and use them
 * to authenticate an agent.
 * @version $Id: AuthenticationHandler.interface.php,v 1.3 2003/06/25 20:43:49 gabeschine Exp $
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
	function authenticate($systemName, $password) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Attempts to validate the given credentials.
	 * Attempts to validate the given credentials. It steps through all of the 
	 * AuthenticationMethod objects and tries to validate with each one.
	 * @param string $systemName The system name, i.e. the username, etc.
	 * @param string $password The password.
	 * @access public
	 * @return object AuthenticationResult The AuthenticationResult object.
	 **/
	function authenticateAllMethods($systemName, $password) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * addMethod adds an authenticationMethod to the system.
	 * @param string $name A user-defined string, preferrably one word, that
	 * describes the method. (ex: "OurInstitutionDB", "LDAPServer", "backupServer", etc)
	 * @param int $priority Defines the "authoritative order" of methods that 
	 * are installed for the purposes of fetching Agent Information (such as 
	 * email addresses, full names, ID numbers, etc).
	 * If multiple methods return conflicting Agent Information (like two 
	 * different email addresses), the one with the higher priority (the LOWEST 
	 * number) will be used.
	 * @param object AuthenticationMethod $methodObject The instantiated method 
	 * to add to the system.
	 * @param boolean $authoritative (optional) Sets if this method is 
	 * authoritative. At least ONE authoritative method MUST authenticate successfully 
	 * or the entire authentication process will return false.
	 * @see AuthenticationMethodInterface
	 * @see AuthenticationMethodInterface::setPriority()
	 * @see AuthenticationMethodInterface::setAuthoritative()
	 * @access public
	 * @return void 
	 **/
	function addMethod( $name, $priority, & $methodObject, $authoritative = false ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * getMethod returns the AuthenticationMethod object associated with $name.
	 * @param string $name The $name to fetch the object for.
	 * @access public
	 * @return object AuthenticationMethod The AuthenticationMethod object.
	 **/
	function & getMethod( $name ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Returns an array of the method names that are installed.
	 * @access public
	 * @return array The array of method names.
	 **/
	function getMethodNames() {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Removes the method associated with $name from the system.
	 * @param string $name The name of the method to remove.
	 * @access public
	 * @return void 
	 **/
	function removeMethod( $name ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}
	
?>