<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CryptUsernamePasswordAuthNTokens.class.php,v 1.2 2005/03/04 22:22:45 adamfranco Exp $
 */ 

require_once(dirname(__FILE__)."/UsernamePasswordAuthNTokens.class.php");

/**
 * This UserNamePasswordAuthNTokens class encrypts the password passed to it using
 * the database's PHP's crypt() function.
 * 
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: CryptUsernamePasswordAuthNTokens.class.php,v 1.2 2005/03/04 22:22:45 adamfranco Exp $
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
		ArgumentValidator::validate($tokens, new ArrayValidatorRule);
		ArgumentValidator::validate($tokens['username'], new StringValidatorRule);
		ArgumentValidator::validate($tokens['password'], new StringValidatorRule);
		
		$this->_tokens = $tokens;
		$this->_identifier = $tokens['username'];
		$this->_tokens['password'] = crypt($tokens['password'], 
									$this->_configuration->getProperty('crypt_salt'));
	}
	
}

?>