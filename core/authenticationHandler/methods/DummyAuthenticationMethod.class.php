<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.abstract.php");
require_once(HARMONI."authenticationHandler/methods/LDAPMethodOptions.class.php");

/**
 * Performs authentication for two users: demo1 and demo2, with passwords same as usernames.
 *
 * @version $Id: DummyAuthenticationMethod.class.php,v 1.2 2004/04/21 17:55:27 adamfranco Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authentication.methods
 **/
 
class DummyAuthenticationMethod extends AuthenticationMethod {
	
	
	/**
	 * authenticate will check a systemName/password pair against the LDAP server.
	 * 
	 * @param string $systemName the system name to validate (ie, a user name)
	 * @param string $password the password associated with $systemName
	 * @access public
	 * @return boolean true if authentication succeeded with the method, false if not 
	 **/
	function authenticate( $systemName, $password ) {
		if ($systemName == 'demo1' && $password == 'demo1') return true;
		if ($systemName == 'demo2' && $password == 'demo2') return true;
		return false;
	}
	/**
	 * Get's information for $systemName (could be, for example, full name, email, etc)
	 * 
	 * @param string $systemName The system name to get info for.
	 * @param boolean $searchMode Specifies if we are searching for users
	 * or just trying to get info for one user.
	 * @access public
	 * @return array An array of associative arrays corresponding to all the users found
	 * that match systemName. The format is [systemName]=>array([key1]=>value1,...),...
	 **/
	function getAgentInformation( $systemName, $searchMode=false ) {
		return array();
	}
	
	/**
	 * Checks to see if $systemName exists in the LDAP server.
	 * 
	 * @param string $systemName The system name to check.
	 * @access public
	 * @return boolean If the agent exists or not. 
	 **/
	function agentExists( $systemName ) {
		if ($systemName == 'demo1' || $systemName == 'demo2') return true;
		return false;
	}
	
}

?>