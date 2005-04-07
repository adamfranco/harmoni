<?php
/**
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CryptUsernamePasswordAuthNTokens.class.php,v 1.5 2005/04/07 19:42:13 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/UsernamePasswordAuthNTokens.class.php");

/**
 * This UserNamePasswordAuthNTokens class encrypts the password passed to it using
 * the database's PHP's crypt() function.
 * 
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CryptUsernamePasswordAuthNTokens.class.php,v 1.5 2005/04/07 19:42:13 adamfranco Exp $
 */
class CryptUsernamePasswordAuthNTokens
	extends UsernamePasswordAuthNTokens
{

	/**
	 * Initialize this object for a set of authentication tokens. Set the 
	 * password to the encrypted version.
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
		$this->_tokens['password'] = crypt($tokens['password'], 
									$this->_configuration->getProperty('crypt_salt'));
	}
	
}

?>