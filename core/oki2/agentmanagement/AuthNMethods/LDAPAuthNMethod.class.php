<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPAuthNMethod.class.php,v 1.1 2005/03/03 01:03:51 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/AuthNMethod.abstract.php");

/**
 * The LDAPAuthNMethod is used to authenticate against an LDAP system.
 * 
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPAuthNMethod.class.php,v 1.1 2005/03/03 01:03:51 adamfranco Exp $
 */
class LDAPAuthNMethod
	extends AuthNMethod
{
		
	/**
	 * Create a Tokens Object
	 * 
	 * @return object Tokens
	 * @access public
	 * @since 3/1/05
	 */
	function createTokensObject () {
		return new UsernamePasswordTokens($this->_configuration);
	}
	
	/**
	 * Authenticate an AuthNTokens object
	 * 
	 * @param object AuthNTokens $authNTokens
	 * @return boolean
	 * @access public
	 * @since 3/1/05
	 */
	function authenticate ( &$authNTokens ) {
		throwError( new Error("AuthNMethod::authenticate() should have been overridden in a child class.",
									 "AuthNMethod", true));
	}
}

?>