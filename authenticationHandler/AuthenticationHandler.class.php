<?php

require_once(HARMONI."authenticationHandler/AuthenticationHandler.interface.php");
require_once(HARMONI."authenticationHandler/AuthenticationResult.class.php");
require_once(HARMONI."authenticationHandler/methods/inc.php");

/**
 * The AuthenticationHandler keeps track of multiple AuthenticationMethods for 
 * authenticating agents.
 * 
 * @version $Id: AuthenticationHandler.class.php,v 1.11 2003/07/10 02:34:20 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authentication
 **/

class AuthenticationHandler extends AuthenticationHandlerInterface {
	/**
	 * @access private
	 * @var boolean $_used If the handler has been used for authentication yet.
	 **/
	var $_used = false;
	
	/**
	 * @access private
	 * @var array $_methods An associative array of [name]=>AuthenticationMethod pairs.
	 **/
	var $_methods = array();
	
	/**
	 * Attempts to validate the given credentials using the method specified
	 * in $method.
	 * @param string $systemName The system name, i.e. the username, etc.
	 * @param string $password The password.
	 * @param string $method The method with which to try authentication.
	 * @access public
	 * @see {@link AuthenticationMethodInterface}
	 * @return boolean True if authentication succeeds, false otherwise.
	 **/
	function authenticate($systemName, $password, $method ) { 
		// we're being used!!!
		$this->_used = true;
		
		// if the method doesn't exist, return false
		if (!$this->_methodExists($method)) return false;
		
		// return the result of the authentication method.
		// first get it
		$methodObject =& $this->getMethod($method);
		return $methodObject->authenticate($systemName, $password);
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
		// we're being used!!!
		$this->_used = true;
		
		// first, build an array of methods, their priority and authority
		$aMethods = $pMethods = array();
		foreach($this->getMethodNames() as $method) {
			if ($this->_methods[$method]->getAuthoritative())
				$aMethods[$method] = $this->_methods[$method]->getPriority();
			else
				$pMethods[$method] = $this->_methods[$method]->getPriority();
		}
		
		// now, authoritative methods are in $aMethods, non are in $pMethods
		// sort the two arrays
		asort($pMethods,SORT_NUMERIC);
		asort($aMethods,SORT_NUMERIC);
		
		// if we have aMethods, we will assume that none of them authenticated yet.
		if (count($aMethods)) $haveGoodAMethod = false;
		else $haveGoodAMethod = true;
		// otherwise, we have no *required* methods, so everything should just
		// run normally
		
		// now, run through the aMethods first, then the pMethods, and
		// store the results in an AuthenticationResult object.
		$validList = array();
		foreach (array_keys($aMethods) as $method) {
			if ($this->_methods[$method]->authenticate($systemName,$password)) {
				// they're good!
				$haveGoodAMethod = true;
				$validList[] = $method;
			}
		}
		
		// now, continue only if we are a-OK on the authoritative methods
		if ($haveGoodAMethod) {
			foreach (array_keys($pMethods) as $method) {
				if ($this->_methods[$method]->authenticate($systemName,$password)) {
					// they're good!
					$validList[] = $method;
				}
			}
		}
		
		$results = & new AuthenticationResult($validList);
		return $results;
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
	 * or the entire authentication process will return false.
	 * @see {@link AuthenticationMethodInterface}
	 * @see {@link AuthenticationMethodInterface::setPriority()}
	 * @see {@link AuthenticationMethodInterface::setAuthoritative()}
	 * @access public
	 * @return void 
	 **/
	function addMethod( $name, $priority, & $methodObject, $authoritative = false ) {
		// if we have already been used for authentication, return.
		if ($this->_used) {
			throw(new Error("AuthenticationHandler::addMethod() - can not add new method '$name': The handler has already been used for authentication. Please add your method before any authentication occurs.","AuthenticationHandler",true));
		}
		
		// if we already have a method by this name, throw an error & return
		if ($this->_methodExists($name)) {
			throw( new Error("AuthenticationHandler::addMethod() - can not add a method named '$name' because it already exists!", "AuthenticationHandler", true));			
			return;
		}
		
		// otherwise, continue
		// set the priority
		$methodObject->setPriority($priority);
		// set the authoritative flag
		$methodObject->setAuthoritative($authoritative);
		
		// add it to our array
		$this->_methods[$name] =& $methodObject;
	}
	
	/**
	 * Checks if method $name has been added already.
	 * @param string $name The name of the method.
	 * @access private
	 * @return boolean True if method has been added.
	 **/
	function _methodExists( $name ) {
		if (in_array($name,array_keys($this->_methods)))
			return true;
		return false;
	}
	
	
	/**
	 * getMethod returns the AuthenticationMethod object associated with $name.
	 * @param string $name The $name to fetch the object for.
	 * @access public
	 * @return object AuthenticationMethod The AuthenticationMethod object.
	 **/
	function & getMethod( $name ) {
		if ($this->_methodExists($name))
			return $this->_methods[$name];
		else {
			throw(new Error("AuthenticationHandler - can not getMethod('$name'): it does not exist.","AuthenticationHandler",true));
		}
	}
	
	/**
	 * Returns an array of the method names that are installed.
	 * @access public
	 * @return array The array of method names.
	 **/
	function getMethodNames() {
		return array_keys($this->_methods);
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
		// if the AuthenticationManager has been used already, return.
		if ($this->_used) return;
		
		// if the method doesn't exist, return.
		if (!$this->_methodExists($name)) return;
		
		// if not, unset the method from the array
		unset($this->_methods[$name]);
	}
	
	/**
	 * The start function is called when a service is created. Services may
	 * want to do pre-processing setup before any users are allowed access to
	 * them.
	 * @access public
	 * @return void
	 **/
	function start() {
		
	}
	
	/**
	 * The stop function is called when a Harmoni service object is being destroyed.
	 * Services may want to do post-processing such as content output or committing
	 * changes to a database, etc.
	 * @access public
	 * @return void
	 **/
	function stop() {
		
	}
}
	
?>