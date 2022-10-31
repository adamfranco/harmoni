<?php
/**
 * @package harmoni.osid_v2.agentmanagement.authn_methods
 *
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPAuthNTokens.class.php,v 1.10 2007/09/04 20:25:37 adamfranco Exp $
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
 * @version $Id: LDAPAuthNTokens.class.php,v 1.10 2007/09/04 20:25:37 adamfranco Exp $
 */
class LDAPAuthNTokens
	extends UsernamePasswordAuthNTokens
{
	/**
	 * Constructor, Adds some additional functionality to that of the parent's
	 * constructor
	 *
	 * @param object Properties $configuration
	 * @return object
	 * @access public
	 * @since 3/4/05
	 */
	function __construct (  $configuration  ) {
		parent::__construct($configuration);

		$this->_connector =$configuration->getProperty('connector');

		// Validate the configuration options we use:
		ArgumentValidator::validate (
			$this->_configuration->getProperty('login_fields'),
			ArrayValidatorRuleWithRule::getRule(StringValidatorRule::getRule()));
	}

	/**
	 * Initialize this object for a set of authentication tokens. The identifier
	 * is the user's CN, but they may have passed a username or email as part
	 * of their tokens instead.
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
		$this->_tokens['password'] = $tokens['password'];

		// See if we were passed a system name instead of a full DN as this
		// is probably the case. First try the 'main system name' in case
		// a broader search returns more results.
		$primaryLoginFields = $this->_configuration->getProperty('login_fields');

		foreach($primaryLoginFields as $loginField) {
			$dns = $this->_connector->getUserDNsBySearch($loginField."=".$tokens['username']);
// 			printpre($loginField."=".$tokens['username']);

			if (count($dns) == 1) {
				$this->_identifier = $dns[0];
				$this->_tokens['username'] = $dns[0];
				return;
			}
		}

		// If we haven't found it, just leave it alone as it might be the DN
		// itself.
		$this->_identifier = $tokens['username'];
	}

}
