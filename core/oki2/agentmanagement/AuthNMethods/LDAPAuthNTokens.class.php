<?php
/**
 * @package harmoni.oki_v2.agentmanagement
 * 
 * @copyright Copyright &copy; 2005, Middlebury College
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License (GPL)
 *
 * @version $Id: LDAPAuthNTokens.class.php,v 1.1 2005/03/04 22:22:45 adamfranco Exp $
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
 * @version $Id: LDAPAuthNTokens.class.php,v 1.1 2005/03/04 22:22:45 adamfranco Exp $
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
	function LDAPAuthNTokens (  &$configuration  ) {
		$par = get_parent_class($this);
		parent::$par($configuration);
		
		$this->_connector =& $configuration->getProperty('connector');
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
		ArgumentValidator::validate($tokens, new ArrayValidatorRule);
		ArgumentValidator::validate($tokens['username'], new StringValidatorRule);
		ArgumentValidator::validate($tokens['password'], new StringValidatorRule);
		
		$this->_tokens = $tokens;
		$this->_tokens['password'] = $tokens['password'];
		
		//---------------------------------------
		// Make sure that the username is the DN.
		
		// If the username passed matches a DN, use that.
		if ($this->_connector->dnExists($tokens['username']))
			$this->_identifier = $tokens['username'];
		
		// If we weren't passed a valid CN, see if we were passed another
		// system name instead
		else if ($dn = $this->_connector->_getDN($tokens['username'])) {
			$this->_identifier = $dn;
			$this->_tokens['username'] = $dn;
		
		// If we haven't found it, just leave it alone.
		} else {
			$this->_identifier = $tokens['username'];
			print "\nWe didn't find a DN.\n";
		}
	}
}

?>