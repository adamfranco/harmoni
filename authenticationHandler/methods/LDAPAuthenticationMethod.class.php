<?php

require_once(HARMONI."authenticationHandler/AuthenticationMethod.abstract.php");
require_once(HARMONI."authenticationHandler/methods/LDAPMethodOptions.class.php");

/**
 * Does authentication procedures with an LDAP server.
 *
 * @version $Id: LDAPAuthenticationMethod.class.php,v 1.10 2003/07/04 14:04:34 gabeschine Exp $
 * @copyright 2003 
 * @access public
 * @package harmoni.authenticationHandler
 **/
 
class LDAPAuthenticationMethod extends AuthenticationMethod {
	/**
	 * The LDAP connection ID.
	 * @access private
	 * @var integer $_con 
	 */ 
	var $_conn;
	
	/**
	 * LDAP bind result.
	 * @access private
	 * @var boolean $_bind 
	 */ 
	var $_bind;
	
	/**
	 * The DataContainer containing (really) the options for this method.
	 * @access private
	 * @var object LDAPMethodOptions $_opt 
	 */ 
	var $_opt;
	
	/**
	 * The constructor.
	 * @param ref object $options A {@link LDAPMethodOptions} data container with options for connection.
	 * @access public
	 * @return void 
	 **/
	function LDAPAuthenticationMethod( &$options ) {
		$options->checkAll();
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
		$suffix = $this->_opt->get("userDNSuffix");
		if ($suffix && $suffix != '') {
			$dn = "cn=$systemName,".$suffix;
		} else
			$dn = $this->_getDN($systemName);
		
		if ($dn) {
			if ($this->_bind($dn,$password)) {// they're good!
				$this->_disconnect();
				return true;
			}
		}
		$this->_disconnect();
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
		
		$this->_bindForSearch();
		$sr = ldap_search($this->_conn,
						$this->_opt->get("baseDN"),
						"$uidField=$systemName",
						array($uidField));
		if (ldap_count_entries($this->_conn,$sr)) {
			$row = ldap_first_entry($this->_conn, $sr);
			$dn = ldap_get_dn($this->_conn, $row);
			ldap_free_result($this->_conn, $sr);
			if ($dn)
				return $dn;
		}
		ldap_free_result($this->_conn,$sr);
		
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
		$this->_bindForSearch();
		$sr = ldap_search($this->_conn,
						$this->_opt->get("baseDN"),
						$filter,
						$return);
		$info = ldap_get_entries($this->_conn,$sr);
		ldap_free_result($this->_conn,$sr);
		return $info;
	}
	
	/**
	 * Attempts to bind to the LDAP server either anonymously or with a
	 * DN and password supplied in the configuration so that we can
	 * search the database.
	 * @access public
	 * @return void
	 **/
	function _bindForSearch() {
		$dn = $this->_opt->get("bindDN");
		$pass = $this->_opt->get("bindDNPassword");
		if ($dn && $dn != '') { // we don't *require* the passwd
			$this->_bind($dn,$pass);
		} else $this->_anonymousBind();
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
		ldap_close($this->_conn);
		$this->_conn = NULL;
	}
	
	/**
	 * Get's information for $systemName (could be, for example, full name, email, etc).
	 * 
	 * @param string $systemName The system name to get info for.
	 * @access public
	 * @return array An associative array of [key]=>value pairs.  
	 **/
	function getAgentInformation( $systemName ) {
		
		// get the array of fields to fetch
		$fields = $this->_opt->get("agentInformationFields");
		if (!is_array($fields)) return array();
		
		// we need all the values from $fields from the LDAP server.
		$return = array_values($fields);
		
		$this->_connect();
		
		$uidField = $this->_opt->get("usernameField");
		$values = $this->_search("$uidField=$systemName",$return);

		// no go through and populate the $info array
		$info = array();
		
		// first off, do we have any results
		if ($values['count'])
			$row = $values[0];
		else {
			$this->_disconnect();
			return array();
		}
		
		// get array settings that specify if we should fetch ALL the values
		// from a certain attribute or just the first one
		$fetchMultiple = $this->_opt->get("agentInformationFieldsFetchMultiple");
		
		foreach ($fields as $key=>$field) {
			if ($row[$field]['count']) {
				if ($fetchMultiple[$key])
					$info[$key] = $row[$field];
				else
					$info[$key] = $row[$field][0];
			}
		}
		$this->_disconnect();
		return $info;
	}
	
	/**
	 * Checks to see if $systemName exists in the LDAP server.
	 * 
	 * @param string $systemName The system name to check.
	 * @access public
	 * @return boolean If the agent exists or not. 
	 **/
	function agentExists( $systemName ) {
		$this->_connect();
		$dn = $this->_getDN($systemName);
		if ($dn) {
			$this->_disconnect();
			return true;
		}
		$this->_disconnect();
		return false;
	}
	
}

?>