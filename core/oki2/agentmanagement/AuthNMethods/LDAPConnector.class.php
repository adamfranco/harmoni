<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPConnector.class.php,v 1.3 2005/03/04 23:49:47 adamfranco Exp $
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
 * @version $Id: LDAPConnector.class.php,v 1.3 2005/03/04 23:49:47 adamfranco Exp $
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
	 * The configuration for this method.
	 * @access private
	 * @var object Properties $_configuration 
	 */ 
	var $_configuration;
	
	/**
	 * The constructor.
	 * @param ref object $configuration A {@link Properties} Properties with configuration for connection.
	 * @access public
	 * @return void 
	 **/
	function LDAPConnector( &$configuration ) {
		$this->_configuration =& $configuration;
		
		// Validate the configuration options we use:
		ArgumentValidator::validate (
			$this->_configuration->getProperty('LDAPHost'),  
			new FieldRequiredValidatorRule);
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('LDAPPort'),  
			new OptionalRule(new NumericValidatorRule));
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('baseDN'), 
			new FieldRequiredValidatorRule);
		
		ArgumentValidator::validate (
			$this->_configuration->getProperty('bindDN'), 
			new OptionalRule(new StringValidatorRule));
			
		ArgumentValidator::validate (
			$this->_configuration->getProperty('bindDNPassword'),  
			new OptionalRule(new StringValidatorRule));
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
	 * Attempts to bind to the LDAP server either anonymously or with a
	 * DN and password supplied in the configuration so that we can
	 * search the database.
	 * @access public
	 * @return void
	 **/
	function _bindForSearch() {
		$dn = $this->_configuration->getProperty("bindDN");
		$pass = $this->_configuration->getProperty("bindDNPassword");
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
		$this->_conn = ldap_connect($this->_configuration->getProperty("LDAPHost"),$this->_configuration->getProperty("LDAPPort")) or throwError(new Error("LDAPAuthenticationMethod::_connect() - could not connect to LDAP host <b>".$this->_configuration->getProperty("LDAPHost")."</b>!","LDAPAuthenticationMethod",true));
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
						$this->_configuration->getProperty("baseDN"),
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
						$this->_configuration->getProperty("baseDN"),
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
		$this->_disconnect();
		
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
}

?>