<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPConnector.class.php,v 1.1 2005/03/04 22:22:45 adamfranco Exp $
 */ 

/**
 * LDAPConnector is a class used by the LDAPAuthNMethod and the LDAPAuthNTokens
 * to handle common functions
 * 
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPConnector.class.php,v 1.1 2005/03/04 22:22:45 adamfranco Exp $
 */
class LDAPConnector {
		
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
	function LDAPConnector( &$options ) {
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
	 * authenticate will check a DN/password pair against the LDAP server.
	 * 
	 * @param string $dn
	 * @param string $password the password associated with $systemName
	 * @access public
	 * @return boolean true if authentication succeeded with the method, false if not 
	 **/
	function authenticateDN( $dn, $password ) {
		// connect to the LDAP server.
		$this->_connect();
		
		if ($this->_bind($dn,$password)) {// they're good!
			$this->_disconnect();
			return true;
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
			ldap_free_result($sr);
			if ($dn)
				return $dn;
		}
		ldap_free_result($sr);
		
		return null;
	}
	
	/**
	 * Get the DN for the systemname passed
	 * 
	 * @param string $systemName
	 * @return string
	 * @access public
	 * @since 3/4/05
	 */
	function getDN ($systemName) {
		$this->_connect();
		$dn = $this->_getDN($systemName);
		$this->_disconnect();
		return $dn;
	}
	
	/**
	 * Get the DNs that match the search
	 * 
	 * @param string $systemName
	 * @return string
	 * @access public
	 * @since 3/4/05
	 */
	function getDNsBySearch ($filter) {
		$this->_connect();
		$this->_bindForSearch();
		$sr = ldap_search($this->_conn,
						$this->_opt->get("baseDN"),
						$filter);
		$dns = array();
		$entry = ldap_first_entry($this->_conn, $sr);
		while($entry) {
			$dns[] = ldap_get_dn($this->_conn, $entry);
			$entry = ldap_next_entry($this->_conn, $entry);
		}
		ldap_free_result($sr);
		$this->_disconnect();
		return $dns;
	}
	
	/**
	 * returns true if the dn exists
	 * @param string $systemName The name to fetch the DN for.
	 * @access private
	 * @return string|null The DN, or NULL if it can't be found. 
	 **/
	function dnExists( $dn ) {
		$this->_connect();
		$this->_bindForSearch();
		$sr = ldap_search($this->_conn,
						$this->_opt->get("baseDN"),
						$dn,
						array($uidField));
		if (ldap_count_entries($this->_conn,$sr)) {
			$row = ldap_first_entry($this->_conn, $sr);
			$founddn = ldap_get_dn($this->_conn, $row);
			ldap_free_result($sr);
			$this->_disconnect();
			if ($founddn)
				return TRUE;
		}
		ldap_free_result($sr);
		
		return FALSE;
	}
	
	/**
	 * Get the DN for the systemname passed
	 * 
	 * @param string $dn
     * @param optional array $return An array of fields to return.
	 * @return string
	 * @access public
	 * @since 3/4/05
	 */
	function getInfo ($dn, $fields) {
		$this->_connect();
		$this->_bindForSearch();
		$sr = ldap_read($this->_conn, $dn, "(objectclass=*)", $fields);
		$entries = ldap_get_entries($this->_conn, $sr);
		ldap_free_result($sr);
		$this->_disconnect();
		
		// Rebuild the array
		if (!$entries['count'])
			return array();
		
		$entry = $entries[0];
		$numValues = $entry['count'];
		
		$values = array();
		for ($i=0; $i<$numValues; $i++) {
			$values[$entry[$i]] = $entry[$entry[$i]][0];
		}
		
		return $values;
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
		ldap_free_result($sr);
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
		$this->_conn = ldap_connect($this->_opt->get("LDAPHost"),$this->_opt->get("LDAPPort")) or throwError(new Error("LDAPAuthenticationMethod::_connect() - could not connect to LDAP host <b>".$this->_opt->get("LDAPHost")."</b>!","LDAPAuthenticationMethod",true));
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
		
		// get the array of fields to fetch
		$fields = $this->_opt->get("agentInformationFields");
		if (!is_array($fields)) return array();
		
		// we need all the values from $fields from the LDAP server.
		$return = array_values($fields);
		
		$this->_connect();
		
		$uidField = $this->_opt->get("usernameField");
		$return[] = $uidField;
		
		if ($searchMode) {
			$filter = "(|";
			foreach ($fields as $key=>$field)
				$filter .= "($field=*$systemName*)";
			$filter .= "($uidField=*$systemName*)";
			$filter .= ")";
		} else
			$filter .= "($uidField=$systemName)";
		$values = $this->_search($filter,$return);

		// no go through and populate the $info array
		$info = array();
		
		// first off, do we have any results
		if ($values['count'])
			if ($searchMode)
				$rows = $values;
			else
				$rows[0] = $values[0];
		else {
			$this->_disconnect();
			return array();
		}
		
		// get array settings that specify if we should fetch ALL the values
		// from a certain attribute or just the first one
		$fetchMultiple = $this->_opt->get("agentInformationFieldsFetchMultiple");
		
		foreach ($rows as $row) {
			$userName = $row[$uidField][0];
    		foreach ($fields as $key=>$field) {
    			if ($row[$field]['count']) {
    				if ($fetchMultiple[$key])
    					$info[$userName][$key] = $row[$field];
    				else
    					$info[$userName][$key] = $row[$field][0];
    			}
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