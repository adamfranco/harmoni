<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.abstract.php");
require_once(HARMONI."authenticationHandler/methods/LDAPMethodOptions.class.php");

/**
 * Does authentication procedures with an LDAP server.
 *
 * @version $Id: LDAPAuthenticationMethod.class.php,v 1.1 2003/06/30 02:16:09 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
 **/
 
class LDAPAuthenticationMethod extends AuthenticationMethod {
	/**
	 * 
	 * 
	 * @access private
	 * @var mixed $_con 
	 */ 
	var $_con;
	
	/**
	 * 
	 * 
	 * @access private
	 * @var mixed $_bind 
	 */ 
	var $_bind;
	
	/**
	 * 
	 * 
	 * @access private
	 * @var mixed $_opt 
	 */ 
	var $_opt;
	
	/**
	 * The constructor.
	 * @param ref object $options A {@link LDAPMethodOptions} data container with options for connection.
	 * @access public
	 * @return void 
	 **/
	function LDAPAuthenticationMethod( &$options ) {
		$this->_opt =& $options;
	}
	
	
	/**
	 * authenticate will check a systemName/password pair against the LDAP server.
	 * 
	 * @param string $systemName the system name to validate (ie, a user name)
	 * @param string $password the password associated with $systemName
	 * @access public
	 * @return boolean true if authentication succeeded with the method, false if not 
	 **/
	function authenticate( $systemName, $password ) {
		// connect to the LDAP server.
		$this->_connect();
		
		// get the user's DN.
		$dn = $this->_getDN($systemName);
		
		if ($dn) {
			// the user exists
			if ($this->_bind($dn,$password)) // they're good!
				return true;
		}
		return false;
	}
	
	/**
	 * 
	 * @access public
	 * @return void 
	 **/
	function _bind() {
		
	}
	
	/**
	 * 
	 * @access public
	 * @return void 
	 **/
	function _anonymousBind() {
		
	}
	
	
	/**
	 * Fetches the DN entry for $systemName.
	 * @param string $systemName The name to fetch the DN for.
	 * @access private
	 * @return string The DN. 
	 **/
	function _getDN( $systemName ) {
		
	}
	
	/**
	 * Connects to the LDAP server.
	 * @access private
	 * @return void 
	 **/
	function _connect() {
		
	}
	
	/**
	 * Disconnects from the LDAP server.
	 * @access private
	 * @return void 
	 **/
	function _disconnect() {
		
	}
	
	/**
	 * Get's information for $systemName (could be, for example, full name, email, etc).
	 * 
	 * @param string $systemName The system name to get info for.
	 * @access public
	 * @return array An associative array of [key]=>value pairs.  
	 **/
	function getAgentInformation( $systemName ) {
		
	}
	
	/**
	 * Checks to see if $systemName exists in the LDAP server.
	 * 
	 * @param string $systemName The system name to check.
	 * @access public
	 * @return boolean If the agent exists or not. 
	 **/
	function agentExists( $systemName ) {
		
	}
	
}

?>