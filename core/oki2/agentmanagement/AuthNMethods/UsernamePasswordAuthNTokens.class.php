<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UsernamePasswordAuthNTokens.class.php,v 1.2 2005/03/29 19:44:23 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/AuthNTokens.abstract.php");

/**
 * UsernamePasswordAuthNTokens is used by AuthNMethods that wrap systems that
 * authenticate via a Username/Password pair of strings.
 * 
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: UsernamePasswordAuthNTokens.class.php,v 1.2 2005/03/29 19:44:23 adamfranco Exp $
 */
class UsernamePasswordAuthNTokens
	extends AuthNTokens
{

	/**
	 * Initialize this object for a set of authentication tokens.
	 * 
	 * @param mixed $tokens
	 * @return void
	 * @access public
	 * @since 3/1/05
	 */
	function initializeForTokens ( $tokens ) {
		ArgumentValidator::validate($tokens, ArrayValidatorRule::getRule());
		ArgumentValidator::validate($tokens['username'], StringValidatorRule::getRule());
		ArgumentValidator::validate($tokens['password'], StringValidatorRule::getRule());
		
		$this->_tokens = $tokens;
		$this->_identifier = $tokens['username'];
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
		ArgumentValidator::validate($identifier, StringValidatorRule::getRule());
		
		$this->_identifier = $identifier;
		$this->_tokens = array(
								'username' => $identifier,
								'password' => ''
							);
	}
	
	/**
	 * Return the username.
	 * 
	 * @return string
	 * @access public
	 * @since 3/1/05
	 */
	function getUsername () {
		return $this->_identifier;
	}
	
	/**
	 * Return the password.
	 * 
	 * @return string
	 * @access public
	 * @since 3/1/05
	 */
	function getPassword () {
		return $this->_tokens['password'];
	}
	
}

?>