<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.abstract.php");
require_once(HARMONI."authenticationHandler/methods/LDAPMethodOptions.class.php");

/**
 * Does authentication procedures with an LDAP server.
 *
 * @version $Id: LDAPAuthenticationMethod.class.php,v 1.2 2003/06/30 14:48:07 gabeschine Exp $
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
	var $_conn;
	
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
	 * Attempt to bind to the LDAP server using $dn and $password credentials.
	 * @param string $dn The LDAP DN.
	 * @param string $password The password.
	 * @access private
	 * @return boolean TRUE if bind was successful, FALSE otherwise. 
	 **/
	function _bind( $dn, $password ) {
		$this->_bind = ldap_bind($this->_conn, $dn, $password);
		if ($this->_bind) return true;
		return false;
	}
	
	/**
	 * Attempts to bind to the LDAP server anonymously.
	 * @access private
	 * @return boolean TRUE if bind was successful, FALSE otherwise. 
	 **/
	function _anonymousBind() {
		$this->_bind = ldap_bind($this->_conn);
		if ($this->_bind) return true;
		return false;
	}
	
	
	/**
	 * Fetches the DN entry for $systemName.
	 * @param string $systemName The name to fetch the DN for.
	 * @access private
	 * @return string|null The DN, or NULL if it can't be found. 
	 **/
	function _getDN( $systemName ) {
		$uidField = $this->_opt->get("usernameField");
		
		$info = $this->_search("$uidField=$systemName");
		if ($info['count']) {
			$dn = $info[0]['dn'][0];
			return $dn;
		}
		return null;
	}
	
	/**
	 * Searches the LDAP directory for $filter and returns $return fields.
	 * @param string $filter the LDAP search filter.
	 * @param optional array $return An array of fields to return.
	 * @access private
	 * @return array An array of ldap_get_entries results.
	 **/
	function _search( $filter, $return = array() ) {
		$sr = ldap_search($this->_conn,
						$this->_opt->get("baseDN"),
						$filter,
						$return);
		$info = ldap_get_entries($this->_conn,$sr);
		return $info;
	}
	
	/**
	 * Connects to the LDAP server.
	 * @access private
	 * @return void 
	 **/
	function _connect() {
		$this->_conn = ldap_connect($this->_opt->get("LDAPHost"),$this->_opt->get("LDAPPort")) or throw(new Error("LDAPAuthenticationMethod::_connect() - could not connect to LDAP host <b>".$this->_opt->get("LDAPHost")."</b>!","LDAPAuthenticationMethod",true));
	}
	
	/**
	 * Disconnects from the LDAP server.
	 * @access private
	 * @return void 
	 **/
	function _disconnect() {
		// don't do anything -- we want to keep the connection open.
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