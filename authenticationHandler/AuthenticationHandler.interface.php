<?php

require_once(HARMONI."services/Service.interface.php");

/**
 * The AuthenticationHandlerInterface defines the functionallity that all extending classes should have.
 * An implementing class should reference one or several AuthenticationMethod objects and use them
 * to authenticate an agent.
 * @version $Id: AuthenticationHandler.interface.php,v 1.12 2003/08/06 22:32:40 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.interfaces.authentication
 **/

class AuthenticationHandlerInterface extends ServiceInterface {
	/**
	 * Attempts to validate the given credentials using the method specified
	 * in $method.
	 * @param string $systemName The system name, i.e. the username, etc.
	 * @param string $password The password.
	 * @param string $method The method with which to try authentication.
	 * @access public
	 * @see {@link AuthenticationMethod}
	 * @return boolean True if authentication succeeds, false otherwise.
	 **/
	function authenticate($systemName, $password, $method) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * Attempts to validate the given credentials. It steps through all of the 
	 * AuthenticationMethod objects and tries to validate with each one. Authentication
	 * order is based on two things: First, any authoritative methods are tried first, in
	 * order of their priority setting. Second, any other methods are tried in order of
	 * their priority.
	 * @param string $systemName The system name, i.e. the username, etc.
	 * @param string $password The password.
	 * @access public
	 * @return object AuthenticationResult The AuthenticationResult object.
	 **/
	function & authenticateAllMethods($systemName, $password) { 
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
	
	/**
	 * addMethod adds an AuthenticationMethod to the system.
	 * 
	 * addMethod will add an AuthenticationMethod (previous instantiated & configured)
	 * to the authentication system. If any methods have been used already for 
	 * authentication of any kind, adding or removing methods will fail due to
	 * security/useability restrictions.
	 * @param string $name A user-defined string, preferrably one word, that
	 * describes the method. (ex: "OurInstitutionDB", "LDAPServer", "backupServer", etc)
	 * @param int $priority Defines the "authoritative order" of methods that 
	 * are installed for the purposes of fetching Agent Information (such as 
	 * email addresses, full names, ID numbers, etc).
	 * If multiple methods return conflicting Agent Information (like two 
	 * different email addresses), the one with the higher priority (the LOWEST 
	 * number) will be used.
	 * @param ref object AuthenticationMethod $methodObject The instantiated method 
	 * to add to the system.
	 * @param optional boolean $authoritative Sets if this method is 
	 * authoritative. At least ONE authoritative method MUST authenticate successfully 
	 * or the entire authentication process will return false. Default = false.
	 * @see {@link AuthenticationMethodInterface}
	 * @see {@link AuthenticationMethodInterface::setPriority()}
	 * @see {@link AuthenticationMethodInterface::setAuthoritative()}
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
	 * Removes the method associated with $name from the system. If any methods
	 * have already been used for any authentication, removing a method will fail
	 * due to security/useability restrictions. Add and remove methods before
	 * anyone is authenticated.
	 * @param string $name The name of the method to remove.
	 * @access public
	 * @return void 
	 **/
	function removeMethod( $name ) {
		die ("Method <b>".__FUNCTION__."()</b> declared in interface<b> ".__CLASS__."</b> has not been overloaded in a child class."); 
	}
}
	
?>