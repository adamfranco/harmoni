<?php
/**
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthNTokens.abstract.php,v 1.3 2005/04/07 19:42:12 adamfranco Exp $
 */ 

/**
 * AuthNTokens are used by AuthNMethods as an abstraction to allow for accessing
 * common data from tokens passed that correspond to multiple Authorization
 * systems. The identifier is often a username, but can be any string as long as
 * it is unique within a given AuthNMethod.
 *
 * AuthNMethods deal with two types of tokens. The first are arbitrary data that
 * is passed by the user trying to authenticate. This data may be an array with
 * elements for 'username' and 'password', it might be a string operated on by a
 * private key, it might be a Kerberos Ticket, or pretty much anything else. It is
 * up to a given AuthNMethod to pass the tokens passed to it to appropriate 
 * AuthNTokens objects for the handling of this data. AuthNTokens objects provide
 * access to a string 'identifier' for given tokens data that can be used by
 * other systems to identify this set of tokens. Additionally, the AuthNTokens
 * objects can be initialized with an identifier and then passed to the authentication
 * method for querying on the existance or associated properties of the user
 * that corresponds to the identifier.
 * 
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: AuthNTokens.abstract.php,v 1.3 2005/04/07 19:42:12 adamfranco Exp $
 */
class AuthNTokens {

	/**
	 * Constructor. Stores the configuration.
	 * 
	 * @param object Properties $configuration
	 * @return object
	 * @access public
	 * @since 3/1/05
	 */
	function AuthNTokens ( &$configuration ) {
		$this->_configuration =& $configuration;
	}
	
	/**
	 * Initialize this object for a set of authentication tokens.
	 * 
	 * @param mixed $tokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function initializeForTokens ( $tokens ) {
		throwError( new Error("AuthNTokens::initializeForTokens() should have been overridden in a child class.",
									 "AuthNTokens", true));
	}
	
	/**
	 * Initialize this object for an identifier. The identifier is often a 
	 * username, but can be any string as long as it is unique within a given 
	 * AuthNMethod.
	 * 
	 * @param string $identifier
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function initializeForIdentifier ( $identifier ) {
		throwError( new Error("AuthNTokens::initializeForIdentifier() should have been overridden in a child class.",
									 "AuthNTokens", true));
	}
	
	/**
	 * Return the identifier string for this instance.
	 * 
	 * @return string
	 * @access public
	 * @since 3/1/05
	 */
	function getIdentifier () {
		return $this->_identifier;
	}
	
	/**
	 * Return properly formatted tokens for this instance.
	 * 
	 * @return mixed
	 * @access public
	 * @since 3/1/05
	 */
	function getTokens () {
		return $this->_tokens();
	}
}

?>